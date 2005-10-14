<?php
//Esta clase puede recibir los siguientes parametros de AFUERA:
//(Desde la pantalla de LOGON y desde el CONTROL del panel)
//GET
define("apex_sesion_qs_finalizar","fs");    	//SOLICITUD de finalizacion de sesion
define("apex_sesion_qs_cambio_proyecto","cps"); //SOLICITUD de cambio e proyecto: cerrar sesion y abrir nueva
//POST
define("apex_sesion_post_proyecto","sp");   	//Proyecto (En el caso de multiproyecto)
define("apex_sesion_post_usuario","su");    	//Usuario
define("apex_sesion_post_clave","sc");      	//Clave

//Arreglar flujo de errorres de validacion y control de IP bloqueada

class sesion {
//Clase estatica que administra el ciclo de vida de una sesion

	function abrir($usuario,$proyecto)
	//Abre una sesion de la aplicacion
	{
		$db = toba::get_db("instancia");
		//---------------------------- Controlo que la IP no este bloqueada...
		$sql = "SELECT '1' FROM apex_log_ip_rechazada WHERE ip='{$_SERVER["REMOTE_ADDR"]}'";
		$rs = $db->consultar($sql, apex_db_numerico);
		if (count($rs)>0){
			throw new excepcion_toba("Ha sido bloqueado el acceso desde la maquina '{$_SERVER["REMOTE_ADDR"]}'. Por favor contáctese con el <a href='mailto:".apex_pa_administrador."'>Administrador</a>.");
		}
		//---------------------------- Creo la sesion en la base...
		$sql = "SELECT nextval('apex_sesion_browser_seq'::text);";
		$rs = $db->consultar($sql, apex_db_numerico);
		if(!$rs){
			monitor::evento("bug","sesion: Error consultando la secuencia de sesiones [ ".$db["instancia"][apex_db_con]->ErrorMsg()." ]",$usuario);
			throw new excepcion_toba("Imposible determinar el ID de la sesion");
		}else{
			$sesion = $rs[0][0];
			$sql = "INSERT INTO apex_sesion_browser (sesion_browser,usuario,ip,proyecto,php_id) VALUES ('$sesion','$usuario','".$_SERVER["REMOTE_ADDR"]."','$proyecto','".session_id()."');";
			try{
				$db->ejecutar($sql);
			}catch(excepcion_toba $e){
				monitor::evento("bug","sesion: No es posible registrar la sesion [ ".$e->getMessage()." ]",$usuario);
				throw new excepcion_toba("No se puede registrar la sesion");
			}
			//-----------------------------> Creo la sesion de PHP
			//BASICOS
			$_SESSION['toba']["id"] = $sesion;
			$_SESSION['toba']["apex_pa_ID"] = apex_pa_ID; //Punto de acceso utilizado para abrir la sesion
			$_SESSION['toba']["inicio"]=time();
			//PATHs
			$_SESSION['toba']["path"] = toba_dir();
			$_SESSION['toba']["path_php"] = $_SESSION['toba']["path"]. "/php";
			//-----------------------------> Cargo INFORMACION del USUARIO
			$sql = "SELECT	u.usuario as id,
							u.hora_salida,
							u.solicitud_registrar as				sol_registrar,
							u.solicitud_obs_tipo_proyecto as		sol_obs_tipo_proyecto,
							u.solicitud_obs_tipo as					sol_obs_tipo,
							u.solicitud_observacion as				sol_obs,
							up.usuario_grupo_acc as 				grupo_acceso,
							up.usuario_perfil_datos as 			perfil_datos,
							ga.nivel_acceso as						nivel_acceso
					FROM 	apex_usuario u,
							apex_usuario_proyecto up,
							apex_usuario_grupo_acc ga
					WHERE	u.usuario = up.usuario
					AND		up.usuario_grupo_acc = ga.usuario_grupo_acc
					AND		up.proyecto = ga.proyecto
					AND		up.usuario = '$usuario'
					AND		up.proyecto = '$proyecto';";
			//echo $sql;
			$rs = $db->consultar($sql);
			if(count($rs)==0){
				//Este recordset da vacio, el usuario no tenia permiso 
				//para ver el proyecto.
				sesion::cerrar();
				throw new excepcion_toba("El usuario intento abrir un proyecto para el cual no posee permisos");					
			}
			$_SESSION['toba']["usuario"]=$rs[0];
			//-----------------------------> Cargo propiedades del proyecto
			$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
			$sql = "SELECT	proyecto as nombre,
							descripcion_corta as descripcion,
							estilo
					FROM 	apex_proyecto
					WHERE	proyecto = '$proyecto';";
			$rs = $db->consultar($sql);
			$_SESSION['toba']["proyecto"]=$rs[0];
			//-----------------------------> Manejo inicializacion y tiempo de conexion
			sesion::actualizar_estado();
			toba::get_logger()->debug('Se creo la SESION [usuario: ' . $_SESSION['toba']["usuario"]['id'] . ' ]');
		}
	}
//-----------------------------------------------------------------------------

	function cerrar($observaciones="")
	//Cierra una sesion de la aplicacion
	{
		if (isset($_SESSION['toba']["id"]))
		{
			//Cierro la sesion de la base
			if($observaciones!=""){
				$sql = "UPDATE apex_sesion_browser SET egreso = current_timestamp, observaciones='$observaciones' WHERE sesion_browser = '".$_SESSION['toba']["id"]."';";
			}else{
				$sql = "UPDATE apex_sesion_browser SET egreso = current_timestamp WHERE sesion_browser = '".$_SESSION['toba']["id"]."';";
			}
			toba::get_db('instancia')->ejecutar($sql);
			//ATENCION: Tengo que controlar que esto este OK!!!
			//Destruyo la sesion de PHP
			if(isset($_SESSION['toba']["archivos"]))
			//Existieron UPLOADS temporales asociados a la sesion
			{
				foreach($_SESSION['toba']["archivos"] as $archivo)
				{
					//SI puedo ubicar los archivos los elimino
					if(is_file($archivo)){
						unlink($archivo);
					}
				}
			}
		}
		session_unset();
		session_destroy();
	}
//-----------------------------------------------------------------------------

	function autorizar()
	//Determina cual es el estado de la sesion y responde con un array:
	//[0] se puede acceder al sistema? (boolean)
	//[1] Detalle de la respuesta.
	{
		session_start();//Activo el manejo de sesiones
		if(!isset($_SESSION['toba']["id"])){		//****  NO EXISTE sesion  ****
			if(apex_pa_validacion)	// Se requiere VALIDACION de usuarios?
			{
				//Decido con que proyecto me voy a loguear, o lo extraigo de la interface si es "multi"
				if(apex_pa_proyecto=="multi"){
                    if(isset($_POST[apex_sesion_post_proyecto])){
                        $proyecto = $_POST[apex_sesion_post_proyecto];
                    }else{
                        //Hay que elegir proyecto pero no se eligio
    					session_destroy();//El sesion start del principio deja un archivo de sesion inutil...
    					throw new excepcion_toba("");
                    }
				}else{
					$proyecto=apex_pa_proyecto;
				}
				if (isset($_POST[apex_sesion_post_usuario])){ //Hay datos para loguear un usuario?
						if(!isset($proyecto)){//SI no hay un proyecto seleccionado, afuera...
		   					session_destroy();//El sesion start del principio deja un archivo de sesion inutil...
    						throw new excepcion_toba("Es necesario seleccionar un proyecto");
						}
					if((apex_pa_usuario_anonimo!="") && ($_POST[apex_sesion_post_usuario]==apex_pa_usuario_anonimo)){
						//---> Entrada USUARIO anonimo 1.
						return sesion::abrir(apex_pa_usuario_anonimo,$proyecto);
					}else{
						//---> Entrada USUARIO normal.
						//echo "VALIDACION de USUARIOS";
						$usuario =& new usuario_http($_POST[apex_sesion_post_usuario],$_POST[apex_sesion_post_clave],$proyecto);
						$status_usuario = $usuario->autorizar();
						if($status_usuario[0]){
                            //-------------------------------------> ABRO LA SESION..
							return sesion::abrir($_POST[apex_sesion_post_usuario],$proyecto);
						}else{
							session_destroy();//El sesion start del principio deja un archivo de sesion inutil...
							return $status_usuario;
						}
					}
				}else{	//Request inicial
					//return array(false,"Bienvenido, por favor ingrese su nombre de usuario y contraseña");
					session_destroy();//El sesion start del principio deja un archivo de sesion inutil...
					throw new excepcion_toba("");
				}
			}
			else {	//No se requiere VALIDACION, se crea una sesion del usuario anonimo
				//---> Entrada USUARIO anonimo 2.
				sesion::actualizar_estado();
                //PAra entrar con usuario anonimo hay que elegir un proyecto SI o SI.
                if(apex_pa_proyecto=="multi"){
                    die("Para acceder con un USUARIO ANONIMO hay que seleccionar un proyecto");
                }else{
    				return sesion::abrir(apex_pa_usuario_anonimo,apex_pa_proyecto);
                }
			}
		}
		else									//*** SESION ACTIVA! ****
		{
			//La sesion esta creada, comienzo el control de FALTAS
			//* Control 1: Fin tiempo de NO interaccion.
			if(apex_pa_sesion_ventana != 0){ // 0 implica desactivacion
				$tiempo_desconectado = ((time()-$_SESSION['toba']["ultimo_acceso"])/60);//Tiempo desde el ultimo REQUEST
				if ( $tiempo_desconectado >= apex_pa_sesion_ventana){
					sesion::cerrar("Se exedio la ventana temporal (" . apex_pa_sesion_ventana . " m.)");
					throw new excepcion_toba("Usted ha permanecido mas de <b>". apex_pa_sesion_ventana. 
								" minutos</b> sin interactuar con el servidor.
								Por razones de seguridad <b> su sesion ha sido eliminada. </b>
								Por favor vuelva a registrarse si desea continuar utilizando el sistema.
								Disculpe las molestias ocasionadas.");
				}
			}

			//* Control 2: Fin de franja horaria.  ->>> NO TERMINADO!!
			if(false){
				sesion::cerrar("Termino la franja horaria de acceso asociada al usuario");
				throw new excepcion_toba("Ha terminado su franja horaria de trabajo");
			}

			//* Control 3: Cambio de punto de acceso.
			if(apex_pa_ID!=$_SESSION['toba']["apex_pa_ID"]){
				sesion::cerrar("Cambio de punto de acceso: " . $_SESSION['toba']["apex_pa_ID"]. " -> " . apex_pa_ID );
				throw new excepcion_toba("El cambio de puntos de acceso no es permitido. Se ha generado un informe");
			}

			//* Control 4: Tiempo maximo de sesion.
			if(apex_pa_sesion_maximo != 0){ // 0 implica desactivacion
				$tiempo_total = ((time()-$_SESSION['toba']["inicio"])/60);//Tiempo desde el ultimo REQUEST
				if ( $tiempo_total >= apex_pa_sesion_maximo){
					sesion::cerrar("Se exedio el tiempo maximo de sesion (" . apex_pa_sesion_maximo . " m.)");
					throw new excepcion_toba("Se ha superado el tiempo de sesion permitido (<b>". apex_pa_sesion_maximo. 
								" minutos</b>) Por favor vuelva a registrarse si desea continuar utilizando el sistema.
								Disculpe las molestias ocasionadas.");
				}
			}
			//Controles OK...
			
			//---> El usuario solicito el fin de sesion??
			if(isset($_GET[apex_sesion_qs_finalizar])&&($_GET[apex_sesion_qs_finalizar]==1)){
				sesion::cerrar();
				if(apex_pa_validacion){	// Si no se requiere validacion hay que volver a entrar
					throw new excepcion_toba("La sesion ha sido eliminada");					
				}else{
					//Si no hay validacion tengo que vuelver a abrir la sesion
					session_start();
					return sesion::abrir(apex_pa_usuario_anonimo,apex_pa_proyecto);
				}
			//---> El usuario solicito cambio de proyecto???
			}elseif(isset($_GET[apex_sesion_qs_cambio_proyecto])&&($_GET[apex_sesion_qs_cambio_proyecto]==1)){
                //Es necesario volver a validar algo aca???
                //Recupero el indentificador del usuario
                $usuario_id = $_SESSION['toba']["usuario"]["id"];
                //Cierro la sesion actual
				sesion::cerrar();
                if(isset($_POST[apex_sesion_post_proyecto])){//SE paso como parametro el PROYECTO?
                    //Creo una SESION en el nuevo PROYECTO
                    $proyecto = $_POST[apex_sesion_post_proyecto];
       				session_start();
					//ATENCION, se abre la sesion sin volver a validar el USUARIO.
    				return sesion::abrir($usuario_id,$_POST[apex_sesion_post_proyecto]);
                }else{
                    throw new excepcion_toba("No se especificó el proyecto");
                }
			}else{ //La sesion es VALIDA --> Ahora ya se puede crear la SOLICITUD...
				sesion::actualizar_estado();
			}
		}
 	}
//-----------------------------------------------------------------------------

	function actualizar_estado()
	{
		//echo "<body><pre>"; print_r($_SESSION); echo "</pre></body>";
		$proyecto = $_SESSION['toba']["proyecto"]["nombre"];
		//--[1]--  Agrego el proyecto al INCLUDE PATH del proyecto
		//Esto esta aca porque se puede cambiar de proyecto manteniendo la SESION
		if($proyecto!="toba"){//Esto es necesario solo si el proyecto no es 'TOBA'
			$dir_raiz = $_SESSION['toba']["path"];
			$i_path = ini_get("include_path");
			if (substr(PHP_OS, 0, 3) == 'WIN'){
				$i_proy = $dir_raiz . "/proyectos/" . $proyecto;
				$i_proy_php = $i_proy  . "/php";
				ini_set("include_path", $i_path . ";.;" . $i_proy_php );
			}else{
				$i_proy = $dir_raiz . "/proyectos/" . $proyecto;
				$i_proy_php = $i_proy . "/php";
				ini_set("include_path", $i_path . ":.:" . $i_proy_php);
			}
			$_SESSION['toba']["path_proyecto"] = $i_proy;
			$_SESSION['toba']["path_proyecto_php"] = $i_proy_php;
			//echo "PROYECTO: $proyecto - INCLUDE_PATH= \"" . ini_get("include_path") ."\"";
		}
		//--[2]-- Seteo el estilo que se va a usar
        define("apex_proyecto_estilo",$_SESSION['toba']["proyecto"]["estilo"]);

		//--[3]-- Actualizo la variable que guarda el ultimo acceso a la sesion
		$_SESSION['toba']["ultimo_acceso"]=time();//El tiempo que dure la solicitud no se cuenta... no importa.
	}
//-----------------------------------------------------------------------------
}
?>
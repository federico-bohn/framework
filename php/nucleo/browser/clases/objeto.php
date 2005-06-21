<?php
define('apex_ei_analisis_fila', 'apex_ei_analisis_fila');   //Id de la columna utilizada para el resultado del analisis de una fila

include_once('eventos.php');

class objeto
/*
 	@@acceso: nucleo
	@@desc: Padre de todas las clases que definen objetos standart de la aplicacion
*/
{
	var $solicitud;
	var $id;
	var $info;
	var $info_dependencias;						//Definicion de las dependencias
	var $indice_dependencias;					//Indice que mapea las definiciones de las dependencias con su
	var $dependencias_indice_actual = 0;	
	var $lista_dependencias;					//Lista de dependencias disponibles
	var $dependencias = array();							//Array de sub-OBJETOS
	var $memoria;
	var $memoria_existencia_previa = false;
	var $interface_existencia_previa = false;
	var $observaciones;
	var $canal;										// Canal por el que recibe datos 
	var $canal_recibido;							// Datos recibidos por el canal
	var $info_proceso = null;					// Estado interno relacionado con el procesamiento llevado a cabo por el objeto
	var $info_proceso_gravedad = null;		// Array donde se apilan los niveles de gravedad, pada definir que tipo de mensaje se muestra
	var $info_proceso_indice = 0;
	var $estado_proceso;							// interno | string | "OK","ERROR","INFRACCION"
	var $id_ses_g;									//ID global para la sesion
	var $definicion_partes;						//indica el nombre de los arrays de metadatos que posee el objeto
	var $exportacion_archivo;
	var $exportacion_path;
	var $colapsado = false;						//El elemento s�lo mantiene su t�tulo
	var $evento_por_defecto;					//Evento disparado cuando no hay una orden explicita
	protected $eventos = array();
	
	function objeto($id)
/*
 	@@acceso: nucleo
	@@desc: Constructor de la clase
*/
	{
	$this->solicitud = toba::get_solicitud();
		$this->log = $this->solicitud->log;
		if(!($this->id = $id)) monitor::evento("bug","[objeto]: ERROR, no se indico el ID del objeto a crear");
		$this->exportacion_archivo = "nucleo/definiciones/objetos/".$this->id[1].".php";
		$this->exportacion_path = $this->solicitud->hilo->obtener_path(). "/php/". $this->exportacion_archivo;
		$this->cargar_definicion();
		$this->conectar_fuente();
		//Recibi datos por el CANAL?
		$this->canal = apex_hilo_qs_canal_obj . $this->id[1];
		$this->canal_recibidos = $this->solicitud->hilo->obtener_parametro($this->canal);
		$this->id_ses_g = "obj_" . $this->id[1];
		$this->id_ses_grec = "obj_" . $this->id[1] . "_rec";
		//Manejo transparente de memoria
		$this->cargar_memoria();			//RECUPERO Memoria sincronizada
		//$this->recuperar_estado_sesion();	//RECUPERO Memoria dessincronizada
		$this->evaluar_existencia_interface_anterior();
		$this->log->debug( $this->get_txt() . "[ __construct ]");
	}
//--------------------------------------------------------------------------------------------

/*	function establecer_solicitud($solicitud)
	//Esto evita usar la referencia global
	{
		$this->solicitud = $solicitud;	
		$this->exportacion_path = $this->solicitud->hilo->obtener_path(). "/php/". $this->exportacion_archivo;
		$this->canal_recibidos = $this->solicitud->hilo->obtener_parametro($this->canal);
	}*/

	function destruir()
	{
		//echo "Me estoy destruyendo " . $this->id[1] . "<br>";
		//Persisto informacion
		$this->memorizar();						//GUARDO Memoria sincronizada
		//$this->guardar_estado_sesion();		//GUARDO Memoria dessincronizada
		//Llamo a los destructores de los OBJETOS anidados
		foreach(array_keys($this->dependencias) as $dependencia){
			$this->dependencias[$dependencia]->destruir();
		}
	}
	//-------------------------------------------------------------------------------

	function cargar_definicion()
/*
 	@@acceso:
	@@desc: 
*/
	{
		global $db, $ADODB_FETCH_MODE, $cronometro;
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		//$cronometro->marcar('basura',apex_nivel_nucleo);
		$tipo_de_carga="db";
		if($tipo_de_carga=="db"){
			//-- Cargo la definicion de la base --
			$definicion = $this->obtener_definicion_db();
			foreach(array_keys($definicion) as $parte)
			{
				$this->definicion_partes[] = $parte;
				$rs = $db["instancia"][apex_db_con]->Execute($definicion[$parte]["sql"]);
				if((!$rs)){
					monitor::evento("bug","Error cargando la DEFINICION del OBJETO [objeto: $parte] Error cargando la definicion del OBJETO '{$this->id[0]}, {$this->id[1]}'. ".$db["instancia"][apex_db_con]->ErrorMsg());
				}
				if($rs->EOF){
					if($definicion[$parte]["estricto"]=="1"){
						monitor::evento("bug","Error cargando la DEFINICION del OBJETO [objeto:$parte] '{$this->id[0]},{$this->id[1]}'. No hay registros.");
					}else{
						//El parametro no es estricto, lo inicializo como ARRAY vacio
						$this->$parte = array();
					}
				}else{
					$temp = $rs->getArray();
					//Registro UNICO o GRUPO
					if($definicion[$parte]["tipo"]=="1"){	
						$this->$parte = $temp[0];
					}else{
						$this->$parte = $temp;
					}
				}
			}
		}else{
			//-- Cargo la DEFINICION el PHP autogenerado
			//ATENCION, un include_once no sirve para objetos ANIDADOS
			include( $this->exportacion_archivo );
			//ei_arbol( $definicion_objeto ,"DEFINICION");
			foreach(array_keys($definicion_objeto) as $parte){
				$this->$parte =  $definicion_objeto[$parte];
				$this->definicion_partes[] = $parte;
			}
		}
		//$cronometro->marcar('OBJETO: Cargar INFO basica',apex_nivel_objeto);
	}
//--------------------------------------------------------------------------------------------

	function obtener_definicion_db()
/*
 	@@acceso:
	@@desc: 
*/
	{
		$sql["info"]["sql"] = "	SELECT	o.*,
									c.editor_proyecto as		clase_editor_proyecto,
									c.editor_item as			clase_editor_item,
									c.archivo as				clase_archivo,
									c.plan_dump_objeto as		clase_dump,
									c.vinculos as 				clase_vinculos,
									c.editor_item as			clase_editor,
									d.fuente_datos as			fuente,
									d.fuente_datos_motor as		fuente_motor,
									d.host as					fuente_host,
									d.usuario as				fuente_usuario,
									d.clave as					fuente_clave,
									d.base as					fuente_base,
									d.link_instancia as			fuente_link_instancia,
									d.instancia_id as			fuente_link_instancia_id,
									oi.objeto as				objeto_existe_ayuda,
									o.parametro_a as			parametro_a,
									o.parametro_b as			parametro_b,
									o.parametro_c as			parametro_c,
									o.parametro_d as			parametro_d,
									o.parametro_e as			parametro_e,
									o.parametro_f as			parametro_f
							FROM	apex_objeto o
										LEFT OUTER JOIN apex_objeto_info oi 
											ON (o.objeto = oi.objeto AND o.proyecto = oi.objeto_proyecto),
									apex_fuente_datos d,
									apex_clase c
							WHERE	o.fuente_datos = d.fuente_datos
							AND     o.fuente_datos_proyecto = d.proyecto
							AND		o.clase_proyecto = c.proyecto
							AND			o.clase = c.clase
							AND		o.proyecto='".$this->id[0]."'
							AND		o.objeto='".$this->id[1]."';";
		$sql["info"]["tipo"]="1";
		$sql["info"]["estricto"]="1";
		return $sql;
	}
//--------------------------------------------------------------------------------------------

	function get_clave_memoria_global()
	{
		return $this->id_ses_grec;
	}

	function info_estado()
/*
 	@@acceso: actividad
	@@desc: Da informacion sobre el ESTADO del objeto
*/
	{
		//Reemplazar por un iterador de las propiedades
		return get_object_vars($this);
	}
//--------------------------------------------------------------------------------------------

	function info_definicion()
/*
 	@@acceso: actividad
	@@desc: Da informacion sobre la DEFINICION objeto
*/
	{
		foreach($this->definicion_partes as $parte){
			$definicion[$parte] = $this->$parte;
		}
		return $definicion;
	}
//--------------------------------------------------------------------------------------------

	function exportar_definicion_php()
/*
 	@@acceso:
	@@desc: 
*/
	{
		//Atencion, por ahora solo para el proyecto TOBA
		$archivo = fopen($this->exportacion_path,"w"); 
		fwrite($archivo, "<?\n//Generacion: " .date("j-m-Y H:i:s") ."\n" );
		fwrite($archivo, "\$definicion_objeto = unserialize(stripslashes(\"".
								addslashes(serialize( $this->info_definicion() ))."\"));\n");
		fwrite($archivo, "\n?>\n" );
		fclose($archivo);
	}
	//-------------------------------------------------------------------------------

	function exportar_definicion_sql()
/*
	Esto es viejo, no funciona segun el modelo actual
 	@@acceso:
	@@desc: 
*/
	{
		$sql = db_dump_tabla("apex_objeto","WHERE objeto = '".$this->id."'");
		foreach(explode("\n",$this->info["clase_dump"]) as $plan){
			$plan_array = explode(":",$plan);
			$tabla = trim($plan_array[0]);
			$where = ereg_replace("##",$this->id,trim($plan_array[1]));
			//echo "<TABLA> $tabla <WHERE> $where <br>";
			$sql .= db_dump_tabla($tabla,$where);
		}
		return $sql;
	}
	//-------------------------------------------------------------------------------

	function info()
/*
	@@acceso: actividad
	@@desc: Imprime la informacion COMPLETA en la PANTALLA
*/
	{
		ei_arbol($this->info_estado());
		ei_arbol($this->info_definicion());
	}	

	function get_txt()
	{
		return "objeto[". $this->id[1] . "] < ". get_class($this). " > ";	
	}
	
//*******************************************************************************************
//****************************************<  SOPORTE   >*************************************
//*******************************************************************************************	

	function consulta_datos_recibidos()
/*
 	@@acceso: objeto
	@@desc: Responde si el OBJETO recibio datos por su CANAL
*/
	{
		if(isset($this->canal_recibidos)){
			return true;
		}else{
			return false;
		}
	}
//--------------------------------------------------------------------

	function conectar_fuente()
/*
 	@@acceso:
	@@desc: Crea la conexion que el objeto necesita para trabajar
*/
	{
		//global $cronometro;
		abrir_base( 	$this->info["fuente"], array(
						apex_db_motor => $this->info["fuente_motor"],
						apex_db_profile => $this->info["fuente_host"],
						apex_db_usuario => $this->info["fuente_usuario"],
						apex_db_clave => $this->info["fuente_clave"],
						apex_db_base => $this->info["fuente_base"],
						apex_db_link =>	$this->info["fuente_link_instancia"],
						apex_db_link_id =>	$this->info["fuente_link_instancia_id"])
					);
		//$cronometro->marcar('OBJETO ['.$this->id[1].']: Conectar FUENTE de DATOS',apex_nivel_nucleo);
	}
	//-------------------------------------------------------------------------------

	function existe_ayuda()
	{
		return (trim($this->info['objeto_existe_ayuda'])!="");
	}
	//-------------------------------------------------------------------------------

	function autovinculacion($parametro, $texto="Autovinculo")
/*
 	@@acceso: objeto
	@@desc: Genera un vinculo al mismo objeto
*/
	{
		$html = "<a href='". $this->solicitud->vinculador->generar_solicitud(null,null,$parametro,true) ."'>";
		$html .= $texto;
		$html .="</a>";
		return $html;
	}

//*******************************************************************************************
//**********************<  Comunicacion de informacion al USUARIO   >************************
//*******************************************************************************************	
/*
	Falta pensar el tema de las transacciones necesitan una reafirmacion despues
	de mostrar la cola de mensajes
*/
	function obtener_mensaje($indice, $parametros=null)
	//Obtiene un mensaje del repositorio de mensajes
	{
		//Busco el mensaje del OBJETO
		if($mensaje = mensaje::get_objeto($this->id[1], $indice, $parametros)){
			return $mensaje;	
		}else{
			//El objeto no tiene un mensaje con el indice solicitado,
			//Busco el INDICE global
			return mensaje::get($indice, $parametros);
		}
	}

	function informar_msg($mensaje, $nivel=null)
	//Guarda un  mensaje en la cola de mensajes
	{
		$this->solicitud->cola_mensajes->agregar($mensaje,$nivel);	
	}
	
	function informar($indice, $parametros=null,$nivel=null)
	//Obtiene un mensaje del repositorio y lo guarda en la cola de mensajes
	{
		$mensaje = $this->obtener_mensaje($indice, $parametros);
		$this->informar_msg($mensaje,$nivel);
	}

//*******************************************************************************************
//****************************<  Informacion sobre el proceso   >****************************
//*******************************************************************************************	

	function obtener_estado_proceso()
/*
 	@@acceso: actividad
	@@desc: Indica el estado del proceso: ( OK | ERROR | INFRACCION )
*/
	{
		return $this->estado_proceso;
	}
	//-------------------------------------------------------------------------------

	function mostrar_info_proceso()
/*
 	@@acceso: objeto
	@@desc: Muestra el estado del proceso que se esta ejecutando
*/
	{
		if(is_array($this->info_proceso)){
			$mensaje = "";
			foreach($this->info_proceso as $nota){
				$mensaje .= $nota . "<br>";
			}
			if($mensaje!=""){
				if(is_array($this->info_proceso_gravedad)){
					if(in_array("error",$this->info_proceso_gravedad)){
						$tipo = "error";
						$subtitulo = null;
/*	
					$subtitulo = "CLASE <b>" . get_class($this) . "</b><br>".
									"OBJETO <b>" . $this->id[0] . " - " . $this->id[1] . "</b>".
									" ( " . $this->info["nombre"] . " ) ";
*/
					}else{
						$tipo = "info";
						$subtitulo = null;
					}
					echo ei_mensaje($mensaje, $tipo, $subtitulo);
				}
			}
		}
	}
	//-------------------------------------------------------------------------------

	function registrar_info_proceso($mensaje, $gravedad="info")
/*
 	@@acceso: objeto 
	@@desc: Registra un mensaje en la cola de mensajes del proceso
*/
	{
		$this->info_proceso[$this->info_proceso_indice] = $mensaje;
		$this->info_proceso_gravedad[$this->info_proceso_indice] = $gravedad;
		$this->info_proceso_indice++;
	}
	
//*******************************************************************************************
//********************************<  AUDITORIA Y LOG   >*************************************
//*******************************************************************************************	

	function observar($tipo,$observacion,$forzar_registro=false,$mostrar=false,$cortar_ejecucion=false)
/*
 	@@acceso: objeto
	@@desc: Deja guardada una observacion en la solicitud
	@@param: string | Tipo de error (info, error)
	@@param: string | Texto de la observacion
	@@param: boolean | forzar el registro el en LOG | false
	@@param: boolean | Mostrar el mensaje de error al usuario | false
	@@param: boolean | cortar la ejecucion | false
*/
	{
		global $solicitud;
		$this->observaciones[]="[$tipo] ".$observacion;	//El objeto acumula sus propias observaciones
		$solicitud->observar_objeto($this->id,$tipo,$observacion,$forzar_registro,$mostrar,$cortar_ejecucion);
	}

	function mostrar_observaciones()
	{
		ei_arbol($this->observaciones);
	}
	
//*******************************************************************************************
//**************************************<  MEMORIA   >***************************************
//*******************************************************************************************	
//La memoria es una array que se hace perdurable a travez del HILO
//Las clases que lo usen solo tienen generar las claves que necesiten dentro de este (ej: $this->memoria["una_cosa"])
//y despues llamar a los metodos "memorizar" para guardarla en el HILO y "cargar_memoria" para recuperarlo
//Preg: Por que no se usa el indice 0 en la clave del OBJETO?
//Res: proque no se pueden cargar objetos de dos proyectos en la misma solicitud

	function memorizar()
/*
 	@@acceso: objeto
	@@desc: Persiste el array '$this->memoria' para utilizarlo en la proxima invocacion del objeto
*/
	{
		if(isset($this->memoria)){
			$this->solicitud->hilo->persistir_dato("obj_".$this->id[1],$this->memoria);
		}else{

		}
	}
	
	function cargar_memoria()
/*
 	@@acceso: objeto
	@@desc: Recupera la memoria que dejo una instancia anterior del objeto. (Setea $this->memoria)
*/
	{
		if( $this->solicitud->hilo->verificar_acceso_menu() ){
			//$this->log->debug($this->get_txt() . " El estado de la memoria no es regenerado porque el acceso proviene del MENU");
		}else{
			if($this->memoria = $this->solicitud->hilo->recuperar_dato("obj_".$this->id[1])){
				$this->memoria_existencia_previa = true;
			}
		}
	}

	function controlar_memoria()
/*
 	@@acceso: objeto
	@@desc: Controla la existencia de la memoria
*/
	//SI la memoria no se cargo se corta la ejecucion y despliega un mensaje
	{
		if ((!isset($this->memoria)) || (is_null($this->memoria))){
			$this->observar("error","Error cargando la MEMORIA del OBJETO. abms[". ($this->id[1]) ."]",false,true,true);
		}
	}

	function borrar_memoria()
/*
 	@@acceso: objeto
	@@desc: Dumpea la memoria
*/
	{
		unset($this->memoria);
		$this->solicitud->hilo->persistir_dato("obj_".$this->id[1],null);
	}

	function existio_memoria_previa()
	//Atencion, para que esto funcione antes hay que cargar la memoria
	{
		return $this->memoria_existencia_previa;
	}
	
//*******************************************************************************************
//**************************************<  Memoria GLOBAL   >********************************
//*******************************************************************************************

	function limpiar_memoria_global()
	{
		unset($_SESSION["global"][$this->id_ses_g]);
	}
	
	function existe_dato($indice)
	{
		return isset($_SESSION["global"][$this->id_ses_g][$indice]);
	}

	function guardar_dato($indice, $dato)
	//El indice no puede ser "x_propiedades_persistidas"
	{
		$_SESSION["global"][$this->id_ses_g][$indice] = $dato;
	}
	
	function recuperar_dato($indice)
	{
		return $_SESSION["global"][$this->id_ses_g][$indice];
	}
	
	function eliminar_dato($indice)
	{
		unset($_SESSION["global"][$this->id_ses_g][$indice]);
		if(count($_SESSION["global"][$this->id_ses_g])==0){
			unset($_SESSION["global"][$this->id_ses_g]);
		}
	}

//*******************************************************************************************
//****************************<  Memorizacion de PROPIEDADES   >*****************************
//*******************************************************************************************
//Cuando deja de propagarse por la sesion esto???

	function mantener_estado_sesion()
	//Esta funcion retorna las propiedades que se desea persistir
	{
		return array();
	}

	function recuperar_estado_sesion()
	//Recupera las propiedades guardadas en la sesion
	{
		if($this->solicitud->hilo->existe_dato_global($this->id_ses_grec)){
			if( $this->solicitud->hilo->verificar_acceso_menu() ){
				//$this->log->debug($this->get_txt() . " El estado de las propiedades no es regenerado porque el acceso proviene del MENU");
			}else{
				//Recupero las propiedades de la sesion
				$temp = $this->solicitud->hilo->recuperar_dato_global($this->id_ses_grec);
				foreach($temp as $propiedad => $valor){
					$this->$propiedad = $valor;
				}	
			}
		}		
	}
	
	function guardar_estado_sesion()
	//Guardo propiedades en la sesion
	{
		//Busco las propiedades que se desea persistir entre las sesiones
		$propiedades_a_persistir = $this->mantener_estado_sesion();
		if(count($propiedades_a_persistir)>0){
			$propiedades = get_object_vars($this);
			for($a=0;$a<count($propiedades_a_persistir);$a++){
				//Existe la propiedad
				if(in_array($propiedades_a_persistir[$a],$propiedades)){
					//Si la propiedad no es NULL
					if(isset($this->$propiedades_a_persistir[$a])){
						$temp[$propiedades_a_persistir[$a]] = $this->$propiedades_a_persistir[$a];
					}else{
						//$this->log->error($this->get_txt() . " Se solocito mantener el estado de una propiedad inexistente: '{$propiedades_a_persistir[$a]}' ");
						//echo $this->get_txt() . " guardar_estado_sesion '{$propiedades_a_persistir[$a]}' == NULL <br>";
					}
				}
			}
			if(isset($temp)){
				//ei_arbol($temp,"Persistencia PROPIEDADES " . $this->id[1]);
				$this->solicitud->hilo->persistir_dato_global($this->id_ses_grec, $temp, true);
			}else{
				//Si existia y las propiedades pasaron a null, hay que borrarlo
				$this->solicitud->hilo->eliminar_dato_global($this->id_ses_grec);
			}
		}
	}

	function eliminar_estado_sesion($no_eliminar=null)
	{
		if(!isset($no_eliminar))$no_eliminar=array();
		$propiedades_a_persistir = $this->mantener_estado_sesion();
		for($a=0;$a<count($propiedades_a_persistir);$a++){
			if(!in_array($propiedades_a_persistir[$a], $no_eliminar)){
				unset($this->$propiedades_a_persistir[$a]);			
			}
		}
		$this->solicitud->hilo->eliminar_dato_global($this->id_ses_grec);
	}
	
	function get_estado_sesion()
	{
		$propiedades_a_persistir = $this->mantener_estado_sesion();
		if(count($propiedades_a_persistir)>0){
			$propiedades = get_object_vars($this);
			for($a=0;$a<count($propiedades_a_persistir);$a++){
				//Existe la propiedad
				if(in_array($propiedades_a_persistir[$a],$propiedades)){
					//Si la propiedad no es NULL
					if(isset( $this->$propiedades_a_persistir[$a]) ){
						$temp[$propiedades_a_persistir[$a]] = $this->$propiedades_a_persistir[$a];
					}
				}
			}
			if(isset($temp)){
				return $temp;
			}
		}
	}

//*******************************************************************************************
//*******************************************************************************************

	function mostrar_memoria()
/*
 	@@acceso: objeto
	@@desc: Dumpea la memoria
*/
	{
		if(isset($this->memoria)){
			ei_arbol($this->memoria,"MEMORIA Sincronizada del OBJETO [". $this->id[1] ."]");
		}
		if(isset($_SESSION["global"][$this->id_ses_g])){
			ei_arbol($_SESSION["global"][$this->id_ses_g],"MEMORIA GLOBAL del OBJETO [". $this->id[1] ."]");
		}
		//ATENCION, emprolijar esto un toque
		if(isset($_SESSION["global"][$this->id_ses_grec])){
			ei_arbol($_SESSION["global"][$this->id_ses_grec],"MEMORIA RECICLABLE del OBJETO [". $this->id[1] ."]");
		}
	}

//*******************************************************************************************
//*************************************<  DEPENDENCIAS  >************************************
//*******************************************************************************************

	function cargar_info_dependencias()
/*
 	@@acceso: interno
	@@desc: Carga informacion sobre las DEPENDENCIAS definidas en el objeto actual
*/
	{
		global $db, $ADODB_FETCH_MODE;
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		$sql = 	"	SELECT	d.identificador as		identificador,
							o.proyecto as			proyecto,
							o.objeto as				objeto,
							o.clase as				clase,
							c.archivo as 			clase_archivo,
							o.subclase as			subclase,
							o.subclase_archivo as	subclase_archivo,
							o.fuente_datos as 		fuente,
							d.parametros_a as		parametros_a,
							d.parametros_b as		parametros_b
					FROM	apex_objeto o,
							apex_objeto_dependencias d,
							apex_clase c
					WHERE	o.objeto = d.objeto_proveedor
					AND		o.proyecto = d.proyecto
					AND		o.clase = c.clase
					AND		o.clase_proyecto = c.proyecto
					AND		d.proyecto='".$this->id[0]."'
					AND		d.objeto_consumidor='".$this->id[1]."'
					ORDER BY identificador;";
		$rs = $db["instancia"][apex_db_con]->Execute($sql);
		if(!$rs){
			monitor::evento("bug","OBJETO: NO se pudo cargar las dependencias: '{$this->id[0]},{$this->id[1]}'. ". $db["instancia"][apex_db_con]->ErrorMsg() );
		}
		if($rs->EOF) return;
		$this->info_dependencias = $rs->getArray();
		for($a=0;$a<count($this->info_dependencias);$a++){
			$this->indice_dependencias[$this->info_dependencias[$a]["identificador"]] = $a;//Columna de informacion donde esta la definicion
			$this->lista_dependencias[] = $this->info_dependencias[$a]["identificador"];
		}
	}
//--------------------------------------------------------------------------------------------

	function cargar_dependencia($identificador, $parametros=null)
/*
 	@@acceso:
	@@desc: Ingrase un objeto en el array interno $this->dependencias;
*/
 	{
		//-[0]- La dependencia ya esta cargada?
		if(isset($this->dependencias[$identificador])){
			return 999;
		}
		//-[1]- El indice es valido?
		if(!isset($this->indice_dependencias[$identificador])){
			throw new excepcion_toba("OBJETO [cargar_dependencia]: No EXISTE una dependencia asociada al indice [$identificador].");
			$this->observar("error","OBJETO [cargar_dependencia]: No EXISTE una dependencia asociada al indice [$identificador].",false,true,true);
			$this->obtener_info_dependencias();
			return -1;
		}

		$posicion = $this->indice_dependencias[$identificador];
		//Decido si tengo que instanciar una clase o una subclase
		$archivo = $this->info_dependencias[$posicion]['clase_archivo'];
		//-------> Crear una SUBCLASE para el OBJETO en CUESTION
		if(isset($this->info_dependencias[$posicion]['subclase']))
		{
			if(trim($this->info_dependencias[$posicion]['subclase_archivo'])!=""){
				$archivo = trim($this->info_dependencias[$posicion]['subclase_archivo']);
				$clase =  $this->info_dependencias[$posicion]['subclase'];
			}else{
				if( $this->solicitud->hilo->entorno_instanciador() )
				//Si el archivo no esta especificado, el codigo de la subclase esta
				//En la actividad y no esta disponible en el entorno instanciador!
				//En ese caso instancio al padre
				{
					$this->registrar_info_proceso("ATENCION: La dependencia define
								 una SUBCLASE ('".$this->info_dependencias[$posicion]['subclase']."')
								 que no es accesible desde el INSTANCIADOR del OBJETO que la consume
								 ('".$this->info['clase']."'). Se utilizara la clase padre de la dependencia
								 ('".$this->info_dependencias[$posicion]['clase']."').
								 Para ver el comportamiento definitivo de la misma, 
								 utilize este objeto desde la ACTIVIDAD");
					$clase = $this->info_dependencias[$posicion]['clase'];
				}else{
					//Subclase sin archivo fuera del instanciador de libreria, 
					//La actividad deberia tener cargada la clase
					$clase =  $this->info_dependencias[$posicion]['subclase'];
				}
			}
		}else{ 
		//-------> Crear una CLASE del SISTEMA
			$clase = $this->info_dependencias[$posicion]['clase'];
		}
		//-[2]- Incluyo el PHP que tiene la descripcion de la CLASE a la que este dependencia pertenece
		if(trim($archivo)!="") include_once($archivo);//Las subclases pueden incluirse en la ACTIVIDAD, en ese caso no hay que incluir
		//-[3]- Creo el dependencia standart en cuestion
//		$creacion_objeto = "\$this->dependencias[$identificador] =& new {$clase}(array({$this->info_dependencias[$posicion]['proyecto']},{$this->info_dependencias[$posicion]['objeto']}),\$this->solicitud);";
		$creacion_objeto = "\$this->dependencias['$identificador'] = new {$clase}(array('{$this->info_dependencias[$posicion]['proyecto']}',{$this->info_dependencias[$posicion]['objeto']}), \$parametros);";
		eval($creacion_objeto);
		//-[4]- Abro la CONEXION del dependencia este (Si ya existe no se vuelve a abrir)
		$this->dependencias[$identificador]->conectar_fuente();
		return true;
	}
//--------------------------------------------------------------------------------------------

	function consultar_info_dependencia($dep,$dato=null)
	{
		if(isset($dato)){
			if(isset($this->info_dependencias[$this->indice_dependencias[$dep]][$dato])){
				return $this->info_dependencias[$this->indice_dependencias[$dep]][$dato];	
			}else{
				return null;
			}
		}else{
			if(isset($this->info_dependencias[$this->indice_dependencias[$dep]])){
				return $this->info_dependencias[$this->indice_dependencias[$dep]];	
			}else{
				return null;
			}
		}
	}
//--------------------------------------------------------------------------------------------

	function info_definicion_dependencias()
	{
		return $this->info_dependencias;
	}
//--------------------------------------------------------------------------------------------

	function get_dependencias_clase($ereg_busqueda)
	//Devuelve las dependencias cuya clase coincide con la expresion regular pasada como parametro
	{
		$ok = array();
		for($a=0;$a<count($this->info_dependencias);$a++){
			if( preg_match("/".$ereg_busqueda."/", $this->info_dependencias[$a]['clase']) ){
				$ok[] = $this->info_dependencias[$a]["identificador"];
			}
		}
		return $ok;
	}
	
	
//*******************************************************************************************
//***********************************<  INTERFACE GRAFICA  >*********************************
//*******************************************************************************************

	protected function evaluar_existencia_interface_anterior()
	{
		if(isset($this->memoria["generacion_interface"]))
		{
			if( $this->memoria["generacion_interface"] == 1 ){
				$this->interface_existencia_previa = true;
			}
		}
		$this->memoria["generacion_interface"] = 0;		
	}

	protected function existio_interface_previa()
	{
		return $this->interface_existencia_previa;
	}

	protected function registrar_generacion_interface()
	{
		$this->memoria["generacion_interface"] = 1;		
	}

//*******************************************************************************************

	function barra_superior_especifica(){}
/*
 	@@acceso:
	@@desc: 
*/
	//Barra especifica de la clase, declarada en los hijos

	function barra_superior($titulo=null, $control_titulo_vacio=false, $estilo="objeto-barra-superior")
/*
 	@@acceso:
	@@desc: 
*/
	//Muestra la barra del objeto
	{
		//Marco la existencia de una interface previa
		$this->registrar_generacion_interface();
		if($control_titulo_vacio){
			if(trim($this->info["titulo"])==""){
				return;	
			}
		}
		if(!isset($titulo)){
			$titulo = $this->info["titulo"];	
		}
		echo "<table class='tabla-0' width='100%'><tr>\n";
		//Vinculo a los EDITORES	
		if(apex_pa_acceso_directo_editor){ 
			if( ($this->id[0]) == $this->solicitud->hilo->obtener_proyecto() ) {
				echo "<td class='$estilo'>";
				$this->vinculo_editor();
				echo "</td>\n";
			}
		}
		//Barra de colapsado
		$colapsado = "";
		if ($this->info['colapsable'] && isset($this->objeto_js)) {
			$colapsado = "style='cursor: hand;' onclick=\"{$this->objeto_js}.cambiar_colapsado();\" title='Mostrar / Ocultar'";
			echo "<td class='$estilo'>";
			$img_min = recurso::imagen_apl('sentido_asc_sel.gif', false);
			echo "<img id='colapsar_boton_{$this->objeto_js}' src='$img_min' $colapsado>";
			echo "</td>\n";
		}
		//Titulo
		echo "<td class='$estilo' width='99%'><span $colapsado>$titulo</span></td>\n";
		if(trim($this->info["descripcion"])!=""){
			echo "<td class='$estilo'>\n";
			echo recurso::imagen_apl("descripcion.gif",true,null,null,$this->info["descripcion"]);
			echo "</td>\n";
		}
		if($this->existe_ayuda()){
			$parametros = array("objeto"=>$this->info["objeto"],"proyecto"=>$this->info["proyecto"]);
			echo "<td class='$estilo'>\n";
			echo $this->solicitud->vinculador->obtener_vinculo_a_item("toba","/basicos/ayuda_obj",$parametros,true);
			echo "</td>\n";
		}
		//Barra especifica dependiente de la clase
		echo "<td class='$estilo'>";
		echo $this->barra_superior_especifica();
		echo "</td>\n";
		if (isset($this->objeto_js)) {
			//Barra de mensajeria
			echo "<td class='$estilo' id='barra_{$this->objeto_js}' style='display:none'>";
			echo "<a href='javascript: cola_mensajes.mostrar({$this->objeto_js})'>";
			echo recurso::imagen_apl('warning.gif', true, null, null, 'Muestra las notificaciones encontradas durante la �ltima operaci�n.');
			echo "</a>";
			echo "</td>\n";
		}
		echo "</tr></table>";
	}
//-----------------------------------------------------------------------------
	
	function vinculo_editor()
/*
 	@@acceso:
	@@desc: 
*/
	//Muestra vinculos a los editores
	{
		if(apex_pa_acceso_directo_editor)
		{
			if($this->info["reflexivo"]){
				$estilo = "objeto-editores-reflexivo";
			}else{
				$estilo = "objeto-editores";
			}
	
	  		echo "<table class='tabla-0' border='1'><tr>\n";
	        
			//Vinculo a la CABECERA del OBJETO
	        $vinc_cabecera = $this->solicitud->vinculador->obtener_vinculo_a_item(
	        					"toba","/admin/objetos/propiedades",
	        					array(apex_hilo_qs_zona=>implode(apex_qs_separador,$this->id)),
	        					true);        
	        if ($vinc_cabecera){
	    		echo "<td class='$estilo'>";
	    		echo $vinc_cabecera;
	    		echo "</td>\n";
	        }            
	
			//Vinculo al EDITOR del OBJETO
			$vinc_editor= $this->solicitud->vinculador->obtener_vinculo_a_item(
						$this->info["clase_editor_proyecto"],$this->info["clase_editor_item"],
						array(apex_hilo_qs_zona=>implode(apex_qs_separador,$this->id)),
						true);        
	
			if($vinc_editor && isset($this->info["clase_editor"])){
				echo "<td class='$estilo'>";
	            echo $vinc_editor;
				echo "</td>\n";
			}
	
			//Vinculo al EDITOR de VINCULOS del OBJETO
	        $vinc_editor_vinc= $this->solicitud->vinculador->obtener_vinculo_a_item(
	        		"toba","/admin/objetos/vinculos",
	        		array(apex_hilo_qs_zona=>implode(apex_qs_separador,$this->id)),
	        		true);
	
			if($vinc_editor_vinc && $this->info["clase_vinculos"]==1){
				echo "<td class='$estilo'>";
	            echo $vinc_editor_vinc;
				echo "</td>\n";
			}
	
			//Vinculo a las NOTAS del OBJETO
			$vinc_notas= $this->solicitud->vinculador->obtener_vinculo_a_item(
						"toba","/admin/objetos/notas",
						array(apex_hilo_qs_zona=>implode(apex_qs_separador,$this->id)),
						true);
	        if ($vinc_notas){
	    		echo "<td class='$estilo'>";
	            echo $vinc_notas;
	    		echo "</td>\n";
	        }
	        
			//Vinculo a la INFORMACION del OBJETO
			$vinc_info= $this->solicitud->vinculador->obtener_vinculo_a_item(
						"toba","/admin/objetos/info",
						array(apex_hilo_qs_zona=>implode(apex_qs_separador,$this->id)),
						true);
	        if ($vinc_info){
	    		echo "<td class='$estilo'>";
	            echo $vinc_info;
	    		echo "</td>\n";
	        }            

/*
			//Vinculo al plan de RUTEO de EVENTOS
			$vinc_info= $this->solicitud->vinculador->obtener_vinculo_a_item(
						"toba","/admin/objetos/dependencias",
						array(apex_hilo_qs_zona=>implode(apex_qs_separador,$this->id)),
						true);
	        if ($vinc_info && ($this->info['clase']) ){
	    		echo "<td class='$estilo'>";
	            echo $vinc_info;
	    		echo "</td>\n";
	        }            
*/
	   		echo "</tr></table>";
		}
	}
//--------------------------------------------------------------------------------------------
//  ATENCION: Estos m�todos se deber�an pasar a una clase intermedia objeto_ei
//--------------------------------------------------------------------------------------------

	//---Eventos
	public function definir_eventos()
	{
		$this->eventos = $this->get_lista_eventos();
	}
		
	public function set_eventos($eventos)
	{
		$this->eventos = $eventos;
	}
	
	public function set_evento_defecto($id)
	{
		$this->evento_por_defecto = $id;
	}
	
	public function agregar_observador($observador)
	{
		$this->observadores[] = $observador;
	}

	function eliminar_observador($observador){}

	protected function reportar_evento($evento)
	//Registro un evento en todos mis observadores
	{
		$parametros = func_get_args();
		$parametros	= array_merge(array($this->id_en_padre), $parametros);
		foreach(array_keys($this->observadores) as $id){
			//$this->observadores[$id]->registrar_evento( $this->id_en_padre, $evento, $parametros );			
			call_user_func_array(array($this->observadores[$id], 'registrar_evento'), $parametros);
		}
	}
	
	function hay_botones() 
	{
		foreach($this->eventos as $id => $evento ) {	
			if (!isset($evento['en_botonera']) || $evento['en_botonera']) {
				return true;
			}
		}
		return false;
	}	

	function obtener_botones()
	{
		//----------- Generacion
		echo "<table class='tabla-0' align='center' width='100%'>\n";
		echo "<tr><td align='right'>";
		foreach($this->eventos as $id => $evento )
		{
			if (!isset($evento['en_botonera']) || $evento['en_botonera']) {
				$tip = '';
				$clase = ( isset($evento['estilo']) && (trim( $evento['estilo'] ) != "")) ? $evento['estilo'] : "abm-input";
				$tab_order = 0;//Esto esta MAAL!!!
				$acceso = tecla_acceso( $evento["etiqueta"] );
				$html = $acceso[0]; //Falta concatenar la imagen
				$tecla = $acceso[1];
				$evento_js = eventos::a_javascript($id, $evento);
				$js = "onclick=\"{$this->objeto_js}.set_evento($evento_js);\"";
				echo "&nbsp;" . form::button_html( $this->submit."_".$id, $html, $js, $tab_order, $tecla, $tip, 'button', '', $clase);
			}
		}
		echo "</td></tr>\n";
		echo "</table>\n";
	}	
	
	//---SERVICIOS GRAFICOS
	public function colapsar()
	{
		$this->colapsado = true;
		$this->info['colapsable'] = true;
	}
	
	public function set_colapsable($colapsable)
	{
		$this->info['colapsable'] = $colapsable;
	}
	
	public function consumo_javascript_global()
	{
		return array('clases/objeto');
	}
	
	
	protected function obtener_javascript()
/*
	@@acceso: Actividad
	@@desc: Construye la clase javascript asociada al objeto
*/
	{
		$identado = js::instancia()->identado();
		echo "\n$identado//---------------- CREANDO OBJETO {$this->objeto_js} --------------  \n";
		$this->crear_objeto_js();
		$this->extender_objeto_js();
		echo "\n";
		$this->iniciar_objeto_js();
		echo "$identado//-----------------------------------------------------------------  \n";		
		return $this->objeto_js;
	}	
	
	protected function crear_objeto_js()
	{
		$identado = js::instancia()->identado();
		echo $identado."var {$this->objeto_js} = new objeto('{$this->objeto_js}');\n";
	}
	
	protected function extender_objeto_js()
	{

	}
	
	protected function iniciar_objeto_js()
	{
		$identado = js::instancia()->identado();
		//-- EVENTO por DEFECTO --
		if($this->evento_por_defecto != null && isset($this->eventos[$this->evento_por_defecto])){
			$evento = eventos::a_javascript($this->evento_por_defecto, $this->eventos[$this->evento_por_defecto]);
			echo js::instancia()->identado()."{$this->objeto_js}.set_evento_defecto($evento);\n";
		}
		if ($this->colapsado) {
			echo $identado."{$this->objeto_js}.colapsar();\n";
		}
		echo $identado."{$this->objeto_js}.iniciar();\n";
		//Se agrega al objeto al singleton toba
		echo $identado."toba.agregar_objeto({$this->objeto_js});\n";		
	}

	
}
?>

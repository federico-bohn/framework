<?php
/**
 * Padre de todas las clases que definen componentes
 * @package Objetos
 */
class objeto
{
	protected $solicitud;
	protected $id;
	protected $info;
	protected $info_dependencias;						//Definicion de las dependencias
	protected $indice_dependencias;					//Indice que mapea las definiciones de las dependencias con su
	protected $dependencias_indice_actual = 0;	
	protected $lista_dependencias;					//Lista de dependencias disponibles
	protected $dependencias = array();							//Array de sub-OBJETOS
	protected $memoria;
	protected $memoria_existencia_previa = false;
	protected $observaciones;
	protected $canal;										// Canal por el que recibe datos 
	protected $canal_recibido;							// Datos recibidos por el canal
	protected $estado_proceso;							// interno | string | "OK","ERROR","INFRACCION"
	protected $id_ses_g;									//ID global para la sesion
	protected $definicion_partes;						//indica el nombre de los arrays de metadatos que posee el objeto
	protected $exportacion_archivo;
	protected $exportacion_path;
	
	function __construct( $definicion )
	{
		// Compatibilidad hacia atras en el ID
		$this->id[0] = $definicion['info']['proyecto'];
		$this->id[1] = $definicion['info']['objeto'];
		//Cargo las variables internas que forman la definicion
		foreach (array_keys($definicion) as $parte) {
			$this->definicion_partes[] = $parte;
			$this->$parte = $definicion[$parte];
		}
		$this->solicitud = toba::get_solicitud();
		$this->log = toba::get_logger();
		//Recibi datos por el CANAL?
		$this->canal = apex_hilo_qs_canal_obj . $this->id[1];
		$this->canal_recibidos = toba::get_hilo()->obtener_parametro($this->canal);
		$this->id_ses_g = "obj_" . $this->id[1];
		$this->id_ses_grec = "obj_" . $this->id[1] . "_rec";
		//Manejo transparente de memoria
		$this->cargar_memoria();			//RECUPERO Memoria sincronizada
		$this->recuperar_estado_sesion();	//RECUPERO Memoria dessincronizada
		$this->cargar_info_dependencias();
		$this->log->debug("CONSTRUCCION: {$this->info['clase']}({$this->id[1]}): {$this->get_nombre()}.", 'toba');
		$this->configuracion();
	}

	function configuracion()
	{
	}

	function destruir()
	{
		//echo "Me estoy destruyendo " . $this->id[1] . "<br>";
		//Persisto informacion
		$this->memorizar();						//GUARDO Memoria sincronizada
		$this->guardar_estado_sesion();		//GUARDO Memoria dessincronizada
		//Llamo a los destructores de los OBJETOS anidados
		foreach(array_keys($this->dependencias) as $dependencia){
			$this->dependencias[$dependencia]->destruir();
		}
	}

	function get_clave_memoria_global()
	{
		return $this->id_ses_grec;
	}

	function get_txt()
	{
		return "objeto(".$this->id[1]."): ";	
	}

	function get_nombre()
	{
		return $this->info['nombre'];
	}

	function get_titulo()
	{
		return $this->info['titulo'];
	}

	function get_id()
	{
		return $this->id;	
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

	function existe_ayuda()
	{
		return (trim($this->info['objeto_existe_ayuda'])!="");
	}


//*******************************************************************************************
//**********************<  Comunicacion de informacion al USUARIO   >************************
//*******************************************************************************************	

	function informar_msg($mensaje, $nivel=null)
	//Guarda un  mensaje en la cola de mensajes
	{
		toba::get_cola_mensajes()->agregar($mensaje,$nivel);	
	}
	
	function informar($indice, $parametros=null,$nivel=null)
	//Obtiene un mensaje del repositorio y lo guarda en la cola de mensajes
	{
		$mensaje = $this->obtener_mensaje($indice, $parametros);
		$this->informar_msg($mensaje,$nivel);
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
			toba::get_hilo()->persistir_dato_sincronizado("obj_".$this->id[1],$this->memoria);
		}else{

		}
	}
	
	function cargar_memoria()
/*
 	@@acceso: objeto
	@@desc: Recupera la memoria que dejo una instancia anterior del objeto. (Setea $this->memoria)
*/
	{
		if($this->memoria = toba::get_hilo()->recuperar_dato_sincronizado("obj_".$this->id[1])){
			$this->memoria_existencia_previa = true;
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
			throw new excepcion_toba("Error cargando la MEMORIA del OBJETO. abms[". ($this->id[1]) ."]");
		}
	}

	function borrar_memoria()
/*
 	@@acceso: objeto
	@@desc: Dumpea la memoria
*/
	{
		unset($this->memoria);
		toba::get_hilo()->persistir_dato_sincronizado("obj_".$this->id[1],null);
	}

	function existio_memoria_previa()
	//Atencion, para que esto funcione antes hay que cargar la memoria
	{
		return $this->memoria_existencia_previa;
	}
	
//*******************************************************************************************
//****************************<  Memorizacion de PROPIEDADES   >*****************************
//*******************************************************************************************

	function mantener_estado_sesion()
	//Esta funcion retorna las propiedades que se desea persistir
	{
		/*$ref = new ReflectionClass($this);
		$props = array();
		foreach ($ref->getProperties() as $prop) {
			$nombre = $prop->getName();
			if (substr($nombre, 0, 3) === 's__') {
				$props[] = $nombre;
			}
		}*/		
		return array();
	}

	function recuperar_estado_sesion()
	//Recupera las propiedades guardadas en la sesion
	{
		if(toba::get_hilo()->existe_dato_global($this->id_ses_grec)){
			//Recupero las propiedades de la sesion
			$temp = toba::get_hilo()->recuperar_dato_global($this->id_ses_grec);
			if(isset($temp["toba__indice_objetos_serializados"]))	//El objeto persistio otros objetos
			{
				/*
					PERSISTENCIA de OBJETOS 
					-----------------------
					Hay una forma de no hacer este IF: 
						Que en el consumo de "mantener_estado_sesion" se indique que propiedades son objetos.
						Hay comprobar si la burocracia justifica el tiempo extra que implica este mecanismo o no.
				*/
				$objetos = $temp["toba__indice_objetos_serializados"];
				unset($temp["toba__indice_objetos_serializados"]);
				foreach(array_keys($temp) as $propiedad)
				{
					if(in_array($propiedad,$objetos)){
						//La propiedad es un OBJETO!
						$this->$propiedad = unserialize($temp[$propiedad]);
					}else{
						$this->$propiedad = $temp[$propiedad];
					}
				}
			}
			else //El objeto solo persistio variables
			{
				foreach(array_keys($temp) as $propiedad)
				{
					$this->$propiedad = $temp[$propiedad];
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
			for($a=0;$a<count($propiedades_a_persistir);$a++){
				//Existe la propiedad
				if(isset($this->$propiedades_a_persistir[$a])) {
					if(is_object($this->$propiedades_a_persistir[$a])){
						/*
							PERSISTENCIA de OBJETOS 
							-----------------------
							Esta es la forma mas sencilla de implementar esto para el caso en el que
							el elemento persistidor permanece inactivo durante n request y luego vuelve
							a la actividad. Lo malo es que que hay que saber que propiedades son objetos 
							y cuales no.
							ATENCION: 
								Hay que tener mucho cuidado con las referencias circulares:
								ej: 	un db_tablas posee un por composicion db_registros y
										el db_registros posee una referencia a su controlador 	
										que es el mismo el db_tablas...
								En casos como este es necesario definir __sleep en el objeto hijo, para
									anular el controlador y __wakeup en el padre para restablecerlo
						*/
						$temp[$propiedades_a_persistir[$a]] = serialize($this->$propiedades_a_persistir[$a]);
						//Dejo la marca de que serialize un OBJETO.
						$temp["toba__indice_objetos_serializados"][] = $propiedades_a_persistir[$a];
					}else{
						$temp[$propiedades_a_persistir[$a]] = $this->$propiedades_a_persistir[$a];
					}
				} else {
					//$this->log->error($this->get_txt() . " Se solocito mantener el estado de una propiedad inexistente: '{$propiedades_a_persistir[$a]}' ");
					//echo $this->get_txt() . " guardar_estado_sesion '{$propiedades_a_persistir[$a]}' == NULL <br>";
				}
			}
			if(isset($temp)){
				//ei_arbol($temp,"Persistencia PROPIEDADES " . $this->id[1]);
				$temp['toba__descripcion_objeto'] = '['. get_class($this). '] ' . $this->info['nombre'];
				toba::get_hilo()->persistir_dato_global($this->id_ses_grec, $temp, true);
			}else{
				//Si existia y las propiedades pasaron a null, hay que borrarlo
				toba::get_hilo()->eliminar_dato_global($this->id_ses_grec);
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
		toba::get_hilo()->eliminar_dato_global($this->id_ses_grec);
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
//*************************************<  DEPENDENCIAS  >************************************
//*******************************************************************************************

	function cargar_info_dependencias()
	{
		if (isset($this->info_dependencias)) {
			for($a=0;$a<count($this->info_dependencias);$a++){
				$this->indice_dependencias[$this->info_dependencias[$a]["identificador"]] = $a;//Columna de informacion donde esta la definicion
				$this->lista_dependencias[] = $this->info_dependencias[$a]["identificador"];
			}
		}
	}

	
	/**
	 * Accede a una dependencia del objeto, opcionalmente si la dependencia no esta cargada, la carga
	 *
	 * @param string $id Identificador de la dependencia dentro del objeto actual
	 * @param boolean $cargar_en_demanda En caso de que el objeto no se encuentre cargado en memoria, lo carga
	 * @return Objeto
	 */
	function dependencia($id, $carga_en_demanda = true)
	{
		if (! $this->dependencia_cargada($id) && $carga_en_demanda) {
			$this->cargar_dependencia($id);
		}
		return $this->dependencias[$id];
	}	
	
	/**
	*	Agregar dinámicamente una dependencia
	*/
	function agregar_dependencia( $identificador, $proyecto, $objeto )
	{
		$sig = count($this->info_dependencias);
		$sql = "SELECT 
					'$identificador' 	as identificador,
					o.proyecto 			as proyecto,
					o.objeto 			as objeto,
					o.fuente_datos		as fuente,
					o.clase				as clase,
					o.subclase			as subclase,
					o.subclase_archivo	as subclase_archivo,
					c.archivo			as clase_archivo
				FROM
					apex_objeto o,
					apex_clase c
				WHERE
					o.objeto = '$objeto' AND
					o.proyecto = '$proyecto' AND
					o.clase = c.clase AND
					o.clase_proyecto = c.proyecto
		";
		$res = info_instancia::get_db()->consultar($sql);
		$this->info_dependencias[$sig] = $res[0];
		$this->indice_dependencias[$identificador] = $sig;
		$this->lista_dependencias[] = $identificador;	
	}

	function cargar_dependencia($identificador, $parametros=null)
 	{
		//-[0]- La dependencia ya esta cargada?
		if(isset($this->dependencias[$identificador])){
			return 999;
		}
		//-[1]- El indice es valido?
		if(!isset($this->indice_dependencias[$identificador])){
			throw new excepcion_toba("OBJETO [cargar_dependencia]: No EXISTE una dependencia asociada al indice [$identificador].");
		}
		$posicion = $this->indice_dependencias[$identificador];
		$clase = $this->info_dependencias[$posicion]['clase'];
		$clave['proyecto'] = $this->info_dependencias[$posicion]['proyecto'];
		$clave['componente'] = $this->info_dependencias[$posicion]['objeto'];
		$this->dependencias[$identificador] = constructor_toba::get_runtime( $clave, $clase );
		return true;
	}

	/**
	 * Retorna verdadero si la dependencia fue cargada en este pedido de página
	 */
	function dependencia_cargada($id)
	{
		return isset($this->dependencias[$id]);
	}
	
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
	

}
?>
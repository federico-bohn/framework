<?php
require_once("objeto_ci.php");	//Ancestro de todos los OE
/*
	//ATENCION Ordenar los eventos antes de rutearlos... (seleccion ultimos)
*/

class objeto_ci_me extends objeto_ci
/*
 	@@acceso: nucleo
	@@desc: Descripcion
*/
{
	//Etapas
	var $indice_etapas;
	var $etapa_actual;
	var $etapa_previa;
	//Dependencias
	var $dependencias_previas;

	function objeto_ci_me($id)
/*
 	@@acceso: nucleo
	@@desc: Muestra la definicion del OBJETO
*/
	{
		parent::objeto_ci($id);
		//Inicializo informacion
		for($a = 0; $a<count($this->info_ci_me_etapa);$a++){
			//Preparo el nombre del SUBMIT de cada etapa
			$this->info_ci_me_etapa[$a]["submit"] = $this->submit."_".$this->info_ci_me_etapa[$a]["posicion"];
			//Indice de acceso por etapas
			$this->indice_etapas[$this->info_ci_me_etapa[$a]["posicion"]] = $a;
		}
	}
	//-------------------------------------------------------------------------------

	function obtener_definicion_db()
/*
 	@@acceso:
	@@desc: 
*/
	{
		$sql = parent::obtener_definicion_db();
		//-- CI - Multiples etapas --------------
		$sql["info_ci_me_etapa"]["sql"] = "SELECT	posicion			  as posicion,
													etiqueta			  as etiqueta,
													descripcion			  as descripcion,
													objetos				  as objetos,
													objetos_adhoc		as	objetos_adhoc,
													pre_condicion		as	pre_condicion,	
													post_condicion	    as	post_condicion,	
													ev_procesar		    as	ev_procesar,
													ev_cancelar			as ev_cancelar
										FROM	apex_objeto_mt_me_etapa
										WHERE	objeto_mt_me_proyecto='".$this->id[0]."'
										AND	objeto_mt_me = '".$this->id[1]."'
										ORDER	BY	posicion;";
		$sql["info_ci_me_etapa"]["tipo"]="x";
		$sql["info_ci_me_etapa"]["estricto"]="1";
		return $sql;
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//---------------------  Manejo de DEPENDENCIAS  --------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function obtener_dependencias( $etapa )
/*
 	@@acceso: actividad
	@@desc: Devuelve las dependencias asociadas especificamente con el ME
*/
	{
		$dependencias = array();
		if( trim( $this->info_ci_me_etapa[$this->indice_etapas[$etapa]]["objetos_adhoc"] )!="" )
		{
			$metodo = $this->info_ci_me_etapa[$this->indice_etapas[$etapa]]["objetos_adhoc"];
			//ATENCION: hay que controlar que las DEPENDENCIAS existan...
			$dependencias = $this->cn->$metodo();
		}
		elseif( trim($this->info_ci_me_etapa[$this->indice_etapas[$etapa]]["objetos"])!="" )
		{
			$dependencias = explode(",",$this->info_ci_me_etapa[$this->indice_etapas[$etapa]]["objetos"]);
			$dependencias = array_map("trim",$dependencias);
		}
		return $dependencias;
		/*
		else{
			//Todas las etapas
			for($a=0;$a<count($this->info_ci_me_etapa);$a++)
			{
				$temp = null;
				if(isset($this->info_ci_me_etapa[$a]["objetos"])){
					$temp = explode(",",$this->info_ci_me_etapa[$a]["objetos"]);
					$temp = array_map("trim",$temp);
				}
				if(is_array($temp)) $dependencias = array_merge($dependencias, $temp) ;
			}
		}*/
	}
	//-------------------------------------------------------------------------------

	function cargar_dependencias_activas()
	{
		$this->cargar_dependencias_actuales();
		$this->cargar_dependencias_previas();
	}
	//-------------------------------------------------------------------------------

	function cargar_dependencias_previas()
	{
		if(isset($this->etapa_previa)){
			$this->dependencias_previa = $this->obtener_dependencias($this->etapa_previa);
			$dependencias = null;
			foreach($this->dependencias_previa as $dep){
				if(!isset($this->dependencias[$dep])){
					$dependencias[] = $dep;
				}
			}
			if(isset($dependencias)){
				$this->cargar_dependencias($this->dependencias_previa);
			}
		}		
	}

	function cargar_dependencias_actuales()
	{
		$this->dependencias_actual = $this->obtener_dependencias($this->etapa_actual);	
		//Controlo no volver a cargar una dependencia
		$dependencias = null;
		foreach($this->dependencias_actual as $dep){
			if(!isset($this->dependencias[$dep])){
				$dependencias[] = $dep;
			}
		}
		if(isset($dependencias)){
			$this->cargar_dependencias($dependencias);
		}
	}
	//-------------------------------------------------------------------------------

	function cargar_dependencias_inactivas()
/*
 	@@acceso: interno
	@@desc: Carga las dependencias
*/
	{
		//Cargo todas las dependencias (Las instanciadas no se repiten)
		$dependencias_activas = array_keys($this->dependencias);
		//$dependencias = $this->lista_dependencias;
		$dependencias = $this->obtener_dependencias();
		foreach($dependencias as $dep){
			if(!(in_array($dep, $dependencias_activas))){
				$dependencias_inactivas[] = $dep;
			}
		}
		$this->cargar_dependencias($dependencias_inactivas);
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//---------------------  PROCESAMIENTO de ETAPAS  -------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function evaluar_etapa()
	{
		$this->etapa_actual = null;
		$this->etapa_previa = null;
        $navegando_tabs = false;     //Indica que se esta navegando por el objeto_ci

        for($a=0;$a<count($this->info_ci_me_etapa);$a++)
        {
            if(isset($_POST[$this->info_ci_me_etapa[$a]["submit"]])){
            	$this->etapa_actual = $this->info_ci_me_etapa[$a]["posicion"];
            	$this->etapa_previa = $this->memoria["etapa"];
                $navegando_tabs = true;
   				//echo "Etapa " . $this->etapa_actual;
            	break;			
            }
        } 

		//Toda la navegacion interna es por POST
		if(!$navegando_tabs){
			//Navegacion de TABS: en que etapa entre
			//Se activo un subelemento, mantengo la etapa
			if(isset($this->memoria["etapa"])){
				$this->etapa_actual = $this->memoria["etapa"];
				$this->etapa_previa = $this->memoria["etapa"];
			}else{
				//--> Entrada a la ETAPA inicial!!
				//echo "Estado INICIAL";
				//$this->limpiar_memoria_global();
				$this->etapa_actual = $this->get_etapa_inicial();
				//$this->cn->reset();
			}
		}
		$this->memoria["etapa"] = $this->etapa_actual;
	}
	//-------------------------------------------------------------------------------

	function get_etapa_inicial()
	{
		return $this->info_ci_me_etapa[0]["posicion"];
	}
	//-------------------------------------------------------------------------------
	

	function procesar()
	{
		$this->determinar_modelo_opciones();
		//Veo en que etapa estoy.
		$this->evaluar_etapa();
		if( ! $this->controlar_cancelacion() )
		{
			try{
				//-[1]- Procesamiento de la <<< SALIDA de la etapa PREVIA >>>
				if(isset($this->etapa_previa)){
					$this->disparar_salida();
				}
				//-[2]- Procesamiento de la <<< ENTRADA a etapa ACTUAL >>>
				$this->disparar_entrada();

				//-[3]- Se activo una orden de procesamiento?
				if( $this->controlar_procesamiento() ){
					$this->cargar_etapa_inicial();					
				}
			} catch(excepcion_toba $e) 
			{
				$this->cargar_etapa_anterior();
				$this->informar_msg($e->getMessage(), 'error');
			}
		}
		else{
			//El usuario cancelo la operacion
			$this->cargar_etapa_inicial();					
		}
	}
	//-------------------------------------------------------------------------------
	
	function disparar_salida()
	{
		//Creo las dependencias de esta etapa
		$this->cargar_dependencias_previas();
		$proceso_salida_especifico = "procesar_salida_" . $this->etapa_previa;
		if(method_exists($this, $proceso_salida_especifico)){
			return $this->$proceso_salida_especifico();
		}else{
			//Utilizo el procesamiento generico
			return $this->procesar_salida();
		}
	}
	//-------------------------------------------------------------------------------

	function procesar_salida()
	//Salida GENERICA a una ETAPA
	{
		//echo "SALIDA<br>";
		$this->controlar_eventos($this->dependencias_previa);
		//--> controlo que se cumplo la POST-Condicion!!!
		if($metodo = $this->info_ci_me_etapa[$this->indice_etapas[$this->etapa_previa]]["post_condicion"]){
			return $this->cn->$metodo();
		}
		return true;	
	}
	//-------------------------------------------------------------------------------

	function disparar_entrada()
	//Dispara la entrada a una etapa
	{
		//Creo las dependencias de esta etapa
		$this->cargar_dependencias_actuales();
		$proceso_entrada_especifico = "procesar_entrada_" . $this->etapa_actual;
		if(method_exists($this, $proceso_entrada_especifico)){
			return $this->$proceso_entrada_especifico();
		}else{
			//Utilizo el procesamiento generico
			return $this->procesar_entrada();
		}
	}
	//-------------------------------------------------------------------------------

	function procesar_entrada()
	//Entrada GENERICA a una ETAPA
	{
		//echo "ENTRADA<br>";
		//Controlo la PRE-Condicion
		if($metodo = $this->info_ci_me_etapa[$this->indice_etapas[$this->etapa_actual]]["pre_condicion"]){
			$this->cn->$metodo();
		}
		// Cargo los elementos de interface
		$this->cargar_datos_dependencias();
		// Cargar de los DAOS
		$this->cargar_daos();
		return true;	
	}
	//-------------------------------------------------------------------------------

	function cargar_etapa_anterior()
	//Carga la etapa anterior a la actual
	{
		$this->etapa_actual = $this->etapa_previa;
		$this->memoria["etapa"] = $this->etapa_actual;
		$this->disparar_entrada();
	}
	//-------------------------------------------------------------------------------
	
	function cargar_etapa_inicial()
	//Carga la etapa inicial de la operacion
	{
		$this->etapa_actual = $this->get_etapa_inicial();
		$this->memoria["etapa"] = $this->etapa_actual;
		$this->disparar_entrada();
	}

	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//--------------------------------  SALIDA  HTML --------------------------------
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------

	function obtener_interface()
/*
 	@@acceso: interno
	@@desc: Genera la INTERFACE de la transaccion.
*/
	{
		//-[2]- Genero la SALIDA
		$ancho = isset($this->info_ci["ancho"]) ? $this->info_ci["ancho"] : "100%";
		$alto = isset($this->info_ci["alto"]) ? "height='" . $this->info_ci["alto"] . "'" : "";
		echo "<table width='$ancho' $alto class='tabla-0'>\n";
		//Tabs
		echo "<tr><td class='celda-vacia'>";
		$this->obtener_barra_navegacion();
		echo "</td></tr>\n";
		//Interface de la etapa correspondiente
		echo "<tr><td class='tabs-contenedor'>";
		//Las hijas cambian la forma de mostrar la interface para una etapa?
		$interface_especifica = "obtener_interface_" . $this->etapa_actual;
		if(method_exists($this, $interface_especifica)){
			$this->$interface_especifica();
		}else{
			$this->interface_estandar();
		}
		echo "</td></tr>\n";
		echo "</table>\n";
	}
	//-------------------------------------------------------------------------------

	function interface_estandar()
	{
		parent::obtener_interface();
	}
	//-------------------------------------------------------------------------------
	
	function generar_opciones_estandar()
/*
 	@@acceso: interno
	@@desc: Genera los BOTONES del Marco Transaccional
*/
	{
		if($this->info_ci_me_etapa[$this->indice_etapas[$this->etapa_actual]]["ev_procesar"]){
			echo form::submit($this->submit,$this->submit_etiq,"abm-input");
		}
		if($this->info_ci_me_etapa[$this->indice_etapas[$this->etapa_actual]]["ev_cancelar"]){
			echo "&nbsp;" . form::button("boton", $this->cancelar_etiq ,"onclick=\"document.location.href='".$this->solicitud->vinculador->generar_solicitud(null,null,array($this->flag_cancelar_operacion=>1),true)."';\"","abm-input");
		}
	}																		
	//-------------------------------------------------------------------------------
}
?>

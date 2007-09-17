<?php 

class ci_admin_asistentes extends toba_ci
{
	protected $s__datos_asistente = array();
	protected $s__clave_molde;
	protected $s__opciones_generacion;
	protected $s__formulario_tipo;
	protected $s__molde_preexistente = false;

	function ini__operacion()
	{
		if (! toba::zona()->cargada()) {
			throw new toba_error('La operación se debe invocar desde la zona de un item');
		} else {
			$info = toba::zona()->get_info();
			if($info['molde']) {					//Ya existe un molde
				$this->s__molde_preexistente = true;
				$this->s__datos_asistente = toba_info_editores::get_lista_tipo_molde($info['molde_tipo_operacion']);
				$this->cargar_editor_molde();
				$this->dep('asistente')->set_molde($info['proyecto'], $info['molde']);
				$this->set_pantalla('pant_edicion');				
			}
		}		
	}

	function ini()
	{
		if ( $this->s__datos_asistente ) {
			$this->cargar_editor_molde();
		}
	}
	
	function cargar_editor_molde($forzar=false)
	{
		if( !$this->existe_dependencia('asistente') || $forzar ) {
			$this->agregar_dependencia('asistente', 'toba_editor', $this->s__datos_asistente['ci']);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- API para ASISTENTES embebidos ------------------------------------------------
	//-----------------------------------------------------------------------------------	

	function get_datos_basicos()
	{
		$info_item = toba::zona()->get_info();
		$datos['item'] = $info_item['item'];
		$datos['proyecto'] = $info_item['proyecto'];
		$datos['operacion_tipo'] = $this->s__datos_asistente['operacion_tipo'];
		return $datos;
	}
	
	//-----------------------------------------------------------------------------------
	//---- Elegir tipo ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------	
	
	function conf__form_tipo_operacion()
	{
		if (isset($this->s__formulario_tipo)) {
			return $this->s__formulario_tipo;
		}
	}
	
	function evt__form_tipo_operacion__modificacion($datos)
	{
		$this->s__formulario_tipo = $datos;
		$this->s__datos_asistente = toba_info_editores::get_lista_tipo_molde($this->s__formulario_tipo['tipo']);
		$this->cargar_editor_molde(true);
	}	

	function evt__siguiente_editar()
	{
		$this->set_pantalla('pant_edicion');	
	}

	//-----------------------------------------------------------------------------------
	//---- Editar ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------	
	
	function conf__pant_edicion()
	{
		$this->pantalla()->set_descripcion('Edición de un '.$this->s__datos_asistente['descripcion_corta']);
		$this->pantalla()->agregar_dep('asistente');		
		if( $this->s__molde_preexistente ) {
			$this->pantalla()->eliminar_evento('volver_editar');	
		}
		$completo = $this->dep('asistente')->posee_informacion_completa();
		if( $completo !== true) {
			if (is_array($completo)) {
				$this->pantalla()->set_descripcion('Datos faltantes: <ul><li>'.implode('</li><li>', $completo).'</ul>');
			}
			$this->pantalla()->eliminar_evento('siguiente_generar');				
		}
	}
	
	function evt__volver_editar()
	{
		$this->set_pantalla('pant_tipo_operacion');	
	}
	
	function evt__siguiente_generar()
	{
		$this->dep('asistente')->sincronizar();
		$this->s__clave_molde = $this->dep('asistente')->get_clave_molde();
		if( $this->generacion_requiere_confirmacion() ) {
			$this->set_pantalla('pant_confirmacion');	
		} else {
			$this->evt__generar();
		}
	}

	function generacion_requiere_confirmacion()
	{
		try {
			$bloqueos = $this->asistente(true)->get_bloqueos();
			if(! empty($bloqueos) ) {
				return true;
			}
			$confirmaciones = $this->asistente()->get_opciones_generacion();
			if(! empty($confirmaciones) ) {
				return true;
			}
			return false;
		} catch ( toba_error_asistentes $e ) {
			toba::notificacion()->agregar("El molde que desea cargar posee errores en su definicion: " . $e->getMessage() );
		}		
	}

	//-----------------------------------------------------------------------------------
	//---- Generación ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------	

	function conf__pant_confirmacion()
	{
		try {
			//Si hay algun tema bloqueante, no dejo hacer nada
			$bloqueos = $this->asistente(true)->get_bloqueos();
			if(! empty($bloqueos)) {
				$this->pantalla()->eliminar_evento('generar');
				$this->pantalla()->eliminar_dep('form_generaciones');
				toba::notificacion()->agregar('Existen problemas que imposibilitan la ejecución del molde. '
												.' Por favor edite el mismo y vuelva a intentar. '
												.'Los errores se describen a continuacion.');
				foreach($bloqueos as $bloqueo) {
					toba::notificacion()->agregar($bloqueo);	
				}
			}
			// Si no hay opciones de generacion, excluyo el form de opciones
			$opciones = $this->asistente()->get_opciones_generacion();
			if(empty($opciones)) {
				$this->pantalla()->eliminar_dep('form_generaciones');
			}
		} catch ( toba_error_asistentes $e ) {
			toba::notificacion()->agregar("El molde que desea cargar posee errores en su definicion: " . $e->getMessage() );
			$this->pantalla()->eliminar_evento('generar');
			$this->pantalla()->eliminar_dep('form_generaciones');
		}
	}
	
	function evt__volver_generar()
	{
		$this->set_pantalla('pant_edicion');	
	}

	//--- Opciones de generacion ----

	function conf__form_generaciones($componente)
	{
		$componente->set_datos( $this->asistente()->get_opciones_generacion() );
	}
	
	function evt__form_generaciones__modificacion($datos)
	{
		$this->s__opciones_generacion = $datos;
	}

	function evt__generar()
	{
		$this->asistente()->crear_operacion(toba::zona()->get_info('item'), $this->s__opciones_generacion );
	}	

	function asistente($reset=false)
	{
		if($reset || !isset($this->asistente)) {
			$this->asistente = toba_catalogo_asistentes::cargar_por_molde(	$this->s__clave_molde['proyecto'], 
																			$this->s__clave_molde['molde'] );
			$this->asistente->preparar_molde();
		}
		return $this->asistente;
	}
}
?>
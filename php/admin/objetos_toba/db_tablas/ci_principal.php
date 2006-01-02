<?php
require_once('admin/objetos_toba/ci_editores_toba.php'); 
/*
	Cosas faltantes:

		- Control de que existan dependencias
		- Borrado de dependencias
		- Validacion de relaciones
*/

class ci_principal extends ci_editores_toba
{
	protected $seleccion_relacion;
	protected $seleccion_relacion_anterior;

	function mantener_estado_sesion()
	{
		$propiedades = parent::mantener_estado_sesion();
		$propiedades[] = "seleccion_relacion";
		$propiedades[] = "seleccion_relacion_anterior";
		return $propiedades;
	}

	//*******************************************************************
	//*****************  PROPIEDADES BASICAS  ***************************
	//*******************************************************************

	function evt__base__carga()
	{
		return $this->get_entidad()->tabla("base")->get();
	}

	function evt__base__modificacion($datos)
	{
		$this->get_entidad()->tabla("base")->set($datos);
	}

	function evt__prop_basicas__carga()
	{
		return $this->get_entidad()->tabla("prop_basicas")->get();
	}

	function evt__prop_basicas__modificacion($datos)
	{
		$this->get_entidad()->tabla("prop_basicas")->set($datos);
	}

	//*******************************************************************
	//**  DEPENDENCIAS  *************************************************
	//*******************************************************************

	function evt__dependencias__carga()
	{
		return $this->get_entidad()->tabla('dependencias')->get_filas(null,true);	
	}

	function evt__dependencias__modificacion($datos)
	{
		foreach ($datos as $id => $dep) {
			switch ($dep[apex_ei_analisis_fila]) {
				case 'B':
					// Si se borra una dependencias hay que borrar antes las relaciones donde participa
					$id_dep = $this->get_entidad()->tabla('dependencias')->get_fila_columna($id, 'identificador');					
					$this->eliminar_relaciones_con_dependencia($id_dep);
					break;
				case 'M':
					//Si se modifica el identificador de una dependencia, propagarlo a las relaciones
					$id_anterior = $this->get_entidad()->tabla('dependencias')->get_fila_columna($id, 'identificador');
					$id_nuevo = $dep['identificador'];
					if ($id_anterior != $id_nuevo)
						$this->modificar_id_en_relaciones($id_anterior, $id_nuevo);
					break;
			}
		}
		
		$this->get_entidad()->tabla('dependencias')->procesar_filas($datos);
	}

	//*******************************************************************
	//**  RELACIONEs  *************************************************
	//*******************************************************************

	function get_tabla_relaciones()
	//Abastecimiento al CI de relaciones
	{
		return $this->get_entidad()->tabla("relaciones");	
	}

	function get_lista_tablas()
	{
		$datos = array();
		$tablas = $this->get_entidad()->tabla("dependencias")->get_filas();
		for($a=0;$a<count($tablas);$a++){
			$datos[$a]['objeto'] = $tablas[$a]['identificador']. "," .$tablas[$a]['objeto_proveedor'];
			$datos[$a]['desc'] = $tablas[$a]['identificador'];
		}
		return $datos;
	}

	function evt__salida__relaciones()
	{
		$this->dependencia('relaciones')->limpiar_seleccion();
	}
	
	/**
	*	Elimina toda relacion que haga referencia a la dependencia 
	*/
	function eliminar_relaciones_con_dependencia($id_dep)
	{
		$relaciones = $this->get_entidad()->tabla("relaciones")->get_filas(array(), true);
		foreach ($relaciones as $id => $relacion) {
			if ($relacion['hijo_id'] == $id_dep || $relacion['padre_id'] == $id_dep) {
				$this->get_entidad()->tabla("relaciones")->eliminar_fila($id);
			}
		}
	}
	
	function modificar_id_en_relaciones($anterior, $nuevo)
	{
		$relaciones = $this->get_entidad()->tabla("relaciones")->get_filas(array(), true);
		foreach ($relaciones as $id => $relacion) {
			if ($relacion['hijo_id'] == $anterior) {
				$this->get_entidad()->tabla('relaciones')->set_fila_columna_valor($id, 'hijo_id', $nuevo);
			}
			if ($relacion['padre_id'] == $anterior) {
				$this->get_entidad()->tabla('relaciones')->set_fila_columna_valor($id, 'padre_id', $nuevo);
			}
		}
	}
	
	//---------------------------------------------------------------------------
	//--------------------    SINCRONIZACION     --------------------------------
	//---------------------------------------------------------------------------	
	
	function evt__opciones__carga()
	{
		return $this->get_entidad()->tabla("prop_basicas")->get();
	}
	
	function evt__opciones__modificacion($datos)
	{
		return $this->get_entidad()->tabla("prop_basicas")->set($datos);
	}
	
	//*******************************************************************
	//** PROCESAR  ******************************************************
	//*******************************************************************

	function evt__procesar()
	{
		//Se retrasa el chequeo de constraints para permitir la modificacion de ident. de dependencias
		$this->get_entidad()->get_persistidor()->retrasar_constraints();
		
		//Seteo los datos asociados al uso de este editor
		$this->get_entidad()->tabla('base')->set_fila_columna_valor(0,"proyecto",toba::get_hilo()->obtener_proyecto() );
		//$this->get_entidad()->tabla('base')->set_fila_columna_valor(0,"proyecto","toba_testing" );
		$this->get_entidad()->tabla('base')->set_fila_columna_valor(0,"clase_proyecto", "toba" );
		$this->get_entidad()->tabla('base')->set_fila_columna_valor(0,"clase", "objeto_datos_relacion" );
		//Sincronizo el DBT
		$this->get_entidad()->sincronizar();	
	}
	//-------------------------------------------------------------------
}
?>

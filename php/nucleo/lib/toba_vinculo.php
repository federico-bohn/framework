<?php

/**
 * Mantiene un vinculo especifico y brinda una api para poder manipularlo
 * @package Centrales
 * @jsdoc vinculador vinculador
 */
class toba_vinculo
{
	private $item;
	private $proyecto;
	private $parametros;// = array();
	private $opciones;// = array();
	private $target;
	private $popup = 0;
	private $popup_parametros = array();
	private $popup_parametros_validos = array('width','height','scrollbars','resizable');

	function __construct($proyecto=null, $item=null, $popup=null, $opciones_popup=null)
	{
		if(isset($proyecto)&&isset($item)){
			$this->set_item($proyecto, $item);	
		}
		if($popup){
			$this->activar_popup();
		}
		if(isset($opciones_popup)){
			//Parseo del formato actual de definicion
			$temp = explode(',',$opciones_popup);
			$temp = array_map('trim',$temp);
			foreach($temp as $opcion) {
				$o = explode(':',$opcion);
				$o = array_map('trim',$o);
				$popup_parametros[$o[0]] = $o[1];
			}	
			$this->set_popup_parametros( $popup_parametros );
		}
	}
	
	/**
	 * Cambia la operaci�n destino del vinculo
	 */
	function set_item( $proyecto, $item )
	{
		$this->item = $item;
		$this->proyecto = $proyecto;
	}

	function get_item()
	{
		return $this->item;
	}
	
	function get_proyecto()
	{
		return $this->proyecto;
	}
	
	/**
	 * Cambia los parametros de la URL generada por el vinculo
	 */	
	function set_parametros( $parametros )
	{
		$this->parametros = $parametros;	
	}

	/**
	 * Agrega parametros a la URL generada por el vinculo
	 */
	function agregar_parametro($clave, $valor)
	{
		$this->parametros[$clave] = $valor;
	}
	
	/**
	 * Agrega a la URL generado un par�metro que carga autom�ticamente la zona de la operaci�n destino del v�nculo
	 * @param mixed $editable Valor com�n de los items a cargar en la zona
	 * @see toba_zona
	 */
	function set_editable_zona($editable)
	{
		$this->parametros[apex_hilo_qs_zona] = toba::vinculador()->variable_a_url($editable);
	}
	
	/**
	 * Determina si el vinculo actual propaga el editable de la zona (si tiene zona y esta cargada)
	 * @param boolean $propagar
	 * @see toba_zona
	 */
	function set_propagar_zona($propagar=true)
	{
		$this->opciones['zona'] = $propagar;
	}

	function get_parametros()
	{
		return $this->parametros;	
	}

	function set_opciones($datos)
	{
		$this->opciones = $datos;
	}
	
	function get_opciones()
	{
		return $this->opciones;
	}

	function agregar_opcion($clave, $valor)
	{
		$this->opciones[$clave] = $valor;
	}

	function activar_popup()
	{
		$this->popup = 1;	
	}

	function desactivar_popup()
	{
		$this->popup = 0;	
	}

	function estado_popup()
	{
		return $this->popup;
	}

	function set_popup_parametros($parametros)
	{
		$this->popup_parametros = $parametros;	
	}

	function set_popup_parametro($clave, $valor)
	{
		$this->popup_parametros[$clave] = $valor;	
	}

	function get_popup_parametros()
	{
		return $this->popup_parametros;	
	}
	
	function set_target($id)
	{
		$this->target = $id;	
	}
	
	function get_target()
	{
		return $this->target;	
	}
	
}
?>
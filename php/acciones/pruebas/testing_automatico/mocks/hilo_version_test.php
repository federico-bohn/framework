<?php
require_once('nucleo/browser/hilo.php');

class hilo_version_test extends hilo
{
	protected $sincronizada;
	
	function __construct()
	{
	}
	
	function persistir_dato($indice, $datos)
	{
		$this->sincronizada[$indice] = $datos;
	}
	
	function recuperar_dato($indice)
	{
		return $this->sincronizada[$indice];
	}	
	

}


?>
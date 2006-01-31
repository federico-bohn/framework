<?php
require_once('lib/elemento_modelo.php');
require_once('modelo/procesos/proyecto_exportador.php');
require_once('modelo/procesos/proyecto_compilador.php');
/*
	FALTA:
		- Control de que se referencia a un proyecto VALIDO
*/
class proyecto extends elemento_modelo
{
	private $instancia;				
	private $identificador;
	private $dir;

	public function __construct( $directorio_raiz, $instancia, $identificador )
	{
		parent::__construct( $directorio_raiz );
		$this->instancia = $instancia;
		$this->identificador = $identificador;
		if ( $this->identificador == 'toba' ) {
			$this->dir = $this->dir_raiz . '/php/admin';	
		} else {
			$this->dir = $this->dir_raiz . '/proyectos/' . $this->identificador;	
		}
	}

	static function nombre_valido( $nombre )
	{
		if ( trim( $nombre ) == '' ) {
			throw new excepcion_toba("ATENCION: Es necesario definir el proyecto sobre el cual se va a trabajar");	
		}
	}
	
	//-----------------------------------------------------------
	//	Informacion
	//-----------------------------------------------------------

	function get_id()
	{
		return $this->identificador;
	}
	
	function get_instancia()
	{
		return $this->instancia;	
	}

	function get_dir()
	{
		return $this->dir;	
	}

	function get_dir_componentes()
	{
		return $this->dir . '/metadatos/componentes';
	}
	
	function get_dir_tablas()
	{
		return $this->dir . '/metadatos/tablas';
	}

	function get_dir_componentes_compilados()
	{
		return $this->dir . '/metadatos_compilados/componentes';
	}

	//-----------------------------------------------------------
	//	Procesos
	//-----------------------------------------------------------

	function exportar()
	{
		try {
			$exportador = new proyecto_exportador( $this );
			$exportador->procesar();
		} catch ( excepcion_toba $e ) {
			$this->manejador_interface->error( 'Ha ocurrido un error durante la exportacion.' );
			$this->manejador_interface->mensaje( $e->getMessage() );
		}
	}

	function compilar()
	{
		try {
			$compilador = new proyecto_compilador( $this );
			$compilador->procesar();
		} catch ( excepcion_toba $e ) {
			$this->manejador_interface->error( 'Ha ocurrido un error durante la compilacion.' );
			$this->manejador_interface->mensaje( $e->getMessage() );
		}
	}
}
?>
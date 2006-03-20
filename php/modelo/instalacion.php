<?
require_once('modelo/lib/elemento_modelo.php');
require_once('nucleo/lib/manejador_archivos.php');
require_once('modelo/lib/version_toba.php');
require_once('nucleo/lib/ini.php');

/**
*	@todo:	Control de que la estructura de los INIs sea correcta
*/
class instalacion extends elemento_modelo
{
	const db_encoding_estandar = 'LATIN1';
	const directorio_base = 'instalacion';
	const info_basica = 'instalacion.ini';
	const info_basica_titulo = 'Configuracion de la INSTALACION';
	const info_bases = 'bases.ini';
	const info_bases_titulo = 'Configuracion de BASES de DATOS';
	private $dir;							// Directorio con info de la instalacion.
	private $ini_bases;						// Informacion de bases de datos.
	private $ini_instalacion;				// Informacion basica de la instalacion.
	private $ini_cargado = false;

	function __construct()
	{
		$this->dir = self::dir_base();
	}

	function cargar_info_ini()
	{
		if (!$this->ini_cargado) {
			//--- Levanto la CONFIGURACION de bases
			$archivo_ini_bases = $this->dir . '/' . self::info_bases;
			if ( ! is_file( $archivo_ini_bases ) ) {
				throw new excepcion_toba("INSTALACION: La instalacion '".toba_dir()."' es invalida. (El archivo de configuracion '$archivo_ini_bases' no existe)");
			} else {
				//  BASE
				$this->ini_bases = parse_ini_file( $archivo_ini_bases, true );
			}
			//--- Levanto la CONFIGURACION de bases
			$archivo_ini_instalacion = $this->dir . '/' . self::info_basica;
			if ( ! is_file( $archivo_ini_instalacion ) ) {
				throw new excepcion_toba("INSTALACION: La instalacion '".toba_dir()."' es invalida. (El archivo de configuracion '$archivo_ini_instalacion' no existe)");
			} else {
				//  BASE
				$this->ini_instalacion = parse_ini_file( $archivo_ini_instalacion );
			}
			$this->ini_cargado = true;
		}
	}

	//-----------------------------------------------------------
	//	Manejo de subcomponentes
	//-----------------------------------------------------------
		
	function get_instancias()
	{
		$instancias = array();
		foreach( instancia::get_lista() as $instancia ) {
			$instancias[ $instancia ] = new instancia( $this, $instancia );	
			$instancias[ $instancia ]->set_manejador_interface( $this->manejador_interface );	
		}
		return $instancias;
	}
	
	
	//-------------------------------------------------------------
	//-- Informacion general
	//-------------------------------------------------------------
	
	function get_dir()
	{
		return $this->dir;	
	}
	
	/**
	* Devuelve la lista de las INSTANCIAS
	*/
	function get_id_grupo_desarrollo()
	{
		$this->cargar_info_ini();		
		return $this->ini_instalacion['id_grupo_desarrollo'];
	}

	/**
	* Devuelve las claves utilizadas para encriptar
	*/
	function get_claves_encriptacion()
	{
		$this->cargar_info_ini();
		$claves['db'] = $this->ini_instalacion['clave_querystring'];
		$claves['get'] = $this->ini_instalacion['clave_db'];
		return $claves;
	}
	
	function get_parametros_base( $id_base )
	{
		$this->cargar_info_ini();		
		if ( isset( $this->ini_bases[$id_base] ) ) {
			return $this->ini_bases[$id_base];			
		} else {
			throw new excepcion_toba("INSTALACION: La base '$id_base' no existe en el archivo de instancias.");
		}
	}

	function existe_base_datos_definida( $id_base )
	{
		$this->cargar_info_ini();		
		return isset( $this->ini_bases[$id_base] );
	}

	function hay_bases()
	{
		$this->cargar_info_ini();		
		return count( $this->ini_bases ) > 0 ;
	}

	function get_lista_bases()
	{
		$this->cargar_info_ini();		
		return array_keys( $this->ini_bases );
	}

	//------------------------------------------------------------------------
	// Relacion con el MOTOR de base de datos
	//------------------------------------------------------------------------

	/**
	*	Conecta una base de datos definida en bases.ini
	*	@param string $nombre Nombre de la base
	* 	@return db Objeto db resultante
	*/
	function conectar_base( $nombre )
	{
		return $this->conectar_base_parametros( $this->get_parametros_base( $nombre ) );	
	}

	/**
	*	Crea una base de datos definida en bases.ini
	*	@param string $nombre Nombre de la base
	*/
	function crear_base_datos( $nombre )
	{
		$info_db = $this->get_parametros_base( $nombre );
		$base_a_crear = $info_db['base'];
		if($info_db['motor']=='postgres7')
		{
			sleep(1);	//Para esperar que el script se desconecte			
			$info_db['base'] = 'template1';
			$db = $this->conectar_base_parametros( $info_db );
			$sql = "CREATE DATABASE $base_a_crear ENCODING '" . self::db_encoding_estandar . "';";
			$db->ejecutar( $sql );
			$db->destruir();
		}else{
			throw new excepcion_toba("INSTALACION: El metodo no esta definido para el motor especificado");
		}
	}

	/**
	*	Borra una base de datos definida en bases.ini
	*	@param string $nombre Nombre de la base
	*/	
	function borrar_base_datos( $nombre )
	{
		$info_db = $this->get_parametros_base( $nombre );
		$base_a_borrar = $info_db['base'];
		if($info_db['motor']=='postgres7')
		{
			sleep(1);	//Para esperar que el script se desconecte
			$info_db['base'] = 'template1';
			$db = $this->conectar_base_parametros( $info_db );
			$sql = "DROP DATABASE $base_a_borrar;";
			$db->ejecutar($sql);
			$db->destruir();
		}else{
			throw new excepcion_toba("INSTALACION: El metodo no esta definido para el motor especificado");
		}
	}

	/**
	*	Determina si una base de datos definida en bases.ini existe
	*	@param string $nombre Nombre de la base
	*/
	function existe_base_datos( $nombre )
	{
		try{
			$info_db = $this->get_parametros_base( $nombre );
			$db = $this->conectar_base_parametros( $info_db );
			$db->destruir();
			return true;
		}catch(excepcion_toba $e){
			return false;
		}
	}

	/**
	*	Conecta una BASE a partir de un juego de parametros
	*	@param array $parametros Parametros de conexion
	*/
	function conectar_base_parametros( $parametros )
	{
		$archivo = "nucleo/lib/db/db_" . $parametros['motor'] . ".php";
		$clase = "db_" . $parametros['motor'];
		require_once($archivo);
		$db = new $clase(	$parametros['profile'],
							$parametros['usuario'],
							$parametros['clave'],
							$parametros['base'] );
		$db->conectar();
		return $db;
	}

	//-------------------------------------------------------------------------
	//-- Funcionalidad estatica relacionada a la CREACION de INSTALACIONES
	//-------------------------------------------------------------------------

	static function crear( $id_grupo_desarrollo )
	{
		instalacion::crear_directorio();
		instalacion::actualizar_version( instalacion::get_version_actual() );
		$apex_clave_get = md5(uniqid(rand(), true)); 
		$apex_clave_db = md5(uniqid(rand(), true)); 
		instalacion::crear_info_basica( $apex_clave_get, $apex_clave_db, $id_grupo_desarrollo );
		instalacion::crear_info_bases();
		instalacion::crear_directorio_proyectos();
		// Creo un archivo de referencia para la configuracion del apache.
		$archivo = self::dir_base() . '/toba.conf';
		copy( toba_dir(). '/php/modelo/var/toba.conf', $archivo );
		$editor = new editor_archivos();
		$editor->agregar_sustitucion( '|__toba_dir__|', manejador_archivos::path_a_unix( toba_dir() ) );
		$editor->procesar_archivo( $archivo );
	}

	static function dir_base()
	{
		return toba_dir() . '/' . self::directorio_base;
	}

	/**
	* Crea el directorio de la instalacion
	*/
	static function crear_directorio()
	{
		if( ! is_dir( self::dir_base() ) ) {
			mkdir( self::dir_base() );
		}		
	}

	/**
	* Crea el directorio de proyectos
	*/
	static function crear_directorio_proyectos()
	{
		$dir = toba_dir() .'/proyectos';
		if( ! is_dir( $dir ) ) {
			mkdir( $dir );
		}		
	}
	
	//-- Archivo de CONFIGURACION de la INSTALACION  --------------------------------------

	/**
	* Crea el archivo con la informacion basica sobre la instalacion	
	*/
	static function crear_info_basica($clave_qs, $clave_db, $id_grupo_desarrollo=null )
	{
		$ini = new ini();
		$ini->agregar_titulo( self::info_basica_titulo );
		$ini->agregar_entrada( 'id_grupo_desarrollo', $id_grupo_desarrollo );
		$ini->agregar_entrada( 'clave_querystring', $clave_qs );	
		$ini->agregar_entrada( 'clave_db', $clave_db );	
		$ini->guardar( self::archivo_info_basica() );
	}
	
	/**
	 * Cambia o agrega algunos parametros al archivo de información de la instalación
	 * @param array $datos clave => valor
	 */
	function cambiar_info_basica($datos)
	{
		$ini = new ini(self::archivo_info_basica());
		foreach ($datos as $entrada => $valor) {
			if ($ini->existe_entrada) {
				$ini->set_datos_entrada($entrada, $valor);
			} else {
				$ini->agregar_entrada($entrada, $valor);
			}
		}
		$ini->guardar();
	}
	
	/**
	* Indica si el archivo de informacion basica existe
	*/
	function existe_info_basica()
	{
		return ( is_file( self::archivo_info_basica() ) );
	}

	/**
	* path del archivo con informacion basica
	*/
	static function archivo_info_basica()
	{
		return self::dir_base() . '/' . self::info_basica;
	}
	
	//-- Archivo de CONFIGURACION de BASES  -----------------------------------------------

	/**
	* Crea el archivo con la lista de bases disponibles
	*/
	static function crear_info_bases( $lista_bases = array() )
	{
		$ini = new ini();
		$ini->agregar_titulo( self::info_bases_titulo );
		foreach( $lista_bases as $id => $base ) {
			//Valido que la definicion sea correcta
			if( isset( $base['motor'] ) &&
				isset( $base['profile'] ) &&
				isset( $base['usuario'] ) &&
				isset( $base['clave'] ) &&
				isset( $base['base'] ) ) {
				$ini->agregar_entrada( $id, $base );	
			} else {
				throw new excepcion_toba("La definicion de la BASE '$id' es INCORRECTA.");	
			}
		}
		$ini->guardar( self::archivo_info_bases() );
	}
	
	static function agregar_db( $id_base, $parametros )
	{
		if ( ! is_array( $parametros ) ) {
			throw new excepcion_toba("INSTALACION: Los parametros definidos son incorrectos");	
		} else {
			// Estan todos los parametros
			if ( !isset( $parametros['motor']  )
				|| !isset( $parametros['profile'] ) 
				|| !isset( $parametros['usuario'] )
				|| !isset( $parametros['clave'] )
				|| !isset( $parametros['base'] ) ) {
				throw new excepcion_toba("INSTALACION: Los parametros definidos son incorrectos");	
			}
			// El motor es reconocido
			$motores = array('postgres7', 'informix', 'mysql', 'odbc');
			if( ! in_array( $parametros['motor'], $motores ) ) {
				throw new excepcion_toba("INSTALACION: El motor tiene que pertenecer a la siguente lista: " . implode(', ',$motores) );	
			}
		}
		$ini = new ini( self::archivo_info_bases() );
		$ini->agregar_titulo( self::info_bases_titulo );
		$ini->agregar_entrada( $id_base, $parametros );
		$ini->guardar();
	}
	
	static function eliminar_db( $id_base )
	{
		$ini = new ini( self::archivo_info_bases() );
		$ini->agregar_titulo( self::info_bases_titulo );
		$ini->eliminar_entrada( $id_base );
		$ini->guardar();		
	}
	
	function existe_info_bases()
	{
		return ( is_file( self::archivo_info_bases() ) );
	}

	static function archivo_info_bases()
	{
		return self::dir_base() . '/' . self::info_bases;
	}
	
	//------------------------------------------------------------------------
	//-------------------------- Manejo de Versiones -------------------------
	//------------------------------------------------------------------------
	
	function migrar_version($version, $recursivo)
	{
		$this->manejador_interface->subtitulo("Migrando instalación");
		$version->ejecutar_migracion('instalacion', $this);
		$this->actualizar_version($version);
		
		//-- Se migran las instancias incluidas		
		if ($recursivo) {
			foreach ($this->get_instancias() as $instancia) {
				$instancia->migrar_version($version,$recursivo);
			}
		}
	}
	
	private function actualizar_version($version)
	{
		file_put_contents(self::dir_base()."/VERSION", $version->__toString() );
	}
	
	static function get_version_actual()
	{
		return new version_toba(file_get_contents(toba_dir()."/VERSION"));
	}
	
	
	function get_version_anterior()
	{
		if (file_exists($this->dir_base()."/VERSION")) {
			return new version_toba(file_get_contents($this->dir_base()."/VERSION"));
		} else {
			return version_toba::inicial();
		}
	}	
}
?>

<?
require_once('modelo/proceso_toba.php');
require_once('nucleo/lib/reflexion/clase_datos.php');

class parser_ddl extends proceso_toba
{
	// Directorios de trabajo
	protected $dir_sql;
	protected $dir_ddl;
	protected $prefijo_archivo = 'tablas_';
	protected $ba_instancia = 'instancia';
	protected $ba_nucleo = 'nucleo';
	protected $ba_proyecto = 'proyecto';
	protected $ba_componente = 'componente';
	// Parseo
	protected $secuencias = array();
	protected $tablas = array();
	protected $archivos_procesados = 0;
	protected $cantidad_tablas_total = 0;	
	protected $cantidad_secuencias_total = 0;	
	protected $archivos;
	// Plan de generacion de PHP
	protected $plan;

	function __construct( $raiz, $instancia, $proyecto=null )    
	{                                                       
		parent::__construct( $raiz, $instancia, $proyecto );
		$this->dir_sql = $this->dir_raiz . '/sql';
		$this->dir_ddl = $this->dir_raiz . '/php/modelo/estructura_db';
	}

	function procesar( $argumentos )
	{
		parent::procesar( $argumentos );
		$this->get_archivos_ddl();
		$this->parsear_archivos();
		$this->analizar_tablas();
		$this->generar_php();
	}
	
	function get_archivos_ddl()
	{
		if ($dir = opendir($this->dir_sql)) {	
		   while (false	!==	($archivo = readdir($dir)))	{ 
				if(preg_match('%pgsql_a.*\.sql%',$archivo)){
					$this->archivos[] = $this->dir_sql . '/' . $archivo;
				}
		   } 
		   closedir($dir); 
		}
	}

	function parsear_archivos()
	{
		foreach($this->archivos as $archivo)
		{
			//Intento abrir	el archivo
			$fd	= @fopen ($archivo,	"r");
			if(!is_resource($fd)){
				throw new excepcion_toba("ERROR: '$archivo' no es un archivo valido\n");
			}
			//Recorro el archivo
			$table = null; //Referencia a una tabla.
			if(isset($table)) unset($table);
			while (!feof ($fd))	
			//while((!feof	($fd)) && $tabla_actual	< 3	)
			{
				$buffer	= fgets($fd, 4096);	
				//------- Entro	en una tabla
				if(preg_match("/^create\ssequence/i",$buffer))
				{
					$temp =	preg_split("/\s+/",$buffer);
					$this->secuencias[] = $temp[2];
					$this->cantidad_secuencias_total++;
				}
				//------- Entro	en una tabla
				if(preg_match("/^create\stable/i",$buffer))
				{
					$temp =	preg_split("/\s+/",$buffer);
					$nombre_tabla = $temp[2];
					if(!isset($this->tablas[$nombre_tabla])){
						$this->tablas[$nombre_tabla] = array();
					}
					//Apunto la referencia a la tabla
					$tabla =& $this->tablas[$nombre_tabla];
					$tabla['archivo'] = basename($archivo);
					$this->cantidad_tablas_total++;
				}
				//------- Entre	en una propiedad
				if(preg_match("/^--:/",$buffer))
				{
					$temp =	preg_split("/(\s*):(\s*)/",$buffer);
					if(!isset($temp[1])||!isset($temp[2])){	
						throw new excepcion_toba("Error parseando la linea: $temp\n (archivo: $archivo)");
					}
					$tabla[trim($temp[1])]=addslashes(trim($temp[2]));
				}
				//------- Entre	en una columna
				if(preg_match("/^\s*?\w+\s*?.*NULL/",$buffer))
				{
					$temp =	preg_split("/\s+|\t/",$buffer);	
					//print_r($temp);
					$columna = $temp[1];
					//$columna_definicion	= addslashes(trim(preg_replace("/^\s*?\w+\s*?/","",$buffer)));
					//$tabla['columnas'][$columna] = $columna_definicion;
					$tabla['columnas'][] = $columna;	
				}
			}
			$this->archivos_procesados++;	
			fclose ($fd);
		}
	}
	
	function analizar_tablas()
	{
		foreach($this->tablas as $id => $tabla) {
			//-- Clasificacion de tablas --
			$es_instancia = (isset($tabla['instancia']) && $tabla['instancia']=='1');
			$es_log = (isset($tabla['historica']) && $tabla['historica']=='1');
			$dump_componente = ($tabla['dump']=='componente');
			$dump_proyecto = ($tabla['dump']=='multiproyecto'); //Proyecto siempre es igual a toba
			$dump_nucleo = ($tabla['dump']=='proyecto');
			//-- Controles de integridad de la DEFINICION del plan --
			if ( $dump_componente && ( $es_instancia || $es_log ) ) {
				throw new excepcion_toba("La tabla '$id' posee un error en el plan de dumpeo: componente + (historica || instancia).");
			}
			if( $es_instancia && $es_log ) {
				throw new excepcion_toba("La tabla '$id' posee un error en el plan de dumpeo: historica + instancia.");
			}
			if( !( $dump_componente || $dump_proyecto || $dump_nucleo ) ) {
				throw new excepcion_toba("La tabla '$id' no posee una modalidad de dumpeo definida.");
			}
			//-- Armo el PLAN --
			if ( $es_instancia ) {
				$this->plan[ $this->ba_instancia ]['tablas'][] = $id;
				if ( $dump_proyecto ) {
					$this->plan[ $this->ba_instancia ]['indices']['get_lista_instancia_proyecto'][] = $id;
				} elseif ( $dump_nucleo ) {
					$this->plan[ $this->ba_instancia ]['indices']['get_lista_instancia_global'][] = $id;
				}
			} elseif ( $es_log ) {
				$this->plan[ $this->ba_instancia ]['tablas'][] = $id;
				if ( $dump_proyecto ) {
					$this->plan[ $this->ba_instancia ]['indices']['get_lista_log_proyecto'][] = $id;
				} elseif ( $dump_nucleo ) {
					$this->plan[ $this->ba_instancia ]['indices']['get_lista_log_global'][] = $id;
				}
			} else {
				if ( $dump_componente ) {
					$this->plan[ $this->ba_componente ]['tablas'][] = $id;
					$this->plan[ $this->ba_componente ]['indices']['get_lista'][] = $id;
				} elseif ( $dump_proyecto ) {
					$this->plan[ $this->ba_proyecto ]['tablas'][] = $id;
					$this->plan[ $this->ba_proyecto ]['indices']['get_lista'][] = $id;
				} elseif ( $dump_nucleo ) {
					$this->plan[ $this->ba_nucleo ]['tablas'][] = $id;
					$this->plan[ $this->ba_nucleo ]['indices']['get_lista'][] = $id;
				} 
			}
		}
	}

	function generar_php()
	{
		foreach(array_keys($this->plan) as $archivo ) {
			$nombre = $this->prefijo_archivo . $archivo;
			$this->interface->titulo( $nombre );
			$clase = new clase_datos( $nombre, basename(__FILE__));
			//Creo los indices
			foreach ( $this->plan[$archivo]['indices'] as $id => $indice) {
				$clase->agregar_metodo_datos( $id, $indice );
			}
			//Informacion de cada tabla
			foreach($this->plan[$archivo]['tablas'] as $tabla) {
				$this->interface->mensaje("Tabla: $tabla");
				$clase->agregar_metodo_datos( $tabla, $this->tablas[$tabla] );
			}
			$clase->guardar( $this->dir_ddl .'/'.$nombre.'.php' );
		}
	}
}
?>
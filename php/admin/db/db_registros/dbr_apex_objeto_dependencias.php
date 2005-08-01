<?
//Generacion: 14-07-2005 17:04:53
//Fuente de datos: 'instancia'
require_once('nucleo/persistencia/db_registros_s.php');

class dbr_apex_objeto_dependencias extends db_registros_s
//db_registros especifico de la tabla 'apex_objeto_dependencias'
{
	function __construct($fuente=null, $min_registros=0, $max_registros=0 )
	{
		$def['tabla']='apex_objeto_dependencias';
		$def['columna'][0]['nombre']='proyecto';
		$def['columna'][0]['pk']='1';
		//$def['columna'][0]['no_nulo']='1';
		$def['columna'][1]['nombre']='objeto_consumidor';
		$def['columna'][1]['pk']='1';
		//$def['columna'][1]['no_nulo']='1';
		$def['columna'][2]['nombre']='objeto_proveedor';
		$def['columna'][2]['no_nulo']='1';
		$def['columna'][3]['nombre']='identificador';
		$def['columna'][3]['pk']='1';
		$def['columna'][3]['no_nulo']='1';
		$def['columna'][4]['nombre']='parametros_a';
		$def['columna'][5]['nombre']='parametros_b';
		$def['columna'][6]['nombre']='parametros_c';
		$def['columna'][7]['nombre']='inicializar';
		$def['columna'][8]['nombre']='clase';
		$def['columna'][8]['externa']='1';
		$def['columna'][9]['nombre']='nombre_objeto';
		$def['columna'][9]['externa']='1';
		parent::__construct( $def, $fuente, $min_registros, $max_registros);
		//Activo la carga de columnas externas
		$this->activar_proceso_carga_externa_dao(	"get_info_dependencia",
													"dao_editores",
													"admin/db/dao_editores.php", 
													array('proyecto','objeto_proveedor'), 
													array('clase','nombre_objeto')	);
		$this->set_no_duplicado( array("identificador") );
	}	
	
	function cargar_datos_clave($id)
	{
		$where[] = "proyecto = '{$id['proyecto']}'";
		$where[] = "objeto_consumidor = '{$id['objeto']}'";
		$this->cargar_datos($where);
	}
}
?>
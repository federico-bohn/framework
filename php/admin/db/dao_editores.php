<?
class dao_editores
{
	//---------------------------------------------------
	//---------------- CLASES ---------------------------
	//---------------------------------------------------

	static function get_clases_validas()
	{
		return array(	'objeto_ci',
						'objeto_ei_cuadro',
						'objeto_ei_formulario',
						'objeto_ei_formulario_ml',
						'objeto_ei_filtro',
						'objeto_ei_arbol',
						'objeto_ei_calendario',
						'objeto_ei_archivos' );
	}

	/*
		Las clases usan un ID concatenado para que las cascadas
		las soporten (actualmente pasan un parametro solo)
	*/

	static function get_lista_clases_toba()
	{
		$sql = "SELECT 	proyecto || ',' || clase as clase, 
						clase as descripcion
				FROM apex_clase 
				WHERE clase IN ('". implode("','",self::get_clases_validas() ) ."')
				AND proyecto = '". toba::get_hilo()->obtener_proyecto() ."'
				ORDER BY 2";
		return consultar_fuente($sql, "instancia");
	}	

	static function get_clase_archivo($proyecto, $clase)
	{
		$sql = "SELECT 	archivo
				FROM apex_clase 
				WHERE 	clase = '$clase'
				AND		proyecto = '$proyecto'";
		$temp = consultar_fuente($sql, "instancia");
		if(is_array($temp)){
			return $temp[0]['archivo'];
		}
	}

	//---------------------------------------------------
	//---------------- ITEMS --------------------------
	//---------------------------------------------------
	static function get_ids_items_instancia($proyecto)
	{
		$sql = "SELECT 	item 
				FROM apex_item
				WHERE proyecto = '$proyecto'
				ORDER BY 1";
		return consultar_fuente($sql, "instancia");
	}


	//---------------------------------------------------
	//---------------- OBJETOS --------------------------
	//---------------------------------------------------

	static function get_ids_objetos_instancia($proyecto)
	{
		$sql = "SELECT 	objeto 
				FROM apex_objeto 
				WHERE clase IN ('". implode("','",self::get_clases_validas() ) ."')
				AND proyecto = '$proyecto'
				ORDER BY 1";
		return consultar_fuente($sql, "instancia");
	}

	static function get_lista_objetos_toba($clase)
	{
		$clase = explode(",",$clase);
		$sql = "SELECT 	proyecto, 
						objeto, 
						'[' || objeto || '] -- ' || nombre as descripcion
				FROM apex_objeto 
				WHERE 	clase = '{$clase[1]}'
				AND		clase_proyecto = '{$clase[0]}'
				AND 	proyecto = '". toba::get_hilo()->obtener_proyecto() ."'
				ORDER BY 2";
		return consultar_fuente($sql, "instancia");
	}
	
	static function get_info_dependencia($objeto_proyecto, $objeto)
	//Carga externa para un db_registros de dependencias
	{
		$sql = "SELECT 	o.clase || ' - ' || '[' || o.objeto || '] - ' || o.nombre as nombre_objeto,
						'[' || o.objeto || '] - ' || o.nombre as descripcion,
						o.clase_proyecto || ',' || o.clase as clase
				FROM 	apex_clase c, apex_objeto o
				WHERE 	o.clase = c.clase
				AND 	o.clase_proyecto = c.proyecto
				AND 	o.proyecto = '$objeto_proyecto'
				AND 	o.objeto = '$objeto'";
		return consultar_fuente($sql, "instancia");
	}
	//---------------------------------------------------

	static function get_lista_objetos_dt()
	//Listar objetos que son datos_tabla
	{
		$sql = "SELECT 	proyecto, 
						objeto, 
						'[' || objeto || '] -- ' || nombre as descripcion
				FROM apex_objeto 
				WHERE 	clase = 'objeto_datos_tabla'
				AND		clase_proyecto = 'toba'
				AND 	proyecto = '". toba::get_hilo()->obtener_proyecto() ."'
				ORDER BY 2";
		return consultar_fuente($sql, "instancia");
	}
	//---------------------------------------------------

	static function get_lista_dt_columnas($objeto)
	/*
		Lista las columnas de los DATOS_TABLA
		Esta pregunta hay que hacercela a una clase de dominio (un datos_tabla)
	*/
	{
		$temp = explode(",",$objeto);
		$objeto = $temp[1];
		$sql = "SELECT 		columna,
							col_id
				FROM apex_objeto_db_registros_col 
				WHERE 	objeto = $objeto
				AND 	objeto_proyecto = '". toba::get_hilo()->obtener_proyecto() ."'
				ORDER BY 2";
		return consultar_fuente($sql, "instancia");
	}}
?>
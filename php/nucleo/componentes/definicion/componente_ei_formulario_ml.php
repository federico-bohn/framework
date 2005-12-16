<?
require_once("componente_ei_formulario.php");	//Ancestro de todos los	OE

class componente_ei_formulario_ml extends componente_ei_formulario
{
	static function get_vista_extendida($proyecto, $componente=null)
	{
		$sql = parent::get_vista_extendida($proyecto, $componente);
		//Formulario
		$sql["info_formulario"]['sql'] = "SELECT	auto_reset as	auto_reset,
										scroll as 					scroll,					
										ancho as					ancho,
										alto as						alto,
										filas as					filas,
										filas_agregar as			filas_agregar,
										filas_agregar_online as 	filas_agregar_online,
										filas_ordenar as			filas_ordenar,
										filas_numerar as 			filas_numerar,
										columna_orden as 			columna_orden,
										analisis_cambios		as	analisis_cambios
								FROM	apex_objeto_ut_formulario
								WHERE	objeto_ut_formulario_proyecto='$proyecto'";
		if ( isset($componente) ) {
			$sql['info_formulario']['sql'] .= "	AND		objeto_ut_formulario='$componente' ";	
		}
		$sql['info_formulario']['sql'] .= ";";
		$sql['info_formulario']['registros']='1';
		$sql['info_formulario']['obligatorio']=true;
		//EF
		$sql["info_formulario_ef"]['sql'] = "SELECT	identificador as identificador,
										columnas	as				columnas,
										obligatorio	as				obligatorio,
										elemento_formulario as		elemento_formulario,
										inicializacion	as			inicializacion,
										etiqueta	as				etiqueta,
										etiqueta_estilo	as			etiqueta_estilo,
										descripcion	as				descripcion,
										orden	as					orden,
										total as 					total,
										estilo as					columna_estilo,
										colapsado as 				colapsado
								FROM	apex_objeto_ei_formulario_ef
								WHERE	objeto_ei_formulario_proyecto='$proyecto'";
		if ( isset($componente) ) {
			$sql['info_formulario_ef']['sql'] .= "	AND		objeto_ei_formulario='$componente' ";	
		}
		$sql['info_formulario_ef']['sql'] .= " AND	(desactivado=0	OR	desactivado	IS	NULL)
								ORDER	BY	orden;";
		$sql['info_formulario_ef']['registros']='n';
		$sql['info_formulario_ef']['obligatorio']=false;
		return $sql;
	}

	static function get_nombre_clase_info()
	{
		return 'info_ei_formulario_ml';
	}
}
?>
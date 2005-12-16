<?
//Generador: compilador_proyecto.php

class php_1535
{
	function get_metadatos()
	{
		return array (
  'info' => 
  array (
    'proyecto' => 'toba',
    'objeto' => '1535',
    'anterior' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'objeto_datos_relacion',
    'subclase' => NULL,
    'subclase_archivo' => NULL,
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'OBJETO - EI filtro',
    'titulo' => NULL,
    'colapsable' => NULL,
    'descripcion' => NULL,
    'fuente_proyecto' => 'toba',
    'fuente' => 'instancia',
    'solicitud_registrar' => NULL,
    'solicitud_obj_obs_tipo' => NULL,
    'solicitud_obj_observacion' => NULL,
    'parametro_a' => NULL,
    'parametro_b' => NULL,
    'parametro_c' => NULL,
    'parametro_d' => NULL,
    'parametro_e' => NULL,
    'parametro_f' => NULL,
    'usuario' => NULL,
    'creacion' => '2005-08-28 03:51:37',
    'clase_editor_proyecto' => 'toba',
    'clase_editor_item' => '/admin/objetos_toba/editores/db_tablas',
    'clase_archivo' => 'nucleo/persistencia/objeto_datos_relacion.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '/admin/objetos_toba/editores/db_tablas',
    'clase_icono' => 'objetos/datos_relacion.gif',
    'clase_descripcion_corta' => 'Objeto DATOS - RELACION',
    'clase_instanciador_proyecto' => NULL,
    'clase_instanciador_item' => NULL,
    'objeto_existe_ayuda' => NULL,
  ),
  'info_estructura' => 
  array (
    'proyecto' => 'toba',
    'objeto' => '1535',
    'clave' => NULL,
    'ap' => '2',
    'ap_clase' => NULL,
    'ap_archivo' => NULL,
  ),
  'info_relaciones' => 
  array (
    0 => 
    array (
      'proyecto' => 'toba',
      'objeto' => '1535',
      'asoc_id' => '12',
      'identificador' => 'base -> prop_basicas',
      'padre_proyecto' => 'toba',
      'padre_objeto' => '1501',
      'padre_id' => 'base',
      'padre_clave' => 'proyecto,objeto',
      'hijo_proyecto' => 'toba',
      'hijo_objeto' => '1529',
      'hijo_id' => 'prop_basicas',
      'hijo_clave' => 'objeto_ut_formulario_proyecto,objeto_ut_formulario',
      'cascada' => '0',
      'orden' => '1',
    ),
    1 => 
    array (
      'proyecto' => 'toba',
      'objeto' => '1535',
      'asoc_id' => '13',
      'identificador' => 'base -> efs',
      'padre_proyecto' => 'toba',
      'padre_objeto' => '1501',
      'padre_id' => 'base',
      'padre_clave' => 'proyecto,objeto',
      'hijo_proyecto' => 'toba',
      'hijo_objeto' => '1530',
      'hijo_id' => 'efs',
      'hijo_clave' => 'objeto_ei_formulario_proyecto,objeto_ei_formulario',
      'cascada' => '0',
      'orden' => '2',
    ),
    2 => 
    array (
      'proyecto' => 'toba',
      'objeto' => '1535',
      'asoc_id' => '14',
      'identificador' => 'base -> eventos',
      'padre_proyecto' => 'toba',
      'padre_objeto' => '1501',
      'padre_id' => 'base',
      'padre_clave' => 'proyecto,objeto',
      'hijo_proyecto' => 'toba',
      'hijo_objeto' => '1505',
      'hijo_id' => 'eventos',
      'hijo_clave' => 'proyecto,objeto',
      'cascada' => '0',
      'orden' => '3',
    ),
  ),
  'info_dependencias' => 
  array (
    0 => 
    array (
      'identificador' => 'base',
      'proyecto' => 'toba',
      'objeto' => '1501',
      'clase' => 'objeto_datos_tabla',
      'clase_archivo' => 'nucleo/persistencia/objeto_datos_tabla.php',
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'fuente' => 'instancia',
      'parametros_a' => '1',
      'parametros_b' => '1',
    ),
    1 => 
    array (
      'identificador' => 'efs',
      'proyecto' => 'toba',
      'objeto' => '1530',
      'clase' => 'objeto_datos_tabla',
      'clase_archivo' => 'nucleo/persistencia/objeto_datos_tabla.php',
      'subclase' => 'odt_formulario_efs',
      'subclase_archivo' => 'admin/db/odt_formulario_efs.php',
      'fuente' => 'instancia',
      'parametros_a' => '1',
      'parametros_b' => '0',
    ),
    2 => 
    array (
      'identificador' => 'eventos',
      'proyecto' => 'toba',
      'objeto' => '1505',
      'clase' => 'objeto_datos_tabla',
      'clase_archivo' => 'nucleo/persistencia/objeto_datos_tabla.php',
      'subclase' => 'odt_eventos',
      'subclase_archivo' => 'admin/db/odt_eventos.php',
      'fuente' => 'instancia',
      'parametros_a' => '0',
      'parametros_b' => '0',
    ),
    3 => 
    array (
      'identificador' => 'prop_basicas',
      'proyecto' => 'toba',
      'objeto' => '1529',
      'clase' => 'objeto_datos_tabla',
      'clase_archivo' => 'nucleo/persistencia/objeto_datos_tabla.php',
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'fuente' => 'instancia',
      'parametros_a' => '1',
      'parametros_b' => '1',
    ),
  ),
);
	}

}
?>
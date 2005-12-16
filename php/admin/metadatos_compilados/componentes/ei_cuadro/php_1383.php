<?
//Generador: compilador_proyecto.php

class php_1383
{
	function get_metadatos()
	{
		return array (
  'info' => 
  array (
    'proyecto' => 'toba',
    'objeto' => '1383',
    'anterior' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'objeto_ei_cuadro',
    'subclase' => NULL,
    'subclase_archivo' => NULL,
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'Catalogo Unificado - Fotos',
    'titulo' => 'Fotos',
    'colapsable' => '1',
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
    'creacion' => '2005-07-22 10:55:21',
    'clase_editor_proyecto' => 'toba',
    'clase_editor_item' => '/admin/objetos_toba/editores/ei_cuadro',
    'clase_archivo' => 'nucleo/browser/clases/objeto_ei_cuadro.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '/admin/objetos_toba/editores/ei_cuadro',
    'clase_icono' => 'objetos/cuadro_array.gif',
    'clase_descripcion_corta' => 'Cuadro Array',
    'clase_instanciador_proyecto' => 'toba',
    'clase_instanciador_item' => '1843',
    'objeto_existe_ayuda' => NULL,
  ),
  'info_eventos' => 
  array (
    0 => 
    array (
      'identificador' => 'seleccion',
      'etiqueta' => NULL,
      'maneja_datos' => '0',
      'sobre_fila' => '1',
      'confirmacion' => '',
      'estilo' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'doc.gif',
      'en_botonera' => '0',
      'ayuda' => 'Seleccionar la fila',
      'ci_predep' => NULL,
      'implicito' => NULL,
      'grupo' => NULL,
    ),
    1 => 
    array (
      'identificador' => 'defecto',
      'etiqueta' => 'Predeter.',
      'maneja_datos' => '1',
      'sobre_fila' => '1',
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'en_botonera' => '0',
      'ayuda' => 'Seleccionar como foto predeterminada.',
      'ci_predep' => NULL,
      'implicito' => NULL,
      'grupo' => NULL,
    ),
    2 => 
    array (
      'identificador' => 'baja',
      'etiqueta' => NULL,
      'maneja_datos' => '0',
      'sobre_fila' => '1',
      'confirmacion' => '�Est� seguro que desea ELIMINAR la fila?',
      'estilo' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'borrar.gif',
      'en_botonera' => '0',
      'ayuda' => 'Borra la foto',
      'ci_predep' => NULL,
      'implicito' => NULL,
      'grupo' => NULL,
    ),
  ),
  'info_cuadro' => 
  array (
    'titulo' => 'Fotos',
    'subtitulo' => NULL,
    'sql' => NULL,
    'columnas_clave' => 'foto_nombre',
    'clave_datos_tabla' => NULL,
    'archivos_callbacks' => NULL,
    'ancho' => '100%',
    'ordenar' => NULL,
    'exportar_xls' => NULL,
    'exportar_pdf' => NULL,
    'paginar' => NULL,
    'tamano_pagina' => NULL,
    'tipo_paginado' => NULL,
    'scroll' => NULL,
    'alto' => NULL,
    'eof_invisible' => '1',
    'eof_customizado' => NULL,
    'pdf_respetar_paginacion' => NULL,
    'pdf_propiedades' => NULL,
    'asociacion_columnas' => NULL,
    'dao_nucleo_proyecto' => NULL,
    'dao_clase' => NULL,
    'dao_metodo' => NULL,
    'dao_parametros' => NULL,
    'dao_archivo' => NULL,
    'cc_modo' => NULL,
    'cc_modo_anidado_colap' => NULL,
    'cc_modo_anidado_totcol' => NULL,
    'cc_modo_anidado_totcua' => NULL,
  ),
  'info_cuadro_columna' => 
  array (
    0 => 
    array (
      'orden' => '1',
      'titulo' => 'Predet.',
      'estilo_titulo' => 'lista-col-titulo',
      'estilo' => 'col-num-p1',
      'ancho' => NULL,
      'clave' => 'defecto',
      'formateo' => 'imagen_toba',
      'vinculo_indice' => NULL,
      'no_ordenar' => NULL,
      'mostrar_xls' => NULL,
      'mostrar_pdf' => NULL,
      'pdf_propiedades' => NULL,
      'total' => NULL,
      'total_cc' => NULL,
    ),
    1 => 
    array (
      'orden' => '2',
      'titulo' => 'Nombre',
      'estilo_titulo' => 'lista-col-titulo',
      'estilo' => 'col-tex-p1',
      'ancho' => NULL,
      'clave' => 'foto_nombre',
      'formateo' => 'indivisible',
      'vinculo_indice' => NULL,
      'no_ordenar' => NULL,
      'mostrar_xls' => NULL,
      'mostrar_pdf' => NULL,
      'pdf_propiedades' => NULL,
      'total' => NULL,
      'total_cc' => NULL,
    ),
  ),
  'info_cuadro_cortes' => 
  array (
  ),
);
	}

}
?>
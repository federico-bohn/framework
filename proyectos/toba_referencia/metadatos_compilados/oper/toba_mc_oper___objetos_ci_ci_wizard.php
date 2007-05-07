<?php

class toba_mc_item___objetos_ci_ci_wizard
{
	static function get_metadatos()
	{
		return array (
  'basica' => 
  array (
    'item_proyecto' => 'toba_referencia',
    'item' => '/objetos/ci/ci_wizard',
    'item_nombre' => 'Navegaci�n Wizard',
    'item_descripcion' => NULL,
    'item_act_buffer_proyecto' => 'toba',
    'item_act_buffer' => 0,
    'item_act_patron_proyecto' => 'toba',
    'item_act_patron' => 'CI',
    'item_act_accion_script' => NULL,
    'item_solic_tipo' => 'web',
    'item_solic_registrar' => 0,
    'item_solic_obs_tipo_proyecto' => NULL,
    'item_solic_obs_tipo' => NULL,
    'item_solic_observacion' => NULL,
    'item_solic_cronometrar' => 0,
    'item_parametro_a' => NULL,
    'item_parametro_b' => NULL,
    'item_parametro_c' => NULL,
    'item_imagen_recurso_origen' => NULL,
    'item_imagen' => NULL,
    'tipo_pagina_clase' => 'tp_referencia',
    'tipo_pagina_archivo' => 'tp_referencia.php',
    'item_include_arriba' => NULL,
    'item_include_abajo' => NULL,
    'item_zona_proyecto' => NULL,
    'item_zona' => NULL,
    'item_zona_archivo' => NULL,
    'zona_cons_archivo' => NULL,
    'zona_cons_clase' => NULL,
    'zona_cons_metodo' => NULL,
    'item_publico' => 0,
    'item_existe_ayuda' => NULL,
    'carpeta' => 0,
    'menu' => 1,
    'orden' => '0',
    'publico' => 0,
    'redirecciona' => 0,
    'crono' => 0,
    'solicitud_tipo' => 'web',
    'item_padre' => '/objetos/ci',
    'cant_dependencias' => '1',
    'cant_items_hijos' => '0',
  ),
  'objetos' => 
  array (
    0 => 
    array (
      'objeto_proyecto' => 'toba_referencia',
      'objeto' => 1318,
      'objeto_nombre' => 'ci - wizard',
      'objeto_subclase' => 'ci_wizard',
      'objeto_subclase_archivo' => 'componentes/ci/ci_wizard.php',
      'orden' => 0,
      'clase_proyecto' => 'toba',
      'clase' => 'objeto_ci',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ci.php',
      'fuente_proyecto' => NULL,
      'fuente' => NULL,
      'fuente_motor' => NULL,
      'fuente_host' => NULL,
      'fuente_usuario' => NULL,
      'fuente_clave' => NULL,
      'fuente_base' => NULL,
    ),
  ),
);
	}

}

class toba_mc_comp__1318
{
	static function get_metadatos()
	{
		return array (
  '_info' => 
  array (
    'proyecto' => 'toba_referencia',
    'objeto' => 1318,
    'anterior' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'objeto_ci',
    'subclase' => 'ci_wizard',
    'subclase_archivo' => 'componentes/ci/ci_wizard.php',
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'ci - wizard',
    'titulo' => 'Instalaci�n',
    'colapsable' => 0,
    'descripcion' => NULL,
    'fuente_proyecto' => NULL,
    'fuente' => NULL,
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
    'creacion' => '2005-06-24 18:39:43',
    'clase_editor_proyecto' => 'toba_editor',
    'clase_editor_item' => '/admin/objetos_toba/editores/ci',
    'clase_archivo' => 'nucleo/componentes/interface/toba_ci.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '/admin/objetos_toba/editores/ci',
    'clase_icono' => 'objetos/multi_etapa.gif',
    'clase_descripcion_corta' => 'ci',
    'clase_instanciador_proyecto' => 'toba_editor',
    'clase_instanciador_item' => '1642',
    'objeto_existe_ayuda' => NULL,
    'ap_clase' => NULL,
    'ap_archivo' => NULL,
    'cant_dependencias' => '1',
  ),
  '_info_eventos' => 
  array (
    0 => 
    array (
      'identificador' => 'cancelar',
      'etiqueta' => '&Cancelar',
      'maneja_datos' => 0,
      'sobre_fila' => 0,
      'confirmacion' => NULL,
      'estilo' => 'ei-boton-izq',
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'en_botonera' => 1,
      'ayuda' => '',
      'ci_predep' => NULL,
      'implicito' => 0,
      'defecto' => 0,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => 0,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => 0,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
    1 => 
    array (
      'identificador' => 'procesar',
      'etiqueta' => 'Finalizar',
      'maneja_datos' => 1,
      'sobre_fila' => 0,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'en_botonera' => 1,
      'ayuda' => '',
      'ci_predep' => NULL,
      'implicito' => 0,
      'defecto' => 1,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => NULL,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
  ),
  '_info_puntos_control' => 
  array (
  ),
  '_info_ci' => 
  array (
    'ev_procesar_etiq' => 'Finalizar',
    'ev_cancelar_etiq' => NULL,
    'objetos' => NULL,
    'ancho' => '600px',
    'alto' => NULL,
    'posicion_botonera' => 'abajo',
    'tipo_navegacion' => 'wizard',
    'con_toc' => 1,
  ),
  '_info_ci_me_pantalla' => 
  array (
    0 => 
    array (
      'pantalla' => 425,
      'identificador' => '0',
      'etiqueta' => 'Bienvenida',
      'descripcion' => 'Este CI posee una navegaci�n tipo <em>Wizard</em>.<br>
En la subclase se puede encontrar c�digo que maneja las excepciones como salto de pantallas, borrado de botones y cambio en sus etiquetas bajo ciertas circunstancias.',
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => '',
      'eventos' => 'cancelar',
      'orden' => 1,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
    1 => 
    array (
      'pantalla' => 426,
      'identificador' => '2',
      'etiqueta' => 'Requisitos Previos',
      'descripcion' => 'Verifique la instalaci�n de los siguientes productos.',
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => NULL,
      'eventos' => 'cancelar',
      'orden' => 2,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
    2 => 
    array (
      'pantalla' => 427,
      'identificador' => '3',
      'etiqueta' => 'Tipo de Instalaci�n',
      'descripcion' => 'Seleccione un tipo de instalaci�n.',
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => 'tipos',
      'eventos' => 'cancelar',
      'orden' => 3,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
    3 => 
    array (
      'pantalla' => 428,
      'identificador' => '4',
      'etiqueta' => 'Componentes',
      'descripcion' => 'Seleccione la lista de componentes a instalar',
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => NULL,
      'eventos' => 'cancelar',
      'orden' => 4,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
    4 => 
    array (
      'pantalla' => 429,
      'identificador' => '5',
      'etiqueta' => 'Configuraci�n',
      'descripcion' => 'A continuaci�n seleccione los par�metros con los que se ejecutar� la aplicaci�n.',
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => NULL,
      'eventos' => 'cancelar',
      'orden' => 5,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
    5 => 
    array (
      'pantalla' => 430,
      'identificador' => '6',
      'etiqueta' => 'Listo para instalar',
      'descripcion' => 'Verifique que los datos ingresados sean correctos.',
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => NULL,
      'eventos' => 'cancelar',
      'orden' => 6,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
    6 => 
    array (
      'pantalla' => 431,
      'identificador' => '7',
      'etiqueta' => 'Resultado Instalaci�n',
      'descripcion' => NULL,
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => NULL,
      'eventos' => 'cancelar',
      'orden' => 7,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
    7 => 
    array (
      'pantalla' => 432,
      'identificador' => '8',
      'etiqueta' => 'Finalizar',
      'descripcion' => 'Gracias por elegirnos!!',
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => NULL,
      'eventos' => 'procesar,cancelar',
      'orden' => 8,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
  ),
  '_info_dependencias' => 
  array (
    0 => 
    array (
      'identificador' => 'tipos',
      'proyecto' => 'toba_referencia',
      'objeto' => 1319,
      'clase' => 'objeto_ei_formulario',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ei_formulario.php',
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'fuente' => 'toba_referencia',
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
  ),
);
	}

}

class toba_mc_comp__1319
{
	static function get_metadatos()
	{
		return array (
  '_info' => 
  array (
    'proyecto' => 'toba_referencia',
    'objeto' => 1319,
    'anterior' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'objeto_ei_formulario',
    'subclase' => NULL,
    'subclase_archivo' => NULL,
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'Tipos de instalaci�n',
    'titulo' => NULL,
    'colapsable' => NULL,
    'descripcion' => NULL,
    'fuente_proyecto' => 'toba_referencia',
    'fuente' => 'toba_referencia',
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
    'creacion' => '2005-06-27 10:07:44',
    'clase_editor_proyecto' => 'toba_editor',
    'clase_editor_item' => '/admin/objetos_toba/editores/ei_formulario',
    'clase_archivo' => 'nucleo/componentes/interface/toba_ei_formulario.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '/admin/objetos_toba/editores/ei_formulario',
    'clase_icono' => 'objetos/ut_formulario.gif',
    'clase_descripcion_corta' => 'ei_formulario',
    'clase_instanciador_proyecto' => 'toba_editor',
    'clase_instanciador_item' => '1842',
    'objeto_existe_ayuda' => NULL,
    'ap_clase' => NULL,
    'ap_archivo' => NULL,
    'cant_dependencias' => '0',
  ),
  '_info_eventos' => 
  array (
    0 => 
    array (
      'identificador' => 'modificacion',
      'etiqueta' => 'Modificacion',
      'maneja_datos' => 1,
      'sobre_fila' => NULL,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'en_botonera' => 0,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => 1,
      'defecto' => NULL,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => NULL,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
  ),
  '_info_puntos_control' => 
  array (
  ),
  '_info_formulario' => 
  array (
    'auto_reset' => NULL,
    'ancho' => NULL,
    'ancho_etiqueta' => NULL,
  ),
  '_info_formulario_ef' => 
  array (
    0 => 
    array (
      'objeto_ei_formulario_proyecto' => 'toba_referencia',
      'objeto_ei_formulario' => 1319,
      'objeto_ei_formulario_fila' => 1337,
      'identificador' => 'tipo',
      'elemento_formulario' => 'ef_combo',
      'columnas' => 'tipo',
      'obligatorio' => 0,
      'oculto_relaja_obligatorio' => NULL,
      'orden' => '1',
      'etiqueta' => 'Tipo de instalaci�n',
      'etiqueta_estilo' => NULL,
      'descripcion' => 'En la instalaci�n personalizada se puede elegir la lista de componentes a utilizar y configurar en detalle la instalaci�n.',
      'colapsado' => 0,
      'desactivado' => 0,
      'estilo' => NULL,
      'total' => 0,
      'inicializacion' => NULL,
      'estado_defecto' => NULL,
      'solo_lectura' => 0,
      'carga_metodo' => NULL,
      'carga_clase' => NULL,
      'carga_include' => NULL,
      'carga_col_clave' => NULL,
      'carga_col_desc' => NULL,
      'carga_sql' => NULL,
      'carga_fuente' => 'toba_referencia',
      'carga_lista' => 'tipica/T�pica,personalizada/Personalizada',
      'carga_maestros' => NULL,
      'carga_cascada_relaj' => 0,
      'carga_no_seteado' => NULL,
      'edit_tamano' => NULL,
      'edit_maximo' => NULL,
      'edit_mascara' => NULL,
      'edit_unidad' => NULL,
      'edit_rango' => NULL,
      'edit_filas' => NULL,
      'edit_columnas' => NULL,
      'edit_wrap' => NULL,
      'edit_resaltar' => NULL,
      'edit_ajustable' => NULL,
      'edit_confirmar_clave' => NULL,
      'popup_item' => NULL,
      'popup_proyecto' => NULL,
      'popup_editable' => NULL,
      'popup_ventana' => NULL,
      'popup_carga_desc_metodo' => NULL,
      'popup_carga_desc_clase' => NULL,
      'popup_carga_desc_include' => NULL,
      'fieldset_fin' => NULL,
      'check_valor_si' => NULL,
      'check_valor_no' => NULL,
      'check_desc_si' => NULL,
      'check_desc_no' => NULL,
      'fijo_sin_estado' => NULL,
      'editor_ancho' => NULL,
      'editor_alto' => NULL,
      'editor_botonera' => NULL,
      'selec_cant_minima' => NULL,
      'selec_cant_maxima' => NULL,
      'selec_utilidades' => NULL,
      'selec_tamano' => NULL,
      'selec_ancho' => NULL,
      'selec_serializar' => NULL,
      'selec_cant_columnas' => NULL,
      'upload_extensiones' => NULL,
    ),
  ),
);
	}

}

?>
DELETE FROM apex_objeto_html  WHERE  (( objeto_html_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_esquema  WHERE  (( objeto_esquema_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_negocio_regla  WHERE  (( objeto_negocio_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_negocio  WHERE  (( objeto_negocio_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_ci_pantalla  WHERE  ((	objeto_ci_proyecto =	'toba_testing' )) ;
DELETE FROM apex_objeto_mt_me_etapa  WHERE  ((	objeto_mt_me_proyecto =	'toba_testing' )) ;
DELETE FROM apex_objeto_mt_me  WHERE  ((	objeto_mt_me_proyecto =	'toba_testing' )) ;
DELETE FROM apex_objeto_multicheq  WHERE  (( objeto_multicheq_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_ei_formulario_ef  WHERE  (( objeto_ei_formulario_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_ut_formulario_ef  WHERE  (( objeto_ut_formulario_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_ut_formulario  WHERE  (( objeto_ut_formulario_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_datos_rel_asoc  WHERE  (( proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_datos_rel  WHERE  (( proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_db_registros_col  WHERE  (( objeto_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_db_registros  WHERE  (( objeto_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_plan_linea  WHERE  (( objeto_plan_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_plan_hito  WHERE  (( objeto_plan_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_plan_activ_usu  WHERE  (( objeto_plan_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_plan_activ  WHERE  (( objeto_plan_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_plan  WHERE  (( objeto_plan_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_mapa  WHERE  (( objeto_mapa_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_ei_cuadro_columna  WHERE  (( objeto_cuadro_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_cuadro_columna  WHERE  (( objeto_cuadro_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_cuadro  WHERE  (( objeto_cuadro_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_grafico  WHERE  (( objeto_grafico_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_lista  WHERE  (( objeto_lista_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_filtro  WHERE  (( objeto_filtro_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_hoja_directiva  WHERE  (( objeto_hoja_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_hoja  WHERE  (( objeto_hoja_proyecto = 'toba_testing' )) ;
DELETE FROM apex_et_preferencias  WHERE  ((usuario_proyecto ='toba_testing')) ;
DELETE FROM apex_et_objeto  WHERE  ((objeto_proyecto ='toba_testing')) ;
DELETE FROM apex_et_item  WHERE  ((item_proyecto ='toba_testing')) ;
DELETE FROM apex_tp_tarea  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_ap_tarea_usuario  WHERE  ((apex_ap_tarea.tarea =apex_ap_tarea_usuario.tarea) AND (apex_ap_tarea.proyecto ='toba_testing')) ;
DELETE FROM apex_ap_tarea  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_ap_version  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_mod_datos_zona_tabla  WHERE  (( tabla_proyecto = 'toba_testing' )) ;
DELETE FROM apex_mod_datos_secuencia  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_mod_datos_tabla_restric  WHERE  (( tabla_proyecto = 'toba_testing' )) ;
DELETE FROM apex_mod_datos_tabla_columna  WHERE  (( tabla_proyecto = 'toba_testing' )) ;
DELETE FROM apex_mod_datos_tabla  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_mod_datos_zona  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_objeto_msg  WHERE  (( objeto_proyecto = 'toba_testing' )) ;
DELETE FROM apex_clase_msg  WHERE  (( clase_proyecto = 'toba_testing' )) ;
DELETE FROM apex_item_msg  WHERE  (( item_proyecto = 'toba_testing' )) ;
DELETE FROM apex_patron_msg  WHERE  (( patron_proyecto = 'toba_testing' )) ;
DELETE FROM apex_msg  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_nucleo_nota  WHERE  (( nucleo_proyecto = 'toba_testing' )) ;
DELETE FROM apex_objeto_nota  WHERE  (( objeto_proyecto = 'toba_testing' )) ;
DELETE FROM apex_clase_nota  WHERE  (( clase_proyecto = 'toba_testing' )) ;
DELETE FROM apex_item_nota  WHERE  (( item_proyecto = 'toba_testing' )) ;
DELETE FROM apex_patron_nota  WHERE  (( patron_proyecto = 'toba_testing' )) ;
DELETE FROM apex_nota  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_log_objeto  WHERE  (objeto_proyecto ='toba_testing') ;
DELETE FROM apex_solicitud_obj_observacion  WHERE  (((apex_solicitud.solicitud =apex_solicitud_obj_observacion.solicitud) AND (apex_solicitud.proyecto ='toba_testing'))) ;
DELETE FROM apex_solicitud_observacion  WHERE  (((apex_solicitud.solicitud =apex_solicitud_observacion.solicitud_observacion) AND (apex_solicitud.proyecto ='toba_testing'))) ;
DELETE FROM apex_solicitud_cronometro  WHERE  (((apex_solicitud.solicitud =apex_solicitud_cronometro.solicitud) AND (apex_solicitud.proyecto ='toba_testing'))) ;
DELETE FROM apex_solicitud_consola  WHERE  (((apex_solicitud.solicitud =apex_solicitud_consola.solicitud_consola) AND (apex_solicitud.proyecto ='toba_testing'))) ;
DELETE FROM apex_solicitud_wddx  WHERE  (((apex_solicitud.solicitud =apex_solicitud_wddx.solicitud_wddx) AND (apex_solicitud.proyecto ='toba_testing'))) ;
DELETE FROM apex_solicitud_browser  WHERE  ((apex_solicitud.solicitud =apex_solicitud_browser.solicitud_browser) AND (apex_solicitud.proyecto ='toba_testing')) ;
DELETE FROM apex_sesion_browser  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_solicitud  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_dimension_perfil_datos  WHERE  (( usuario_perfil_datos_proyecto = 'toba_testing' )) ;
DELETE FROM apex_dimension  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_dimension_grupo  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_dimension_tipo  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_nucleo_proto_propiedad  WHERE  ((	nucleo_proyecto =	'toba_testing' )) ;
DELETE FROM apex_nucleo_proto_metodo  WHERE  ((	nucleo_proyecto =	'toba_testing' )) ;
DELETE FROM apex_nucleo_proto  WHERE  ((	nucleo_proyecto =	'toba_testing' )) ;
DELETE FROM apex_objeto_proto_propiedad  WHERE  ((	objeto_proyecto =	'toba_testing' )) ;
DELETE FROM apex_objeto_proto_metodo  WHERE  ((	objeto_proyecto =	'toba_testing' )) ;
DELETE FROM apex_objeto_proto  WHERE  ((	objeto_proyecto =	'toba_testing' )) ;
DELETE FROM apex_clase_proto_propiedad  WHERE  ((	clase_proyecto =	'toba_testing' )) ;
DELETE FROM apex_clase_proto_metodo  WHERE  ((	clase_proyecto =	'toba_testing' )) ;
DELETE FROM apex_clase_proto  WHERE  ((	clase_proyecto =	'toba_testing' )) ;
DELETE FROM apex_item_proto  WHERE  ((	item_proyecto =	'toba_testing' )) ;
DELETE FROM apex_nucleo_info  WHERE  ((	nucleo_proyecto =	'toba_testing' )) ;
DELETE FROM apex_nucleo  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_arbol_items_fotos  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_usuario_grupo_acc_item  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_vinculo  WHERE  ((	origen_item_proyecto	= 'toba_testing' )) ;
DELETE FROM apex_item_objeto  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_objeto_eventos  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_objeto_dependencias  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_objeto_info  WHERE  ((	objeto_proyecto =	'toba_testing' )) ;
DELETE FROM apex_objeto  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_solicitud_obj_obs_tipo  WHERE  ((	clase_proyecto	= 'toba_testing' )) ;
DELETE FROM apex_objeto_categoria  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_patron_dependencias  WHERE  ((	patron_proyecto =	'toba_testing' )) ;
DELETE FROM apex_clase_dependencias  WHERE  ((	clase_consumidora_proyecto	= 'toba_testing' )) ;
DELETE FROM apex_clase_info  WHERE  ((	clase_proyecto	= 'toba_testing' )) ;
DELETE FROM apex_clase  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_item_info  WHERE  ((	item_proyecto = 'toba_testing'	)) ;
DELETE FROM apex_item  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_item_zona  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_buffer  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_patron_info  WHERE  ((	patron_proyecto =	'toba_testing' )) ;
DELETE FROM apex_patron  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_usuario_proyecto  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_usuario_grupo_acc  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_usuario_perfil_datos  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_pdf_propiedad  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_pagina_tipo  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_solicitud_obs_tipo  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_elemento_formulario  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_fuente_datos  WHERE  ((proyecto = 'toba_testing')) ;
DELETE FROM apex_proyecto  WHERE  ((proyecto = 'toba_testing')) ;

------------------------------------------------------------
--[1522]--  Clases posibles 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'toba_editor', --proyecto
	'1522', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_ei_cuadro', --clase
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Clases posibles', --nombre
	NULL, --titulo
	'0', --colapsable
	NULL, --descripcion
	NULL, --fuente_datos_proyecto
	NULL, --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2005-08-26 14:08:14', --creacion
	'abajo'  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_eventos
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio, es_seleccion_multiple) VALUES (
	'toba_editor', --proyecto
	'96', --evento_id
	'1522', --objeto
	'seleccionar', --identificador
	'Seleccionar', --etiqueta
	'1', --maneja_datos
	'1', --sobre_fila
	NULL, --confirmacion
	NULL, --estilo
	'apex', --imagen_recurso_origen
	'doc.gif', --imagen
	'0', --en_botonera
	NULL, --ayuda
	'1', --orden
	NULL, --ci_predep
	NULL, --implicito
	NULL, --defecto
	NULL, --display_datos_cargados
	NULL, --grupo
	NULL, --accion
	NULL, --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	NULL, --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL, --accion_vinculo_servicio
	'0'  --es_seleccion_multiple
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_cuadro
------------------------------------------------------------
INSERT INTO apex_objeto_cuadro (objeto_cuadro_proyecto, objeto_cuadro, titulo, subtitulo, sql, columnas_clave, clave_dbr, archivos_callbacks, ancho, ordenar, paginar, tamano_pagina, tipo_paginado, eof_invisible, eof_customizado, exportar_paginado, exportar, exportar_rtf, pdf_propiedades, pdf_respetar_paginacion, asociacion_columnas, ev_seleccion, ev_eliminar, dao_nucleo_proyecto, dao_nucleo, dao_metodo, dao_parametros, desplegable, desplegable_activo, scroll, scroll_alto, cc_modo, cc_modo_anidado_colap, cc_modo_anidado_totcol, cc_modo_anidado_totcua) VALUES (
	'toba_editor', --objeto_cuadro_proyecto
	'1522', --objeto_cuadro
	NULL, --titulo
	NULL, --subtitulo
	NULL, --sql
	'proyecto,clase', --columnas_clave
	'0', --clave_dbr
	NULL, --archivos_callbacks
	'300px', --ancho
	'0', --ordenar
	'0', --paginar
	NULL, --tamano_pagina
	'P', --tipo_paginado
	'0', --eof_invisible
	NULL, --eof_customizado
	NULL, --exportar_paginado
	'0', --exportar
	NULL, --exportar_rtf
	NULL, --pdf_propiedades
	NULL, --pdf_respetar_paginacion
	NULL, --asociacion_columnas
	NULL, --ev_seleccion
	NULL, --ev_eliminar
	NULL, --dao_nucleo_proyecto
	NULL, --dao_nucleo
	NULL, --dao_metodo
	NULL, --dao_parametros
	NULL, --desplegable
	NULL, --desplegable_activo
	'0', --scroll
	NULL, --scroll_alto
	't', --cc_modo
	'0', --cc_modo_anidado_colap
	NULL, --cc_modo_anidado_totcol
	NULL  --cc_modo_anidado_totcua
);

------------------------------------------------------------
-- apex_objeto_cuadro_cc
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_cuadro_cc (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_cc, identificador, descripcion, orden, columnas_id, columnas_descripcion, pie_contar_filas, pie_mostrar_titular, pie_mostrar_titulos, imp_paginar, modo_inicio_colapsado) VALUES (
	'toba_editor', --objeto_cuadro_proyecto
	'1522', --objeto_cuadro
	'4', --objeto_cuadro_cc
	'clase_tipo', --identificador
	NULL, --descripcion
	'1', --orden
	'clase_tipo', --columnas_id
	'clase_tipo_desc', --columnas_descripcion
	'0', --pie_contar_filas
	NULL, --pie_mostrar_titular
	'0', --pie_mostrar_titulos
	NULL, --imp_paginar
	'0'  --modo_inicio_colapsado
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_ei_cuadro_columna
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc, usar_vinculo, vinculo_carpeta, vinculo_item, vinculo_popup, vinculo_popup_param, vinculo_target, vinculo_celda, vinculo_servicio, permitir_html, grupo) VALUES (
	'toba_editor', --objeto_cuadro_proyecto
	'1522', --objeto_cuadro
	'335', --objeto_cuadro_col
	'clase', --clave
	'2', --orden
	NULL, --titulo
	'ei-cuadro-col-tit', --estilo_titulo
	'4', --estilo
	NULL, --ancho
	NULL, --formateo
	NULL, --vinculo_indice
	NULL, --no_ordenar
	NULL, --mostrar_xls
	NULL, --mostrar_pdf
	NULL, --pdf_propiedades
	NULL, --desabilitado
	NULL, --total
	'', --total_cc
	NULL, --usar_vinculo
	NULL, --vinculo_carpeta
	NULL, --vinculo_item
	NULL, --vinculo_popup
	NULL, --vinculo_popup_param
	NULL, --vinculo_target
	NULL, --vinculo_celda
	NULL, --vinculo_servicio
	NULL, --permitir_html
	NULL  --grupo
);
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc, usar_vinculo, vinculo_carpeta, vinculo_item, vinculo_popup, vinculo_popup_param, vinculo_target, vinculo_celda, vinculo_servicio, permitir_html, grupo) VALUES (
	'toba_editor', --objeto_cuadro_proyecto
	'1522', --objeto_cuadro
	'336', --objeto_cuadro_col
	'icono', --clave
	'1', --orden
	NULL, --titulo
	'ei-cuadro-col-tit', --estilo_titulo
	'7', --estilo
	'200px', --ancho
	'15', --formateo
	NULL, --vinculo_indice
	NULL, --no_ordenar
	NULL, --mostrar_xls
	NULL, --mostrar_pdf
	NULL, --pdf_propiedades
	NULL, --desabilitado
	NULL, --total
	NULL, --total_cc
	NULL, --usar_vinculo
	NULL, --vinculo_carpeta
	NULL, --vinculo_item
	NULL, --vinculo_popup
	NULL, --vinculo_popup_param
	NULL, --vinculo_target
	NULL, --vinculo_celda
	NULL, --vinculo_servicio
	NULL, --permitir_html
	NULL  --grupo
);
--- FIN Grupo de desarrollo 0

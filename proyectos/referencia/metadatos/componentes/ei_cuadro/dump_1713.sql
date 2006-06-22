------------------------------------------------------------
--[1713]--  Cuadro Cortes Estandar (redef. estetica) 
------------------------------------------------------------
INSERT INTO apex_objeto (proyecto, objeto, anterior, reflexivo, clase_proyecto, clase, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion) VALUES ('referencia', '1713', NULL, NULL, 'toba', 'objeto_ei_cuadro', 'extendion_cuadro_estetica_a', 'objetos/ei_cuadro - cortes control/extension_cuadro_estetica_a.php', NULL, NULL, 'Cuadro Cortes Estandar (redef. estetica)', 'Localidades de Santa Fe', NULL, NULL, 'referencia', 'referencia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2005-11-09 00:23:48');
INSERT INTO apex_objeto_cuadro (objeto_cuadro_proyecto, objeto_cuadro, titulo, subtitulo, sql, columnas_clave, clave_dbr, archivos_callbacks, ancho, ordenar, paginar, tamano_pagina, tipo_paginado, eof_invisible, eof_customizado, exportar, exportar_rtf, pdf_propiedades, pdf_respetar_paginacion, asociacion_columnas, ev_seleccion, ev_eliminar, dao_nucleo_proyecto, dao_nucleo, dao_metodo, dao_parametros, desplegable, desplegable_activo, scroll, scroll_alto, cc_modo, cc_modo_anidado_colap, cc_modo_anidado_totcol, cc_modo_anidado_totcua) VALUES ('referencia', '1713', NULL, NULL, NULL, 'zona_id, dep_id, loc_id', NULL, NULL, '100%', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 't', '0', NULL, NULL);
INSERT INTO apex_objeto_cuadro_cc (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_cc, identificador, descripcion, orden, columnas_id, columnas_descripcion, pie_contar_filas, pie_mostrar_titular, pie_mostrar_titulos, imp_paginar) VALUES ('referencia', '1713', '16', 'departamento', 'Departamento', '2', 'dep_id', 'departamento', '0', NULL, '0', NULL);
INSERT INTO apex_objeto_cuadro_cc (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_cc, identificador, descripcion, orden, columnas_id, columnas_descripcion, pie_contar_filas, pie_mostrar_titular, pie_mostrar_titulos, imp_paginar) VALUES ('referencia', '1713', '17', 'zona', 'Zona', '1', 'zona_id', 'zona', '0', NULL, '0', NULL);
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc) VALUES ('referencia', '1713', '387', 'localidad', '1', 'Localidad', 'lista-col-titulo', '5', NULL, '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc) VALUES ('referencia', '1713', '388', 'hab_varones', '2', 'Hab. Varones', 'lista-col-titulo', '0', NULL, '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc) VALUES ('referencia', '1713', '389', 'hab_mujeres', '3', 'Hab. Mujeres', 'lista-col-titulo', '0', NULL, '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc) VALUES ('referencia', '1713', '390', 'hab_total', '4', 'Hab. Total', 'lista-col-titulo', '0', NULL, '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');
INSERT INTO apex_objeto_ei_cuadro_columna (objeto_cuadro_proyecto, objeto_cuadro, objeto_cuadro_col, clave, orden, titulo, estilo_titulo, estilo, ancho, formateo, vinculo_indice, no_ordenar, mostrar_xls, mostrar_pdf, pdf_propiedades, desabilitado, total, total_cc) VALUES ('referencia', '1713', '391', 'superficie', '5', 'Superficie', 'lista-col-titulo', '0', NULL, '17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '');

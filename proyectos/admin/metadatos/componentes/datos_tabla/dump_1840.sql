------------------------------------------------------------
--[1840]--  ZONA - datos 
------------------------------------------------------------
INSERT INTO apex_objeto (proyecto, objeto, anterior, reflexivo, clase_proyecto, clase, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion) VALUES ('admin', '1840', NULL, NULL, 'toba', 'objeto_datos_tabla', NULL, NULL, NULL, NULL, 'ZONA - datos', NULL, NULL, NULL, 'admin', 'instancia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2006-07-24 19:59:01');
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, ap, ap_clase, ap_archivo, tabla, alias, modificar_claves) VALUES ('admin', '1840', NULL, NULL, '1', NULL, NULL, 'apex_item_zona', NULL, '1');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1840', '475', 'proyecto', 'C', '1', NULL, '15', NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1840', '476', 'zona', 'C', '1', NULL, '20', NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1840', '477', 'nombre', 'C', '0', NULL, '80', NULL, '1', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1840', '478', 'archivo', 'C', '0', NULL, '80', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1840', '1000051', 'consulta_archivo', 'C', '0', NULL, '255', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1840', '1000052', 'consulta_clase', 'C', '0', NULL, '60', NULL, '0', '0');
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa) VALUES ('admin', '1840', '1000053', 'consulta_metodo', 'C', '0', NULL, '60', NULL, '0', '0');

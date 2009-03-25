------------------------------------------------------------
--[1614]--  Cuadro - Cortes de Control 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion) VALUES (
	'toba_referencia', --proyecto
	'1614', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_ci', --clase
	'ci_cuadro_cc', --subclase
	'componentes/ei_cuadro - cortes control/ci_cuadro_cc.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'Cuadro - Cortes de Control', --nombre
	'Cuadro con cortes de control', --titulo
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
	'2005-09-20 16:15:14'  --creacion
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_eventos
------------------------------------------------------------

--- INICIO Grupo de desarrollo 30
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, defecto, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda, accion_vinculo_servicio) VALUES (
	'toba_referencia', --proyecto
	'30000041', --evento_id
	'1614', --objeto
	'imprimir', --identificador
	'Imprimir', --etiqueta
	'0', --maneja_datos
	NULL, --sobre_fila
	NULL, --confirmacion
	NULL, --estilo
	'apex', --imagen_recurso_origen
	'impresora.png', --imagen
	'1', --en_botonera
	NULL, --ayuda
	'1', --orden
	NULL, --ci_predep
	'0', --implicito
	'0', --defecto
	NULL, --display_datos_cargados
	NULL, --grupo
	'H', --accion
	'1', --accion_imphtml_debug
	NULL, --accion_vinculo_carpeta
	NULL, --accion_vinculo_item
	NULL, --accion_vinculo_objeto
	'0', --accion_vinculo_popup
	NULL, --accion_vinculo_popup_param
	NULL, --accion_vinculo_target
	NULL, --accion_vinculo_celda
	NULL  --accion_vinculo_servicio
);
--- FIN Grupo de desarrollo 30

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'26', --dep_id
	'1614', --objeto_consumidor
	'1615', --objeto_proveedor
	'cuadro', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'27', --dep_id
	'1614', --objeto_consumidor
	'1622', --objeto_proveedor
	'cuadro_tab', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'122', --dep_id
	'1614', --objeto_consumidor
	'1712', --objeto_proveedor
	'cuadro_tab_2', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'123', --dep_id
	'1614', --objeto_consumidor
	'1713', --objeto_proveedor
	'cuadro_tab_est_1', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'124', --dep_id
	'1614', --objeto_consumidor
	'1714', --objeto_proveedor
	'cuadro_tab_est_2', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'687', --dep_id
	'1614', --objeto_consumidor
	'1710', --objeto_proveedor
	'cuadro_tab_full', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'125', --dep_id
	'1614', --objeto_consumidor
	'1715', --objeto_proveedor
	'cuadro_tab_full_ext', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'686', --dep_id
	'1614', --objeto_consumidor
	'1709', --objeto_proveedor
	'cuadro_tab_regs', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'137', --dep_id
	'1614', --objeto_consumidor
	'1708', --objeto_proveedor
	'cuadro_tab_sum', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'136', --dep_id
	'1614', --objeto_consumidor
	'1707', --objeto_proveedor
	'cuadro_tab_sum_ah_1', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'toba_referencia', --proyecto
	'688', --dep_id
	'1614', --objeto_consumidor
	'1711', --objeto_proveedor
	'cuadro_tab_sum_ah_2', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	NULL  --orden
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_mt_me
------------------------------------------------------------
INSERT INTO apex_objeto_mt_me (objeto_mt_me_proyecto, objeto_mt_me, ev_procesar_etiq, ev_cancelar_etiq, ancho, alto, posicion_botonera, tipo_navegacion, con_toc, incremental, debug_eventos, activacion_procesar, activacion_cancelar, ev_procesar, ev_cancelar, objetos, post_procesar, metodo_despachador, metodo_opciones) VALUES (
	'toba_referencia', --objeto_mt_me_proyecto
	'1614', --objeto_mt_me
	NULL, --ev_procesar_etiq
	NULL, --ev_cancelar_etiq
	'90%', --ancho
	'400px', --alto
	'arriba', --posicion_botonera
	'tab_v', --tipo_navegacion
	'0', --con_toc
	NULL, --incremental
	NULL, --debug_eventos
	NULL, --activacion_procesar
	NULL, --activacion_cancelar
	NULL, --ev_procesar
	NULL, --ev_cancelar
	NULL, --objetos
	NULL, --post_procesar
	NULL, --metodo_despachador
	NULL  --metodo_opciones
);

------------------------------------------------------------
-- apex_objeto_ci_pantalla
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'475', --pantalla
	'pant_cuadro', --identificador
	'1', --orden
	'Cuadro Plano', --etiqueta
	'Este es un ejemplo del uso de cuadros para hacer REPORTES. Estos son los datos que se van a utilizar a lo largo del ejemplo.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'477', --pantalla
	'cuadro_cc_tab', --identificador
	'3', --orden
	'Cortes TAB. (2)', --etiqueta
	'Redefinicion estetica. Se modifica el contenido de las cabeceras de los cortes de control \'Zona\'.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'937', --pantalla
	'cuadro_cc_tab_sah_1', --identificador
	'8', --orden
	'Cortes TAB. Sum AH 1', --etiqueta
	'Se agrega una sumarizacion AD-HOC en el corte \'Zona\'. Para lograr este tipo de sumarizaciones hace falta una extension del cuadro.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_sum_ah_1', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'938', --pantalla
	'cuadro_cc_tab_s', --identificador
	'5', --orden
	'Cortes TAB. Sum', --etiqueta
	'Se agregan sumarizaciones por columna. Todas las columnas se agregan en todos los cortes y en la sumariacion total. Se agrega una cuenta de registros en el corte \'Zona\'.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_sum', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'939', --pantalla
	'cuadro_cc_tab_regs', --identificador
	'4', --orden
	'Cortes TAB. (regs.)', --etiqueta
	'Se agrega una cuenta de filas al corte de control \'Localidades\'.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_regs', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'940', --pantalla
	'cuadro_cc_tab_full', --identificador
	'10', --orden
	'Cortes TAB. FULL', --etiqueta
	'Cabeceras de PIE,  titulos de las columnas en los totales y conteo de filas para el corte \'Zona\' (Este comportamiento NO requier de una extension).', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_full', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'941', --pantalla
	'cuadro_cc_tab_sah_2', --identificador
	'9', --orden
	'Cortes TAB. Sum AH 2', --etiqueta
	'Se agrega una sumarizacion AD-HOC en los cortes \'Zona\' y \'Localidad\' (Para lograr este tipo de sumarizaciones hace falta una extension de los cuadros).', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_sum_ah_2', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'942', --pantalla
	'cuadro_cc_tab_2', --identificador
	'2', --orden
	'Cortes TAB. (1)', --etiqueta
	'Se utiliza la columna \'zona\' para generar un corte de control.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_2', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'943', --pantalla
	'cuadro_cc_tab_est_1', --identificador
	'6', --orden
	'Cortes TAB. (Est.)', --etiqueta
	'Redefinicion estetica. Se modifica el contenido de las cabeceras de los cortes de control \'Zona\'. Para realizar este tipo de customizaciones se necesita extender el cuadro.<br>Adem�s se utiliza el colapsado inicial de los cortes de control.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_est_1', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'944', --pantalla
	'cuadro_cc_tab_est_2', --identificador
	'7', --orden
	'Cortes TAB. (Est. 2)', --etiqueta
	'Redefinicion estetica. Se agrega un texto customizado en el pie del corte de control \'Zona\'. Para esto es necesario definir una subclase.', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_est_2', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
INSERT INTO apex_objeto_ci_pantalla (objeto_ci_proyecto, objeto_ci, pantalla, identificador, orden, etiqueta, descripcion, tip, imagen_recurso_origen, imagen, objetos, eventos, subclase, subclase_archivo) VALUES (
	'toba_referencia', --objeto_ci_proyecto
	'1614', --objeto_ci
	'945', --pantalla
	'cuadro_cc_tab_full_e', --identificador
	'11', --orden
	'Cortes TAB. FULL (e)', --etiqueta
	'Redefinicion de estetica y sumarizaciones. La unica redefinicion que no se utilizo antes es la modificacion del contenido de la cabecera del pie, en el corte de control \'Localidad\' (se accede a los acumuladores de la sumarizacion del toba).', --descripcion
	NULL, --tip
	'apex', --imagen_recurso_origen
	NULL, --imagen
	'cuadro_tab_full_ext', --objetos
	'imprimir', --eventos
	NULL, --subclase
	NULL  --subclase_archivo
);
--- FIN Grupo de desarrollo 0

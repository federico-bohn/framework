------------------------------------------------------------
--[/admin/items/editor_items]--  Editor de Items 
------------------------------------------------------------
INSERT INTO apex_item (item_id, proyecto, item, padre_id, padre_proyecto, padre, carpeta, nivel_acceso, solicitud_tipo, pagina_tipo_proyecto, pagina_tipo, actividad_buffer_proyecto, actividad_buffer, actividad_patron_proyecto, actividad_patron, nombre, descripcion, actividad_accion, menu, orden, solicitud_registrar, solicitud_obs_tipo_proyecto, solicitud_obs_tipo, solicitud_observacion, solicitud_registrar_cron, prueba_directorios, zona_proyecto, zona, zona_orden, zona_listar, imagen_recurso_origen, imagen, parametro_a, parametro_b, parametro_c, publico, redirecciona, usuario, creacion) VALUES ('1239', 'toba_editor', '/admin/items/editor_items', NULL, 'toba_editor', '/items', '0', '0', 'web', 'toba', 'titulo', 'toba', '0', 'toba', 'CI', 'Editor de Items', NULL, '', '1', '10', '0', NULL, NULL, NULL, '0', NULL, 'toba_editor', 'zona_item', NULL, '1', 'apex', 'objetos/editar.gif', NULL, NULL, NULL, '0', '0', NULL, '2005-08-23 14:20:49');
INSERT INTO apex_item_objeto (item_id, proyecto, item, objeto, orden, inicializar) VALUES (NULL, 'toba_editor', '/admin/items/editor_items', '1517', '1', NULL);


------------------------------------------------------------
-- apex_dimension
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, subclase, subclase_archivo, fuente_datos_proyecto, fuente_datos) VALUES (
	'toba_referencia', --proyecto
	'5', --dimension
	'juegos', --nombre
	NULL, --descripcion
	NULL, --schema
	'ref_juegos', --tabla
	'id', --col_id
	'nombre', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	NULL, --subclase
	NULL, --subclase_archivo
	'toba_referencia', --fuente_datos_proyecto
	'toba_referencia'  --fuente_datos
);
INSERT INTO apex_dimension (proyecto, dimension, nombre, descripcion, schema, tabla, col_id, col_desc, col_desc_separador, multitabla_col_tabla, multitabla_id_tabla, subclase, subclase_archivo, fuente_datos_proyecto, fuente_datos) VALUES (
	'toba_referencia', --proyecto
	'6', --dimension
	'deportes', --nombre
	NULL, --descripcion
	NULL, --schema
	'ref_deportes', --tabla
	'id', --col_id
	'nombre', --col_desc
	NULL, --col_desc_separador
	NULL, --multitabla_col_tabla
	NULL, --multitabla_id_tabla
	NULL, --subclase
	NULL, --subclase_archivo
	'toba_referencia', --fuente_datos_proyecto
	'toba_referencia'  --fuente_datos
);
--- FIN Grupo de desarrollo 0

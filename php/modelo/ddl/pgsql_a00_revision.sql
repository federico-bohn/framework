CREATE TABLE			apex_revision
---------------------------------------------------------------------------------------------------
--: proyecto: toba
--: dump: nucleo
--: dump_order_by: revision
--: zona: general
--: desc: Especifica la revision del SVN con que se creo el proyecto
--: version: 1.0
--: instancia: 1
---------------------------------------------------------------------------------------------------
(
	revision					varchar(20)	NOT NULL,
	creacion					timestamp(0) without	time zone	DEFAULT current_timestamp NOT	NULL
);
--#################################################################################################

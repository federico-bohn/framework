<?
//*********  FRAMES entorno EDICION ************
//-- FRAME control
define("apex_frame_control","frame_control");
//-- FRAME lista
define("apex_frame_lista","frame_lista");
//-- FRAME central
define("apex_frame_centro","frame_centro");
//-- FRAME comunicaciones
define("apex_frame_com","frame_com");

if (php_sapi_name() === 'cli') {
	toba_editor::iniciar(toba_instancia::get_id(), toba_editor::get_id());
}

?>
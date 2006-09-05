<?php
	
$url = toba_recurso::path_apl()."/js/jsunit/testRunner.html?autorun=true&showTestFrame=50&testPage=";
$path =  toba::hilo()->get_path().'/www/js/testing/';
$casos = glob($path."*.html");

echo "<ul>";
if (is_array($casos)) { 
	foreach ($casos as $caso) {
		$nombre = basename($caso);
		$direccion = $url.substr(toba_recurso::path_apl()."/js/testing/$nombre", 7);	//Para sacar el protocolo
		echo "<li><a href='#' onclick=\"solicitar_item_popup('$direccion', 700, 600, 'yes', 'yes');\">";
		echo substr($nombre, 0, -5);
		echo "</a></li>";
	}
}
echo "</ul>";


?>
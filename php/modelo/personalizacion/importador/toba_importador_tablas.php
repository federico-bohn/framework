<?php
/**
 * Clase que importa un plan para tablas grales
 * @package Centrales
 * @subpackage Personalizacion
 */
class toba_importador_tablas extends toba_importador {
	
	protected function cargar_tareas()
	{
		foreach($this->plan as $item) {
			$tarea =  new toba_tarea_tabla($item, $this->db);
			$this->tareas[] = $tarea;
		}
	}

}
?>

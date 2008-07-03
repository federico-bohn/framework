<?php 
class toba_rf_subcomponente_columna extends toba_rf_subcomponente
{
	protected $cuadro;
	protected $id_columna;
	
	function __construct($nombre, $padre, $id, $proyecto, $item, $restriccion, $estado_original, $cuadro) 
	{
		$this->cuadro = $cuadro;
		$this->id_columna = $id;
		$id = 'col_cuadro_'.$id;
		parent::__construct($nombre, $padre, $id, $proyecto, $item, $restriccion, $estado_original);
		
	}
	
	function inicializar()
	{
		$this->iconos[] = array(
				'imagen' => toba_recurso::imagen_toba( 'objetos/columna.gif', false),
				'ayuda' => "Columna de un cuadro",
				);		
	}

	function get_input($id)
	{
		$id_input = $id.'_oculto';
		$valor_inicial = $this->no_visible_actual ? 1 : 0;
		$img_inicial = $this->no_visible_actual ? $this->img_oculto : $this->img_visible;		
		$html = '';		
		$html .= "<img src='$img_inicial' id='".$id_input."_img' title='Visible / Oculto' onclick='cambiar_oculto(\"$id_input\")' />";
		$html .= "<input type='hidden' value='$valor_inicial' id='$id_input' name='$id_input' />";		
		return $html;
	}
	
	function cargar_estado_post($id)
	{
		if (isset($_POST[$id.'_oculto'])) {
			if ($_POST[$id.'_oculto']) {
				$this->no_visible_actual = $_POST[$id.'_oculto'];	
			} else {
				$this->no_visible_actual = 0;
			}
		}		
	}
	
	function sincronizar()
	{
		if ($this->no_visible_actual != $this->no_visible_original) {
			if ($this->no_visible_actual == 1) {
				$sql = "INSERT INTO 
							apex_restriccion_funcional_cols (proyecto, restriccion_funcional, item, objeto_cuadro, objeto_cuadro_col, no_visible)
						VALUES
							('$this->proyecto', '$this->restriccion', '$this->item', '$this->cuadro', '$this->id_columna', '$this->no_visible_actual');";
			}else{
				$sql = "DELETE FROM
							apex_restriccion_funcional_cols
						WHERE
								proyecto = '$this->proyecto'
							AND	restriccion_funcional = '$this->restriccion'
							AND objeto_cuadro_col = '$this->id_columna';";
			}
			toba::db()->ejecutar($sql);
		}
		
	}
}
?>
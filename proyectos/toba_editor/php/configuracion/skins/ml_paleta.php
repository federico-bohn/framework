<?php 
class ml_paleta extends toba_ei_formulario_ml
{
	protected $colores = array('fondo', 'frente', 'borde');

	
	function generar_input_ef($ef)
	{
		parent::generar_input_ef($ef);
		if (in_array($ef, $this->colores)) {
			$fila = $this->ef($ef)->get_fila_actual();
			$id_form = $this->ef($ef)->get_id_form();
			$contenido = gif_nulo(16, 16);
			echo "<span id='css_".$ef.'_'.$fila."' onclick='colorpicker($(\"$id_form\"))'
					title='Seleccionar otro color' class='css-preview' >$contenido</span>";
		}
	}
	
	
	function extender_objeto_js()
	{

		echo "
		function colorpicker(nodo)
		{
			document.nodo_colorpicker = nodo;
			var contenedor = document.getElementById('overlay_contenido');
			titulo = 'Selecci�n de color';
			var valor = nodo.value;
			mensaje = \"<div><input type='text' class='color' id='colorselector'/>\";
			mensaje += \"</div><div class='overlay-botonera'>\";
			mensaje += \"<input id='boton_overlay' type='button' value='Aceptar' onclick='colorpicker_aceptar()'/></div>\";			
			var img = '<img class=\"overlay-cerrar\" title=\"Cerrar ventana\" src=\"' + toba.imagen('cerrar')
			img += '\" onclick=\"overlay()\"/>';
			contenedor.innerHTML = '<div class=\"overlay-titulo\">' + img + titulo + '</div>' + mensaje;
			makeColorSelectors();
			overlay();
			$('colorselector').value = valor;
			$('colorselector').onchange();
		}
		
		function colorpicker_aceptar()
		{	
			document.nodo_colorpicker.value=$('colorselector').value;
			document.nodo_colorpicker.onblur();
			overlay();
		}
		";
				
		foreach ($this->colores as $color) {
			echo "
			{$this->objeto_js}.evt__$color"."__procesar = function(inicial, fila)
			{
				var id_ef = '$color';
				var estado = this.ef(id_ef).ir_a_fila(fila).get_estado();
				if (estado == apex_ef_no_seteado) {
					this.ef(id_ef).ir_a_fila(fila).ocultar();
					return;
				}
				if (estado != '') {
					if (estado.indexOf('#') == -1) {
						estado = '#' + estado;
						this.ef(id_ef).ir_a_fila(fila).set_estado(estado);
					}
					$('css_' + id_ef + '_' + fila).style.display = '';
					$('css_' + id_ef + '_' + fila).style.background = estado;
				} else {
					$('css_' + id_ef + '_' + fila).style.display = 'none';
				}
			}
			";
		}
	}
}

?>
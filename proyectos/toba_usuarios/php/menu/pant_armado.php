<?php
class pant_armado extends toba_ei_pantalla
{
	function generar_layout()
	{
		$this->enviar_estilos();
		echo '<table><tr><td>';
		$this->dep('form_armado')->generar_html();
		echo '</td><td><div style=\'height:400px;overflow:auto\'>';
		$this->dep('arbol_origen')->generar_html();		
		echo '</div></td></tr></table>';
	}
	
	function get_consumo_javascript()
	{
		$consumo_js = parent::get_consumo_javascript();
		$consumo_js[] = 'utilidades/jquery-ui.min';
		return $consumo_js;
	}
	
	protected function enviar_estilos()
	{
		echo '<style>
				.menu {
						position: relative;
						background-color: #FFF;
						float: right;
						padding: 3px;
						border: 1px solid #CCC;
						width: 750px;
						height: 400px;
				}		
				.menu-origen {						
						padding: 2px;
				}		
				.menu-contenedor {
						float: left;
						position: relative;
						margin-right: 5px;
				}
				.menu-item {
						border: 1px solid #dfdfdf;
						position: relative;
						padding: 0 25px 0 15px;
						height: auto;
						line-height: 30px;
						overflow: hidden;
						word-wrap: break-word;
						background-color: #fafafa;
						-webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04);
						box-shadow: 0 1px 1px rgba(0,0,0,.04);
						float: left;
				}		
				.menu-item.carpeta {
						background-color: #FBEDBF;
				}
				.menu-subitem {
						background-color: #fff;
						padding: 4px;
						border: 1px dashed #dfdfdf;
						font-weight: 600;
						font-size: 13px;
						width: 300px;
						margin-bottom: 10px;
						line-height: 20px;
						position: relative;
				}
				.menu-subitem .titulo {
						display: block;
						margin-right: 22px;
						padding: 0 5px;
				}
				.control {
						font-size: 12px;
						position: absolute;
						right: 5px;
						top: 0;
						display: block;
				}
				.close-btn{
						cursor: pointer;
						position: absolute;
						right: 5px;
						top: 1px;
				}			
			</style>';
	}
	
	function extender_objeto_js()
	{			
		echo "
		$(function() {			
			newdt = function(id_elem, texto, id_padre) {				
				var dt = $('<dt/>', {
							class: 'menu-subitem',
							id: id_elem, 
							top: '10px', 
							left: '50px'});

				$('<span/>', {class: 'titulo', text:texto}).appendTo(dt);
				
				var spn_ctrl = $('<span/>', {class: 'control'});

				$('<span/>', {class: 'close-btn', text:'X'})
					.on('click', function() { 
						var \$spn = $(this),												
							id_padre = \$spn.closest('dl').attr('id'),	//<dl> padre												
							\$dt = \$spn.closest('dt'),
							id_subitem = \$dt.attr('id');				//<dt> submenu
						\$spn.remove();
						\$dt.remove();
						quitar_subnivel(id_padre, id_subitem);
						})
					.appendTo(spn_ctrl);
				
				dt.append(spn_ctrl);
				agregar_subnivel(id_padre, id_elem);	
				return dt;
			}

			newdl = function (id_elem, texto, es_carpeta) {
				var clase = (es_carpeta)? 'menu-item carpeta' : 'menu-item';
				var nuevo = $('<dl/>', { class: clase, 
								id: id_elem,
								top: '10px',
								left: '70px',
								carpeta: es_carpeta});
								
				$('<span/>', {class: 'titulo', text: texto}).appendTo(nuevo);
				
				nuevo.draggable({ helper:'original', revert: 'invalid'});
				nuevo.droppable({
						greedy:true,
						accept: 'dl.menu-item',
						drop: function (event, ui) {
							var \$ui = ui.helper,
								\$this = $(this);

							if (\$this.attr('carpeta') != 'true') {
								\$ui.draggable({revert: true});
								return;
							} else {
								\$ui.draggable({revert: 'invalid'});
							}

							if (\$ui.find('dt.menu-subitem').length) { 
								\$ui.closest('li')
								   .remove()
								   .end()
								   .remove();
								return;
							}
							//Creo el submenu
							var id_padre = \$this.attr('id'),	//<dl> destino
								id_elem = \$ui.attr('id'),		//<dl> origen														
								dt = newdt(id_elem, \$ui.find('span.titulo').text(), id_padre);	
								
							\$this.append(dt);
							\$ui.closest('li').remove();									
						}
				});
				return nuevo;
			};

			$('.menu-origen').draggable({
				helper: 'original',
				revert: true});
				
			$('div.menu').droppable({ 
				greedy: true, 
				accept: '.menu-origen', 
				drop: function (event, ui) {
					var	es_carpeta = false,
						\$ui = ui.helper,						
						id_elem = \$ui.attr('id_nodo'),
						nomb_cont = id_elem + '__contenedor';		//Este sera el contenedor del nuevo menu

					var \$ul = $(this).find('ul');						
					if (\$ul.find('#' + nomb_cont).length) {			//No agrego uno nuevo del mismo
							return;
					}	

					//Tengo que ver si es una carpeta o un item final usar .data para recuperar los atributos, sino es medio de gusto
					if (\$ui.find('ul').attr('carpeta')  == 'true') {
						es_carpeta = true;
					}

					//Creo un contenedor para todos los submenues
					var contenedor = $('<li/>', { class: 'menu-contenedor', 
												  id: nomb_cont
									}).appendTo(\$ul);

					guardar_primer_nivel(id_elem);

					//Elimino el texto de los hijos para obtener solo el primer nivel
					var texto = \$ui.text();
					if (\$ui.find('ul.menu-origen').length) {				//Revisar
						var texto_hijos = \$ui.find('ul.menu-origen').text(),
								  fin = texto.indexOf(texto_hijos);								  
						texto = texto.slice(0, fin);
					}
					
					//Hago un DL para el menu de primer nivel
					var nuevo = newdl(id_elem, texto, es_carpeta);
					
					var spn_ctrl = $('<span/>', {class: 'control'}).append($('<span/>', {class: 'close-btn', text: 'X'})
																.on('click', function() { 
																			var \$this = $(this);
																			var id_elem = \$this.closest('dl').attr('id');
																			eliminar_primer_nivel(id_elem);
																			\$this.closest('li').remove();})
															);					
					nuevo.append(spn_ctrl).appendTo(contenedor);
				}
			});				
		});";		
	}
}
?>
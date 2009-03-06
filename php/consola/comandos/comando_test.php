<?php
require_once('comando_toba.php');

class comando_test extends comando_toba
{
	static function get_info()
	{
		return 'Ejecucion de baterias de TEST';
	}

	/**
	*	<I_1> <I_2> Compara dos Instancias
	*/
	function opcion__ci()
	{
		if ( !isset( $this->argumentos[1] ) || !isset( $this->argumentos[2] ) ) {
			throw new toba_error("Es necesario indicar el nombre de las dos instancias");
		}
		$ci = new comparador_instancias( $this->argumentos[1], $this->argumentos[2] );
		$datos = $ci->procesar();
		$titulos = array( 'TABLA', $this->argumentos[1], $this->argumentos[2], 'diff');
		$this->consola->tabla( $datos, $titulos );
		$ci->finalizar();
	}
	
	/**
	 * Ejecuta la bater�a de test autom�ticos de un proyecto
	 * @consola_parametros Par�metros: -p Proyecto [-c Cat] [-t Caso] 
	 */
	function opcion__automaticos()
	{
		require_once('modelo/lib/testing_unitario/toba_test_lista_casos.php');
		require_once( toba_dir() . '/php/3ros/simpletest/unit_tester.php');
		require_once( toba_dir() . '/php/3ros/simpletest/reporter.php');
		
		$param = $this->get_parametros();
		
		$proyecto = isset($param["-p"]) ? $param["-p"] : $this->get_id_proyecto_actual(true);
		$instancia = isset($param["-i"]) ? $param["-i"] : $this->get_id_instancia_actual(true);
		
		toba_nucleo::instancia()->iniciar_contexto_desde_consola($instancia, $proyecto);
		
		toba_test_lista_casos::$proyecto = $proyecto;
		toba_test_lista_casos::$instancia = $instancia;

		//Selecciono una categoria
		if (isset($param["-c"])) {
			$seleccionados = toba_test_lista_casos::get_casos($param["-c"]);
		} else {
			$seleccionados = toba_test_lista_casos::get_casos();
		}
		if(isset($param["-t"])) {
			//Seleccion de un test particular
			if (isset($param["-t"])) {
				$particular = false;
				foreach ($seleccionados as $caso) {
					if ($caso['id'] == $param["-t"]) {
						$particular = $caso;
					}
				}
				if ($particular)
					$seleccionados = array($particular);
				else
					$seleccionados = array();
			}	
		} 
		
		$resultado=null;	
		try {
			$separar_casos = (isset($param["-l"])) ? true : false;
			$separar_pruebas = (isset($param["-l"])) ? true : false;
			$test = new toba_test_grupo_casos('Casos de TEST', $separar_casos, $separar_pruebas);
		    foreach ($seleccionados as $caso) {
		        require_once($caso['archivo']);
		        $test->addTestCase(new $caso['id']($caso['nombre']));
			}
			
			//Termina la ejecuci�n con 0 o 1 para que pueda comunicarse con al consola
			$resultado = $test->run(new TextReporter());
			
		} catch (Exception $e) {
			if (method_exists($e, 'mensaje_consola'))
				$this->consola->mensaje( $e->mensaje_consola() );
			else
				$this->consola->mensaje( $e );
			$resultado = 1;
		}
		
		//Guardar LOGS?
		if (isset($param["-l"])) {
			toba::logger()->debug('Tiempo utilizado: ' . toba::cronometro()->tiempo_acumulado() . ' seg.');
			toba::logger()->guardar();
		}
		exit(intval($resultado));
	}
	
}
?>
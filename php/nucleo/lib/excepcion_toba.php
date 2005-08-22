<?php
/**
* Error interno de toba
*/
class excepcion_toba extends Exception
{
	function __construct($mensaje)
	{
		parent::__construct($mensaje);
	}
	
	function agregar_mensaje($mensaje)
	{
		$this->message .= $mensaje;
	}

	function mensaje_web()
	{
		$html = "<div style='text-align: left'>";
		$html .= "<strong style='color:red;'>EXCEPCION:</strong><br>";
		$html .= parent::getMessage()."<br><br>";
		$html .= "Archivo \"".parent::getFile()."\", l�nea ".parent::getLine()."<br>";
		$html .= "<a href='javascript: ' onclick=\"o = this.nextSibling; o.style.display = (o.style.display == 'none') ? '' : 'none';\">[detalle]</a>";
		$html .= "<ul style='display: none'>";
///*
		$html .= "-------------------------------------------\n";
		$html .= parent::getTraceAsString() ."\n";
		$html .= "-------------------------------------------\n";
//*/
/*
	//	ESTO se cuelga en la 5.0.4 si se usa "call_user_func_array"
	//		-> Pasa cuando el error se da a partir de un evento de los EI

		foreach (parent::getTrace() as $paso) {
			$clase = '';
			if (isset($paso['class']))
				$clase .= $paso['class'];
			if (isset($paso['type']))
				$clase .= $paso['type'];				
			$html .= "<li><strong>$clase{$paso['function']}</strong><br>
					Archivo: {$paso['file']}, l�nea {$paso['line']}<br>";
			if (! empty($paso['args'])) {
				$html .= "Par�metros: <ol>";
				foreach ($paso['args'] as $arg) {
					$html .= "<li>";
					$html .= var_export($arg, true);
					$html .= "</li>";
				}
				$html .= "</ol>";
			} 
			$html .= "</li>";
		}
*/
		$html .= "</ul></div>";
		return $html;
	}
	
	function mensaje_consola()
	{
		echo $this->__toString();
	}
}

/**
* Excepci�n producida en tiempo de ejecuci�n producidas por alguna interacci�n del usuario
*/
class excepcion_toba_usuario extends excepcion_toba
{

}

/**
* Excepci�n producida en tiempo de definici�n producidas por error del desarrollo
*/
class excepcion_toba_def extends excepcion_toba
{

}

?>
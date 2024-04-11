<?php  
/**
 * helper incluido en globals_helper.php
 *
 * imprime por pantalla el parametro recibido
 *
 * @param string $data el dato que queremos imprimir
 *
 * @param int $exit un numero entero (default null) 
 * @return none imprime el dato recibido por parametro, con opcion a a cortar la ejecucion
*/
function ddl($data, $exit = null) {
	if($exit == 1) {
		echo "<pre>";
		print_r($data);
		exit;
	} elseif($exit == 2) {
		echo "<pre>";
		var_dump($data);
		exit;
	}
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

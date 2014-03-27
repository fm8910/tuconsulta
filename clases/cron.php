<?php 
require_once('Coneccion.php');
require_once('funciones.php');

$numero= $GLOBALS['Coneccion']->getAll("SELECT numero_tarjeta from contador ORDER BY contador DESC ");
foreach ($numero as $i => $valor) {
	$GLOBALS['funciones']->consultar($valor["numero_tarjeta"]);
}


 ?>
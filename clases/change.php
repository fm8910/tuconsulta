<?php 
require_once('Coneccion.php');
require_once('funciones.php');
$numero= $GLOBALS['Coneccion']->getAll("SELECT contador,fecha from crontable limit 5");
foreach ($numero as $i => $valor) {
	$sSQL= "
                    UPDATE `crontable` SET 
                    `fecha` = CONVERT_TZ( '{$valor["fecha"]}'  ,  '+02:00',  '-06:00' ) where `contador`='{$valor["contador"]}'
                ";
         $GLOBALS['Coneccion']->ejecutar($sSQL);
}
 ?>
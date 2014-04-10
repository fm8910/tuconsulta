<?php 
require_once('Coneccion.php');
require_once('funciones.php');
$numero= $GLOBALS['Coneccion']->getAll("SELECT numero_tarjeta from contador");
foreach ($numero as $i => $valor) {
	$codigo=$valor["numero_tarjeta"];
$ultimosaldo= $GLOBALS['Coneccion']->getAll("SELECT id_historial, saldo FROM `historial` WHERE `numero_tarjeta`='{$codigo}' ORDER BY id_historial ASC");
  
  
 for($i=0;$i<count($ultimosaldo);$i++) {
 		
 	if ($i==0) {
 		$bol= $ultimosaldo[$i]["saldo"];
 		
 		$sSQL= "
                    UPDATE `historial` SET 
                    `balance` = '{$bol}' where `numero_tarjeta`='{$valor["numero_tarjeta"]}' and `id_historial`='{$ultimosaldo[$i]["id_historial"]}'
                ";
         $GLOBALS['Coneccion']->ejecutar($sSQL);
 	}else{
 		
 		$bl= $ultimosaldo[$i]["saldo"] - $ultimosaldo[$i-1]["saldo"] ;
 		 		
 		
 		$SQL= "
                    UPDATE `historial` SET 
                    `balance` = '{$bl}' where `numero_tarjeta`='{$valor["numero_tarjeta"]}' and `id_historial`='{$ultimosaldo[$i]["id_historial"]}'
                ";
              $GLOBALS['Coneccion']->ejecutar($SQL);
 		
     }
}	
}
 ?>
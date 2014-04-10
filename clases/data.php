<?php 
date_default_timezone_set('America/Managua');
require_once('Coneccion.php'); 
$tuc= $_POST["codigo"];
$fecha=$_POST["fecha1"];
list($fec1, $fec2) = split('-', $fecha);
$fec1=str_replace('/', '-', trim($fec1));
$fec2=str_replace('/', '-', trim($fec2));
$fechaini = date('Y-m-d', strtotime($fec1));
$fechafin = date('Y-m-d', strtotime($fec2));


if ($fechaini==$fechafin) {
	$sql="SELECT saldo, TIME( fecha ) as fecha
FROM  `historial` 
WHERE numero_tarjeta =  '{$tuc}'
AND DATE( fecha ) = '{$fechaini}'";
getsaldo($sql);
}else {
	$sql="SELECT saldo, DATE( fecha ) as fecha
FROM  `historial` AS hs
WHERE hs.numero_tarjeta =  '{$tuc}'
AND DATE( hs.fecha ) >=  '{$fechaini}'
AND DATE( hs.fecha ) <=  '{$fechafin}'
AND id_historial = ( 
SELECT MAX( id_historial ) 
FROM historial AS ht
WHERE hs.numero_tarjeta = ht.numero_tarjeta
AND DATE( hs.fecha ) = DATE( ht.fecha ) ) 
GROUP BY DATE( fecha ) ";
 getsaldo($sql);
}
function getsaldo($query){

$result = mysql_query($query) or die("SQL Error 1: " . mysql_error()); 

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { 
$orders[] = array( 

'saldo' => $row['saldo'], 
'fecha' => $row['fecha'] 
); 
} 
echo json_encode($orders); 
}


?>
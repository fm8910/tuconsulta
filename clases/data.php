<?php 

require_once('coneccion.php'); 


$query = "SELECT saldo,fecha FROM `historial` where numero_tarjeta='00108714' ORDER BY fecha asc LIMIT 0 , 100"; 
$result = mysql_query($query) or die("SQL Error 1: " . mysql_error()); 

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { 
$orders[] = array( 

'saldo' => $row['saldo'], 
'fecha' => $row['fecha'] 
); 
} 

mysql_close($link); 

echo json_encode($orders); 


?>
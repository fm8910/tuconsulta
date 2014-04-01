<?php
/**
* 
*/
class funciones 
{
 
  function ingresar($codigo,$saldo){
  $ultimoid= $GLOBALS['Coneccion']->getOne("SELECT id_historial FROM `historial` WHERE `numero_tarjeta`='{$codigo}' ORDER BY id_historial DESC limit 1");
  if ($ultimoid==null) {
      $ultimoid=0;
       $sSQL = "
                    INSERT INTO `historial` SET 
                    `numero_tarjeta` = '{$codigo}',
                    `saldo` = '{$saldo}',
                    `fecha` = CONVERT_TZ( NOW( ) ,  '+02:00',  '-06:00' )
                ";
    $GLOBALS['Coneccion']->ejecutar($sSQL);
    }else{
  $resultado= $GLOBALS['Coneccion']->getOne("SELECT id_historial FROM `historial` WHERE `numero_tarjeta`='{$codigo}' and `saldo`='{$saldo}' and id_historial='{$ultimoid}' ORDER BY fecha DESC limit 1");
  if($resultado==0){
      $sSQL = "
                    INSERT INTO `historial` SET 
                    `numero_tarjeta` = '{$codigo}',
                    `saldo` = '{$saldo}',
                    `fecha` = CONVERT_TZ( NOW( ) ,  '+02:00',  '-06:00' )
                ";
    $GLOBALS['Coneccion']->ejecutar($sSQL);
    }
  }
        
}
function cron(){
  $sSQL = "
                    INSERT INTO `crontable` SET 
                    `fecha` = CONVERT_TZ( NOW( ) ,  '+02:00',  '-06:00' )
                ";
    $GLOBALS['Coneccion']->ejecutar($sSQL);
}
function contadorVisitas($codigo){
     $contador= $GLOBALS['Coneccion']->getOne("SELECT contador FROM `contador` WHERE `numero_tarjeta`='{$codigo}'");
     if($contador==null){
        $contador=0;
        $c= $contador + 1;
        $sSQL= "
                    INSERT INTO `contador` SET 
                    `numero_tarjeta` = '{$codigo}',
                    `contador` = '{$c}',
                    `fecha` = CONVERT_TZ( NOW( ) ,  '+02:00',  '-06:00' )
                ";
         $GLOBALS['Coneccion']->ejecutar($sSQL);   
     } else{
      $c= $contador + 1;
        $sSQL= "
                    UPDATE `contador` SET 
                    `contador` = '{$c}',
                    `fecha` = CONVERT_TZ( NOW( ) ,  '+02:00',  '-06:00' ) where `numero_tarjeta`='{$codigo}'
                ";
         $GLOBALS['Coneccion']->ejecutar($sSQL);
     }
    
}
 function consultar($codigo){
  $json= file_get_contents("https://mpeso.net/datos/captcha.php");
$js= json_decode($json,true);
$postdata = http_build_query(
    array(
        '_funcion' => "1",
        '_captcha' => $js["captcha"],
        '_terminal' => $codigo,
        '_codigo' => $js["captcha"]
    )
);
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded; charset=UTF-8',
        'content' => $postdata
    )
);
$context  = stream_context_create($opts);

$result = file_get_contents('https://mpeso.net/datos/consulta.php', false, $context);
$array= json_decode($result,true);
$tm=strlen($array["Mensaje"]);
$saldo= substr($array["Mensaje"],35,$tm-4);
$this->ingresar($codigo,$saldo);
 }
}
$GLOBALS['funciones'] = new funciones();
?>
<?php
/**
* 
*/
class funciones 
{
 
  function ingresar($codigo,$saldo){
  $ultimoid= $GLOBALS['Coneccion']->getOne("SELECT id_historial FROM `historial` WHERE `numero_tarjeta`='{$codigo}' and `saldo`='{$saldo}' ORDER BY id_historial DESC limit 1");
  if ($ultimoid==null) {
      $ultimoid=0;
       $sSQL = "
                    INSERT INTO `historial` SET 
                    `numero_tarjeta` = '{$codigo}',
                    `saldo` = '{$saldo}',
                    `fecha` = NOW()
                ";
    $GLOBALS['Coneccion']->ejecutar($sSQL);
    }else{
  $resultado= $GLOBALS['Coneccion']->getOne("SELECT id_historial FROM `historial` WHERE `numero_tarjeta`='{$codigo}' and `saldo`='{$saldo}' and id_historial='{$ultimoid}' ORDER BY fecha DESC limit 1");
  if($resultado==0){
      $sSQL = "
                    INSERT INTO `historial` SET 
                    `numero_tarjeta` = '{$codigo}',
                    `saldo` = '{$saldo}',
                    `fecha` = NOW()
                ";
    $GLOBALS['Coneccion']->ejecutar($sSQL);
    }
  }
        
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
                    `fecha` = NOW()
                ";
         $GLOBALS['Coneccion']->ejecutar($sSQL);   
     } else{
      $c= $contador + 1;
        $sSQL= "
                    UPDATE `contador` SET 
                    `contador` = '{$c}',
                    `fecha` = NOW() where `numero_tarjeta`='{$codigo}'
                ";
         $GLOBALS['Coneccion']->ejecutar($sSQL);
     }
    
}
}
$GLOBALS['funciones'] = new funciones();
?>
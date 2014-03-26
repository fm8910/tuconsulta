<?php 
require_once('clases/Coneccion.php');
require_once('clases/funciones.php');
$json= file_get_contents("https://mpeso.net/datos/captcha.php");
$js= json_decode($json,true);
$postdata = http_build_query(
    array(
        '_funcion' => "1",
        '_captcha' => $js["captcha"],
        '_terminal' => $_POST["codigo"],
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

$GLOBALS['funciones']->ingresar($_POST["codigo"],$saldo);
$GLOBALS['funciones']->contadorVisitas($_POST["codigo"]);

echo $array["Mensaje"] ;

 ?>
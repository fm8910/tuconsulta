<?php 

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
header('Content-Type: application/json');
echo $result;
 ?>
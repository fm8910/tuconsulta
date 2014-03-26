<?php 


class Coneccion{

	var $gDbNombre;
	var $gDbUsuario;
	var $gDbContra;
	var $vEnlace;
	

	 function Coneccion(){
		$this->gDbNombre="tuc_saldo";
		$this->gDbUsuario="root";
		$this->gDbContra="tda123";

		$this->vEnlace= mysql_connect("localhost", $this->gDbUsuario, $this->gDbContra);

		mysql_select_db($this->gDbNombre, $this->vEnlace);

        mysql_query("SET names UTF8");
	}
	function getOne($query, $index = 0) {
        if (! $query)
            return false;
        $res = mysql_query($query);
        $arr_res = array();
        if ($res && mysql_num_rows($res))
            $arr_res = mysql_fetch_array($res);
        if (count($arr_res))
            return $arr_res[$index];
        else
            return false;
    }
		 function existe($query) {
        if (! $query)
            return false;
        $resultado = mysql_query($query);
        if ($resultado)
            $arr_resultado = mysql_num_rows($resultado);
        if ($arr_resultado>0)
            return true;
        else
            return false;
    }
	  function ejecutar($query, $error_checking = true) {
        if(!$query)
            return false;
        $res = mysql_query($query, $this->vEnlace);
        if (!$res)
            $this->error('Error en la BD', false, $query);
        return $res;
    }
	function getnumero($query){
		$resultado = $this->ejecutar ($query);
        $arr_resultado = array();
        if($resultado && mysql_num_rows($resultado)) {
            $arr_resultado = mysql_fetch_array($resultado, MYSQL_ASSOC);
            mysql_free_result($resultado);
        }
        return $arr_resultado;
	}
	function lastId() {
        return mysql_insert_id($this->vEnlace);
    }
    
}
$GLOBALS['Coneccion'] = new Coneccion();

 ?>
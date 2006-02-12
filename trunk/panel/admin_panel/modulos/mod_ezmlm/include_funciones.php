<?php

function ezmlm_info(){
	$info["nombre"]="Ezmlm";
	$info["version"]="1.0";
	$info["grupo"]="servicios";

	return $info;
}

function ezmlm_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_ezmlm test...<br>";
	$test[1].= "==================<br>";
	if (!file_exists(_CFG_SUDO)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_SUDO."<br>";
		$test[0]=false;
	}

	if($test[0])
		$test[1].= "El módulo esta correctamente instalado<br>";
	return $test;
}

function ezmlm_list($dominio){
	$array_listas=Array();

	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	$result = execute_cmd("$exec_cmd $dominio");
	$x=0;
	for($i=0;$i<count($result);$i++)
	{
		if(strpos($result[$i],"ezmlm-reject")!==false){
			list($cuenta_origen, $cuenta_destino) =split(_CFG_VPOPMAIL_CFG_CUENTAALIAS, $result[$i], 2);
			$array_listas[$x]=trim($cuenta_origen);
			$x++;
		}
	}
	array_multisort($array_listas);

	return $array_listas;
}

function ezmlm_homedir($dominio){
	$array_listado=Array();

	$exec_cmd = _CFG_VPOPMAIL_INFODOMAIN;
	$result = execute_cmd("$exec_cmd  -a $dominio|"._CFG_CMD_GREP." -e "._CFG_VPOPMAIL_CFG_DIR." |"._CFG_CMD_CUT." -d\":\" -f2");
	return trim($result[0]);
}

?>
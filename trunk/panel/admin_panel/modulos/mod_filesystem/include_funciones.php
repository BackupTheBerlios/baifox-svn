<?php

function filesystem_info(){
	$info["nombre"]="Sistema ficheros";
	$info["version"]="1.0";
	$info["grupo"]="sistema";

	return $info;
}

function filesystem_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_filesystem test...<br>";
	$test[1].= "==================<br>";
	if($test[0])
		$test[1].= "El módulo esta correctamente instalado<br>";
	return $test;
}

function filesystem_listdirectories($dominio){
	$handle=GetDirArray(_CFG_APACHE_DOCUMENTROOT.$dominio);
	$array_modules= array();

 	while (list ($key, $file) = each ($handle)) { 
    	if ($file != "." && $file != "..") { 
		if(is_dir(_CFG_APACHE_DOCUMENTROOT.$dominio."/".$file)){
			$array_modules[]=$file;
		}
     	}
 	}
	return $array_modules;
}

function filesystem_htpasswdsave($dominio,$directorio,$usuario,$password){
	if($password!=""){
		$exec_cmd = _CFG_APACHE_HTPASSWD;
		$result = execute_cmd("$exec_cmd -b "._CFG_AWSTATS_PASSWD_FILE." $usuario $password");
		return $result;
	}else{
		return false;
	}
}

?>
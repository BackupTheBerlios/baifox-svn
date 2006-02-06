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
	$exec_cmd = _CFG_APACHE_HTPASSWD;
	if(file_exists(_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd"))
		$result = execute_cmd("$exec_cmd -b "._CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd"." $usuario $password");
	else{
		$result = execute_cmd("$exec_cmd -b -c "._CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd"." $usuario $password");
		$result = execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." "._CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd");
	}
	return $result;
}

function filesystem_htpasswdlist($dominio,$directorio){
	$array_modules= array();
	if(file_exists(_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd")){
		$lines=file(_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd"); 
 		foreach($lines as $line)
 		{
			list($ht_usuario, $ht_password) =split(":", $line, 2);
			$array_modules[]=$ht_usuario;
 		}
	}
	return $array_modules;
}

function filesystem_htpasswddelete($usuario,$dominio,$directorio){
 	$lines=file(_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd"); 
	$result = execute_cmd("chmod 777 "._CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd");
 	$fichero_nuevo=fopen(_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd","w");

 	foreach($lines as $line)
 	{
	      	if (stristr($line,$usuario)==false){
			fputs($fichero_nuevo,$line);
      		}
 	}
 	fclose($fichero_nuevo);
	$result = execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." "._CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd");
	$result = execute_cmd("chmod 644 "._CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd");
}

function filesystem_paginaserrorsave($dominio,$tipo){
	$directorio_error=_CFG_APACHE_DOCUMENTROOT.$dominio."/errorpages/";
	$result = execute_cmd("mkdir -f $directorio_error");
	$file_error=$directorio_error.$tipo.".html";
	$result = execute_cmd("touch $file_error");
	$result = execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $file_error");
	$result = execute_cmd("chmod 777 $file_error");


}

function filesystem_htaccesssave($dominio,$directorio,$cadena){
	$fichero_htaccess=_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htaccess";
	$result = execute_cmd("touch $fichero_htaccess");
	$result = execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $fichero_htaccess");
	$result = execute_cmd("chmod 777 $fichero_htaccess");
	$contenido="AuthName $cadena\n";
	$contenido.="AuthType Basic\n";
	$contenido.="AuthUserFile "._CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htpasswd\n";
	$contenido.="require valid-user\n";
 	$fichero_nuevo=fopen($fichero_htaccess,"w");
	fwrite($fichero_nuevo,$contenido);
	fclose($fichero_nuevo);
	$result = execute_cmd("chmod 644 $fichero_htaccess");
}

function filesystem_htaccessdelete($dominio,$directorio){
	$fichero_htaccess=_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htaccess";
	$result = execute_cmd("rm -f $fichero_htaccess");
}

function filesystem_htaccessread($dominio,$directorio,$flag){
	$fichero_htaccess=_CFG_APACHE_DOCUMENTROOT.$dominio."/".$directorio."/.htaccess";
	switch($flag){
        case "cadena":
		if(file_exists($fichero_htaccess)){
			$result = execute_cmd(_CFG_CMD_CAT." $fichero_htaccess");
			list($cadena_auth, $cadena) =split("AuthName", $result[0], 2);
		}else{
			$cadena="";
		}
		return trim($cadena);
	break;
        case "estado":
		if(file_exists($fichero_htaccess))
			return true;
		else
			return false;
	break;
	}
}

?>
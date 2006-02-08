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

function filesystem_paginaserrorsave($dominio,$contenido,$tipo){
	$directorio_error=_CFG_APACHE_DOCUMENTROOT.$dominio."/errorpages/";

	if($contenido!=""){
		$result = execute_cmd("mkdir $directorio_error");
		$file_error=$directorio_error.$tipo.".html";
		$result = execute_cmd("touch $file_error");
		$result = execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $file_error");
		$result = execute_cmd("chmod 777 $file_error");
	 	$fichero_nuevo=fopen($file_error,"w");
		fwrite($fichero_nuevo,$contenido);
		fclose($fichero_nuevo);
		$result = execute_cmd("chmod 644 $file_error");
		filesystem_paginaserrorhtaccess($dominio,$tipo,true);
	}else{
		if(file_exists($directorio_error.$tipo.".html"))
			$result = execute_cmd("rm ".$directorio_error.$tipo.".html");
		if(file_exists(_CFG_APACHE_DOCUMENTROOT.$dominio."/.htaccess"))
			filesystem_paginaserrorhtaccess($dominio,$tipo,false);
	}
}

function filesystem_paginaserrorread($dominio,$tipo){
	$file_htaccess=_CFG_APACHE_DOCUMENTROOT.$dominio."/errorpages/$tipo.html";
	if(file_exists($file_htaccess)){
		$contenido_array=file($file_htaccess);
		return implode("\n",$contenido_array);
	}else{
		return "";
	}
}

function filesystem_paginaserrorhtaccess($dominio,$tipo,$flag){
	$file_htaccess=_CFG_APACHE_DOCUMENTROOT.$dominio."/.htaccess";
	$result = execute_cmd("touch $file_htaccess");
	$result = execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $file_htaccess");
	$result = execute_cmd("chmod 777 $file_htaccess");
	$contenido="ErrorDocument $tipo /errorpages/$tipo.html\n";
 	$lines=file($file_htaccess);
 	$fichero_nuevo=fopen($file_htaccess,"w");
 	foreach($lines as $line)
 	{
	      	if (stristr($line,$contenido)==false){
			fputs($fichero_nuevo,$line);
      		}
 	}
	if($flag)
		fwrite($fichero_nuevo,$contenido);
	fclose($fichero_nuevo);
	$result = execute_cmd("chmod 644 $file_htaccessr");
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

function filesystem_backupdescargar($dominio,$flag){
	$fecha=date("d").date("m").date("Y");
	switch($flag){
	case "web":
		$file_nombre=_CFG_APACHE_DOCUMENTROOT.$dominio;
		$path=_CFG_FILESYSTEM_BACKUPDIR.$dominio."_web.zip";
		$download_name=$dominio."-".$fecha."_web.zip";
	break;
	case "basedatos":
		$file_nombre=_CFG_APACHE_DOCUMENTROOT.$dominio;
		$path=_CFG_FILESYSTEM_BACKUPDIR.$dominio."_basedatos.zip";
		$download_name=$dominio."-".$fecha."_basedatos.zip";
	break;
	}

	$datos = fopen($path, "r" ) ;
	if ($datos)
	{
		header("Content-Type: application/force-download");
 		header("Content-Type: application/octet-stream");
 		header("Content-Type: application/download");
 		header("Content-Disposition: attachment; filename=$download_name");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($path));
		$tamano=filesize($path)-1;
		header("Content-range: bytes 0-".filesize($path)."/".$tamano);
		while (!feof($datos))
		{
       			$buffer = fgets($datos, 4096);
			echo $buffer;
		}			
	}
	$result = execute_cmd("rm -f $path");
}

function filesystem_backupexiste($dominio,$flag){
	$path=_CFG_FILESYSTEM_BACKUPDIR.$dominio."_$flag.zip";
	if(file_exists($path)){
		return true;	
	}else{
		return false;
	}
}

function filesystem_backupcomprimir($dominio,$flag){
	$fecha=date("d").date("m").date("Y");
	switch($flag){
	case "web":
		$file_nombre=_CFG_APACHE_DOCUMENTROOT.$dominio;
		$path=_CFG_FILESYSTEM_BACKUPDIR.$dominio."_web.zip";
	break;
	case "basedatos":
		$file_nombre=_CFG_APACHE_DOCUMENTROOT.$dominio;
		$path=_CFG_FILESYSTEM_BACKUPDIR.$dominio."_basedatos.zip";
	break;
	}
	//Borramos antes por si hay una version anterior
	$result = execute_cmd("rm -f $path");

	if(file_exists($file_nombre)){
		$result = execute_cmd(_CFG_CMD_CAT." "._CFG_SUDO_PASSWORD);
		$SUDO_PASSWORD=$result[0];
		$exec_cmd = "zip -9 -r $path $file_nombre";
		$cmd=_CFG_SUDO." -S -u root $exec_cmd\n\n";

		$descriptorspec = array(
		0 => array("pipe", "r"), // stdin es en este caso la tubería que el programa invocado usará como entrada estándar
		1 => array("pipe", "w"), // stdout es la que usará como salida estándar
		2 => array("file","/dev/null", "w") // stderr es un archivo y en él que se grabarán los errores
		);
		$process = proc_open($cmd, $descriptorspec, $pipes); //en este ejemplo el programa invocado es el mismo php
		if (is_resource($process)) {
			// ahora $pipes contiene lo siguiente:
			// 0 => manejador (sólo escritura) conectado al stdin del programa invocado
			// 1 => manejador (sólo lectura) conectado al stdout del programa invocado
			// Se indicó que cualquier error sea deriva a null

			fwrite($pipes[0], $SUDO_PASSWORD); //código php que le enviamos al intérprete ejecutado
			fclose($pipes[0]); // cerramos la conexion para que el código enviado se ejecute

			while(!feof($pipes[1])) {
				echo fgets($pipes[1], 1024); // leemos lo que nos devuelve en tandas de 1K, hasta que llegue el EOF
				echo "<br>\n";
				flush();
			}
			fclose($pipes[1]);
			// Es importante cerrar todas las tuberías del array $pipes
			// antes de ejecutar proc_close de modo de evitar un deadlock
			$return_value = proc_close($process);
			if($return_value==0)
				return true;
			else
				return false;
		}
	}
}

?>
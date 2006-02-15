<?php

function awstats_info(){
	$info["nombre"]="Awstats";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="true";

	return $info;
}

function awstats_test(){
	$test= array();

	$test[0]=true;

	$test[1]="mod_awstats test...<br>";
	$test[1].="==================<br>";
	if (!file_exists(_CFG_AWSTATS_CONF)){
		$test[1].= "[ERROR] No se ha creado el directorio "._CFG_AWSTATS_CONF."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_AWSTATS_CONF)){
		$test[1].="[ERROR] No se puede escribir en el directorio "._CFG_AWSTATS_CONF."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_AWSTATS_CRON)){
		$test[1].= "[ERROR] No se ha creado el fichero "._CFG_AWSTATS_CRON."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_AWSTATS_CRON)){
		$test[1].="[ERROR] No se puede escribir en el fichero "._CFG_AWSTATS_CRON."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_AWSTATS_PASSWD_FILE)){
		$test[1].= "[ERROR] No se ha creado el fichero "._CFG_AWSTATS_PASSWD_FILE."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_AWSTATS_PASSWD_FILE)){
		$test[1].="[ERROR] No se puede escribir en el fichero "._CFG_AWSTATS_PASSWD_FILE."<br>";
		$test[0]=false;
	}

	if($test[0])
		$test[1].="El módulo esta correctamente instalado<br>";
	return $test;
}

function awstats_listdomains(){
$handle=GetDirArray(_CFG_AWSTATS_CONF); 
$array_modules= array();

 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	if(!is_dir(_CFG_AWSTATS_CONF.$file)){
		if(substr($file,-5)==".conf"){
			if(substr($file,strlen("awstats."),-5)!="")
				$array_modules[]=substr($file,strlen("awstats."),-5);
		}
	}
     }
 }
return $array_modules;
}

function awstats_htpasswdsave($dominio,$usuario_actual,$usuario_nuevo,$password){
	$b_nuevo=false;
	$lines=file(_CFG_AWSTATS_PASSWD_FILE); 
 	$fichero_nuevo=fopen(_CFG_AWSTATS_PASSWD_FILE,"w");
 	foreach($lines as $line)
 	{
		list($ht_usuario, $ht_password) =split(":", $line, 2);
      		if ($ht_usuario==$usuario_actual){
			if($usuario_nuevo!=$usuario_actual)
				$usuario=trim($usuario_nuevo);
			else
				$usuario=trim($usuario_actual);
			if($password!="")
				$password=encriptar(trim($password));
			else
				$password=trim($ht_password);
			$contenido="$usuario:$password\n";
			fputs($fichero_nuevo,$contenido);
			$b_nuevo=true;
      		}else{
			if(trim($line)!="")
				fputs($fichero_nuevo,$line);
		}
 	}
	if(!$b_nuevo){
		$password=encriptar($password);
		$contenido="$usuario_nuevo:$password\n";
		fputs($fichero_nuevo,$contenido);
	}
 	fclose($fichero_nuevo);
	
	return true;
}

function awstats_htpasswdsave_old($dominio,$usuario,$password){
	if($password!=""){
		$exec_cmd = _CFG_APACHE_HTPASSWD;
		$result = execute_cmd("$exec_cmd -b "._CFG_AWSTATS_PASSWD_FILE." $usuario $password");
		return $result;
	}else{
		return false;
	}
}

function awstats_cronsave($dominio){
	$filename=_CFG_AWSTATS_CRON;

	if (!$handle = fopen($filename, 'a')) {
      		echo "No se ha podido abrir el fichero ($filename)";
		return false;
        	exit;
   	}
	
	$contenido=_CFG_AWSTATS_BIN." -config=$dominio -update >/dev/null\n";

   	if (fwrite($handle, $contenido) === FALSE) {
       		echo "No se ha podido abrir el fichero ($filename)";
		return false;
		exit;
   	}
   	fclose($handle);
	return true;
}

function awstats_domaindel($dominio){
 //borrar linea del cron
 $lines=file(_CFG_AWSTATS_CRON); 
 $fichero_nuevo=fopen(_CFG_AWSTATS_CRON,"w");
 foreach($lines as $line)
 {
      if (stristr($line,$dominio)==false){
	fputs($fichero_nuevo,$line);
      }
 }
 fclose($fichero_nuevo);

 //borrar linea del htpasswd
 $usuario=awstats_usuariohtpasswd($dominio);

 $lines=file(_CFG_AWSTATS_PASSWD_FILE); 
 $fichero_nuevo=fopen(_CFG_AWSTATS_PASSWD_FILE,"w");

 foreach($lines as $line)
 {
      if (stristr($line,$usuario)==false){
	fputs($fichero_nuevo,$line);
      }
 }
 fclose($fichero_nuevo);

 //borrar fichero configuracion awstats
 if(file_exists(_CFG_AWSTATS_CONF."awstats.$dominio.conf"))
	@unlink(_CFG_AWSTATS_CONF."awstats.$dominio.conf");

  //Borra el directorio para los datos del awstats
 if(file_exists(_CFG_AWSTATS_DATADIR."$dominio")){
        $exec_cmd = "rm -f -R";
  	$result = execute_cmd("$exec_cmd "._CFG_AWSTATS_DATADIR."$dominio");
  }
}

function awstats_fileopen_conf($dominio){
	if(file_exists(_CFG_AWSTATS_CONF."awstats.$dominio.conf")) {
		return file_get_contents(_CFG_AWSTATS_CONF."awstats.$dominio.conf");
	}
	else{
		return "";
	}	
}

function awstats_usuariohtpasswd($dominio){
	if(file_exists(_CFG_AWSTATS_CONF."awstats.$dominio.conf")) {
		$lines=file(_CFG_AWSTATS_CONF."awstats.$dominio.conf");
 		foreach($lines as $line)
 		{
      			if (stristr($line,"AllowAccessFromWebToFollowingAuthenticatedUsers=")!=false){
				return trim(substr(trim($line),strlen("AllowAccessFromWebToFollowingAuthenticatedUsers=")+1, -1));
      			}
 		}
 	}
}

function awstats_filesave_conf($dominio,$usuario,$contenido){

$filename=_CFG_AWSTATS_CONF."awstats.$dominio.conf";

	if (!$handle = fopen($filename, 'w')) {
      		echo "No se ha podido abrir el fichero ($filename)";
		return false;
        	exit;
   	}
	//Si no le pasamos el fichero awstats lo generamos
	if($contenido==""){
		$contenido=awstats_generartemplate($dominio,$usuario);
	}else{
		$convertir=array();
		$convertir=explode("\n",$contenido);
		$contenido="";
		foreach($convertir as $line)
		{
  			if (stristr($line,"AllowAccessFromWebToFollowingAuthenticatedUsers=")!=false){
				$contenido.="AllowAccessFromWebToFollowingAuthenticatedUsers=\"$usuario\"\n";
      			}else{
				$contenido.="$line\n";
			}
	 	}
	}
	$contenido=stripslashes($contenido);
	$contenido = str_replace("\r", "", $contenido); 
	
   	if (fwrite($handle, $contenido) === FALSE) {
       		echo "No se ha podido abrir el fichero ($filename)";
		return false;
		exit;
   	}
   	fclose($handle);

	//Genera el directorio para los datos del awstats
	$exec_cmd = "mkdir";
	$result = execute_cmd("$exec_cmd "._CFG_AWSTATS_DATADIR."$dominio");
	$exec_cmd = "chown";
	$result = execute_cmd("$exec_cmd "._CFG_SUDO_USERNAME." "._CFG_AWSTATS_DATADIR."$dominio");

	return true;
}

function awstats_generartemplate($dominio,$usuario){
	//Generar conf 
	require_once _CFG_INTERFACE_FASTTEMPLATE;
	$tpl = new FastTemplate(_CFG_INTERFACE_PLANTILLAS);
	$tpl->define(array(main=> "awstats.tpl"));	
	$tpl->assign(APACHE_LOGS, _CFG_APACHE_LOGS);
	$tpl->assign(APACHE_STRING_AWSTATS, _CFG_LOGROTATE_CFG_AWSTATSTRING);
	$tpl->assign(AWSTATS_DATADIR, _CFG_AWSTATS_DATADIR);
	if($dominio!=""){
		$tpl->assign(DOMINIO, $dominio);
		$tpl->assign(AWSTATS_USUARIO, $usuario);
		$tpl->assign(DOMINIO_SIN, fnStripSLD($dominio));
		$tpl->assign(DOMINIO_EXT, fnStripTLD($dominio));
	}
	$tpl->parse(CONTENT, "main");
	$contenido=$tpl->fetch(CONTENT);
	return $contenido;
}

?>
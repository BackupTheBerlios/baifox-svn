<?php

function apache_info(){
	$info["nombre"]="Apache";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="true";

	return $info;
}

function apache_test(){
	$test= array();

	$test[0]=true;

	$test[1]="mod_apache test...<br>";
	$test[1].="==================<br>";
	if (!file_exists(_CFG_APACHE_CONF)){
		$test[1].="[ERROR] No se ha creado el directorio "._CFG_APACHE_CONF."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_APACHE_CONF)){
		$test[1].="[ERROR] No se puede escribir en el directorio "._CFG_APACHE_CONF."<br>";
		$test[0]=false;
	}
	if($test[0])
		$test[1].="El módulo esta correctamente instalado<br>";
	return $test;
}

function apache_version(){
	$exec_cmd = _CFG_APACHE_HTTPD;
	$result=execute_cmd("$exec_cmd -v");
	list($buffer,$version) = split(":",$result[0],2);
	return $version;
}

function apache_phpversion(){
$socket = fsockopen(_CFG_SERVER_IP, 80, $errno, $errstr, 3);
	if ($socket) {
   		$buffer = "GET / HTTP/1.0\r\n";
		$buffer .= "Connection: Close\r\n\r\n";
   		fwrite($socket, $buffer);
   		while (!feof($socket)) {
       			if(strstr(fgets($socket, 128),"PHP")!=FALSE){
				$version=strstr(fgets($socket, 128),"PHP");
				break;
			}
   		}
   		fclose($socket);
	}
	return $version;
}

function apache_listdomains(){
$handle=GetDirArray(_CFG_APACHE_CONF); 
$array_modules= array();

 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	if(!is_dir(_CFG_APACHE_CONF.$file)){
		if(substr($file,-5)=="_conf"){
			$dominio=trim(substr($file,0,-5));
			if ($dominio!="")
				if(substr_count($dominio, '.')<2)
					$array_modules[]=$dominio;
		}
	}
     }
 }
return $array_modules;
}

function apache_listsubdomains(){
$handle=GetDirArray(_CFG_APACHE_CONF); 
$array_modules= array();

 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	if(!is_dir(_CFG_APACHE_CONF.$file)){
		if(substr($file,-5)=="_conf"){
			$subdominio=trim(substr($file,0,-5));
			if ($subdominio!="")
				if(substr_count($subdominio, '.')>1)
					$array_modules[]=$subdominio;
		}
	}
     }
 }
return $array_modules;
}

function apache_subdomains($dominio){
$handle=GetDirArray(_CFG_APACHE_CONF); 
$array_modules= array();

$x=0;
 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	if(!is_dir(_CFG_APACHE_CONF.$file)){
		if(substr($file,-5)=="_conf"){
			if (strpos(trim($file),".".$dominio)!==false)
				if (trim(substr($file,-5))!=""){
					$subdominio=trim(substr($file,0,-5));
					$array_modules[$x]["dominio"]=$subdominio;
					$array_modules[$x]["directorio"]=substr($subdominio,0,strpos($subdominio,"."));
					$x++;
				}
		}
	}
     }
 }
return $array_modules;
}

function apache_generartemplate($dominio,$variables,$subdominio){
	//Generar conf apache
	require_once _CFG_INTERFACE_FASTTEMPLATE;
	$tpl = new FastTemplate(_CFG_INTERFACE_PLANTILLAS);
	if($subdominio){
		if($variables["APACHE_CGIBIN"]==1){
			$tpl->define(array(main=> "subapache-cgi.tpl"));
		}else{
			$tpl->define(array(main=> "subapache.tpl"));
		}
	}else{
		if($variables["APACHE_CGIBIN"]==1){
			$tpl->define(array(main=> "apache-cgi.tpl"));
		}else{
			$tpl->define(array(main=> "apache.tpl"));
		}
	}
	if($subdominio){
		$substrip=substr($dominio,0,strpos($dominio,".")+1);
		$domstrip=substr($dominio,strpos($dominio,".")+1);
		$tpl->assign(SUBDOMINIO, $substrip);
		$tpl->assign(DOMINIO, $domstrip);
		if($variables["APACHE_DOCUMENTROOT"]!=_CFG_APACHE_DESACTIVADO)
			$tpl->assign(APACHE_SUBDOCUMENTROOT, substr($variables["APACHE_DOCUMENTROOT"],0,-(strlen($substrip))));
		else
			$tpl->assign(APACHE_SUBDOCUMENTROOT, $variables["APACHE_DOCUMENTROOT"]);
	}else{
		$tpl->assign(DOMINIO, $dominio);
	}
	$tpl->assign(CFG_ESTADO, $variables["CFG_ESTADO"]);
	$tpl->assign(CFG_DOCUMENTROOT, $variables["CFG_DOCUMENTROOT"]);
	$tpl->assign(APACHE_ALIAS, $variables["APACHE_ALIAS"]);
	$tpl->assign(APACHE_INDEXES, $variables["APACHE_INDEXES"]);
	$tpl->assign(APACHE_MULTIVIEWS, $variables["APACHE_MULTIVIEWS"]);
	$tpl->assign(APACHE_DOCUMENTROOT, $variables["APACHE_DOCUMENTROOT"]);
	$tpl->assign(APACHE_LOGS, _CFG_APACHE_LOGS);
	$tpl->assign(APACHE_STRING_AWSTATS, _CFG_LOGROTATE_CFG_AWSTATSTRING);
	$tpl->assign(PHP_REGISTERGLOBAL, $variables["PHP_REGISTERGLOBAL"]);
	$tpl->assign(PHP_SAFEMODE, $variables["PHP_SAFEMODE"]);
	$tpl->assign(PHP_UPLOAD, $variables["PHP_UPLOAD"]);
	$tpl->assign(SERVER_NAME, _CFG_SERVER_NAME);

	$tpl->parse(CONTENT, "main");
	$contenido=$tpl->fetch(CONTENT);
	//Escribiendo fichero de configuración de apache
	$filename=_CFG_APACHE_CONF.$dominio."_conf";
   	if (!$handle = fopen($filename, 'w')) {
         	echo "No se ha podido abrir el fichero ($filename)";
		return false;
        	exit;
   	}	
   	if (fwrite($handle, $contenido) === FALSE) {
       		echo "No se ha podido abrir el fichero ($filename)";
		return false;
       		exit;
	}
	fclose($handle);
	return true;
	//Fin configuración apache
}

function apache_domaindel($dominio){
$filename=_CFG_APACHE_CONF.$dominio."_conf";
	if(file_exists($filename)){
		@unlink ($filename);
	}
}

function apache_domainread($dominio){
$variables=array();

	if(file_exists(_CFG_APACHE_CONF.$dominio."_conf")) {
		$lineas=file(_CFG_APACHE_CONF.$dominio."_conf");
		foreach ($lineas as $value) {
   			if(stristr ($value,"CFG_ESTADO")!=false)
				$variables["CFG_ESTADO"]=trim(substr($value,-2));
   			if(stristr ($value,"CFG_DOCUMENTROOT")!=false)
				$variables["CFG_DOCUMENTROOT"]=trim(substr($value,strlen("# CFG_DOCUMENTROOT=")));
   			if(stristr ($value,"register_globals")!=false)
				$variables["PHP_REGISTERGLOBAL"]=trim(substr($value,stripos($value,"register_globals")+strlen("register_globals")));
   			if(stristr ($value,"safe_mode")!=false)
				$variables["PHP_SAFEMODE"]=trim(substr($value,stripos($value,"safe_mode")+strlen("safe_mode")));
   			if(stristr ($value,"file_uploads")!=false)
				$variables["PHP_UPLOAD"]=trim(substr($value,stripos($value,"file_uploads")+strlen("file_uploads")));
   			if(stristr ($value,"MultiViews")!=false)
				$variables["APACHE_MULTIVIEWS"]="MultiViews";
   			if(stristr ($value,"ScriptAlias")!=false)
				$variables["APACHE_CGIBIN"]=1;
   			if(stristr ($value,"Indexes")!=false)
				$variables["APACHE_INDEXES"]="Indexes";
   			if(stristr ($value,"DocumentRoot")!=false)
				$variables["APACHE_DOCUMENTROOT"]=trim(substr($value,strlen("DocumentRoot")+1));
   			if(stristr ($value,"ServerAlias")!=false)
				$variables["APACHE_ALIAS"]=trim(substr($value,strlen("ServerAlias")+1));
		}
	}
return $variables;
}

function apache_domainonoff($dominio,$estado,$subdominio){
	$variables=apache_domainread($dominio);
	if($estado==1){
		$variables["APACHE_DOCUMENTROOT"]=$variables["CFG_DOCUMENTROOT"];
		$variables["CFG_ESTADO"]=1;
	}else{
		$variables["APACHE_DOCUMENTROOT"]=_CFG_APACHE_DESACTIVADO;
		$variables["CFG_ESTADO"]=0;
	}
	apache_generartemplate($dominio,$variables,$subdominio);
}

function apache_control($accion){
	$exec_cmd = _CFG_APACHE_APACHECTL;
	$result = execute_cmd("$exec_cmd $accion");
	return $result;
}

function apache_descargarlog($dominio,$flag){
	switch($flag){
	case "hoy":
		$fecha=date("d").date("m").date("Y");
		$file_nombre=$dominio._CFG_LOGROTATE_CFG_AWSTATSTRING;
	break;
	case "ayer":
		$dia_anterior=DateAdd("d", -1, mktime(0,0,0,date("m"),date("d"),date("Y")));
		$fecha=date("d",$dia_anterior).date("m",$dia_anterior).date("Y",$dia_anterior);
		$file_nombre=$dominio._CFG_LOGROTATE_CFG_AWSTATSTRING.".1";
	break;
	}

	if(file_exists(_CFG_APACHE_LOGS.$file_nombre)){
		$exec_cmd = "gzip";
		$path="/tmp/$file_nombre.gz";
		$result = execute_cmd("$exec_cmd -9 -c "._CFG_APACHE_LOGS."$file_nombre >$path");
		$datos = fopen($path, "r" ) ;
		if ($datos)
  		{
			$download_name=$dominio."-".$fecha.".gz";
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
		$result = execute_cmd("rm -f /tmp/$file_nombre.gz");
	}
}

?>

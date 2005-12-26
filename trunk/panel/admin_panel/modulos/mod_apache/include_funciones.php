<?php

function apache_info(){
	$info["nombre"]="Apache";
	$info["version"]="1.0";
	$info["grupo"]="servicios";

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
	$exec_cmd = "HTTP/1.0 200 OK";
	$result=execute_cmd("$exec_cmd -v");
	list($buffer,$version) = split(":",$result[0],2);
	return $version;
}

function apache_listdomains(){
$handle=GetDirArray(_CFG_APACHE_CONF); 
$array_modules= array();

 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	if(!is_dir(_CFG_APACHE_CONF.$file)){
		if(substr($file,-5)=="_conf"){
			if (trim(substr($file,-5))!="")
				$array_modules[]=substr($file,0,-5);
		}
	}
     }
 }
return $array_modules;
}

function apache_generartemplate($domain,$variables){
	//Generar conf apache
	require_once _CFG_INTERFACE_FASTTEMPLATE;
	$tpl = new FastTemplate(_CFG_INTERFACE_PLANTILLAS);
	if($variables["APACHE_CGIBIN"]==1){
		$tpl->define(array(main=> "apache-cgi.tpl"));
	}else{
		$tpl->define(array(main=> "apache.tpl"));
	}
	$tpl->assign(DOMINIO, $domain);
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
	$filename=_CFG_APACHE_CONF.$domain."_conf";
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

function apache_domaindel($domain){
$filename=_CFG_APACHE_CONF.$domain."_conf";
	if(file_exists($filename)){
		@unlink ($filename);
	}
}

function apache_domainread($domain){
$variables=array();

	if(file_exists(_CFG_APACHE_CONF.$domain."_conf")) {
		$lineas=file(_CFG_APACHE_CONF.$domain."_conf");
		foreach ($lineas as $value) {
   			if(stristr ($value,"CFG_ESTADO")!=false)
				$variables["CFG_ESTADO"]=trim(substr($value,-2));
   			if(stristr ($value,"CFG_DOCUMENTROOT")!=false)
				$variables["CFG_DOCUMENTROOT"]=trim(substr($value,strlen("# CFG_DOCUMENTROOT=")));;
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
				$variables["APACHE_DOCUMENTROOT"]=trim(substr($value,strlen("DocumentRoot")+1));;
   			if(stristr ($value,"ServerAlias")!=false)
				$variables["APACHE_ALIAS"]=trim(substr($value,strlen("ServerAlias *.$domain $domain")+1));;
		}
	}
return $variables;
}

function apache_domainonoff($domain,$estado){
	$variables=apache_domainread($domain);
	if($estado==1){
		$variables["APACHE_DOCUMENTROOT"]=$variables["CFG_DOCUMENTROOT"];
		$variables["CFG_ESTADO"]=1;
	}else{
		$variables["APACHE_DOCUMENTROOT"]=_CFG_APACHE_DESACTIVADO;
		$variables["CFG_ESTADO"]=0;
	}
	apache_generartemplate($domain,$variables);
}

function apache_control($accion){
	$exec_cmd = _CFG_APACHE_APACHECTL;
	$result = execute_cmd("$exec_cmd $accion");
	return $result;
}
?>

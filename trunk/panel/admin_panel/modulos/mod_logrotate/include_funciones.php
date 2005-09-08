<?php

function logrotate_info(){
	$info["nombre"]="Logrotate";
	$info["version"]="1.0";
	$info["grupo"]="servicios";

	return $info;
}

function logrotate_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_logrotate test...<br>";
	$test[1].= "==================<br>";
	if (!file_exists(_CFG_LOGROTATE_CFG_FILE)){
		$test[1].= "[ERROR] No se ha creado el fichero "._CFG_LOGROTATE_CFG_FILE."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_LOGROTATE_CFG_FILE)){
		$test[1].="[ERROR] No se puede escribir en el fichero "._CFG_LOGROTATE_CFG_FILE."<br>";
		$test[0]=false;
	}
	if($test[0])
		$test[1].= "El módulo esta correctamente instalado<br>";
	return $test;
}

function logrotate_listdomains(){
	$array_listado=Array();
	$lines = file(_CFG_LOGROTATE_CFG_FILE);

	$i=0;
	foreach ($lines as $line) {
   		if(strstr($line,_CFG_APACHE_LOGS)){
   			$linea_log=trim($line);
			$pos_ini=strlen(_CFG_APACHE_LOGS);
			$pos_fin=strpos($linea_log,_CFG_LOGROTATE_CFG_AWSTATSTRING,$pos_ini);
			$value=substr($linea_log, $pos_ini,$pos_fin-strlen($linea_log));
			$array_listado[$i]= $value;
			$i++;
   		}
	}
	sort($array_listado);
	return $array_listado;
}

function logrotate_domainsave($domain){
	$filename=_CFG_LOGROTATE_CFG_FILE;

	if (!$handle = fopen($filename, 'a')) {
      		echo "No se ha podido abrir el fichero ($filename)";
		return false;
        	exit;
   	}
	
	$contenido=_CFG_APACHE_LOGS."$domain"._CFG_LOGROTATE_CFG_AWSTATSTRING." {\n";
	$contenido.="        rotate 1 \n";
	$contenido.="        daily \n";
	$contenido.="        missingok \n";
	$contenido.="        postrotate \n";
	$contenido.="        /usr/bin/killall -HUP "._CFG_APACHE_HTTPD." \n";
	$contenido.="        endscript \n";
	$contenido.="} \n";

   	if (fwrite($handle, $contenido) === FALSE) {
       		echo "No se ha podido abrir el fichero ($filename)";
		return false;
		exit;
   	}
   	fclose($handle);
	return true;
}

function logrotate_domaindel($domain){
 $lines=file(_CFG_LOGROTATE_CFG_FILE);
 $seccion=false; 

$fichero_nuevo=fopen(_CFG_LOGROTATE_CFG_FILE,"w");
 foreach($lines as $line)
 {
      if (strstr($line,$domain)){
	$seccion=true;
      }
      if($seccion){
	if(strstr(trim($line),"}"))
		$seccion=false;
      }else{
            fputs($fichero_nuevo,$line);
      }
 }
 fclose($fichero_nuevo);
}

?>
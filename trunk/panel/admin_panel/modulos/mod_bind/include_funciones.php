<?php

function bind_info(){
	$info["nombre"]="Bind";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="true";

	return $info;
}

function bind_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_bind test...<br>";
	$test[1].= "==================<br>";
	if (!file_exists(_CFG_BIND_CFG_FILE)){
		$test[1].= "[ERROR] No se ha creado el fichero "._CFG_BIND_CFG_FILE."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_BIND_CFG_FILE)){
		$test[1].= "[ERROR] No se puede escribir en el fichero "._CFG_BIND_CFG_FILE."<br>";
		$test[0]=false;
	}
	if (!file_exists(_CFG_BIND_CFG_HOSTS)){
		$test[1].= "[ERROR] No se ha creado el directorio "._CFG_BIND_CFG_HOSTS."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_BIND_CFG_HOSTS)){
		$test[1].= "[ERROR] No se puede escribir en el directorio "._CFG_BIND_CFG_HOSTS."<br>";
		$test[0]=false;
	}

	if($test[0])
		$test[1].= "El módulo esta correctamente instalado<br>";
	return $test;
}

function bind_listdomains(){
	$array_listado=Array();
	$lines = file(_CFG_BIND_CFG_FILE);

	$i=0;
	foreach ($lines as $line_num => $line) {
   		$cadena=str_word_count($line,1);
	   	if($cadena[0]=="zone"){
		   	$linea_zona=trim($line);
			$pos_ini=strpos($linea_zona, '"');
			$pos_fin=strpos($linea_zona, '"',$pos_ini+1);
			$zona=substr($linea_zona, $pos_ini+1,$pos_fin-strlen($linea_zona));
			if(!word_exist($zona,_CFG_BIND_IGNORE_FILE)){
				$array_listado[$i]=trim($zona);
				$i++;
			}
   		}
   		if($cadena[0]=="file"){
   			$linea_fichero=trim($line);
			$pos=strpos($linea_fichero, '"');
			$fichero=trim(substr($linea_fichero, $pos+1,-2));
   		}
	}
	sort($array_listado);
	return $array_listado;
}

function bind_domainsave($dominio){
	$filename=_CFG_BIND_CFG_FILE;

	if (!$handle = fopen($filename, 'a')) {
      		echo "No se ha podido abrir el fichero ($filename)";
		return false;
        	exit;
   	}
	
	$contenido="zone \"$dominio\" { \n";
	$contenido.="       type master;\n";
	$contenido.="       file \""._CFG_BIND_CFG_HOSTS."$dominio.hosts\";\n";
	$contenido.="};\n";

   	if (fwrite($handle, $contenido) === FALSE) {
       		echo "No se ha podido abrir el fichero ($filename)";
		return false;
		exit;
   	}
   	fclose($handle);
	return true;
}


function bind_domaindel($dominio){
 $lines=file(_CFG_BIND_CFG_FILE);
 $seccion=false; 

$fichero_nuevo=fopen(_CFG_BIND_CFG_FILE,"w");
 foreach($lines as $line)
 {
      if (strstr($line,$dominio)){
	$seccion=true;
      }
      if($seccion){
	if(strstr(trim($line),"};"))
		$seccion=false;
      }else{
            fputs($fichero_nuevo,$line);
      }
 }
 fclose($fichero_nuevo);

  if(file_exists(_CFG_BIND_CFG_HOSTS."$dominio.hosts")) {
	@unlink(_CFG_BIND_CFG_HOSTS."$dominio.hosts");
  }
}

function bind_fileopen_hosts($dominio){
	if(file_exists(_CFG_BIND_CFG_HOSTS."$dominio.hosts")) {
		return file_get_contents(_CFG_BIND_CFG_HOSTS."$dominio.hosts");
	}
	else{
		return "";
	}	
}

function bind_filesave_hosts($dominio,$contenido){

$filename=_CFG_BIND_CFG_HOSTS."$dominio.hosts";

	if (!$handle = fopen($filename, 'w')) {
      		echo "No se ha podido abrir el fichero ($filename)";
		return false;
        	exit;
   	}

	//Si no le pasamos el fichero awstats lo generamos
	if($contenido==""){
		$contenido=bind_generartemplate($dominio);
	}
	$contenido = str_replace("\r", "", $contenido); 
	
   	if (fwrite($handle, $contenido) === FALSE) {
       		echo "No se ha podido abrir el fichero ($filename)";
		return false;
		exit;
   	}
   	fclose($handle);
	return true;
}

function bind_generartemplate($dominio){
	//Generar conf apache
	require_once _CFG_INTERFACE_FASTTEMPLATE;
	$tpl = new FastTemplate(_CFG_INTERFACE_PLANTILLAS);
	$tpl->define(array(main=> "bind.tpl"));	
	$tpl->assign(SERVER_NAME, _CFG_SERVER_NAME);
	$tpl->assign(SERVER_NS, _CFG_SERVER_NS);
	$tpl->assign(SERVER_IP, _CFG_SERVER_IP);
	if($dominio!=""){
		$tpl->assign(DOMINIO, $dominio);
	}
	$tpl->parse(CONTENT, "main");
	$contenido=$tpl->fetch(CONTENT);
	return $contenido;
	//Fin configuración apache
}

function bind_control($accion){
	$exec_cmd = _CFG_BIND_BINDCTL;
	$result = execute_cmd("$exec_cmd $accion");
	return $result;
}

?>
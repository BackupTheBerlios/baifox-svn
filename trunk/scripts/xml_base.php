#!/usr/local/bin/php
<?php 
     include "/usr/local/baifox/panel/admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
     require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
     define(MYSQLDIR,"/var/lib/mysql/");

function xmlbase_add($dbase){

	//Crea la configuracion en el XML
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_BASEDATOS,a);

	$NEW_ID=xmlconfig_generaid(_CFG_XML_BASEDATOS);
	$conf->setConfigValue($NEW_ID, array(
		 "ID" 	  => $NEW_ID,
		 "DOMINIO" => "",
		 "DATABASE"=> $dbase,
		 "USUARIO" => $dbase,
		 "PASSWORD" => "",
		 "ESTADO" => 1)
	, "array");
	$conf->writeConfigFile(_CFG_XML_BASEDATOS, "xml", array( "mode" => "pretty" ) );
	//Fin fichero configuracion XML
}

$handle=GetDirArray(MYSQLDIR);

 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	echo "\nBase de datos encontrada: $file"; 
	if(is_dir(MYSQLDIR.$file)){
		echo "\nAñadiendo base de datos: $file";
		xmlbase_add($file);
	}
     }
 }


?>
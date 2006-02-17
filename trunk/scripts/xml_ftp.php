#!/usr/local/bin/php
<?php 
     include "/usr/local/baifox/panel/admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
     require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";

function xmlbase_add($dominio,$usuario,$homedir,$tipo){

	//Crea la configuracion en el XML
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_FTP,a);
	$NEW_ID=xmlconfig_generaid(_CFG_XML_FTP);
	$conf->setConfigValue($NEW_ID, array(
	 	"ID" 	  => $NEW_ID,
	 	"DOMINIO" => $dominio,
	 	"HOMEDIR"=> $homedir,
	 	"USUARIO" => $usuario, 
	 	"PASSWORD" => "",
		"TIPO" => $tipo)
	, "array");
	$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
	//Fin fichero configuracion XML
}

   $link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
   mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);

   $result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." order by dominio",$link);

   while($rs = mysql_fetch_array($result)) {
		echo "\nCuenta FTP encontrada: ".$rs["dominio"]; 
		xmlbase_add($rs["dominio"],$rs["usuario"],$rs["homedir"],$rs["tipo"]);
     }
   @mysql_close($link);

?>
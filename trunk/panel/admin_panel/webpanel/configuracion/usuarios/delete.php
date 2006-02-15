<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
 	require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";

    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_USUARIOS,a);
	$conf->clearConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_USUARIOS)); 
	$conf->writeConfigFile(_CFG_XML_USUARIOS, "xml", array( "mode" => "pretty" ) );
	
	header ("Location: ../../../index.php?grupo=configuracion&seccion=usuarios&pag=index\n\n");
	exit();	
?>

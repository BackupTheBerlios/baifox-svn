<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_XML_PATCONFIG;
    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_CLIENTES,a);
	$conf->clearConfigValue($_GET['id']); 
	$conf->writeConfigFile(_CFG_XML_CLIENTES, "xml", array( "mode" => "pretty" ) );
	
	header ("Location: ../../../index.php?grupo=gestion&seccion=clientes&pag=index\n\n");
	exit();	
?>

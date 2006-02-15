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
	
	$datos=$conf->getConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_USUARIOS));
	
	if ($_GET['estado']==1){
		$datos["ESTADO"]=0;
  	}else{
		$datos["ESTADO"]=1;
  	}
	$conf->setConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_USUARIOS), $datos, "array");
	$conf->writeConfigFile(_CFG_XML_USUARIOS, "xml", array( "mode" => "pretty" ) );
		
	header ("Location: ../../../index.php?grupo=configuracion&seccion=usuarios&pag=index\n\n");
	exit();	
?>


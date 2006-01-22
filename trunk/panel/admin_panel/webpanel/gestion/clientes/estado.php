<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_CLIENTES,a);
	
	$datos=$conf->getConfigValue(busca_xml_id($_GET['id'],_CFG_XML_CLIENTES));
	
	if ($_GET['estado']==1){
		$datos["ESTADO"]=0;
  	}else{
		$datos["ESTADO"]=1;
  	}
	$conf->setConfigValue(busca_xml_id($_GET['id'],_CFG_XML_CLIENTES), $datos, "array");
	$conf->writeConfigFile(_CFG_XML_CLIENTES, "xml", array( "mode" => "pretty" ) );
		
	header ("Location: ../../../index.php?grupo=gestion&seccion=clientes&pag=index\n\n");
	exit();	
?>


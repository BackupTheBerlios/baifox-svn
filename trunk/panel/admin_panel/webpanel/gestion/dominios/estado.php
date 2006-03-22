<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	//Carga todos los modulos
	$modulos_instalados=modules_array(_CFG_INTERFACE_DIRMODULES);
	foreach ($modulos_instalados as $modulo) { 
		require _CFG_INTERFACE_DIRMODULES."mod_".$modulo."/include_funciones.php"; 
	}

	//Crea copia seguridad antes de modificar
	xmlconfig_backup(_CFG_XML_DOMINIOS);

    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS,a);

	
	$datos=$conf->getConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_DOMINIOS));
	
	if ($_GET['estado']==1){
		apache_domainonoff($datos['DOMINIO'],0);
		pureftpd_domainonoffall($datos['DOMINIO'],0);
		vpopmail_domainonoff($datos['DOMINIO'],0);
		$datos["ESTADO"]=0;
  	}else{
		apache_domainonoff($datos['DOMINIO'],1);
		pureftpd_domainonoffall($datos['DOMINIO'],1);
		vpopmail_domainonoff($datos['DOMINIO'],1);
		$datos["ESTADO"]=1;
  	}
	$conf->setConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_DOMINIOS), $datos, "array");
	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );
	
	header ("Location: ../../../index.php?grupo=gestion&seccion=dominios&pag=index\n\n");
	exit();	
?>


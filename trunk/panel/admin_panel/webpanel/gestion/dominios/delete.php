<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_XML_PATCONFIG;

	//Carga todos los modulos
	$modulos_instalados=modules_array(_CFG_INTERFACE_DIRMODULES);
	foreach ($modulos_instalados as $modulo) { 
		require _CFG_INTERFACE_DIRMODULES."mod_".$modulo."/include_funciones.php"; 
	}

    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS,a);

	$datos=$conf->getConfigValue($_GET['id']);

	if (function_exists("apache_info")){
		apache_domaindel($datos['DOMINIO']);
	}
	if (function_exists("awstats_info")){
		awstats_domaindel($datos['DOMINIO']);
	}
	if (function_exists("bind_info")){
		bind_domaindel($datos['DOMINIO']);
	}
	if (function_exists("mysql_info")){
		db_mysql_dbasedel($datos['BASE']);
	}
	if (function_exists("logrotate_info")){
		logrotate_domaindel($datos['DOMINIO']);
	}
	if (function_exists("pureftpd_info")){
		pureftpd_domaindel($datos['IDFTP']);
	}
	if (function_exists("vpopmail_info")){
		vpopmail_domaindel($datos['DOMINIO']);
	}

	$conf->clearConfigValue($_GET['id']); 
	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );
	
	header ("Location: ../../../index.php?grupo=gestion&seccion=dominios&pag=index\n\n");
	exit();	
?>

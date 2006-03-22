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
	if($_POST['borrar']=="true"){
		if (function_exists("apache_info")){
			if($datos['DOMINIO']!=""){
				apache_domaindel($datos['DOMINIO']);
			}
		}
		if (function_exists("awstats_info")){
			if($datos['DOMINIO']!=""){
				awstats_domaindel($datos['DOMINIO']);
			}
		}
		if (function_exists("bind_info")){
			if($datos['DOMINIO']!=""){
				bind_domaindel($datos['DOMINIO']);
			}
		}
		if (function_exists("mysql_info")){
			if($datos['DOMINIO']!=""){
				db_mysql_dbasedelall($datos['DOMINIO']);
			}
		}
		if (function_exists("logrotate_info")){
			if($datos['DOMINIO']!=""){
				logrotate_domaindel($datos['DOMINIO']);
			}
		}
		if (function_exists("pureftpd_info")){
			if($datos['DOMINIO']!=""){
				pureftpd_domaindelall($datos['DOMINIO'],true);
			}
		}
		if (function_exists("vpopmail_info")){
			if($datos['DOMINIO']!=""){
				vpopmail_domaindel($datos['DOMINIO']);
			}
		}
	}

	$conf->clearConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_DOMINIOS)); 
	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );
	
	header ("Location: ../../../index.php?grupo=gestion&seccion=dominios&pag=index\n\n");
	exit();	
?>

<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_awstats/include_funciones.php";
require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
?>
<?php
$mDominio=trim($_POST['frmDominio']);
$mContenido=$_POST['frmContenido'];
$mUsuario=trim($_POST['frmUsuario']);
$mPassword=trim($_POST['frmPassword']);

	//Modificar el password en el fichero xml
    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS,a);
	$posicion=xmlconfig_buscar(_CFG_XML_DOMINIOS,"DOMINIO",$mDominio,"","","posicion");
	$datos=$conf->getConfigValue($posicion);
	$datos["PASSWORD"]=md5_encrypt(trim($_POST['frmPassword']),_CFG_INTERFACE_BLOWFISH);
	$conf->setConfigValue($posicion, $datos, "array");
	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );

	if ($_GET['id']!= 0 ){
		$mUsuario_Antiguo=awstats_usuariohtpasswd($mDominio);
		awstats_htpasswdsave($mDominio,$mUsuario_Antiguo,$mUsuario,$mPassword);
		awstats_filesave_conf($mDominio,$mUsuario,$mContenido);
	}else{
		awstats_htpasswdsave($mDominio,$mUsuario,$mUsuario,$mPassword);
		awstats_cronsave($mDominio);
		awstats_filesave_conf($mDominio,$mUsuario,$mContenido);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=awstats&pag=index\n\n");
	exit();
 ?>
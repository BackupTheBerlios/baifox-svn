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

$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_DOMINIOS,a);
?>
<?php

  $mIDCliente=trim($_POST['frmIDCliente']);
  $mDominio=trim($_POST['frmDominio']);
  $mBase=trim($_POST['frmBase']);
  $mUsuario=trim($_POST['frmUsuario']);
  $mPassword=trim($_POST['frmPassword']);
  $mCuentas=trim($_POST['frmCuentas']);
  $mRedirecciones=trim($_POST['frmRedirecciones']);
  $mAlias=trim($_POST['frmAlias']);
  $mAutoRespuesta=trim($_POST['frmAutoRespuesta']);
  $mLista=trim($_POST['frmLista']);
  $mQuotaCORREO=trim($_POST['frmQuotaCORREO']);
  $mIDFTP=trim($_POST['frmIDFTP']);
  $mQuotaFTP=trim($_POST['frmQuotaFTP']);
  $mEstado=$_POST['frmEstado'];
  
	if ($_GET['id']!= 0 ){
		$conf->setConfigValue($_GET['id'], array(
					 "ID" 	  => $_GET['id'],
					 "IDCLIENTE" => $mIDCliente,
 					 "DOMINIO"  => $mDominio, 
 					 "BASE"  => $mBase, 
 					 "USUARIO"  => $mUsuario, 
 					 "PASSWORD"  => $mPassword,
 					 "CUENTAS"  => $mCuentas, 
 					 "REDIRECCIONES"  => $mRedirecciones, 
 					 "ALIAS"  => $mAlias, 
 					 "AUTORESPUESTA"  => $mAutoRespuesta, 
					 "LISTA" => $mLista,
					 "QUOTACORREO" => $mQuotaCORREO,
					 "IDFTP" => $mIDFTP,
					 "QUOTAFTP" => $mQuotaFTP,
					 "ESTADO" => $mEstado)
			 	, "array");

        	if (function_exists("awstats_info")){
			$mUsuario_Antiguo=awstats_usuariohtpasswd($mDominio);
			awstats_htpasswdsave($mDominio,$mUsuario_Antiguo,$mUsuario,$mPassword);
			awstats_filesave_conf($mDominio,$mUsuario,$mContenido);
        	}
        	if (function_exists("mysql_info")){
			db_mysql_password($mBase,$mPassword);
	        }
	        if (function_exists("pureftpd_info")){
			pureftpd_crear($mDominio,$mUsuario,$mPassword,_CFG_APACHE_DOCUMENTROOT.$mDominio,$mQuotaFTP,$mEstado,$mIDFTP);
        	}
        	if (function_exists("vpopmail_info")){
			vpopmail_userpasswd("postmaster",$mDominio,$mPassword);
			vpopmail_domainquota($mDominio,$mQuota);
			vpopmail_domainconf($mDominio,"cuentas",$mCuentas);
			vpopmail_domainconf($mDominio,"alias",$mAlias);
			vpopmail_domainconf($mDominio,"redirecciones",$mRedirecciones);
			vpopmail_domainconf($mDominio,"autorespuesta",$mAutoRespuesta);
			vpopmail_domainconf($mDominio,"listas",$mLista);
			vpopmail_domainconf($mDominio,"quota",$mQuotaCORREO);
        	} 
	}else{
		$NEW_ID=obtiene_xml_id(_CFG_XML_DOMINIOS);
		$conf->setConfigValue($NEW_ID, array(
					 "ID" 	  => $NEW_ID,
					 "IDCLIENTE" => $mIDCliente,
 					 "DOMINIO"  => $mDominio, 
 					 "BASE"  => $mBase, 
 					 "USUARIO"  => $mUsuario, 
 					 "PASSWORD"  => $mPassword,
 					 "CUENTAS"  => $mCuentas, 
 					 "REDIRECCIONES"  => $mRedirecciones, 
 					 "ALIAS"  => $mAlias, 
 					 "AUTORESPUESTA"  => $mAutoRespuesta, 
					 "LISTA" => $mLista,
					 "QUOTACORREO" => $mQuotaCORREO,
					 "IDFTP" => 0,
					 "QUOTAFTP" => $mQuotaFTP,
					 "ESTADO" => $mEstado)
			 	, "array");
	}
	
	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );

	header ("Location: ../../../index.php?grupo=gestion&seccion=dominios&pag=index\n\n");
	exit();
 ?>
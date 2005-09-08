<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_vpopmail/include_funciones.php";
?>
<?php
$mDominio=trim($_POST['frmDominio']);
$mPassword=trim($_POST['frmPassword']);
$mCuentas=trim($_POST['frmCuentas']); 
$mRedirecciones=trim($_POST['frmRedirecciones']); 
$mAlias=trim($_POST['frmAlias']);
$mAutoRespuesta=trim($_POST['frmAutoRespuesta']);
$mLista=trim($_POST['frmLista']);
$mQuota=trim($_POST['frmQuota']);

	if ($_GET['id']!= 0 ){
		vpopmail_userpasswd("postmaster",$mDominio,$mPassword);
		vpopmail_domainquota($mDominio,$mQuota);
		vpopmail_domainconf($mDominio,"cuentas",$mCuentas);
		vpopmail_domainconf($mDominio,"alias",$mAlias);
		vpopmail_domainconf($mDominio,"redirecciones",$mRedirecciones);
		vpopmail_domainconf($mDominio,"autorespuesta",$mAutoRespuesta);
		vpopmail_domainconf($mDominio,"listas",$mLista);
		vpopmail_domainconf($mDominio,"quota",$mQuota);
	}else{
		vpopmail_domainadd($mDominio,$mPassword);
		vpopmail_domainquota($mDominio,$mQuota);
		vpopmail_domainconf($mDominio,"cuentas",$mCuentas);
		vpopmail_domainconf($mDominio,"alias",$mAlias);
		vpopmail_domainconf($mDominio,"redirecciones",$mRedirecciones);
		vpopmail_domainconf($mDominio,"autorespuesta",$mAutoRespuesta);
		vpopmail_domainconf($mDominio,"listas",$mLista);
		vpopmail_domainconf($mDominio,"quota",$mQuota);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=vpopmail&pag=index\n\n");
	exit();
 ?>
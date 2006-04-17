<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_apache/include_funciones.php";
require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
?>
<?php
	$variables=Array();

	$mDominio=trim($_GET['dominio']);
	$mSubdominio=trim($_POST['frmSubdominio']);
	$variables["APACHE_ALIAS"]="www.$mSubdominio.$mDominio";
	$variables["APACHE_DOCUMENTROOT"]=_CFG_APACHE_DOCUMENTROOT.$mDominio."/$mSubdominio";
	$variables["CFG_DOCUMENTROOT"]=_CFG_APACHE_DOCUMENTROOT.$mDominio."/$mSubdominio";
	$variables["CFG_ESTADO"]=1;
	$variables["APACHE_CGIBIN"]=0;
	$variables["APACHE_INDEXES"]="";
	$variables["APACHE_MULTIVIEWS"]="MultiViews";
	$variables["PHP_REGISTERGLOBAL"]=1;
	$variables["PHP_SAFEMODE"]=1;
	$variables["PHP_UPLOAD"]=0;

	if ($mSubdominio!=""){
		apache_generartemplate($mSubdominio.".".$mDominio,$variables,true);
		filesystem_crearsubdomain($variables["APACHE_DOCUMENTROOT"]);
		apache_control("restart");
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=subdominios&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
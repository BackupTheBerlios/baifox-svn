<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_apache/include_funciones.php";
?>
<?php
$variables=Array();

$mDominio=trim($_POST['frmDominio']);
$variables["APACHE_ALIAS"]=trim($_POST['frmAlias']);
$variables["APACHE_DOCUMENTROOT"]=trim($_POST['frmDocumentRoot']);
if($_POST['frmDocumentRoot']!=_CFG_APACHE_DESACTIVADO)
	$variables["CFG_DOCUMENTROOT"]=trim($_POST['frmDocumentRoot']);
else
	$variables["CFG_DOCUMENTROOT"]=trim($_POST['frmCFG_DOCUMENTROOT']);
$variables["CFG_ESTADO"]=$_POST['frmCFG_ESTADO'];
if($_POST['frmOPCGIBIN']==1){
	$variables["APACHE_CGIBIN"]=1;
}else{
	$variables["APACHE_CGIBIN"]=0;
}
if($_POST['frmOPIndexes']==1){
	$variables["APACHE_INDEXES"]="Indexes";
}else{
	$variables["APACHE_INDEXES"]="";
}
if($_POST['frmOPMultiViews']==1){
	$variables["APACHE_MULTIVIEWS"]="MultiViews";
}else{
	$variables["APACHE_MULTIVIEWS"]="";
}
if($_POST['frmOPRegisterGlobal']==1){
	$variables["PHP_REGISTERGLOBAL"]=1;
}else{
	$variables["PHP_REGISTERGLOBAL"]=0;
}
if($_POST['frmOPSafeMode']==1){
	$variables["PHP_SAFEMODE"]=1;
}else{
	$variables["PHP_SAFEMODE"]=0;
}
if($_POST['frmOPUpload']==1){
	$variables["PHP_UPLOAD"]=1;
}else{
	$variables["PHP_UPLOAD"]=0;
}
 
apache_generartemplate($mDominio,$variables,false);
pureftpd_crearsubdomain	($variables["APACHE_DOCUMENTROOT"]);

	header ("Location: ../../../index.php?grupo=servicios&seccion=apache&pag=sub_index\n\n");
	exit();
 ?>
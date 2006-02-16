<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_pureftpd/include_funciones.php";
require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
?>
<?php
$mDominio=trim($_POST['frmDominio']);
$mUsuario=$_POST['frmUsuario'];
$mPassword=$_POST['frmPassword'];
$mHomedir=$_POST['frmHomedir'];
$mQuota=$_POST['frmQuota'];
$mEstado=$_POST['frmCFG_ESTADO'];
$mTipo=$_POST['frmTipo'];

	if ($_GET['id']!=0){
		pureftpd_crear($mDominio,$mUsuario,$mPassword,$mHomedir,$mQuota,$mEstado,$_GET['id'],$mTipo);
	}else{
		pureftpd_crear($mDominio,$mUsuario,$mPassword,$mHomedir,$mQuota,$mEstado,$_GET['id'],$mTipo);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=pureftpd&pag=index\n\n");
	exit();
 ?>
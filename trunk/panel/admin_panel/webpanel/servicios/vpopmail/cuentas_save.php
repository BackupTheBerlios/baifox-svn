<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_vpopmail/include_funciones.php";
?>
<?php
$mUsuario=trim($_POST['frmCuenta']);
$mDominio=trim($_GET['dominio']);
$mPassword=trim($_POST['frmPassword']);
$mQuota=trim($_POST['frmQuota']);

	if ($_GET['id']!=0){
		vpopmail_userpasswd($mUsuario,$mDominio,$mPassword);
		vpopmail_cuentaquota($mUsuario,$mDominio,$mQuota);
	}else{
		vpopmail_cuentaadd($mUsuario,$mDominio,$mPassword,$mQuota);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=vpopmail&pag=cuentas_index&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
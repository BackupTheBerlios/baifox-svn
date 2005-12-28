<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_vpopmail/include_funciones.php";
?>
<?php
$mCuentaOrigen=trim($_POST['frmCuentaOrigen']);
$mCuentaDestino=trim($_POST['frmCuentaDestino']);
$mDominio=trim($_GET['dominio']);


	if ($_GET['id']==0){
		vpopmail_aliasadd($mCuentaOrigen,$mDominio,$mCuentaDestino);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=vpopmail&pag=alias_index&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
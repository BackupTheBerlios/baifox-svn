<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
?>
<?php
$mCuenta=trim($_POST['frmCuenta']);
$mCuentaCopia=trim($_POST['frmCuentaCopia']);
$mAsunto=trim($_POST['frmAsunto']);
$mMensaje=trim($_POST['frmMensaje']);
$mDominio=trim($_GET['dominio']);

	if ($_GET['id']==0){
		filesystem_htpasswdsave();
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=protegedir&pag=directorio&directorio=".$_GET['directorio']."&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
?>
<?php
$mUsuario=trim($_POST['frmUsuario']);
$mPassword=trim($_POST['frmPassword']);
$mDirectorio=trim($_GET['directorio']);
$mDominio=trim($_GET['dominio']);

	if ($_GET['id']==0){
		filesystem_htpasswdsave($mDominio,$mDirectorio,$mUsuario,$mPassword);
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=protegedir&pag=directorio&directorio=".$_GET['directorio']."&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
?>
<?php
$mCadena=trim($_POST['frmNombre']);
$mDirectorio=trim($_GET['directorio']);
$mDominio=trim($_GET['dominio']);

	if ($_POST['frmActivar']){
		filesystem_htaccesssave($mDominio,$mDirectorio,$mCadena);
	}else{
		filesystem_htaccessdelete($mDominio,$mDirectorio);
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=protegedir&pag=directorio&directorio=".$_GET['directorio']."&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
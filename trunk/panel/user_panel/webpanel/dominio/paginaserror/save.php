<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
?>
<?php
$mTipo=trim($_POST['frmTipo']);
$mContenido=trim($_POST['frmContenido']);
$mDominio=trim($_GET['dominio']);

	if ($_GET['id']==0){
		filesystem_paginaserrorsave($mDominio,$mContenido,$mTipo);
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=paginaserror&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
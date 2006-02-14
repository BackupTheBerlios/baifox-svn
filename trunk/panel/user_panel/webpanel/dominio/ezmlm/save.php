<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_ezmlm/include_funciones.php";
?>
<?php
$mLista=trim($_POST['frmLista']);
$mSendOp=trim($_POST['frmSendOp']);
$mOwner=trim($_POST['frmOwner']);
$mDominio=trim($_GET['dominio']);

	if ($_GET['id']==0){
		ezmlm_crearlista($mDominio,$mLista,$mSendOp);
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=ezmlm&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
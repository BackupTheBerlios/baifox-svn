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
$mEmail=trim($_POST['frmEmail']);
$mTipo=trim($_POST['frmTipo']);
$mRespuesta=trim($_POST['frmRespuesta']);
$mEmailRespuesta=trim($_POST['frmEmailRespuesta']);
$mDominio=trim($_GET['dominio']);

	if ($_GET['id']==0){
		ezmlm_addsucritos($mDominio,$mLista,$mEmail,$mTipo,$mRespuesta,$mEmailRespuesta);
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=ezmlm&pag=listar&dominio=".$_GET['dominio']."&lista=".$_POST['frmLista']."&tipo=".$_POST['frmTipo']."\n\n");
	exit();
 ?>
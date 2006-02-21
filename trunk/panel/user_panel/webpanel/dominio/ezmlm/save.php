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
$mRespuesta=trim($_POST['frmRespuesta']);
$mEmailRespuesta=trim($_POST['frmEmailRespuesta']);
$mDominio=trim($_GET['dominio']);

$mOpciones="";
if($_POST['frmSubH'])
	$mOpciones.="H";
else
	$mOpciones.="h";
if($_POST['frmSubS'])
	$mOpciones.="S";
else
	$mOpciones.="s";
if($_POST['frmSubJ'])
	$mOpciones.="J";
else
	$mOpciones.="j";
if($mOwner!="")
	$mOpciones.=" -5$mOwner";
$mSendOp.=$mOpciones;

	if ($_GET['id']==0){
		ezmlm_crearlista($mDominio,$mLista,$mSendOp,$mRespuesta,$mEmailRespuesta);
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=ezmlm&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
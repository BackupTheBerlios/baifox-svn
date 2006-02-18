<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_pureftpd/include_funciones.php";
require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
?>
<?php
$mDominio=trim($_GET['dominio']);
$mUsuario=$_POST['frmUsuario'];
$mPassword=$_POST['frmPassword'];
$mHomedir=_CFG_APACHE_DOCUMENTROOT.$mDominio."/".$_POST['frmDirectorio'];
$datos=xmlconfig_buscar(_CFG_XML_DOMINIOS,"DOMINIO",$_GET["dominio"],"","","datos");
$mQuota=$datos["QUOTAFTP"];
$mTipo=$_POST['frmTipo'];

	if ($_GET['id']!=0){
		$resultado=pureftpd_passwd($mDominio,$mUsuario,$mPassword,$mHomedir,$mTipo);
	}else{
		$resultado=pureftpd_crearsecundario($mDominio,$mUsuario,$mPassword,$mHomedir,$mQuota,$mTipo);
	}
	if($resultado){	
		header ("Location: ../../../index.php?grupo=dominio&seccion=ftp&pag=index&dominio=".$_GET['dominio']."\n\n");
	}else{
		$_SESSION["strTemp"]="Error, el usuario ya existe, elija otro por favor";
		header ("Location: ../../../index.php?grupo=dominio&seccion=ftp&pag=index&dominio=".$_GET['dominio']."&resulid=99\n\n");
	}
	exit();
 ?>
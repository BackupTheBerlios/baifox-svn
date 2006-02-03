<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_vpopmail/include_funciones.php";
?>
<?php
$mUsuario=trim($_POST['frmCuenta']);
$mDominio=trim($_GET['dominio']);
$mAsunto=trim($_POST['frmAsunto']);
$mMensaje=trim($_POST['frmMensaje']);

if($_POST['frmActivar']){
	vpopmail_cuenta_autorespondadd($mUsuario,$mAsunto,$mMensaje,$mDominio);
}else{
	vpopmail_cuenta_autoresponddel($mUsuario,$mDominio);
}
		
header ("Location: ../../../index.php?grupo=dominio&seccion=correo&pag=index&dominio=".$_GET['dominio']."\n\n");
exit();
?>
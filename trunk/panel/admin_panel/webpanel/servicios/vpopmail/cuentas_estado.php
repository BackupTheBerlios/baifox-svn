<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_vpopmail/include_funciones.php";
?>
<?php 
	if ($_GET['estado']==1){
		vpopmail_cuentaonoff($_GET['usuario'],$_GET['dominio'],0);
  	}else{
		vpopmail_cuentaonoff($_GET['usuario'],$_GET['dominio'],1);
  	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=vpopmail&pag=cuentas_index&dominio=".$_GET['dominio']."\n\n");
	exit();	
?>


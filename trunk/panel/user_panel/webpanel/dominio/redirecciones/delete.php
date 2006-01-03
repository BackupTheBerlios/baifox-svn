<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_vpopmail/include_funciones.php";
	vpopmail_aliasdel($_GET['usuario']);
	header ("Location: ../../../index.php?grupo=dominio&seccion=redirecciones&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();	
?>

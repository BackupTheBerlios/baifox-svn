<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_ezmlm/include_funciones.php";
	ezmlm_deletelista($_GET['dominio'],$_GET['lista']);
	header ("Location: ../../../index.php?grupo=dominio&seccion=ezmlm&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();	
?>

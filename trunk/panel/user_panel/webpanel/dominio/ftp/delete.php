<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_pureftpd/include_funciones.php";
	require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
	pureftpd_deletesecundario($_GET['usuario'],$_GET['dominio']);
	header ("Location: ../../../index.php?grupo=dominio&seccion=ftp&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();	
?>

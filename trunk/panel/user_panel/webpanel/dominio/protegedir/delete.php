<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
	filesystem_htpasswddelete($_GET['usuario'],$_GET['dominio'],$_GET['directorio']);
	header ("Location: ../../../index.php?grupo=dominio&seccion=protegedir&pag=directorio&directorio=".$_GET['directorio']."&dominio=".$_GET['dominio']."\n\n");
	exit();	
?>

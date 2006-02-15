<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
	require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
	filesystem_backupdescargar($_GET['dominio'],$_GET['tipo']);
	exit();	
?>

<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_apache/include_funciones.php";
	apache_descargarlog($_GET['dominio'],$_GET['tipo']);
	exit();	
?>

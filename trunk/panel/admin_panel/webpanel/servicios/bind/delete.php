<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_INTERFACE_DIRMODULES."mod_bind/include_funciones.php";
	bind_domaindel($_GET['dominio']);
	header ("Location: ../../../index.php?grupo=servicios&seccion=bind&pag=index\n\n");
	exit();	
?>

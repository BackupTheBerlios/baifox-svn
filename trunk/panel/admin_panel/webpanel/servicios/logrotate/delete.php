<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_INTERFACE_DIRMODULES."mod_logrotate/include_funciones.php";
	logrotate_domaindel($_GET['dominio']);
	header ("Location: ../../../index.php?grupo=servicios&seccion=logrotate&pag=index\n\n");
	exit();	
?>

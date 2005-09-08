<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_INTERFACE_DIRMODULES."mod_pureftpd/include_funciones.php";
	pureftpd_domaindel($_GET['id']);
	header ("Location: ../../../index.php?grupo=servicios&seccion=pureftpd&pag=index\n\n");
	exit();	
?>

<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_INTERFACE_DIRMODULES."mod_awstats/include_funciones.php";
	awstats_domaindel($_GET['dominio']);
	header ("Location: ../../../index.php?grupo=servicios&seccion=awstats&pag=index\n\n");
	exit();	
?>

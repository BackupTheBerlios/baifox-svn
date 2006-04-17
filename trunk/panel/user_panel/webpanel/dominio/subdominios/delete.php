<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_apache/include_funciones.php";
?>
<?php 
	if(strpos($_GET['subdominio'],$_GET['dominio'])!==false)
		apache_domaindel($_GET['subdominio']);
	header ("Location: ../../../index.php?grupo=dominio&seccion=subdominios&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();	
?>

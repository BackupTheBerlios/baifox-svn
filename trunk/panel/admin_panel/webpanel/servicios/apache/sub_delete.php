<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_apache/include_funciones.php";
?>
<?php 
	apache_domaindel($_GET['dominio']);
	
	header ("Location: ../../../index.php?grupo=servicios&seccion=apache&pag=sub_index\n\n");
	exit();	
?>

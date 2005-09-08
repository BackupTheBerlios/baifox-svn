<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_apache/include_funciones.php";
?>
<?php 
	if ($_GET['estado']==1){
		apache_domainonoff($_GET['dominio'],0);
  	}else{
		apache_domainonoff($_GET['dominio'],1);
  	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=apache&pag=index\n\n");
	exit();	
?>


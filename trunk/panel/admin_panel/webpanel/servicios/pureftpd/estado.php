<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_pureftpd/include_funciones.php";
require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
?>
<?php 
	if ($_GET['estado']==1){
		pureftpd_domainonoff($_GET['id'],0);
  	}else{
		pureftpd_domainonoff($_GET['id'],1);
  	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=pureftpd&pag=index\n\n");
	exit();	
?>


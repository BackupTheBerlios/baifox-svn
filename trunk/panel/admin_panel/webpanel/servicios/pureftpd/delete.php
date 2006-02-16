<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_INTERFACE_DIRMODULES."mod_pureftpd/include_funciones.php";
	require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
	
	if($_POST['borrar']=="true"){
		pureftpd_domaindel($_GET['id'],true);
	}else{
		pureftpd_domaindel($_GET['id'],false);
	}
	header ("Location: ../../../index.php?grupo=servicios&seccion=pureftpd&pag=index\n\n");
	exit();	
?>

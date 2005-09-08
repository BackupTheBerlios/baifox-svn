<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_bind/include_funciones.php";
?>
<?php
$mDominio=trim($_POST['frmDominio']);
$mContenido=trim($_POST['frmContenido']);


	if ($_GET['id']!= 0 ){
		bind_filesave_hosts($mDominio,$mContenido);
	}else{
		bind_domainsave($mDominio);
		bind_filesave_hosts($mDominio,$mContenido);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=bind&pag=index\n\n");
	exit();
 ?>
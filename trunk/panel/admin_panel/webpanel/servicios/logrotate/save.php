<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_logrotate/include_funciones.php";
?>
<?php
$mDominio=trim($_POST['frmDominio']);


	if ($_GET['id']!= 0 ){
		logrotate_domainsave($mDominio);
	}else{
		logrotate_domainsave($mDominio);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=logrotate&pag=index\n\n");
	exit();
 ?>
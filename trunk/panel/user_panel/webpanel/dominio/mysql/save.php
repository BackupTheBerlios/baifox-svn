<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_db_mysql/include_funciones.php";
?>
<?php
$mDominio=trim($_POST['frmDominio']);
$mBase=trim($_POST['frmBase']);
$mPassword=$_POST['frmPassword'];

	if ($_GET['id']!= 0 ){
		db_mysql_password($mDominio,$mBase,$mPassword);
	}
		
	header ("Location: ../../../index.php?grupo=dominio&seccion=mysql&pag=index&dominio=".$_GET['dominio']."\n\n");
	exit();
 ?>
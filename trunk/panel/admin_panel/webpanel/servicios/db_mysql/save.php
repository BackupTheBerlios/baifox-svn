<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_db_mysql/include_funciones.php";
?>
<?php
$mBase=trim($_POST['frmBase']);
$mPassword=$_POST['frmPassword'];

	if ($_GET['id']!= 0 ){
		db_mysql_password($mBase,$mPassword);
	}else{
		db_mysql_dbasecrear($mBase,$mPassword);
	}
		
	header ("Location: ../../../index.php?grupo=servicios&seccion=db_mysql&pag=index\n\n");
	exit();
 ?>
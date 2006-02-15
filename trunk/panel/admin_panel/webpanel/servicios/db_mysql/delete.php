<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
	require_once _CFG_INTERFACE_DIRMODULES."mod_db_mysql/include_funciones.php";
	require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
	$mDominio=xmlconfig_buscadbase($_GET['base'],"dominio");
	db_mysql_dbasedel($mDominio,$_GET['base']);
	header ("Location: ../../../index.php?grupo=servicios&seccion=db_mysql&pag=index\n\n");
	exit();	
?>

<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_ezmlm/include_funciones.php";
	ezmlm_delsucritos($_GET['dominio'],$_GET['lista'],$_GET['usuario'],$_GET['tipo']);
	header ("Location: ../../../index.php?grupo=dominio&seccion=ezmlm&pag=listar&dominio=".$_GET['dominio']."&lista=".$_GET['lista']."&tipo=".$_GET['tipo']."\n\n");
	exit();	
?>

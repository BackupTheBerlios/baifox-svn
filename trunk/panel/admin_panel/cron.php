#!/usr/local/bin/php
<?php 
     include "config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
require_once _CFG_XML_PATCONFIG;
	
	//Carga todos los modulos
	$modulos_instalados=modules_array(_CFG_INTERFACE_DIRMODULES);
	foreach ($modulos_instalados as $modulo) { 
		require _CFG_INTERFACE_DIRMODULES."mod_".$modulo."/include_funciones.php"; 
	}

	foreach ($modulos_instalados as $modulo) { 
		if (function_exists($modulo."_cron"))
			call_user_func($modulo."_cron");
	}
?>
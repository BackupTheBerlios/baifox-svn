<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
include "../include_permiso.php"; 
require_once _CFG_INTERFACE_DIRMODULES."mod_bandwidth/include_funciones.php";
require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
?>
<link rel="stylesheet" type="text/css" href="../../../main.css">
<?php
echo bandwidth_estadisticas_dia($_GET['dominio'],$_GET['mes'],$_GET['anio']);
?>

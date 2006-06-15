<?php
	include "../admin_panel/config/main_config.php"; 
        require _CFG_INTERFACE_LIBRERIA; 

	$modulos_instalados=modules_array(_CFG_INTERFACE_DIRMODULES);
	foreach ($modulos_instalados as $modulo) { 
		require _CFG_INTERFACE_DIRMODULES."mod_".$modulo."/include_funciones.php"; 
	}
?>
<?php include "secure.php"; ?> 
<html>
<head>
<title>Panel Administraci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _CFG_INTERFACE_GETTEXT_ENCODING; ?>">
<link href="main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="javascript/funciones.js"></script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<?php include "include_top.php"; ?>
<br>
<?php include "include_redir.php"; ?>
</body>
</html>

<?php require ("../libreria.php"); ?>
<?php
	include "config/main_config.php"; 
	require_once _CFG_XML_PATCONFIG;
	$modulos_instalados=modules_array(_CFG_INTERFACE_DIRMODULES);
	foreach ($modulos_instalados as $modulo) { 
		require _CFG_INTERFACE_DIRMODULES."mod_".$modulo."/include_funciones.php"; 
	}
?>
<?php include "secure.php"; ?> 
<html>
<head>
<title>ADMIN: <?php echo _CFG_INTERFACE_NOMBRE." "._CFG_INTERFACE_VERSION; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="main.css">
<script language="JavaScript" src="javascript/funciones.js"></script>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td colspan="2"><?php include "include_top.php"; ?></td>
        </tr>
        <tr> 
          <td width="20%" height="32" valign="top"><?php include "include_left.php"; ?></td>
          <td width="80%" height="32" valign="top" align="left"> 
            <table width="100%">
              <tr>
                <td> 
                  <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php include "include_infoayuda.php"; ?>
                  </font></td>
              </tr>
              <tr>
                <td><?php include "include_redir.php"; ?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

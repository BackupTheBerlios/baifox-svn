<?php
	include "admin_panel/config/main_config.php"; 
        require _CFG_INTERFACE_LIBRERIA; 
?>
<html>
<head>
<title><?php echo _CFG_INTERFACE_NOMBRE." "._CFG_INTERFACE_VERSION; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _CFG_INTERFACE_GETTEXT_ENCODING; ?>">
<link href="user_panel/main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="user_panel/javascript/funciones.js"></script>
</head>
<body bgcolor="#ffffff">
<!--
<table width=70% align=center class=main>
  <tr bgcolor="#FFCC66"> 
    <td width=50% valign=top align=left height="10" style="BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid" bgcolor="#FFCB0D"> 
      <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
       
        </font></p>
    </td>
  </tr>
</table>
<br>
-->
		<form method="post" action="secure.php" id="form2" name="form2">
		<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
			<tr>
			    <td colspan="4" align="center"><br>
        <table width="340" border="0" cellpadding="2" cellspacing="2">
          <tr> 
            <td colspan="2" align="center" valign="bottom"><img src="logo.gif" width="147" height="107" border="0" align="absmiddle"><br></td>
          </tr>
          <tr align="center"> 
            <td colspan="2" class="red"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Login 
              Usuarios </font></strong></font> </td>
          </tr>
          <td width="90" align="right" valign="middle"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Usuario:&nbsp;&nbsp;</font></b></td>
          <td> 
            <input type="text" maxlength="272" name="frmUsuario">
          </td>
          </tr>
          <tr> 
            <td align="right" valign="middle"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Contrase&ntilde;a:&nbsp;&nbsp;</font></b></td>
            <td> 
              <input type="password" maxlength="60" name="frmPassword">
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><a href="index_recuperar.php"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Recuperar 
              Contrase&ntilde;a</font></a></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td> 
              <input type="submit" WIDTH="79" HEIGHT="25" value="Entrar"  STYLE="font-weight:normal;font-size:10px;">
            </td>
          </tr>
        </table>
				</td>
			</tr>
		</table>
		</form>
<?php if ($_GET['resulid']) { ?>
<script language="JavaScript">
<!--
 <?php switch ($_GET['resulid']){
	case 1:
		echo "mostrar_mensaje('Gracias por utilizar "._CFG_INTERFACE_NOMBRE."','info');\n";
	break;
    	default:
        	echo "mostrar_mensaje('".$_SESSION['strTemp']."','error');\n";
        break;
	} ?>
-->
</script>
<?php } ?>
</body>
</html>
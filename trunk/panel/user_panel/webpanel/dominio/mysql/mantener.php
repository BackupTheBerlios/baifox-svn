<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?> 
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center" height="33"><img src="images/icn_cseguridad_sub.gif" width="47" height="34"></td>
                <td width="88%" height="33"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">
            <?php 
	switch($_GET['accion']){
	case "check":
		echo "Chequear";
	break;
	case "repair":
		echo "Reparar";
	break;
	}
?> Base de datos  [ <?php echo $_GET['base']; ?> ]</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> <br>
            <?php 
	switch($_GET['accion']){
	case "check":
		echo db_mysql_checkdatabase($_GET['base']);
	break;
	case "repair":
		echo db_mysql_repairdatabase($_GET['base']);
	break;
	}
?>
            <br>
            <br>
            [ <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=index&dominio=<?php echo $_GET['dominio']; ?>"> 
            volver</a> ] </td>
        </tr>
      </table>
      <br>
    </td>
  </tr>
</table>

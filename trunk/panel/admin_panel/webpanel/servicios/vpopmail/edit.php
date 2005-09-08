<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=<?php echo $_GET['id']; ?>">
  <font size="2" face="Arial, Helvetica, sans-serif">Modificar Dominio</font><br>
<br>
<table width="75%" border="1" bordercolor="#333333" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top" align="center"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3" height="121" align="center" bordercolor="#000000">
          <tr align="center" bgcolor="#CC3300"> 
            <td width="30%"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Concepto</font></b></font></td>
            <td width="70%"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Datos</font></b></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="25" align="left" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Dominio</font></td>
            <td height="25" align="left"> 
	      <input type="hidden" name="frmDominio" size="50" value="<?php echo $_GET['dominio']; ?>" >
              <?php echo $_GET['dominio']; ?>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Password</font></td>
            <td> 
              <input type="text" name="frmPassword" size="15" value="<?php echo vpopmail_usershowpasswd("postmaster",$_GET['dominio']); ?>" maxlength="14">
	      <font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font>
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Cuentas</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmCuentas" value="<?php echo vpopmail_domainlimits($_GET['dominio'],"cuentas"); ?>" size="4">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Redirecciones</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmRedirecciones" value="<?php echo vpopmail_domainlimits($_GET['dominio'],"redirecciones"); ?>" size="4">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Alias</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmAlias" value="<?php echo vpopmail_domainlimits($_GET['dominio'],"alias"); ?>" size="4">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Autorespondedores</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmAutoRespuesta" value="<?php echo vpopmail_domainlimits($_GET['dominio'],"autorespuesta"); ?>" size="4">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Listas 
              de Correo</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmLista" value="<?php echo vpopmail_domainlimits($_GET['dominio'],"listas"); ?>" size="4">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><font face="Arial, Helvetica, sans-serif" size="2">Quota</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmQuota" value="<?php echo vpopmail_domainlimits($_GET['dominio'],"quota"); ?>" size="10">
              ejemplo: 10M, 500K, 5MB</font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2">&nbsp; </td>
          </tr>
        </table>
      <input type="submit" name="Submit" value="Modificar">
    </td>
  </tr>
</table>
</form>


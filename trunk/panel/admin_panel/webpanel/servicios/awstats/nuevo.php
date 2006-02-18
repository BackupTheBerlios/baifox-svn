<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>

<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0">
  <font size="2" face="Arial, Helvetica, sans-serif">A&ntilde;adir Nuevo Dominio</font><br>
<br>
<table width="75%" border="1" bordercolor="#333333" cellspacing="0" cellpadding="0">
  <tr> 
      <td valign="top" align="center"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3" height="121" align="center" bordercolor="#000000">
          <tr align="center" bgcolor="#CC3300"> 
            <td width="16%"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Concepto</font></b></font></td>
            <td width="84%"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Datos</font></b></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="25" align="left" bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Dominio</font></td>
            <td height="25" align="left" width="84%"> 
              <input type="text" name="frmDominio" size="50" onchange="frmContenido.value=replaceAll(frmContenido.value,'{DOMINIO}',this.value);  frmContenido.value=replaceAll(frmContenido.value,'{DOMINIO_SIN}',fnStripSLD(this.value)); frmContenido.value=replaceAll(frmContenido.value,'{DOMINIO_EXT}',fnStripTLD(this.value)); crear_usuario(this.form);">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Usuario</font></td>
            <td> 
              <input type="text" name="frmUsuario" size="15" maxlength="14" onblur="frmContenido.value=replaceAll(frmContenido.value,'{AWSTATS_USUARIO}',this.value);" onchange="frmContenido.value=replaceAll(frmContenido.value,'{AWSTATS_USUARIO}',this.value);"><font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="25" align="left" bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Password</font></td>
            <td height="25" align="left" width="84%"> 
              <input type="text" name="frmPassword" size="15" maxlength="14">
              <font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font>
	     </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF" width="16%" valign="top"><font face="Arial, Helvetica, sans-serif" size="2">Fichero AWSTATS</font></td>
            <td width="84%"> 
              <textarea name="frmContenido" cols="100" rows="15"><?php echo awstats_generartemplate("",""); ?></textarea>
            </td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2">&nbsp; </td>
          </tr>
        </table>
        <input type="submit" name="Submit" value="A&ntilde;adir">
    </td>
  </tr>
</table>
</form>
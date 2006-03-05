<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0" name="formulario">
<input type="hidden" name="frmCFG_ESTADO" value="1">
  <font size="2" face="Arial, Helvetica, sans-serif">A&ntilde;adir Nuevo Dominio</font><br>
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
              <input type="text" name="frmDominio" size="50" onkeyup="crear_documentroot(this.form,'<?php echo _CFG_APACHE_DOCUMENTROOT; ?>');crear_serveralias(this.form);">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Alias</font></td>
            <td> 
              <input type="text" name="frmAlias" size="50">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Directorio 
              Inicial </font></td>
            <td> 
              <input type="text" name="frmDocumentRoot" size="50">
            </td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2">
              <table border="1" cellspacing="0" cellpadding="0" width="80%">
                <tr> 
                  <td colspan="2"><font face="Arial, Helvetica, sans-serif" size="2"><b>Variables 
                    de Apache</b></font></td>
                </tr>
                <tr> 
                  <td width="89%"><font face="Arial, Helvetica, sans-serif" size="2">Activar Scripts CGI-BIN</font></td>
                  <td align="center" width="11%"> <font face="Arial, Helvetica, sans-serif" size="2"> 
                    <input type="checkbox" name="frmOPCGIBIN" value="1">
                    </font></td>
                </tr>
                <tr> 
                  <td width="89%"><font face="Arial, Helvetica, sans-serif" size="2">Activar 
                    Vista directorio</font></td>
                  <td align="center" width="11%"> <font face="Arial, Helvetica, sans-serif" size="2"> 
                    <input type="checkbox" name="frmOPIndexes" value="1">
                    </font></td>
                </tr>
                <tr> 
                  <td width="89%"><font face="Arial, Helvetica, sans-serif" size="2">Activar 
                    MultiViews</font></td>
                  <td align="center" width="11%"> <font face="Arial, Helvetica, sans-serif" size="2"> 
                    <input type="checkbox" name="frmOPMultiViews" value="1">
                    </font></td>
                </tr>
              </table>
              <br>
              <table border="1" cellspacing="0" cellpadding="0" width="80%">
                <tr> 
                  <td colspan="2"><font face="Arial, Helvetica, sans-serif" size="2"><b>Variables 
                    de <font face="Arial, Helvetica, sans-serif" size="2">PHP</font></b></font></td>
                </tr>
                <tr> 
                  <td width="89%"><font face="Arial, Helvetica, sans-serif" size="2">Activar 
                    Register Global</font></td>
                  <td align="center" width="11%"> <font face="Arial, Helvetica, sans-serif" size="2"> 
                    <input type="checkbox" name="frmOPRegisterGlobal" value="1">
                    </font></td>
                </tr>
                <tr> 
                  <td><font face="Arial, Helvetica, sans-serif" size="2">Activar 
                    Safe Mode</font></td>
                  <td align="center"> <font face="Arial, Helvetica, sans-serif" size="2"> 
                    <input type="checkbox" name="frmOPSafeMode" value="1">
                    </font></td>
                </tr>
                <tr> 
                  <td><font face="Arial, Helvetica, sans-serif" size="2">Activar 
                    Uploads</font></td>
                  <td align="center"> <font face="Arial, Helvetica, sans-serif" size="2"> 
                    <input type="checkbox" name="frmOPUpload" value="1">
                    </font></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      <input type="submit" name="Submit" value="A&ntilde;adir">
    </td>
  </tr>
</table>
</form>
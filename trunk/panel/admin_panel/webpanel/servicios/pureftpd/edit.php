<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
$rs=pureftpd_domainread($_GET['id']);
?>
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=<?php echo $_GET['id']; ?>">
<input type="hidden" name="frmCFG_ESTADO" value="<?php echo $rs["estado"]; ?>">
<input type="hidden" name="frmUsuarioActual" value="<?php echo $rs["usuario"]; ?>">
  <font size="2" face="Arial, Helvetica, sans-serif">Modificar FTP</font><br>
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
              <input type="hidden" name="frmDominio" size="50" value="<?php echo $_GET['dominio']; ?>" >
              <?php echo $_GET['dominio']; ?>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Usuario</font></td>
            <td width="84%"> 
              <input type="text" name="frmUsuario" size="15" value="<?php echo $rs["usuario"]; ?>" maxlength="14">
              <font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font> 
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Password</font></td>
            <td width="84%"> 
              <input type="text" name="frmPassword" size="15" maxlength="14">
              <font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font> 
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Home</font></td>
            <td width="84%"> 
              <input type="text" name="frmHomedir" size="42" value="<?php echo $rs["homedir"]; ?>">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Quota</font></td>
            <td width="84%"> 
              <input type="text" name="frmQuota" size="20" value="<?php echo $rs["quotasize"]; ?>">
              Mb </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Tipo</font></td>
            <td width="84%"> 
              <select name="frmTipo">
                <option value="1" <?php if($rs["tipo"]==1){ echo "selected"; } ?>>PRINCIPAL</option>
                <option value="2" <?php if($rs["tipo"]==2){ echo "selected"; } ?>>SECUNDARIA</option>
              </select>
            </td>
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
<br>
<?php echo pureftpd_showstatus($_GET['id']); ?>
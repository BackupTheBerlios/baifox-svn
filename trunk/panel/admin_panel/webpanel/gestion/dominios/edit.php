<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<?php
$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_DOMINIOS);
$rs=$conf->getConfigValue($_GET['id']);
?> 
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=<?php echo $_GET['id']; ?>">
<input type="hidden" name="frmIDFTP" value="<?php echo $rs["IDFTP"]; ?>">
<input type="hidden" name="frmEstado" value="<?php echo $rs["ESTADO"]; ?>">
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
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Clientes</font></td>
            <td> 
              <select name="frmIDCliente">
                <?php rellenacombo_xml(_CFG_XML_CLIENTES,_CFG_XML_CONFIG_DIR,"ID","NOMBRE",$rs["IDCLIENTE"]); ?>
              </select>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="25" align="left" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Dominio</font></td>
            <td height="25" align="left"> 
              <input type="text" name="frmDominio" size="35" value="<?php echo $rs["DOMINIO"]; ?>">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="25" align="left" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Base 
              Datos </font></td>
            <td height="25" align="left"> 
              <input type="text" name="frmBase" size="15" maxlength="14" value="<?php echo $rs["BASE"]; ?>">
              <font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Usuario</font></td>
            <td> 
              <input type="text" name="frmUsuario" size="15" maxlength="14" value="<?php echo $rs["USUARIO"]; ?>"><font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Password</font></td>
            <td> 
              <input type="text" name="frmPassword" size="15" maxlength="14"><font face="Arial, Helvetica, sans-serif" size="2"> Max 14 car.</font>
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Cuentas</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmCuentas" size="4" value="<?php echo $rs["CUENTAS"]; ?>">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Redirecciones</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmRedirecciones" size="4" value="<?php echo $rs["REDIRECCIONES"]; ?>">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><font face="Arial, Helvetica, sans-serif" size="2">Alias</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmAlias" size="4" value="<?php echo $rs["ALIAS"]; ?>">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Autorespondedores</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmAutoRespuesta" size="4" value="<?php echo $rs["AUTORESPUESTA"]; ?>">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td ><font face="Arial, Helvetica, sans-serif" size="2">Listas de 
              Correo</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmLista" size="4" value="<?php echo $rs["LISTA"]; ?>">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td><font face="Arial, Helvetica, sans-serif" size="2">Quota de Correo</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmQuotaCORREO" size="10" value="<?php echo $rs["QUOTACORREO"]; ?>">
              ejemplo: 10M, 500K, 5MB</font></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF" width="16%"><font face="Arial, Helvetica, sans-serif" size="2">Quota 
              FTP </font></td>
            <td width="84%"> 
              <input type="text" name="frmQuotaFTP" size="20" value="<?php echo $rs["QUOTAFTP"]; ?>">
              Mb </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <input type="submit" name="Submit" value="Modificar">
    </td>
  </tr>
</table>
</form>

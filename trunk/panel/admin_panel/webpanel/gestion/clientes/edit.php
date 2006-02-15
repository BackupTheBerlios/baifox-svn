<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<?php
$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_CLIENTES);
$rs=$conf->getConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_CLIENTES));
?> 
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=<?php echo xmlconfig_buscaid($_GET['id'],_CFG_XML_CLIENTES); ?>">
<input type="hidden" name="frmEstado" value="<?php echo $rs["ESTADO"]; ?>">
  <font size="2" face="Arial, Helvetica, sans-serif">Modificar Cliente</font><br>
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
            <td height="25" align="left" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Nombre</font></td>
            <td height="25" align="left"> 
              <input type="text" name="frmNombre" size="50" value="<?php echo $rs["NOMBRE"]; ?>">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Email</font></td>
            <td> 
              <input type="text" name="frmEmail" size="50" value="<?php echo $rs["EMAIL"]; ?>">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Permisos</font></td>
            <td> 
              <select name="frmPermiso">
                <option value="100" <?php if($rs["PERMISO"]==100){ echo "selected"; } ?>>PERMISO 
                BASICO [100]</option>
              </select>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Estado</font></td>
            <td> 
              <?php if($rs["ESTADO"]==1){ ?>
              <img src="images/activo.gif" width="20" height="20"> 
              <?php }else{ ?>
              <img src="images/suspendido.gif" width="20" height="20"> 
              <?php } ?>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="35" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Usuario</font></td>
            <td height="35"> 
              <input type="text" name="frmUsuario" size="20" value="<?php echo $rs["USERNAME"]; ?>">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Password</font></td>
            <td> 
              <input type="text" name="frmPassword" size="20">
            </td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2"><font face="Arial, Helvetica, sans-serif" size="2">Caracter&iacute;sticas</font></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="35" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Total 
              dominios </font></td>
            <td height="35"> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmDominios" size="20" value="<?php echo $rs["DOMINIOS"]; ?>">
              <b>Unidades</b></font></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Total 
              espacio </font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmEspacio" size="20" value="<?php echo $rs["ESPACIO"]; ?>">
              <b>MB</b></font></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Total 
              ancho banda</font></td>
            <td> <font face="Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmAnchoBanda" size="20" value="<?php echo $rs["ANCHOBANDA"]; ?>">
              <b>MB</b> </font></td>
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
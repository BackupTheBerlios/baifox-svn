<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/autorespond_save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
  <input type="hidden" name="frmEstado" value="1">
  <font size="2" face="Arial, Helvetica, sans-serif">Modificar Autorespuesta
  [ 
  <?php echo $_GET['dominio']; ?>
  ]</font> <br>
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
            <td height="25" align="left" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Cuenta 
              Origen </font></td>
            <td height="25" align="left"> 
              <?php echo $_GET['usuario']; ?>
	      <input type="hidden" name="frmCuenta" value="<?php list($cuenta,$dominio)=split("@",$_GET['usuario'],2); echo $cuenta; ?>">
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Enviar 
              copia a</font></td>
            <td> 
              <input type="text" name="frmCuentaCopia" size="25" value="<?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"copia"); ?>">
              </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Asunto</font></td>
            <td> 
              <input type="text" name="frmAsunto" size="25" value="<?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"asunto"); ?>">
              </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF" valign="top"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Mensaje</font></td>
            <td> 
              <textarea name="frmMensaje" cols="50" rows="20"><?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"mensaje"); ?></textarea>
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
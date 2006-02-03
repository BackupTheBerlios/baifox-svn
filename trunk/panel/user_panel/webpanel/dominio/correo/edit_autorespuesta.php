
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td>
      <form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save_autorespuesta.php?id=<?php echo $_GET["id"]; ?>&dominio=<?php echo $_GET['dominio']; ?>">
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td valign="top"> 
              <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" bgcolor="#F2A500" valign="top"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                        <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Modificar 
                          Autorespuesta</font></b></font></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3"> 
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr align="center"> 
                        <td width="43%" align="right" bgcolor="#d6d6d6">&nbsp;&nbsp;activar 
                          autorespuesta </td>
                        <td width="57%" align="left" bgcolor="#d6d6d6">
                          <input type="checkbox" name="frmActivar" value="true" <?php if(vpopmail_cuenta_autorespondread($_GET['usuario'],$_GET['dominio'],"estado")){ echo "checked"; } ?>>
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="43%" bgcolor="#d6d6d6" align="right">remitente</td>
                        <td width="57%" bgcolor="#d6d6d6" align="left"> 
                          <?php echo $_GET["usuario"]."@".$_GET["dominio"]; ?>
                          <input type="hidden" name="frmCuenta" class="boxBlur" value="<?php echo $_GET["usuario"]; ?>">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="43%" bgcolor="#d6d6d6" align="right">asunto</td>
                        <td width="57%" bgcolor="#d6d6d6" align="left"> 
                          <input type="text" name="frmAsunto" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25" value="<?php echo vpopmail_cuenta_autorespondread($_GET['usuario'],$_GET['dominio'],"asunto"); ?>">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td bgcolor="#d6d6d6" align="right" width="43%" valign="top">mensaje</td>
                        <td bgcolor="#d6d6d6" align="left" width="57%"> 
                          <textarea name="frmMensaje" cols="50" rows="10"><?php echo vpopmail_cuenta_autorespondread($_GET['usuario'],$_GET['dominio'],"mensaje"); ?></textarea>
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td bgcolor="#d6d6d6" colspan="2"><a href="javascript:document.formulario.submit();"><img src="images/icn_grabar.gif" width="25" height="25" border="0"><br>
                          [ Modificar ] </a></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        </form>
    </td>
  </tr>
</table>


<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td>
      <form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td valign="top">
              <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" bgcolor="#F2A500"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                        <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Modificar 
                          autorespuesta</font></b></font></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3"> 
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr align="center"> 
                        <td width="17%" align="left" bgcolor="#d6d6d6">&nbsp;&nbsp;cuenta 
                          local </td>
                        <td width="31%" align="left" bgcolor="#d6d6d6">
                          <?php echo $_GET['usuario']; ?>
			  <input type="hidden" name="frmCuenta" value="<?php list($cuenta,$dominio)=split("@",$_GET['usuario'],2); echo $cuenta; ?>">
                        </td>
                        <td width="15%" align="center" bgcolor="#d6d6d6">enviar 
                          copia a </td>
                        <td width="25%" align="left" bgcolor="#d6d6d6"> 
                          <input type="text" name="frmCuentaCopia" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25" value="<?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"copia"); ?>">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="17%" align="left" bgcolor="#d6d6d6">&nbsp;&nbsp;asunto</td>
                        <td colspan="3" align="left" bgcolor="#d6d6d6"> 
                          <input type="text" name="frmAsunto" size="25" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" value="<?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"asunto"); ?>">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="17%" align="left" bgcolor="#d6d6d6" valign="top">&nbsp;&nbsp;mensaje</td>
                        <td colspan="3" align="left" bgcolor="#d6d6d6"> 
                          <textarea name="frmMensaje" cols="50" rows="15" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'"><?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"mensaje"); ?></textarea>
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td colspan="4" bgcolor="#d6d6d6" valign="top"><a href="javascript:document.formulario.submit();"><img src="images/icn_grabar.gif" width="25" height="25" border="0"><br>
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
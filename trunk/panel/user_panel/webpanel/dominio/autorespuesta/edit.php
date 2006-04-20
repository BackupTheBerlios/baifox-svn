
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td>
      <form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td valign="top">
              <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td width="50%" valign="top">
                    <table border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr> 
                        <td colspan="3" bgcolor="#F2A500"> 
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                              <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Crear 
                          nueva autorespuesta</font></b></font></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td colspan="3"> 
                          <table width="100%" border="0" cellspacing="2" cellpadding="0">
                            <tr align="center"> 
                              <td width="20%" align="right" bgcolor="#d6d6d6">&nbsp;&nbsp;cuenta local </td>
                              <td align="left" bgcolor="#d6d6d6">&nbsp; 
                                 <?php echo $_GET['usuario']; ?>
			  <input type="hidden" name="frmCuenta" value="<?php list($cuenta,$dominio)=split("@",$_GET['usuario'],2); echo $cuenta; ?>"></td>
                            </tr>
                            <tr align="center"> 
                              <td width="20%" align="right" bgcolor="#d6d6d6">enviar 
                          copia a </td>
                              <td align="left" bgcolor="#d6d6d6"> 
                               <input type="text" name="frmCuentaCopia" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25" value="<?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"copia"); ?>">
                        </td>
                            </tr>
                            <tr align="center"> 
                              <td width="20%" align="right" bgcolor="#d6d6d6">&nbsp;&nbsp;asunto</td>
                              <td align="left" bgcolor="#d6d6d6"> 
                                <input type="text" name="frmAsunto" size="25" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" value="<?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"asunto"); ?>">
                        </td>
                            </tr>
                            <tr align="center"> 
                              <td width="20%" align="right" bgcolor="#d6d6d6" valign="top">&nbsp;&nbsp;mensaje</td>
                              <td align="left" bgcolor="#d6d6d6"> 
                                <textarea name="frmMensaje" cols="35" rows="8" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'"><?php echo vpopmail_autorespondread($_GET['usuario'],$_GET['dominio'],"mensaje"); ?></textarea>
                        </td>
                            </tr>
                            <tr align="center"> 
                              <td colspan="2" align="center" bgcolor="#d6d6d6" valign="top"><a href="javascript:document.formulario.submit();"><img src="images/icn_grabar.gif" width="25" height="25" border="0"><br>
                          [ Modificar ] </a></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td width="56%" valign="top"> 
                    <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr> 
                        <td colspan="3" bgcolor="#F2A500"> 
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td width="12%" align="center"><img src="images/icn_ayuda.gif" width="47" height="34"></td>
                              <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Ayuda</font></b></font></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td colspan="3"> 
                          <table width="100%" border="0" cellspacing="2" cellpadding="0">
                            <tr align="center" bgcolor="#FFFFCC">
                              <td colspan="2"><b>Si quiere a&ntilde;adir una autorespueta a una cuenta de correo que ya tiene, debe realizar esta operaci&oacute;n en la secci&oacute;n &quot;Gesti&oacute;n Correo -&gt;Autoresp.&quot;</b></td>
                            </tr>
                            <tr align="center" bgcolor="#FFFFCC"> 
                              <td width="37%" align="right">&nbsp;&nbsp;cuenta local</td>
                              <td align="left" width="63%"> introduzca solo su nombre 
                          de usuario sin el nombre de dominio</td>
                            </tr>
                            <tr align="center" bgcolor="#FFFFCC"> 
                              <td width="37%" align="right">enviar copia a</td>
                              <td width="63%" align="left"> permite enviar una copia 
                          del correo que reciba a otra cuenta que decida</td>
                            </tr>
                            <tr align="center" bgcolor="#FFFFCC"> 
                              <td width="37%" align="right">asunto</td>
                              <td width="63%" align="left"> asunto del email</td>
                            </tr>
                            <tr align="center" bgcolor="#FFFFCC"> 
                              <td align="right" width="37%">mensaje</td>
                              <td align="left" width="63%"> mensaje que recibir&aacute; 
                          autom&aacute;ticamente el usuario de origen</td>
                            </tr>
                          </table>
                        </td>
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


<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td>
      <form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=<?php echo $_GET["id"]; ?>&dominio=<?php echo $_GET['dominio']; ?>">
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td width="50%" valign="top"> 
              <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" bgcolor="#F2A500" valign="top"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                        <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Modificar 
                          cuenta</font></b></font></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3"> 
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr align="center"> 
                        <td width="9%" align="right" bgcolor="#d6d6d6">&nbsp;&nbsp;nombre</td>
                        <td width="18%" align="left" bgcolor="#d6d6d6"> 
                          <?php echo $_GET["usuario"]."@".$_GET["dominio"]; ?>
                          <input type="hidden" name="frmCuenta" class="boxBlur" value="<?php echo $_GET["usuario"]; ?>">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="11%" bgcolor="#d6d6d6" align="right">contrase&ntilde;a</td>
                        <td width="17%" bgcolor="#d6d6d6" align="left"> 
                          <input type="text" name="frmPassword" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="14">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="11%" bgcolor="#d6d6d6" align="right">confirmar 
                          contrase&ntilde;a</td>
                        <td width="17%" bgcolor="#d6d6d6" align="left"> 
                          <input type="text" name="frmRePassword" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="14">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td bgcolor="#d6d6d6" align="right" width="6%">espacio</td>
                        <td bgcolor="#d6d6d6" align="left" width="3%"> 
                          <input type="text" name="frmQuota" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="5">
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
            <td width="56%" valign="top"> 
              <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" bgcolor="#F2A500"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                        <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Ayuda</font></b></font></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3"> 
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="42%" align="right">&nbsp;&nbsp;nombre</td>
                        <td align="left" width="58%"> introduzca solo su nombre 
                          de usuario sin el nombre de dominio</td>
                      </tr>
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="42%" align="right">contrase&ntilde;a</td>
                        <td width="58%" align="left"> una contrase&ntilde;a para 
                          su correo</td>
                      </tr>
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="42%" align="right">confirmar contrase&ntilde;a</td>
                        <td width="58%" align="left"> vuelva a escribir la contrase&ntilde;a 
                          para verificar que este correcta </td>
                      </tr>
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td align="right" width="42%">espacio</td>
                        <td align="left" width="58%"> Ej: 10M, 500K, 5MB</td>
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

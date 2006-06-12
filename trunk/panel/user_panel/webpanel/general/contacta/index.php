<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?> 
<table width=90% align=center class=main cellspacing="0" cellpadding="0" border="0">
  <tr> 
    <td width=50% valign=top align=left height="326"> <font color="#000000" face="Verdana, Arial, Helvetica, sans-serif" size="2">Si 
      tienes alg&uacute;n problema o duda con la configuraci&oacute;n de tu dominio 
      que no logras resolver, puedes consultarnos usando el siguiente formulario, 
      o bien puedes escribirnos directamente a </font><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="mailto:<?php echo _CFG_INTERFACE_EMAIL; ?>"><b><?php echo _CFG_INTERFACE_EMAIL; ?></b></a></font><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif" size="2">. <br>
      </font><br>
<form name="contacto" method="post" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/enviamail.php">
        <table border="0" cellspacing="0" cellpadding="0" align="center" width="500">
          <tr> 
            <td colspan="3" bgcolor="#F2A500"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                  <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Contacta 
                    con nosotros</font></b></font></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align="center"> 
            <td colspan="3" valign="top"> 
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr bgcolor="#d6d6d6"> 
                  <td  align="right" height="22"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">De</font></b></td>
                  <td  align="left" height="22"> <font face="Arial, Helvetica, sans-serif"> 
                    <font size="2"> 
                    <?php echo $_SESSION['SEC_USER_NOMBRE']; ?>
                    < 
                    <?php echo $_SESSION['SEC_USER_EMAIL']; ?>
                    > 
                    <input type="hidden" name="frmNombre" value="<?php echo $_SESSION['SEC_USER_NOMBRE']; ?>">
                    <input type="hidden" name="frmEmail" value="<?php echo $_SESSION['SEC_USER_EMAIL']; ?>">
                    </font> </font> </td>
                </tr>
                <tr bgcolor="#d6d6d6"> 
                  <td  align="right"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">Nombre 
                    del dominio</font></b></td>
                  <td  align="left"> 
                    <input type="text" size="30" name="frmDominio" value="<?php echo $_GET['dominio']; ?>" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
                  </td>
                </tr>
                <tr bgcolor="#d6d6d6"> 
                  <td  align="right"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">Su 
                    e-mail</font></b></td>
                  <td  align="left"> <b><font color="#000000"> 
                    <input type="text" maxlength="30" size="30" name="frmEmail2" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
                    </font></b></td>
                </tr>
                <tr bgcolor="#d6d6d6"> 
                  <td  align="right"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">Comentario/Pregunta</font></b></td>
                  <td  align="left"> 
                    <textarea cols="30" name="frmComentario" rows="5" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'"></textarea>
                  </td>
                </tr>
                <tr align="center" bgcolor="#d6d6d6"> 
                  <td colspan="2"> 
                    <input type="submit" value="Enviar"  name="borrar">
                    <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font> 
                    <input type="reset" value="Borrar"  name="borrar">
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

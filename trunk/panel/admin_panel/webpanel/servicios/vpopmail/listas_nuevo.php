<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/listas_save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
  <input type="hidden" name="frmEstado" value="1">
  <font size="2" face="Arial, Helvetica, sans-serif">A&ntilde;adir Nueva Lista 
  Correo[ 
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
          <tr align="center" bgcolor="#FFFFFF"> 
            <td width="32%" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;&nbsp;Nombre 
              Lista </font></td>
            <td width="68%" align="left"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmLista" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25">@<?php echo $_GET['dominio']; ?>
              </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td width="32%" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Email 
              propietario lista </font></td>
            <td width="68%" align="left"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <input type="text" name="frmOwner" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25">
              </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td width="32%" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Envios 
              mensajes</font></td>
            <td width="68%" align="left"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <select name="frmSendOp">
                <option value="MU" selected>Lista abierta</option>
                <option value="Mu">Suscriptores - Resto rechazados</option>
                <option value="mu">Suscriptores - Resto moderados</option>
                <option value="mUo">Moderadores- Resto rechazados</option>
                <option value="mUO">Moderadores - Resto Moderados</option>
              </select>
              </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td align="right" width="32%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Respuesta 
              mensajes</font></td>
            <td align="left" width="68%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <select name="frmRespuesta">
                <option value="REPLYTO_SENDER" selected>Lista de correo</option>
                <option value="REPLYTO_LIST">Remitente original</option>
                <option value="REPLYTO_ADDRESS">Rediriguen al email</option>
              </select>
              redirigido a email 
              <input type="text" name="frmEmailRespuesta" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25">
              </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Peticiones 
              de suscripci&oacute;n </b> </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td align="right" width="32%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Requiere 
              enviar un email de confirmaci&oacute;n a la direcci&oacute;n de 
              suscripci&oacute;n</font></td>
            <td align="left" width="68%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <input type="checkbox" name="frmSubH" value="true" checked>
              </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td align="right" width="32%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Requiere 
              aprobaci&oacute;n del moderador</font></td>
            <td align="left" width="68%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <input type="checkbox" name="frmSubS" value="true">
              </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Peticiones 
              de baja</font></b></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td align="right" width="32%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Requiere 
              enviar un email de confirmaci&oacute;n a la direcci&oacute;n de 
              baja</font></td>
            <td align="left" width="68%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
              <input type="checkbox" name="frmSubJ" value="true" checked>
              </font></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF"> 
            <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"></font> 
            </td>
          </tr>
        </table>
      <input type="submit" name="Submit" value="A&ntilde;adir">
    </td>
  </tr>
</table>
</form>
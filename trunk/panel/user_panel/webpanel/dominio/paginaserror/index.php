<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center" height="33"><img src="images/icn_perror_sub.gif" width="47" height="34"></td>
                <td width="88%" height="33"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">P&aacute;ginas 
                  de error</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr> 
                <td align="left" bgcolor="#d6d6d6" width="89%"><span class="Estilo5">&nbsp;&nbsp;tipo 
                  error </span></td>
                <td align="center" bgcolor="#d6d6d6" width="11%"><span class="Estilo5">&nbsp;&nbsp;</span></td>
              </tr>
              <tr> 
                <td align="left" width="89%"> 400 (Petici&oacute;n err&oacute;nea)</td>
                <td width="11%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&tipo=400"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr> 
                <td align="left" width="89%"> 401 (Requiere autorizaci&oacute;n)</td>
                <td width="11%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&tipo=401"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr> 
                <td align="left" width="89%"> 403 (Prohibido)</td>
                <td width="11%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&tipo=403"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr> 
                <td align="left" width="89%"> 404 (P&aacute;gina incorrecta)</td>
                <td width="11%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&tipo=404"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr> 
                <td align="left" width="89%"> 500 (Error interno del servidor)</td>
                <td width="11%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&tipo=500"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr> 
                <td align="left" bgcolor="#d6d6d6" colspan="2"><img src="#" width="1" height="1"> 
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
    </td>
  </tr>
</table>

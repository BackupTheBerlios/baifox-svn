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
                <td width="12%" align="center" height="33"><img src="images/icn_cseguridad_sub.gif" width="47" height="34"></td>
                <td width="88%" height="33"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Copia 
                  de seguridad</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr> 
                <td align="left" bgcolor="#d6d6d6" width="78%"><span class="Estilo5">&nbsp;&nbsp;log</span></td>
                <td align="center" bgcolor="#d6d6d6" width="22%"><span class="Estilo5">&nbsp;&nbsp;descargar</span></td>
              </tr>
              <tr> 
                <td align="left" width="78%"> 
                  <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=generar&dominio=<?php echo $_GET['dominio']; ?>&tipo=web"><?php echo $_GET["dominio"]; ?> - p&aacute;gina web</a>
                </td>
                <td width="22%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=generar&dominio=<?php echo $_GET['dominio']; ?>&tipo=web"><img src="images/icn_cseguridad_dw.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr> 
                <td align="left" width="78%"> 
                  <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=generar&dominio=<?php echo $_GET['dominio']; ?>&tipo=basedatos"><?php echo $_GET["dominio"]; ?> - base de datos</a>
                </td>
                <td width="22%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=generar&dominio=<?php echo $_GET['dominio']; ?>&tipo=basedatos"><img src="images/icn_cseguridad_dw.gif" width="30" height="30" border="0"></a></td>
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

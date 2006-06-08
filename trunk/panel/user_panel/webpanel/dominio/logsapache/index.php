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
                <td width="12%" align="center" height="33"><img src="images/icn_logs_sub.gif" width="47" height="34"></td>
                <td width="88%" height="33"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Logs 
                  de apache</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr> 
                <td align="left" bgcolor="#d6d6d6" width="78%"><span class="Estilo5">&nbsp;&nbsp;log</span></td>
                <td align="left" bgcolor="#d6d6d6" width="22%"><span class="Estilo5">&nbsp;&nbsp;</span>d&iacute;a</td>
              </tr>
              <tr> 
                <td align="left" width="78%"> 
                  <a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/descargar.php?tipo=hoy&dominio=<?php echo $_GET['dominio']; ?>"><?php echo $_GET["dominio"]; ?></a>
                </td>
                <td width="22%"><span class="Estilo5">&nbsp;&nbsp;</span><b>hoy</b></td>
              </tr>
              <tr> 
                <td align="left" width="78%"> 
                  <a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/descargar.php?tipo=ayer&dominio=<?php echo $_GET['dominio']; ?>"><?php echo $_GET["dominio"]; ?></a>
                </td>
                <td width="22%"><span class="Estilo5">&nbsp;&nbsp;</span>ayer</td>
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

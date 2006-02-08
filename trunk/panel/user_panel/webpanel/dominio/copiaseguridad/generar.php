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
                <td width="12%" align="center" height="33"><img src="images/icn_correo.gif" width="47" height="34"></td>
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
		<IFRAME name="scr1" id="scr1" src="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/generar_frame.php?dominio=<?php echo $_GET['dominio']; ?>&tipo=<?php echo $_GET['tipo']; ?>" target="_top" width="90%" height="100" frameborder="no" border="0" MARGINWIDTH="0" MARGINHEIGHT="0" SCROLLING="yes" allowtransparency="true"></IFRAME>
                </td>
                <td width="22%" align="center"><a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/descargar.php?tipo=<?php echo $_GET['tipo']; ?>&dominio=<?php echo $_GET['dominio']; ?>"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
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
<script type="text/javascript">
/*************************************************************************
  This code is from Dynamic Web Coding at http://www.dyn-web.com/
  See Terms of Use at http://www.dyn-web.com/bus/terms.html
  regarding conditions under which you may use this code.
  This notice must be retained in the code as is!
*************************************************************************/
var timer_id;
function scroll_iframe(frm,inc,dir) {
  if (window.frames[frm]) {
    if (dir == "v") window.frames[frm].scrollBy(0, inc);
    else window.frames[frm].scrollBy(inc, 0);
    timer_id = setTimeout("scroll_iframe('" + frm + "'," + inc + ",'" + dir + "')", 20);
  }
}
scroll_iframe('scr1', 10, 'v');
</script>
<?php flush(); ?>

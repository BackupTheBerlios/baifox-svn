<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?> 
<script language="JavaScript">
<!-- 
setTimeout("actualizar_log()",2000);
function actualizar_log() {
   document.getElementById('news').scrollTop=document.getElementById('news').scrollHeight-document.getElementById('news').clientHeight;
}
// -->
</script>
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
		<div style="overflow:auto;width:550px;height:100px;border:1px solid black;font-size:10px;font-family:arial" id="news"><?php filesystem_backupcomprimir($_GET['dominio'],$_GET['tipo']); ?></div>
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

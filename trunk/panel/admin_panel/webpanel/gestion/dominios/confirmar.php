<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<form method="POST" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/delete.php?id=<?php echo $_GET['id']; ?>">
<table width="75%" border="1" bordercolor="#333333" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="top" align="center"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3" height="121" align="center" bordercolor="#000000">
          <tr align="left" bgcolor="#FFFFFF"> 
            <td colspan="2" align="center"> 
              <p><b>&iquest;Esta seguro de que desea borrar el dominio <?php echo $_GET['dominio']; ?>?</b><br>
                <input type="checkbox" name="borrar" value="true" checked>
                Borrar <?php echo $_GET['dominio']; ?> y todo su contenido</p>
              </td>
          </tr>
        </table>
        <input type="submit" name="BtnAceptar" value="Aceptar">
        <input type="button" name="BtnCancelar" value="Cancelar" onclick="javascript:history.go(-1)">
      </td>
  </tr>
</table>
</form>

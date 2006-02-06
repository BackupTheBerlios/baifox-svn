<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=filesystem_htpasswdlist($_GET['dominio'],$_GET['directorio']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
<form method="POST" name="formhtaccess" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save_htaccess.php?id=0&dominio=<?php echo $_GET['dominio']; ?>&directorio=<?php echo $_GET['directorio']; ?>">
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_correo.gif" width="47" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Activar 
                  protecci&oacute;n directorio [<?php echo $_GET['directorio']; ?> - DIR]</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;activar</span></td>
                <td align="left" bgcolor="#d6d6d6">nombre recurso</td>
                <td bgcolor="#d6d6d6" align="right" width="15%">&nbsp; </td>
              </tr>
              <tr align="center"> 
                <td align="left"> 	
                  <input type="checkbox" name="frmActivar" value="true" <?php if(filesystem_htaccessread($_GET['dominio'],$_GET['directorio'],"estado")){ echo "checked"; } ?>>
                  activar protecci&oacute;n</td>
                <td align="left">
                  <input type="text" name="frmNombre" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25" value="<?php echo filesystem_htaccessread($_GET['dominio'],$_GET['directorio'],"cadena"); ?>">
                </td>
                <td width="15%" align="center"><a href="#"><img src="images/icn_grabar.gif" width="25" height="25" border="0" onclick="document.formhtaccess.submit()"></a></td>
              </tr>
              <tr align="center"> 
                <td colspan="3" align="left" bgcolor="#d6d6d6"><img src="#" width="1" height="1"> 
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
</form>
      <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_correo.gif" width="47" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Gesti&oacute;n 
                  usuarios [<?php echo $_GET['directorio']; ?> - DIR]</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;usuario</span></td>
                <td bgcolor="#d6d6d6" align="right" width="15%">&nbsp; </td>
              </tr>
              <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs!=""){
?>
              <tr align="center"> 
                <td align="left"> 
                  <?php echo $rs; ?>
                </td>
                <td width="15%" align="center"><a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?id=<?php echo $x; ?>&usuario=<?php echo $rs; ?>&dominio=<?php echo $_GET['dominio']; ?>&directorio=<?php echo $_GET['directorio']; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs; ?>?')"><img src="images/icn_eliminar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr align="center"> 
                <td colspan="2" align="left" bgcolor="#d6d6d6"><img src="#" width="1" height="1"> 
                </td>
              </tr>
              <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}
   }

?>
            </table>
          </td>
        </tr>
      </table>
      <br>
<form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>&directorio=<?php echo $_GET['directorio']; ?>">
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
          <td colspan="3" bgcolor="#F2A500">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                  <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Crear 
                    nuevo usuario</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr align="center"> 
                  <td width="17%" align="left" bgcolor="#d6d6d6">&nbsp;&nbsp;usuario</td>
                  <td width="31%" align="left" bgcolor="#d6d6d6"> 
                    <input type="text" name="frmUsuario" class="boxBlur" onfocus="this.className='boxFocus'"  onblur="this.className='boxBlur'" size="15">
                  </td>
                  <td width="15%" align="center" bgcolor="#d6d6d6">contrase&ntilde;a</td>
                  <td width="25%" align="left" bgcolor="#d6d6d6"> 
                    <input type="text" name="frmPassword" class="boxBlur" onfocus="this.className='boxFocus'"  onblur="this.className='boxBlur'" size="25">
                  </td>
                  <td bgcolor="#d6d6d6" align="center" width="12%"><a href="#"><img src="images/icn_grabar.gif" width="25" height="25" border="0" onclick="document.formulario.submit()"></a></td>
                </tr>
              </table>
          </td>
        </tr>
      </table>
</form>
    </td>
  </tr>
</table>

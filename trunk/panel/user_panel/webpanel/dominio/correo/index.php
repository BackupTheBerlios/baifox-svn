<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=vpopmail_listcuentas($_GET['dominio']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<script  language="JavaScript" type="text/javascript">
<!-- 
function correo_autoconfig(usuario,dominio) { 
	alert('Se va a configurar automáticamente la cuenta ' + usuario +'@'+ dominio + ' para su Microsoft (R) Outlook (Express)[tm]. Por favor cierre todas las copias abiertas de Microsoft (R) Outlook (Express)[tm] antes de continuar!  Cuando el proceso finalize debería tener la cuenta ' + usuario +'@'+ dominio + ' configurada en su Microsoft (R) Outlook (Express)[tm].'); 
	alert('Si le pregunta si desea GUARDAR el archivo o ABRIRLO responda "Abrir el fichero."');
	alert('Cuando le pregunte si desea introducir la información en el registro conteste que "SI".'); 
	document.location.href = "webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/email_reg.php?usuario="+usuario+"&dominio="+dominio; 
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
                <td width="12%" align="center"><img src="images/icn_correo.gif" width="47" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Gesti&oacute;n 
                  de cuentas de correo</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center">
                <td width="43%" align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;nombre</span></td>
                <td width="9%" align="center" bgcolor="#d6d6d6">espacio asignado</td>
                <td width="9%" align="center" bgcolor="#d6d6d6">webmail</td>
                <td bgcolor="#d6d6d6" align="center" width="9%">autoconf. </td>
                <td bgcolor="#d6d6d6" align="center" width="5%">antispam</td>
                <td bgcolor="#d6d6d6" align="center" width="5%">autoresp.</td>
                <td bgcolor="#d6d6d6" align="center" width="20%">borrar/editar</td>
              </tr>
              <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs["cuenta"]!=""){
		$estado=vpopmail_cuentalimits($rs["cuenta"],$_GET['dominio'],"estado");
?>
              <tr align="center"> 
                <td width="43%" align="left"> 
                  <?php echo $rs["cuenta"]; ?>
                </td>
                <td width="9%" align="center"> 
                  <?php echo $rs["quota"]; ?>
                </td>
                <td width="9%" align="center"><a href="Javascript:Ventana('<?php echo _CFG_USERINTERFACE_WEBMAIL_LOGIN.$rs["cuenta"]."@".$_GET['dominio']; ?>');"><img src="images/icn_webmailcuenta.gif" width="30" height="30" border="0"></a></td>
                <td width="9%" align="center"><a href="Javascript:correo_autoconfig('<?php echo $rs["cuenta"]; ?>','<?php echo $_GET['dominio']; ?>')"><img src="images/icn_outlookmail.gif" width="30" height="30" border="0"></a></td>
                <td width="5%" align="center">
		<?php if(vpopmail_cuentaantispam($rs["cuenta"],$_GET['dominio'],"estado")){ ?>
		<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/spam.php?usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&accion=delete"><img src="images/icn_spam.gif" width="30" height="30" border="0"></a>
		<?php }else{ ?>
		<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/spam.php?usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&accion=add"><img src="images/icn_spam_off.gif" width="30" height="30" border="0"><a>
		<?php } ?>
		</td>
		<?php if(vpopmail_cuenta_autorespondread($rs["cuenta"],$_GET['dominio'],"estado")){ ?>
                <td width="5%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit_autorespuesta&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&id=<?php echo $x; ?>"><img src="images/icn_autorcuenta.gif" width="30" height="30" border="0"></a></td>
		<?php }else{ ?>
                <td width="5%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit_autorespuesta&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&id=<?php echo $x; ?>"><img src="images/icn_autorcuenta_off.gif" width="30" height="30" border="0"></a></td>
		<?php } ?>
                <td width="20%" align="center"><a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?id=<?php echo $x; ?>&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>" onClick="return confirmLink(this, '¿Desea borrar <?php echo $rs["cuenta"]."@".$_GET['dominio']; ?>?')"><img src="images/icn_eliminar.gif" width="30" height="30" border="0"></a><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&id=<?php echo $x; ?>"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr align="center"> 
                <td colspan="7" align="left" bgcolor="#d6d6d6"><img src="#" width="1" height="1"> 
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
      <p>&nbsp;</p>
     <form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
            <td width="50%" valign="top"> 
              <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" bgcolor="#F2A500" valign="top"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                        <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Crear 
                          nueva cuenta</font></b></font></td>
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
                          <input type="text" name="frmCuenta" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="10">@<?php echo $_GET['dominio']; ?>
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
                          [ A&ntilde;adir ] </a></td>
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
                      <td width="12%" align="center"><img src="images/icn_ayuda.gif" width="47" height="34"></td>
                      <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Ayuda</font></b></font></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr align="center"> 
                <td colspan="3"> 
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="37%" align="right">&nbsp;&nbsp;nombre</td>
                        <td align="left" width="63%"> introduzca solo su nombre 
                          de usuario sin el nombre de dominio</td>
                    </tr>
                    <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="37%" align="right">contrase&ntilde;a</td>
                        <td width="63%" align="left"> una contrase&ntilde;a para 
                          su correo</td>
                    </tr>
                    <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="37%" align="right">confirmar contrase&ntilde;a</td>
                        <td width="63%" align="left"> vuelva a escribir la contrase&ntilde;a 
                          para verificar que este correcta </td>
                    </tr>
                    <tr align="center" bgcolor="#FFFFCC"> 
                        <td align="right" width="37%">espacio</td>
                        <td align="left" width="63%"> Ej: 10M, 500K, 5MB</td>
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

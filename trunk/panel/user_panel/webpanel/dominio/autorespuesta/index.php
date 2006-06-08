<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=vpopmail_listautorespuesta($_GET['dominio']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_autor_sub.gif" width="47" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Gesti&oacute;n 
                  de autorespuestas correo</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td width="49%" align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;cuenta 
                  local </span></td>
                <td width="36%" align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;</span>copia 
                  a </td>
                <td bgcolor="#d6d6d6" align="right" width="15%">&nbsp; </td>
              </tr>
              <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs["cuenta"]!=""){
?>
              <tr align="center"> 
                <td width="49%" align="left"> 
                  <?php echo $rs["cuenta"]; ?>
                </td>
                <td width="36%" align="left">
                  <?php if ($rs["cuenta_copia"]!=""){ echo $rs["cuenta_copia"]; }else{ echo "n/a"; } ?>
                </td>
                <td width="15%" align="center"><a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?id=<?php echo $x; ?>&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs["cuenta"]; ?>?')"><img src="images/icn_eliminar.gif" width="30" height="30" border="0"></a><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&id=<?php echo $x; ?>"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr align="center"> 
                <td colspan="3" align="left" bgcolor="#d6d6d6"><img src="#" width="1" height="1"> 
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
<form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td width="50%" valign="top">
              <table border="0" cellspacing="0" cellpadding="0" align="center">
                <tr> 
                  <td colspan="3" bgcolor="#F2A500"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td width="12%" align="center"><img src="images/icn_autor_add.gif" width="47" height="34"></td>
                        <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Crear 
                          nueva autorespuesta</font></b></font></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3"> 
                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                      <tr align="center"> 
                        <td width="20%" align="right" bgcolor="#d6d6d6">&nbsp;&nbsp;cuenta local </td>
                        <td align="left" bgcolor="#d6d6d6"> 
                          <input type="text" name="frmCuenta" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="15">@<?php echo $_GET['dominio']; ?>
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="20%" align="right" bgcolor="#d6d6d6">enviar 
                          copia a </td>
                        <td align="left" bgcolor="#d6d6d6"> 
                          <input type="text" name="frmCuentaCopia" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="20%" align="right" bgcolor="#d6d6d6">&nbsp;&nbsp;asunto</td>
                        <td align="left" bgcolor="#d6d6d6"> 
                          <input type="text" name="frmAsunto" size="25" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td width="20%" align="right" bgcolor="#d6d6d6" valign="top">&nbsp;&nbsp;mensaje</td>
                        <td align="left" bgcolor="#d6d6d6"> 
                          <textarea name="frmMensaje" cols="35" rows="8" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'"></textarea>
                        </td>
                      </tr>
                      <tr align="center"> 
                        <td colspan="2" align="center" bgcolor="#d6d6d6" valign="top"><a href="javascript:document.formulario.submit();"><img src="images/icn_grabar.gif" width="25" height="25" border="0"><br>
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
                        <td colspan="2"><b>Si quiere a&ntilde;adir una autorespueta a una cuenta de correo que ya tiene, debe realizar esta operaci&oacute;n en la secci&oacute;n &quot;Gesti&oacute;n Correo -&gt;Autoresp.&quot;</b></td>
                      </tr>
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="37%" align="right">&nbsp;&nbsp;cuenta local</td>
                        <td align="left" width="63%"> introduzca solo su nombre 
                          de usuario sin el nombre de dominio</td>
                      </tr>
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="37%" align="right">enviar copia a</td>
                        <td width="63%" align="left"> permite enviar una copia 
                          del correo que reciba a otra cuenta que decida</td>
                      </tr>
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td width="37%" align="right">asunto</td>
                        <td width="63%" align="left"> asunto del email</td>
                      </tr>
                      <tr align="center" bgcolor="#FFFFCC"> 
                        <td align="right" width="37%">mensaje</td>
                        <td align="left" width="63%"> mensaje que recibir&aacute; 
                          autom&aacute;ticamente el usuario de origen</td>
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

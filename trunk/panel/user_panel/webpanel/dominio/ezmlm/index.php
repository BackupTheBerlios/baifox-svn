<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=ezmlm_list($_GET['dominio']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<script type="text/javascript">
<!--
	function hideDiv() {
		if (document.getElementById) { // DOM3 = IE5, NS6
			document.getElementById('hideshow').style.visibility = 'hidden';
		}else {
			if (document.layers) { // Netscape 4
				document.hideshow.visibility = 'hidden';
			}
			else { // IE 4
				document.all.hideshow.style.visibility = 'hidden';
			}
		}
	}
	function showDiv() {
		if (document.getElementById) { // DOM3 = IE5, NS6
			document.getElementById('hideshow').style.visibility = 'visible';
		}else {
			if (document.layers) { // Netscape 4
				document.hideshow.visibility = 'visible';
			}
			else { // IE 4
				document.all.hideshow.style.visibility = 'visible';
			}
		}
	}
	function mostrar(valor){
		if(valor=='REPLYTO_ADDRESS')
			showDiv();
		else
			hideDiv();
	}
-->
</script>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_listas.gif" width="47" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Gesti&oacute;n 
                  de listas de correo</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;lista</span><span class="Estilo5">&nbsp;&nbsp;</span></td>
                <td bgcolor="#d6d6d6" align="right" width="15%">&nbsp; </td>
              </tr>
              <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$total_registros;$i++){
   $rs =$array_listado[$i];
	if($rs!=""){
?>
              <tr align="center"> 
                <td align="left"> 
                  <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=listar&lista=<?php echo $rs; ?>&dominio=<?php echo $_GET["dominio"]; ?>"><?php echo $rs; ?></a>
                </td>
                <td width="15%" align="center"><a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?id=<?php echo $x; ?>&lista=<?php echo $rs; ?>&dominio=<?php echo $_GET['dominio']; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs; ?>?')"><img src="images/icn_eliminar.gif" width="30" height="30" border="0"></a></td>
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
<form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td colspan="3" bgcolor="#F2A500" valign="top"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="12%" align="center"><img src="images/icn_listasc_add.gif" width="47" height="34"></td>
                  <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Crear 
                    nueva lista de correo</font></b></font></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align="center"> 
            <td colspan="3"> 
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr align="center"> 
                  <td width="32%" align="right" bgcolor="#d6d6d6">&nbsp;&nbsp;Nombre 
                    Lista </td>
                  <td width="68%" align="left" bgcolor="#d6d6d6"> 
                    <input type="text" name="frmLista" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25">@<?php echo $_GET['dominio']; ?>
                  </td>
                </tr>
                <tr align="center"> 
                  <td width="32%" bgcolor="#d6d6d6" align="right">Email propietario 
                    lista </td>
                  <td width="68%" bgcolor="#d6d6d6" align="left"> 
                    <input type="text" name="frmOwner" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25">
                  </td>
                </tr>
                <tr align="center"> 
                  <td width="32%" bgcolor="#d6d6d6" align="right">Envios mensajes</td>
                  <td width="68%" bgcolor="#d6d6d6" align="left"> 
                    <select name="frmSendOp">
                      <option value="MU" selected>Lista abierta</option>
                      <option value="Mu">Suscriptores - Resto rechazados</option>
                      <option value="mu">Suscriptores - Resto moderados</option>
                      <option value="mUo">Moderadores- Resto rechazados</option>
                      <option value="mUO">Moderadores - Resto Moderados</option>
                    </select>
                  </td>
                </tr>
                <tr align="center"> 
                  <td bgcolor="#d6d6d6" align="right" width="32%">Respuesta mensajes</td>
                  <td bgcolor="#d6d6d6" align="left" width="68%"> 
                    <select name="frmRespuesta" onchange="Javascript:mostrar(this.value);" onkeyup="Javascript:mostrar(this.value);">
                      <option value="REPLYTO_SENDER" selected>Lista de correo</option>
                      <option value="REPLYTO_LIST">Remitente original</option>
                      <option value="REPLYTO_ADDRESS">Rediriguen al email</option>
                    </select><div id="hideshow">redirigido a email<input type="text" name="frmEmailRespuesta" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="25"></div>
                  </td>
                </tr>
                <tr align="center"> 
                  <td bgcolor="#d6d6d6" colspan="2"><b>Peticiones de suscripci&oacute;n 
                    </b> </td>
                </tr>
                <tr align="center"> 
                  <td bgcolor="#d6d6d6" align="right" width="32%">Requiere enviar 
                    un email de confirmaci&oacute;n a la direcci&oacute;n de suscripci&oacute;n</td>
                  <td bgcolor="#d6d6d6" align="left" width="68%"> 
                    <input type="checkbox" name="frmSubH" value="true" checked>
                  </td>
                </tr>
                <tr align="center"> 
                  <td bgcolor="#d6d6d6" align="right" width="32%">Requiere aprobaci&oacute;n 
                    del moderador</td>
                  <td bgcolor="#d6d6d6" align="left" width="68%"> 
                    <input type="checkbox" name="frmSubS" value="true">
                  </td>
                </tr>
                <tr align="center"> 
                  <td bgcolor="#d6d6d6" colspan="2"><b>Peticiones de baja</b></td>
                </tr>
                <tr align="center"> 
                  <td bgcolor="#d6d6d6" align="right" width="32%">Requiere enviar 
                    un email de confirmaci&oacute;n a la direcci&oacute;n de baja</td>
                  <td bgcolor="#d6d6d6" align="left" width="68%"> 
                    <input type="checkbox" name="frmSubJ" value="true" checked>
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
      </form>
    </td>
  </tr>
</table>
<script type="text/javascript">
<!--
hideDiv();
-->
</script>

<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
$array_directorios=filesystem_listdirectories($_GET['dominio']);
$datos=xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$_GET["dominio"],"TIPO",1,"datos");
?> 
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center" height="33"><img src="images/icn_ftp_sub.gif" width="47" height="34"></td>
                <td width="88%" height="33"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Acceso 
                  FTP Principal</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr> 
                <td align="left" bgcolor="#d6d6d6" colspan="2"><span class="Estilo5">&nbsp;&nbsp;Carpeta</span></td>
                <td align="left" bgcolor="#d6d6d6" width="25%"><span class="Estilo5">&nbsp;&nbsp;Usuario</span></td>
                <td align="left" bgcolor="#d6d6d6" width="36%"><span class="Estilo5">&nbsp;&nbsp;</span>Contrase&ntilde;a</td>
                <td align="left" bgcolor="#d6d6d6" width="13%">&nbsp;</td>
              </tr>
              <form method="POST" name="frmprincipal" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=1&dominio=<?php echo $_GET['dominio']; ?>">
                <input type="hidden" name="frmUsuario" value="<?php echo $datos["USUARIO"]; ?>">
                <input type="hidden" name="frmTipo" value="1">
                <input type="hidden" name="frmDirectorio" value="">
                <tr> 
                  <td align="center" width="4%"><img src="images/icn_carpetita.gif" border="0" width="25" height="25"></td>
                  <td align="left" width="22%"><b>/ [raiz]</b></td>
                  <td align="left" width="25%"> 
                    <?php echo $datos["USUARIO"]; ?>
                  </td>
                  <td align="left" width="36%"> 
                    <input type="text" name="frmPassword" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="20" maxlength="14">
                    Max 14 car.</td>
                  <td align="center" width="13%"> <a href="javascript:document.frmprincipal.submit();"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
                </tr>
              </form>
              <tr> 
                <td align="left" bgcolor="#d6d6d6" colspan="5"><img src="#" width="1" height="1"> 
                </td>
              </tr>
            </table>
            </td>
        </tr>
      </table>
      <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center" height="33"><img src="images/icn_ftp_sub.gif" width="47" height="34"></td>
                <td width="88%" height="33"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Accesos 
                  FTP Secundarios</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr> 
                <td align="left" bgcolor="#d6d6d6" colspan="2"><span class="Estilo5">&nbsp;&nbsp;Carpeta</span></td>
                <td align="left" bgcolor="#d6d6d6" width="25%"><span class="Estilo5">&nbsp;&nbsp;Usuario</span></td>
                <td align="left" bgcolor="#d6d6d6" width="36%"><span class="Estilo5">&nbsp;&nbsp;</span>Contrase&ntilde;a</td>
                <td align="left" bgcolor="#d6d6d6" width="13%">&nbsp;</td>
              </tr>
              <?php 
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_FTP);
	$total_registros=count($conf->getConfigValue());
	for($i=1;$x<$total_registros;$i++){
		$rs=$conf->getConfigValue($i);
		if($rs["DOMINIO"]==$_GET['dominio'] AND $rs["TIPO"]==2){
?>
              <form method="POST" name="formulario<?php echo $rs["USUARIO"]; ?>" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=1&dominio=<?php echo $_GET['dominio']; ?>">
                <input type="hidden" name="frmUsuario" value="<?php echo $rs["USUARIO"]; ?>">
                <input type="hidden" name="frmTipo" value="2">
                <input type="hidden" name="frmDirectorio" value="<?php echo str_replace(_CFG_APACHE_DOCUMENTROOT.$_GET['dominio']."/","",$rs["HOMEDIR"]); ?>">
                <tr> 
                  <td align="center" width="4%"> <img src="images/icn_carpetita.gif" border="0" width="25" height="25"></td>
                  <td align="left" width="22%"> / 
                    <?php 
			$directorio=str_replace(_CFG_APACHE_DOCUMENTROOT.$_GET['dominio']."/","",$rs["HOMEDIR"]); 
			if($directorio!=""){
				echo $directorio;
			}else{
				echo "raiz";
			}
		    ?>
                  </td>
                  <td align="left" width="25%"><a href="ftp://<?php echo $rs["USUARIO"]; ?>:<?php echo md5_decrypt($rs['PASSWORD'],_CFG_INTERFACE_BLOWFISH); ?>@<?php echo $_GET['dominio']; ?>" target="blank"> 
                    <?php echo $rs["USUARIO"]; ?>
                    </a> </td>
                  <td align="left" width="36%"> 
                    <input type="text" name="frmPassword" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="20" maxlength="14">
                    Max 14 car.</td>
                  <td align="center" width="13%">
		    <a href="javascript:document.formulario<?php echo $rs["USUARIO"]; ?>.submit();"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a> 
                    &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?usuario=<?php echo $rs["USUARIO"]; ?>&dominio=<?php echo $_GET['dominio']; ?>" onClick="return confirmLink(this, '¿Desea borrar <?php echo $rs["USUARIO"]; ?>?')"><img src="images/icn_eliminar.gif" width="30" height="30" border="0"></a> 
                  </td>
                </tr>
              </form>
              <?php 
		}
		if($rs)
			$x++;
	}
?>
              <tr> 
                <td align="left" bgcolor="#d6d6d6" colspan="5"><img src="#" width="1" height="1"> 
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
	<input type="hidden" name="frmTipo" value="2">        
	<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td colspan="3" bgcolor="#F2A500"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                  <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Crear 
                    nuevo acceso FTP</font></b></font></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr align="center"> 
            <td colspan="3"> 
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr align="center">
                  <td width="11%" align="left" bgcolor="#d6d6d6"><span class="Estilo5">Carpeta</span></td>
                  <td width="17%" align="left" bgcolor="#d6d6d6"> 
                    <select name="frmDirectorio">
			<option value="">/ [raiz]</option>
   			<?php foreach($array_directorios as $key => $value ) { ?>
				<option value="<?php echo $value; ?>">/<?php echo $value; ?></option>
			<?php } ?>
                    </select>
                  </td>
                  <td width="7%" align="left" bgcolor="#d6d6d6">Usuario</td>
                  <td width="23%" align="left" bgcolor="#d6d6d6"> 
                    <input type="text" name="frmUsuario" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="15" maxlength="14">
                    Max 14 car. </td>
                  <td width="11%" align="center" bgcolor="#d6d6d6">Contrase&ntilde;a</td>
                  <td width="21%" align="left" bgcolor="#d6d6d6"> 
                    <input type="text" name="frmPassword" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="15" maxlength="14">
                    Max 14 car. </td>
                  <td bgcolor="#d6d6d6" align="center" width="10%"><a href="#"><img src="images/icn_grabar.gif" width="25" height="25" border="0" onClick="document.formulario.submit()"></a></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>

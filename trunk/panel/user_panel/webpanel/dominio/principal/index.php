<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td width="57%"> <br>
      <table width="320" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/img_info.gif" width="50" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Informaci&oacute;n 
                  General de la Cuenta</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF"><span class="Estilo5">&nbsp;Espacio 
                  usado por WEB</span></td>
                <td bgcolor="#DFDFDF" align="right" width="49%"> 
                  <?php echo number_format(bitconversor(pureftpd_quotastatus($_SESSION['SEC_USER_DOMINIOS'][$_GET['dominio']]),"byte","mbyte"), 2, ',', '.'); ?>
                  MB</td>
              </tr>
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF"><span class="Estilo5">&nbsp;Espacio 
                  usado por SQL</span></td>
                <td bgcolor="#DFDFDF" align="right" width="49%"> 
                  <?php echo $basedatos=buscardbase_dominio($_GET['dominio']); echo " - "; echo number_format(bitconversor(db_mysql_quotastatus($basedatos),"byte","mbyte"), 2, ',', '.'); ?>
                  MB</td>
              </tr>
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF"><span class="Estilo5">&nbsp;Ancho 
                  de banda usado</span></td>
                <td bgcolor="#DFDFDF" align="right" width="49%"> 
                  <?php echo number_format(bandwidth_estadisticas_mes_total($_GET['dominio'],date("Y"),date("n")), 2, ',', '.'); ?> MB
                </td>
              </tr>
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF"><span class="Estilo5">&nbsp;Cuentas 
                  de E-mail</span></td>
                <td bgcolor="#DFDFDF" align="right" width="49%">
                  <?php echo vpopmail_domaintotalcuentas($_GET['dominio']); ?>
                </td>
              </tr>
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF"><span class="Estilo5">&nbsp;Directorio 
                  Home </span></td>
                <td bgcolor="#DFDFDF" align="right" width="49%">
                  <?php echo _CFG_APACHE_DOCUMENTROOT.$_GET['dominio']; ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="320" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/img_info.gif" width="50" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Informaci&oacute;n 
                  General del Servidor</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF">&nbsp;Sistema operativo</td>
                <td bgcolor="#DFDFDF" align="right" width="49%">
                  <?php echo sysinfo_osversion(); ?>
                </td>
              </tr>
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF">&nbsp;Versi&oacute;n 
                  de PHP</td>
                <td bgcolor="#DFDFDF" align="right" width="49%">
                  <?php echo apache_phpversion(); ?>
                </td>
              </tr>
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF">&nbsp;Versi&oacute;n 
                  de MySQL</td>
                <td bgcolor="#DFDFDF" align="right" width="49%"> 
                  <?php echo db_mysql_version(0); ?>
                </td>
              </tr>
              <tr align="center"> 
                <td width="51%" align="left" bgcolor="#BFBFBF">&nbsp;Versi&oacute;n 
                  de Apache</td>
                <td bgcolor="#DFDFDF" align="right" width="49%">
                  <?php echo apache_version(); ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td width="4%">&nbsp;</td>
    <td width="39%"> <br>
      <table width="345" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/fnd_correo.gif" height="34">
              <tr> 
                <td align="center"><font face="Arial, Helvetica, sans-serif" size="1"><b><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Correo</font></b></font></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center" valign="top"> 
                <td width="23%" class="Estilo2"><a href="Javascript:Ventana('<?php echo _CFG_USERINTERFACE_WEBMAIL; ?>');"><img src="images/icn_webmail.gif" width="50" height="50" border="0"><br>
                  Webmail</a></td>
                <td width="23%" class="Estilo2"><a href="index.php?grupo=dominio&seccion=correo&pag=index&dominio=<?php echo $_GET["dominio"]; ?>"><img src="images/icn_gestioncorreo.gif" width="50" height="50" border="0"><br>
                  Gesti&oacute;n Correo</a></td>
                <td width="17%"><img src="images/icn_listascorreo.gif" width="50" height="50"><br>
                  Listas Correo</td>
                <td width="17%"><a href="index.php?grupo=dominio&seccion=redirecciones&pag=index&dominio=<?php echo $_GET["dominio"]; ?>"><img src="images/icn_redir.gif" width="50" height="50" border="0"><br>
                  Redirecciones Alias</a></td>
              </tr>
              <tr align="center" valign="top"> 
                <td width="23%" class="Estilo2"><a href="index.php?grupo=dominio&seccion=autorespuesta&pag=index&dominio=<?php echo $_GET["dominio"]; ?>"><img src="images/icn_autor.gif" width="50" height="50" border="0"><br>
                  Respuestas autom&aacute;ticas</a></td>
                <td width="23%" class="Estilo2">&nbsp;</td>
                <td width="17%">&nbsp;</td>
                <td width="17%">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="345" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/fnd_discod.gif" height="34">
              <tr> 
                <td align="center"><font face="Arial, Helvetica, sans-serif" size="1"><b><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Gesti&oacute;n 
                  del Disco</font></b></font></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center" valign="top"> 
                <td width="23%" class="Estilo2"><a href="javascript:Ventana('webpanel/<?php echo $_GET['grupo'] ?>/filemanager/filemanager.php?dominio=<?php echo $_GET['dominio']; ?>');" ><img src="images/icn_filemanager.gif" width="50" height="50" border="0"><br>
                  Filemanager</a></td>
                <td width="23%" class="Estilo2"><a href="index.php?grupo=dominio&seccion=copiaseguridad&pag=index&dominio=<?php echo $_GET["dominio"]; ?>"><img src="images/icn_cseguridad.gif" width="50" height="50" border="0"><br>
                  Copia Seguridad</a></td>
                <td width="17%"><a href="index.php?grupo=dominio&seccion=paginaserror&pag=index&dominio=<?php echo $_GET["dominio"]; ?>"><img src="images/icn_perror.gif" width="50" height="50" border="0"><br>
                  P&aacute;ginas Error</a></td>
                <td width="17%"><a href="index.php?grupo=dominio&seccion=protegedir&pag=index&dominio=<?php echo $_GET["dominio"]; ?>">
		<img src="images/icn_dprotegidos.gif" width="50" height="50" border="0"><br>Directorios protegidos</a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <br>
      <table width="345" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/fnd_basesd.gif" height="34">
              <tr> 
                <td align="center"><font face="Arial, Helvetica, sans-serif" size="1"><b><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Bases 
                  de datos</font></b></font></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center" valign="top"> 
                <td width="23%" class="Estilo2"><img src="images/icn_basedatos.gif" width="50" height="50"><br>
                  Bases de datos</td>
                <td width="23%" class="Estilo2"><a href="Javascript:Ventana('<?php echo _CFG_USERINTERFACE_PHPMYADMIN; ?>');"><img src="images/icn_phpmyadmin.gif" width="50" height="50" border="0"><br>
                  phpMyAdmin</a></td>
                <td width="17%"><br>
                </td>
                <td width="17%"><br>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <br>
      <table width="345" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/fnd_estadisticas.gif" height="34">
              <tr> 
                <td align="center"><font face="Arial, Helvetica, sans-serif" size="1"><b><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">Estad&iacute;sticas</font></b></font></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center" valign="top"> 
                <td width="23%" class="Estilo2"><a href="Javascript:Ventana('<?php echo _CFG_USERINTERFACE_AWSTATS.$_GET['dominio']; ?>');"><img src="images/icn_awstats.gif" width="50" height="50" border="0"><br>
                  AwStats</a></td>
                <td width="23%" class="Estilo2"><a href="index.php?grupo=dominio&seccion=logsapache&pag=index&dominio=<?php echo $_GET["dominio"]; ?>"><img src="images/icn_logs.gif" width="50" height="50" border="0"><br>
                  Logs apache</a></td>
                <td width="17%"><br>
                </td>
                <td width="17%"><br>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

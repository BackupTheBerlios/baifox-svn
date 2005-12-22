<?php
$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_DOMINIOS);
$total_registros=count($conf->getConfigValue());
$numpage_total=$total_registros;
?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td width="57%"> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/img_mundo.gif" width="39" height="39"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="3" color="#FFFFFF">Dominios</font><font size="2" color="#FFFFFF"><br>
                  </font></b><font size="2" color="#FFFFFF"><font size="1">dominios 
                  alojados</font></font></font></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="2" align="center"> 
                  <table width="100%" border="0" cellspacing="1" cellpadding="0">
                    <tr align="center"> 
                      <td width="61%" bgcolor="#D6D6D6">nombre</td>
                      <td width="18%" bgcolor="#D6D6D6">disco usado</td>
                      <td width="21%" bgcolor="#D6D6D6">tr&aacute;fico</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
<?php
   $x=0;
   for($i=1;$i<=$total_registros;$i++){
   $rs = $conf->getConfigValue($i);
	if($rs){
		if($rs["IDCLIENTE"]==$_SESSION['SEC_ID']){ 
?>            <tr align="center"> 
                <td width="61%" align="left"><span class="Estilo5"><font color="#D65300">&nbsp; <a href="" class="naranja"><?php echo $rs["DOMINIO"]; ?></a></font></span></td>
                <td width="18%" align="right"><strong><span class="Estilo6">0.00&nbsp;</span></strong></td>
                <td width="21%" align="right"><span class="Estilo5"><b>0.00</b></span><b>&nbsp;</b></td>
              </tr>
  <?php 	$x++;
		}
	}	
   }

?>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="2"><?php echo $x; ?> Dominios en total</td>
          <td width="21%">&nbsp;</td>
        </tr>
      </table>
    </td>
    <td width="4%">&nbsp;</td>
    <td width="39%"> <br>
      <table width="266" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/fnd_disco.gif">
              <tr> 
                <td width="15%" align="center">&nbsp;</td>
                <td width="85%"><font face="Arial, Helvetica, sans-serif" size="1"><b><font color="#FFFFFF" size="3" face="Verdana, Arial, Helvetica, sans-serif">Espacio 
                  en disco</font><font color="#FFFFFF"><br>
                  </font></b></font><font size="1"><font color="#FFFFFF"><font size="1">consumo 
                  y disponibilidad</font></font></font><font size="1">&nbsp;</font></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center"> 
                <td width="46%" align="left" class="Estilo2">&nbsp;Espacio en 
                  disco</td>
                <td width="34%"><img src="images/barra_progreso.gif" width="120" height="11"></td>
              </tr>
              <tr align="center"> 
                <td width="46%" align="left" class="Estilo2">&nbsp;Espacio total 
                </td>
                <td width="34%" align="right"><b>500<font size="1"></font><font size="1"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></b></td>
              </tr>
              <tr align="center"> 
                <td width="46%" align="left" class="Estilo2">&nbsp;Espacio Usado</td>
                <td width="34%" align="right"><b>50<font size="2"></font><font size="2"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></b></td>
              </tr>
              <tr align="center"> 
                <td width="46%" align="left"><b>&nbsp;</b>Disponible</td>
                <td width="34%" align="right"><b>50<font size="2"></font><font size="2"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></b></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      <table width="266" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/fnd_trafico.gif">
              <tr> 
                <td width="15%" align="center">&nbsp;</td>
                <td width="85%"><font face="Arial, Helvetica, sans-serif" size="1"><b><font color="#FFFFFF" size="3" face="Verdana, Arial, Helvetica, sans-serif">Transferencia</font><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                  </font></b></font><font size="1"><font color="#FFFFFF">Transferencia 
                  de Datos</font></font><font size="1">&nbsp;</font></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr align="center"> 
                <td width="46%" align="left">&nbsp;Transferencia</td>
                <td width="34%"><img src="images/barra_progreso.gif" width="120" height="11"></td>
              </tr>
              <tr align="center"> 
                <td width="46%" align="left">&nbsp;L&iacute;mite Mensual </td>
                <td width="34%" align="right"><b>1000<font size="2"></font><font size="2"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></b></td>
              </tr>
              <tr align="center"> 
                <td width="46%" align="left">&nbsp;&Uacute;ltimo Mes </td>
                <td width="34%" align="right"><b>50<font size="2"></font><font size="2"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></b></td>
              </tr>
              <tr align="center"> 
                <td width="46%" align="left"><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Mes 
                  actual</font></td>
                <td width="34%" align="right"><b>50<font size="2"></font><font size="2"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></b></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

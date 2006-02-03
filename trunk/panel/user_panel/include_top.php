
<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr> 
    <td width="18%" rowspan="2"><img src="images/logo_baifox.gif" width="147" height="107"></td>
    <td width="82%" height="71"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#CD3500" width="82%">
            <div align="center"><img src="images/img_titulo.gif" width="257" height="79"></div>
          </td>
          <td bgcolor="#D65300" width="11%">&nbsp;</td>
          <td bgcolor="#E27400" width="5%">&nbsp;</td>
          <td bgcolor="#F2A500" width="2%">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td width="82%" bgcolor="#949494"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr align="center"> 
          <td width="150"><font color="#FFFFFF">[ <a href="index.php" class="blanco">inicio</a> 
            ]</font></td>
          <td width="150"><font color="#FFFFFF">[ ayuda ]</font></td>
          <td width="150"><font color="#FFFFFF">[ contacta ]</font></td>
          <td width="150"><font color="#FFFFFF">[ <a href="salir.php" class="blanco">cerrar sesi&oacute;n</a> 
            ] </font></td>
          <td width="150"><b></b></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php if($_GET['dominio']!=""){ ?>
<br>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr valign="middle"> 
    <td colspan="3">&nbsp;<img src="images/flechita.gif" width="6" height="10"> 
      <font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Dominio: 
      </b><font color="#CD3500">
      <a href="index.php?grupo=dominio&seccion=principal&pag=index&dominio=<?php echo $_GET['dominio']; ?>"><?php echo $_GET['dominio']; ?></a>
      </font></font></td>
  </tr>
</table>
<?php } ?>

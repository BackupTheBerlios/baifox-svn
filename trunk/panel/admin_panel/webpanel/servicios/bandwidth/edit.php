<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<?php
$totalhoy=banthwidth_calcular($_GET['dominio'],0);
$totalayer=banthwidth_calcular($_GET['dominio'],1);
?>
<form method="GET" action="index.php">
<input type="hidden" name="grupo" value="<?php echo $_GET['grupo']; ?>">
<input type="hidden" name="seccion" value="<?php echo $_GET['seccion']; ?>">
<input type="hidden" name="pag" value="<?php echo $_GET['pag']; ?>">
<input type="hidden" name="dominio" value="<?php echo $_GET['dominio']; ?>">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
  <font size="2" face="Arial, Helvetica, sans-serif">Estadísticas de ancho de banda Dominio</font><br>
<br>
<table width="75%" border="1" bordercolor="#333333" cellspacing="0" cellpadding="0">
  <tr> 
      <td valign="top" align="center"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3" height="121" align="center" bordercolor="#000000">
          <tr align="center" bgcolor="#CC3300"> 
            <td width="30%"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Concepto</font></b></font></td>
            <td width="70%"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Datos</font></b></td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td height="25" align="left" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Dominio</font></td>
            <td height="25" align="left"> 
              <?php echo $_GET['dominio']; ?>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Total Ancho Banda Ayer</font></td>
            <td> 
              <font face="Arial, Helvetica, sans-serif" size="2"><b><?php echo $totalayer; ?> MB</b></font>
            </td>
          </tr>
          <tr align="left" bgcolor="#FFFFFF"> 
            <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="2">Total Ancho Banda Hoy</font></td>
            <td> 
              <font face="Arial, Helvetica, sans-serif" size="2"><b><?php echo $totalhoy; ?> MB</b></font>
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php 
if($_GET['anio']!=""){
 $mAnio=$_GET['anio'];
}else{
 $mAnio=date("Y");
}
?>    
  <br>
  <table width="75%" border="1" bordercolor="#333333" cellspacing="0" cellpadding="0">
      <tr> 
        <td valign="top" align="center">          
        <table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
          <tr align="center" bgcolor="#CC3300"> 
            <td width="30%"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Seleccione 
              a&ntilde;o </font></b></font></td>
            <td width="70%" bgcolor="#FFFFFF"><b> 
              <select name="anio" onChange="javascript:submit();">
                <?php for($i=2000;$i<2150;$i++){ ?>
                <option value="<?php echo $i; ?>" <?php if($mAnio==$i){ echo "selected"; } ?>>
                <?php echo $i; ?>
                </option>
                <?php } ?>
              </select>
              </b></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    </form>
<br>
<?php echo banthwidth_estadisticas_mes($_GET['dominio'],$mAnio); ?>
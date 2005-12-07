<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=bandwidth_listdomains();
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag'];
include "include_top_numpage.php"; 
?>
<div align="center">
  <font size="2" face="Arial, Helvetica, sans-serif"><br>
  Listado Dominios</font><br>
  <br>
</div>
<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
  <tr align="center"> 
    <td bgcolor="#CC3300"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></font></td>
    <td width="6%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></b></td>
    <td width="28%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Mes <?php echo Mes(date("n")); ?></font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs){
		$variables=apache_domainread($rs);
		$estado=$variables["CFG_ESTADO"];
?>
  <tr align="left" <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="2" align="left"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&id=<?php echo $x; ?>&dominio=<?php echo $rs; ?>">
      <?php echo $rs; ?>
      </a> </font></td>
    <td width="6%" align="center" height="2"> 
      <?php if($estado){ ?>
      <img src="images/activo.gif" width="20" height="20"> 
      <?php }else{ ?>
      <img src="images/suspendido.gif" width="20" height="20"> 
      <?php } ?>
    </td>
    <td width="28%" align="center" height="2"> 
    <font face="Arial, Helvetica, sans-serif" size="2"><b><?php echo bandwidth_estadisticas_mes_total($rs,date("Y"),date("n")); ?></b></font>
    </td>
  </tr>
  <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}	
   }

?>
  <tr align="left"> 
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td width="6%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="28%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="left" bgcolor="#FFFFFF"> 
    <td colspan="3">&nbsp; </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>

<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=logrotate_listdomains();
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag'];
include "include_top_numpage.php"; 
?>
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Listado Logrotate.</font><br>
  <br>
</div>
<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
  <tr align="center"> 
    <td bgcolor="#CC3300" width="87%"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></font></td>
    <td width="13%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Acciones</font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs){
?>
  <tr align="left" <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="2" align="left" width="87%"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <?php echo $rs; ?>
      </font></td>
    <td width="13%" valign="top" align="center" height="2"><a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?id=<?php echo $x; ?>&dominio=<?php echo $rs; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs; ?>?')"><img src="images/icn_borrar.gif" width="20" height="20" border="0"></a> 
    </td>
  </tr>
  <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}	
   }

?>
  <tr align="left"> 
    <td bgcolor="#FFFFFF" width="87%">&nbsp;</td>
    <td width="13%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="left" bgcolor="#FFFFFF"> 
    <td colspan="2"> 
      <table width="40%" border="0" align="right">
        <tr> 
          <td width="93%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=nuevo"><font size="2" face="Arial, Helvetica, sans-serif">A&ntilde;adir 
            Nuevo Logrotate</font></a></td>
          <td width="7%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=nuevo"><img src="images/icn_nuevo.gif" width="20" height="20" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>


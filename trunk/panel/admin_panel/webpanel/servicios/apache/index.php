<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=apache_listdomains();
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag'];
include "include_top_numpage.php"; 
?>
<div align="center">
  <table width="75%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
    <tr> 
      <td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=accion&accion=start">Arrancar 
        servicio </a></font></td>
      <td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=accion&accion=restart">Aplicar 
        cambios</a></font></td>
      <td align="center"><font face="Arial, Helvetica, sans-serif" size="2"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=accion&accion=stop">Parar 
        servicio</a></font></td>
    </tr>
  </table>
  <font size="2" face="Arial, Helvetica, sans-serif"><br>
  Listado Dominios Apache</font><br>
  <br>
</div>
<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
  <tr align="center"> 
    <td bgcolor="#CC3300"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></font></td>
    <td width="6%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></b></td>
    <td width="28%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Acciones</font></b></td>
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
    <td height="2" align="left"><font face="Arial, Helvetica, sans-serif" size="2"> <a href="http://<?php echo $rs; ?>" target="_blank"> 
      <?php echo $rs; ?>
      </a> </font></td>
    <td width="6%" align="center" height="2"> 
      <?php if($estado){ ?>
      <img src="images/icn_activo.gif" width="20" height="20"> 
      <?php }else{ ?>
      <img src="images/icn_suspendido.gif" width="20" height="20"> 
      <?php } ?>
    </td>
    <td width="28%" valign="top" align="center" height="2"> <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&id=<?php echo $x; ?>&dominio=<?php echo $rs; ?>"><img src="images/icn_editar.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/estado.php?id=<?php echo $x; ?>&dominio=<?php echo $rs; ?>&estado=<?php echo $estado; ?>"><img src="images/icn_suspendido.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?id=<?php echo $x; ?>&dominio=<?php echo $rs; ?>" onclick="return confirmLink(this, '�Desea borrar <?php echo $rs; ?>?')"><img src="images/icn_borrar.gif" width="20" height="20" border="0"></a></td>
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
    <td colspan="3"> 
      <table width="40%" border="0" align="right">
        <tr> 
          <td width="93%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=nuevo"><font size="2" face="Arial, Helvetica, sans-serif">A&ntilde;adir 
            Nuevo Dominio</font></a></td>
          <td width="7%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=nuevo"><img src="images/icn_nuevo.gif" width="20" height="20" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>

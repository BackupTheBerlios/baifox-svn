<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
include "webpanel/".$_GET['grupo']."/".$_GET['seccion']."/menu.php"; 
?>
<?php
$array_listado=vpopmail_listautorespuesta($_GET['dominio']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Listado 
  Autorespuesta[ 
  <?php echo $_GET['dominio']; ?>
  ]</font><br>
  <br>
</div>
<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
  <tr> 
    <td bgcolor="#CC3300" align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">Cuenta 
      Autorespuesta </font></b></font></td>
    <td width="14%" bgcolor="#CC3300" align="center"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Acciones</font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs["cuenta"]!=""){
?>
  <tr <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="2" align="left"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <?php echo $rs["cuenta"]; ?>
      </font></td>
    <td width="14%" valign="top" align="center" height="2"> <a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/autorespond_delete.php?id=<?php echo $x; ?>&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs["cuenta"]; ?>?')"><img src="images/borrar.gif" width="20" height="20" border="0"></a></td>
  </tr>
  <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}
   }

?>
  <tr> 
    <td bgcolor="#FFFFFF" align="left">&nbsp;</td>
    <td width="14%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="2" align="left"> 
      <table width="70%" border="0" align="right">
        <tr> 
          <td width="93%" height="9" align="right"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=autorespond_nuevo&dominio=<?php echo $_GET['dominio']; ?>"><font size="2" face="Arial, Helvetica, sans-serif">A&ntilde;adir 
            Nuevo Autorespuesta [ 
            <?php echo $_GET['dominio']; ?>
            ]</font></a></td>
          <td width="7%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=autorespond_nuevo&dominio=<?php echo $_GET['dominio']; ?>"><img src="images/users_navbar_icon.gif" width="20" height="20" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>


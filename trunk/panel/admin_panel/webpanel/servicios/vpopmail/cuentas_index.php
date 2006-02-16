<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
include "webpanel/".$_GET['grupo']."/".$_GET['seccion']."/menu.php"; 
?>
<?php
$array_listado=vpopmail_listcuentas($_GET['dominio']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Listado Cuentas [<?php echo $_GET['dominio']; ?>]</font><br>
  <br>
</div>
<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
  <tr align="center"> 
    <td width="43%" bgcolor="#CC3300"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></font></td>
    <td bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Cuentas</font></b></td>
    <td bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></b></td>
    <td width="28%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Acciones</font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs["cuenta"]!=""){
		$estado=vpopmail_cuentalimits($rs["cuenta"],$_GET['dominio'],"estado");
?>
  <tr align="left" <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="2" align="left" width="43%"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <?php echo $rs["cuenta"]; ?>
      </font></td>
    <td width="23%" align="center" height="2"> 
      <font face="Arial, Helvetica, sans-serif" size="2"><b><?php echo $rs["quota"]; ?></b></font>
    </td>
    <td width="6%" align="center" height="2"> 
      <?php if($estado==1){ ?>
      <img src="images/icn_activo.gif" width="20" height="20"> 
      <?php }else{ ?>
      <img src="images/icn_suspendido.gif" width="20" height="20"> 
      <?php } ?>
    </td>
    <td width="28%" valign="top" align="center" height="2"> <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=cuentas_edit&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>&id=<?php echo $x; ?>"><img src="images/icn_editar.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/cuentas_estado.php?id=<?php echo $x; ?>&estado=<?php echo $estado; ?>&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>"><img src="images/icn_suspendido.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/cuentas_delete.php?id=<?php echo $x; ?>&usuario=<?php echo $rs["cuenta"]; ?>&dominio=<?php echo $_GET['dominio']; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs["cuenta"]."@".$_GET['dominio']; ?>?')"><img src="images/icn_borrar.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=mailus&email=<?php echo $rs["cuenta"]."@".$_GET['dominio']; ?>&id=<?php echo $x; ?>"><img src="images/icn_mail.gif" border="0" width="20" height="20" alt="Enviar email: <?php echo $rs["cuenta"]."@".$_GET['dominio']; ?>"></a></td>
  </tr>
  <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}
   }

?>
  <tr align="left"> 
    <td bgcolor="#FFFFFF" width="43%">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="28%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="left" bgcolor="#FFFFFF"> 
    <td colspan="4"> 
      <table width="40%" border="0" align="right">
        <tr> 
          <td width="93%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=cuentas_nuevo&dominio=<?php echo $_GET['dominio']; ?>"><font size="2" face="Arial, Helvetica, sans-serif">A&ntilde;adir 
            Nuevo Cuenta [<?php echo $_GET['dominio']; ?>]</font></a></td>
          <td width="7%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=cuentas_nuevo&dominio=<?php echo $_GET['dominio']; ?>"><img src="images/icn_nuevo.gif" width="20" height="20" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>


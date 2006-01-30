<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_DOMINIOS);
$total_registros=count($conf->getConfigValue());
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag'];
include "include_top_numpage.php"; 
?>
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Listado Dominios.</font><br>
  <br>
</div>
<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
  <tr align="center"> 
    <td width="46%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></td>
    <td width="14%" bgcolor="#CC3300"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">Generar</font></b></td>
    <td width="10%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></b></td>
    <td width="30%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Acciones</font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;

   if($total_registros>0)
	$array_mostrar=array_ordenar_campo($conf->getConfigValue(),"DOMINIO");
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs = $array_mostrar[$i];
	if($rs){
?>
  <tr align="left" <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="2" align="left" width="46%"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <?php echo $rs["DOMINIO"]; ?>
      </font></td>
    <td height="2" align="center" width="14%"> 
      <form name="form1" method="post" action="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=generar&id=<?php echo $rs["ID"]; ?>">
      <input type="submit" name="btngenerar" value="generar">
      </form>
    </td>
    <td width="10%" align="center" height="2"> 
      <?php if($rs["ESTADO"]==1){ ?>
      <img src="images/activo.gif" width="20" height="20"> 
      <?php }else{ ?>
      <img src="images/suspendido.gif" width="20" height="20"> 
      <?php } ?>
    </td>
    <td width="30%" valign="top" align="center" height="2"> <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&id=<?php echo $rs["ID"]; ?>"><img src="images/escribir.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/estado.php?id=<?php echo $rs["ID"]; ?>&estado=<?php echo $rs["ESTADO"]; ?>"><img src="images/suspender.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=confirmar&id=<?php echo $rs["ID"]; ?>&dominio=<?php echo $rs["DOMINIO"]; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs["DOMINIO"]; ?>?')"><img src="images/borrar.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=mailus&id=<?php echo $rs["IDCLIENTE"]; ?>"><img src="images/btnmail.gif" border="0" width="20" height="20" alt="Enviar email: <?php echo $rs["DOMINIO"]; ?>"></a></td>
  </tr>
  <?php 	$x++;
		flush();
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}	
   }

?>
  <tr align="left"> 
    <td bgcolor="#FFFFFF" width="46%">&nbsp;</td>
    <td bgcolor="#FFFFFF" width="14%">&nbsp;</td>
    <td width="10%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="30%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="left" bgcolor="#FFFFFF"> 
    <td colspan="4"> 
      <table border="0" align="right" width="200">
        <tr> 
          <td height="9"><font size="2" face="Arial, Helvetica, sans-serif"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=nuevo">A&ntilde;adir 
            Nuevo Dominio</a></font></td>
          <td width="7%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=nuevo"><img src="images/users_navbar_icon.gif" width="20" height="20" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>

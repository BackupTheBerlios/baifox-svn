<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_DOMINIOS);
$array_listado=$conf->getConfigValue();
//Busca dato si se ha solicitado
if(trim($_GET['fndBusqueda'])!=""){
	$array_busqueda=Array();
	foreach ($array_listado as $value) {
   		if(stripos($value["DOMINIO"],$_GET['fndBusqueda'])!==false){
			$array_busqueda[]=$value;
		}
	}
	$array_listado=$array_busqueda;
}
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag'];
include "include_top_numpage.php"; 
?>
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Listado Dominios.</font><br>
    <table border="1" width="552" align="center" cellspacing="0" bordercolor="#999999">
      <tr> 
        <td align="center" valign="middle"> 
   <form name="frmBusqueda" action="index.php" method="get" onSubmit="return checkForm(this);">
	<input type="hidden" name="grupo" size="46" maxlength="150" value="<?php echo $_GET['grupo']; ?>">
        <input type="hidden" name="seccion" size="46" maxlength="150" value="<?php echo $_GET['seccion']; ?>">
        <input type="hidden" name="pag" size="46" maxlength="150" value="<?php echo $_GET['pag']; ?>">
            <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Buscar:</b></font> 
            <select name=searchby  size=1>
              <option value="dominio">dominio</option>
            </select>
          <input type=text name=fndBusqueda size=40 value=''>
            <input type="submit" value="Buscar" name="submit">
          </form>
        </td>
      </tr>
    </table>  
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
	$array_mostrar=array_ordenar_campo($array_listado,"DOMINIO");
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
      <img src="images/icn_activo.gif" width="20" height="20"> 
      <?php }else{ ?>
      <img src="images/icn_suspendido.gif" width="20" height="20"> 
      <?php } ?>
    </td>
    <td width="30%" valign="top" align="center" height="2"> <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&id=<?php echo $rs["ID"]; ?>"><img src="images/icn_editar.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/estado.php?id=<?php echo $rs["ID"]; ?>&estado=<?php echo $rs["ESTADO"]; ?>"><img src="images/icn_suspendido.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=confirmar&id=<?php echo $rs["ID"]; ?>&dominio=<?php echo $rs["DOMINIO"]; ?>" onclick="return confirmLink(this, '�Desea borrar <?php echo $rs["DOMINIO"]; ?>?')"><img src="images/icn_borrar.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=mailus&id=<?php echo $rs["IDCLIENTE"]; ?>"><img src="images/icn_mail.gif" border="0" width="20" height="20" alt="Enviar email: <?php echo $rs["DOMINIO"]; ?>"></a></td>
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
          <td width="7%" height="9"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=nuevo"><img src="images/icn_nuevo.gif" width="20" height="20" border="0"></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>

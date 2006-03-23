<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=bind_listdomains();
//Busca dato si se ha solicitado
if(trim($_GET['fndBusqueda'])!=""){
	$array_busqueda=Array();
	foreach ($array_listado as $value) {
   		if(stripos($value,$_GET['fndBusqueda'])!==false){
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
<div align="center">
<font size="2" face="Arial, Helvetica, sans-serif">Listado Bind.</font><br>
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
<br>
</div>
<table width="80%" border="1" cellspacing="0" cellpadding="3" align="center" bordercolor="#000000">
  <tr align="center"> 
    <td bgcolor="#CC3300"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></font></td>
    <td width="28%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Acciones</font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs){
?>
  <tr align="left" <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="2" align="left"><font face="Arial, Helvetica, sans-serif" size="2">
      <?php echo $rs; ?>
      </font></td>
    <td width="28%" valign="top" align="center" height="2"> <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&dominio=<?php echo $rs; ?>&id=<?php echo $x; ?>"><img src="images/icn_editar.gif" width="20" height="20" border="0"></a> 
      &nbsp;&nbsp;&nbsp;<a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete.php?id=<?php echo $x; ?>&dominio=<?php echo $rs; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs; ?>?')"><img src="images/icn_borrar.gif" width="20" height="20" border="0"></a> 
    </td>
  </tr>
  <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}	
   }

?>
  <tr align="left"> 
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td width="28%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="left" bgcolor="#FFFFFF"> 
    <td colspan="2"> 
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


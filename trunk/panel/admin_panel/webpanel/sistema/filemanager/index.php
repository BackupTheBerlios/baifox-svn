<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=apache_listdomains();
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
  <font size="2" face="Arial, Helvetica, sans-serif">Listado Dominios</font><br>
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
    <td bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs){
?>
  <tr align="left" <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="30" align="left"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <a href="javascript:Ventana('webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/filemanager.php?dominio=<?php echo $rs; ?>');" > 
      <?php echo $rs; ?>
      </a> </font></td>
  </tr>
  <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}	
   }

?>
  <tr align="left"> 
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="left" bgcolor="#FFFFFF"> 
    <td>&nbsp; </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>

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
  <font size="2" face="Arial, Helvetica, sans-serif"><br>
  Listado Dominios</font><br>
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
    <td bgcolor="#CC3300" width="51%"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Dominio</font></b></font></td>
    <td bgcolor="#CC3300" width="9%"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Estado</font></b></td>
    <td width="13%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ancho 
      Banda Asignado</font></b></td>
    <td width="13%" bgcolor="#CC3300"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Ancho 
      Banda<br>
      Consumido </font><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Mes 
      <?php echo Mes(date("n")); ?>
      </font></b></td>
    <td width="14%" bgcolor="#CC3300"><b><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">Ancho 
      Banda Disponible 
      <?php echo Mes(date("n")); ?>
      </font></b></td>
  </tr>
  <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs){
		$nombre_cliente="";
		$ancho_banda_total=0;

		$variables=apache_domainread($rs);
		$estado=$variables["CFG_ESTADO"];
		$rs_dominio=xmlconfig_buscar(_CFG_XML_DOMINIOS,"DOMINIO",trim($rs),"","","datos");
		if ($rs_dominio){ 
			$rs_cliente=xmlconfig_buscar(_CFG_XML_CLIENTES,"ID",trim($rs_dominio["IDCLIENTE"]),"","","datos");
			if ($rs_cliente){ 
				$ancho_banda_total=$rs_cliente["ANCHOBANDA"];
				$nombre_cliente=$rs_cliente["NOMBRE"];
			}else{
				$ancho_banda_total=0;
			}
		}else{
			$ancho_banda_total=0;
		}
		$total_usado=bandwidth_estadisticas_mes_total($rs,date("Y"),date("n"));
		$total_disponible=$ancho_banda_total-$total_usado;
?>
  <tr align="left" <?php if($bool_celdcolor){ echo "class=fondocelda1"; }else{ echo "class=fondocelda2"; } ?>> 
    <td height="2" align="left" width="51%"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <div title="<?php echo $nombre_cliente; ?>"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=edit&id=<?php echo $x; ?>&dominio=<?php echo $rs; ?>"> 
      <?php echo $rs; ?>
      </a></div></font></td>
    <td height="2" align="center" width="9%"> 
      <?php if($estado){ ?>
      <img src="images/icn_activo.gif" width="20" height="20"> 
      <?php }else{ ?>
      <img src="images/icn_suspendido.gif" width="20" height="20"> 
      <?php } ?>
    </td>
    <td width="13%" align="center" height="2"><font face="Arial, Helvetica, sans-serif" size="2">
      <?php echo number_format($ancho_banda_total,2,",",".")." MB"; ?>
      </font> </td>
    <td width="13%" align="center" height="2"> <font face="Arial, Helvetica, sans-serif" size="2"> 
      <?php echo number_format($total_usado,2,",",".")." MB"; ?>
      </font> </td>
    <td width="14%" align="center" height="2"><font face="Arial, Helvetica, sans-serif" size="2"> 
      <?php echo number_format($total_disponible,2,",",".")." MB"; ?>
      <br>
      </font></td>
  </tr>
  <?php 	flush();	
  			$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}	
   }

?>
  <tr align="left"> 
    <td bgcolor="#FFFFFF" width="51%">&nbsp;</td>
    <td bgcolor="#FFFFFF" width="9%">&nbsp;</td>
    <td width="13%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="13%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="14%" align="center" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="left" bgcolor="#FFFFFF"> 
    <td colspan="5">&nbsp; </td>
  </tr>
</table>
<?php include "include_bottom_numpage.php"; ?>

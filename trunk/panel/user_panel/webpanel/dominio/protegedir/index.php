<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=filesystem_listdirectories($_GET['dominio']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_correo.gif" width="47" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Proteger 
                  directorios </font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;directorio</span></td>
                <td bgcolor="#d6d6d6" align="right" width="15%">&nbsp; </td>
              </tr>
              <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=$numpage_regpage AND $x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs!=""){
?>
              <tr align="center"> 
                <td align="left"> 
                  <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=directorio&directorio=<?php echo $rs; ?>&dominio=<?php echo $_GET['dominio']; ?>&id=<?php echo $x; ?>"><?php echo $rs; ?></a>
                </td>
                <td width="15%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=directorio&directorio=<?php echo $rs; ?>&dominio=<?php echo $_GET['dominio']; ?>&id=<?php echo $x; ?>"><img src="images/icn_protegeroff.gif" width="30" height="30" border="0"></a></td>
              </tr>
              <tr align="center"> 
                <td colspan="2" align="left" bgcolor="#d6d6d6"><img src="#" width="1" height="1"> 
                </td>
              </tr>
              <?php 	$x++;
        	if($bool_celdcolor){ $bool_celdcolor=false; }else{ $bool_celdcolor=true; }
	}
   }

?>
            </table>
          </td>
        </tr>
      </table>
      <br>
    </td>
  </tr>
</table>

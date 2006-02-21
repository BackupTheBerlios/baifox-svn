<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
?>
<?php
$array_listado=ezmlm_listasucritos($_GET['dominio'],$_GET['lista'],$_GET['tipo']);
$total_registros=count($array_listado);
$numpage_total=$total_registros;
$numpage_urlweb="index.php?grupo=".$_GET['grupo']."&seccion=".$_GET['seccion']."&pag=".$_GET['pag']."&dominio=".$_GET['dominio'];
include "include_top_numpage.php"; 
?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="40%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr align="center"> 
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2">[ 
          <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=<?php echo $_GET['pag']; ?>&dominio=<?php echo $_GET['dominio']; ?>&lista=<?php echo $_GET['lista']; ?>&tipo=all">suscriptores</a> ]</font></b></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2">[ 
          <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=<?php echo $_GET['pag']; ?>&dominio=<?php echo $_GET['dominio']; ?>&lista=<?php echo $_GET['lista']; ?>&tipo=mod">moderadores</a> ]</font></b></font></td>
        </tr>
      </table>
      <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_correo.gif" width="47" height="34"></td>
                <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">
<?php switch($_GET['tipo']){
	case "mod":
		echo "Moderadores";
	break;
	default:
		echo "Suscriptores";
	break;
     }
?> lista de correo [ <?php echo $_GET['lista']; ?> ]</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr align="center"> 
                <td align="left" bgcolor="#d6d6d6"><span class="Estilo5">&nbsp;&nbsp;lista</span><span class="Estilo5">&nbsp;&nbsp;</span></td>
                <td bgcolor="#d6d6d6" align="right" width="15%">&nbsp; </td>
              </tr>
              <?php
   $bool_celdcolor=false;

   $x=1;
   for($i=$from;$x<=($total_registros-$from);$i++){
   $rs =$array_listado[$i];
	if($rs!=""){
?>
              <tr align="center"> 
                <td align="left"> 
                  <?php echo $rs; ?>
                </td>
                <td width="15%" align="center"><a href="webpanel/<?php echo $_GET['grupo']; ?>/<?php echo $_GET['seccion']; ?>/delete_email.php?id=<?php echo $x; ?>&usuario=<?php echo $rs; ?>&dominio=<?php echo $_GET['dominio']; ?>&lista=<?php echo $_GET['lista']; ?>&tipo=<?php echo $_GET['tipo']; ?>" onclick="return confirmLink(this, '¿Desea borrar <?php echo $rs; ?>?')"><img src="images/icn_eliminar.gif" width="30" height="30" border="0"></a></td>
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
<form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save_email.php?id=0&dominio=<?php echo $_GET['dominio']; ?>">
<input type="hidden" name="frmLista" value="<?php echo $_GET['lista']; ?>">
<input type="hidden" name="frmTipo" value="<?php echo $_GET['tipo']; ?>">
	<table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
          <td colspan="3" bgcolor="#F2A500">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
                  <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">A&ntilde;adir 
                    email a la lista</font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF"> 
                    [ 
                    <?php echo $_GET['lista']; ?>
                    ]</font></b></font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3"> 
              <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr align="center"> 
                  <td width="15%" align="left" bgcolor="#d6d6d6">&nbsp;&nbsp;email</td>
                  <td width="59%" align="left" bgcolor="#d6d6d6"> 
                    <input type="text" name="frmEmail" class="boxBlur" onfocus="this.className='boxFocus'"  onblur="this.className='boxBlur'" size="35">
                  </td>
                  <td bgcolor="#d6d6d6" align="center" width="26%"><a href="#"><img src="images/icn_grabar.gif" width="25" height="25" border="0" onclick="document.formulario.submit()"></a></td>
                </tr>
              </table>
          </td>
        </tr>
      </table>
</form>
    </td>
  </tr>
</table>

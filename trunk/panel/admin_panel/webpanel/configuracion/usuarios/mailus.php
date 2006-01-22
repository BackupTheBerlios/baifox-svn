<?php include "webpanel/".$_GET['grupo']."/include_permiso.php";  ?>
<p align="center"><b><font face="Arial, Helvetica, sans-serif" size="2">
<?php if($enviado<>""){
 	echo "El mensaje ha sido enviado correctamente";
}?>
</font></b></p>
<form action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/enviauser.php?id=<?php echo $id; ?>" method="POST"> 
  <table width="80%" border="1" cellspacing="0" cellpadding="3" height="121" align="center" bordercolor="#000000">
    <tr align="center" bgcolor="#CC3300"> 
      <td width="19%"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Enviar 
        a: </font></b></td>
      <td width="37%" align="left"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
        <?php
$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_USUARIOS);
$rs=$conf->getConfigValue(busca_xml_id($_GET['id'],_CFG_XML_USUARIOS));
echo $rs["NOMBRE"];
?>
        </font></b></td>
      <td align="center" width="25%"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2" face="Arial, Helvetica, sans-serif">Tipo 
        Email:</font></b></font></td>
      <td width="19%" align="left"> 
        <select name="frmTipoEmail">
          <option value="1" selected>SIN PLANTILLA</option>
        </select>
      </td>
    </tr>
    <tr align="left"> 
      <td bgcolor="#CC3300" align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Asunto: 
        </font></b></font></td>
      <td bgcolor="#FFFFFF" colspan="3"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        <input type="text" name="frmAsunto" size="55">
        </font></td>
    </tr>
    <tr align="center" bgcolor="#FFFFFF"> 
      <td colspan="4"> <font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Texto</font><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">: 
        </font></b></font><br>
        <textarea rows="6" name="frmMensaje" cols="55"></textarea>
      </td>
    </tr>
  </table>
  <p align="center">
<input type="submit" value="Enviar" name="BtnEnviar">
    <input type="reset" value="Borrar" name="BtnBorrar">
  </p>
</form>

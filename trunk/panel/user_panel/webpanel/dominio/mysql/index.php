<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
if($_GET['base']!=""){
	$basedatos=$_GET['base'];
}else{
	$basedatos=xmlconfig_buscadbase($_GET['dominio'],"database");
}
?> 
<script  language="JavaScript" type="text/javascript">
<!-- 

  imagenOn = new Image(13,13);
  imagenOn.src = "images/plus.gif";
  imagenOn = new Image(13,13);
  imagenOn.src = "images/minus.gif";

-->
</script>
<style type="text/css">
<!--
.showstate{ /*Definition for state toggling image */
	cursor:hand;
	cursor:pointer;
	float: right;
	margin-top: 2px;
	margin-right: 3px;
}

.headers{
	width: 600px;
	font-size: 120%;
	font-weight: bold;
	border: 1px solid #d6d6d6;
	background-color: #E27400;
}

.switchcontent{
	width: 600px;
	border: 1px solid #d6d6d6;
	border-top-width: 0;
}
-->
</style>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" height="400">
  <tr valign="top"> 
    <td> <br>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td colspan="3" bgcolor="#E27400"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="12%" align="center" height="33"><img src="images/icn_cseguridad_sub.gif" width="47" height="34"></td>
                <td width="88%" height="33"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Base 
                  de datos</font></b></font></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr align="center"> 
          <td colspan="3">
	          <table width="100%" border="0" cellspacing="2" cellpadding="0">
                <tr> 
                  <td align="left" bgcolor="#d6d6d6" width="25%"><span class="Estilo5">&nbsp;&nbsp;Nombre 
                    base datos</span></td>
                  <td align="left" bgcolor="#d6d6d6" width="23%"><span class="Estilo5">&nbsp;&nbsp;Usuario 
                    base datos</span></td>
                  <td align="left" bgcolor="#d6d6d6" width="30%"><span class="Estilo5">&nbsp;&nbsp;</span>Contrase&ntilde;a</td>
                  <td align="left" bgcolor="#d6d6d6" width="11%"><span class="Estilo5">&nbsp;modificar/phpmyadmin&nbsp;</span></td>
                  <td align="left" bgcolor="#d6d6d6" width="11%">chequear/reparar</td>
                </tr>
<?php 
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_BASEDATOS);
	$total_registros=count($conf->getConfigValue());
	for($i=1;$x<$total_registros;$i++){
		$rs=$conf->getConfigValue($i);
		if($rs["DOMINIO"]==$_GET['dominio']){
?>
	<form method="POST" name="formulario<?php echo $rs["DATABASE"]; ?>" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=1&dominio=<?php echo $_GET['dominio']; ?>">
	<input type="hidden" name="frmBase" value="<?php echo $rs["DATABASE"]; ?>">
                <tr> 
                  <td align="left" width="25%"> 
                    <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=index&dominio=<?php echo $_GET['dominio']; ?>&base=<?php echo $rs["DATABASE"]; ?>"><?php echo $rs["DATABASE"]; ?></a>
                  </td>
                  <td align="left" width="23%"> 
                    <?php echo $rs["USUARIO"]; ?>
                  </td>
                  <td align="left" width="30%"> 
                    <input type="text" name="frmPassword" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'" size="14" maxlength="14">
                    Max 14 car.</td>
                  <td width="11%" align="center"> <a href="javascript:document.formulario<?php echo $rs["DATABASE"]; ?>.submit();"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a> 
                    &nbsp;&nbsp;&nbsp;<a href="Javascript:Ventana('<?php echo _CFG_USERINTERFACE_PHPMYADMIN; ?>?pma_username=<?php echo $rs["USUARIO"]; ?>&pma_password=<?php echo md5_decrypt($rs['PASSWORD'],_CFG_INTERFACE_BLOWFISH); ?>');"><img src="images/icn_phpmyadmin_mini.gif" width="30" height="30" border="0"></a></td>
                  <td width="11%" align="center"><a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=mantener&accion=check&dominio=<?php echo $_GET['dominio']; ?>&base=<?php echo $rs["DATABASE"]; ?>"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a> 
                    &nbsp;&nbsp;&nbsp;<a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=mantener&accion=repair&dominio=<?php echo $_GET['dominio']; ?>&base=<?php echo $rs["DATABASE"]; ?>"><img src="images/icn_editar.gif" width="30" height="30" border="0"></a></td>
                </tr>
	</form>
<?php 
		}
		if($rs)
			$x++;
	}
?>
                <tr> 
                  <td align="left" bgcolor="#d6d6d6" colspan="5"><img src="#" width="1" height="1"> 
                  </td>
                </tr>
              </table>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" width="550">
              <tr> 
                <td align="center" bgcolor="#E27400"><font color="#FFFFFF"><b>Datos 
                  conexi&oacute;n MySQL</b></font></td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFCC" valign="top"> <span class="Estilo5">
                  <p>Servidor: localhost<br>
                    Nombre base datos: 
                    <?php echo $basedatos; ?>
                    <br>
                    Usuario base datos: 
                    <?php echo $basedatos; ?>
                    <br>
                    Contrase&ntilde;a: (la que elija)</p>
                  </span> </td>
              </tr>
            </table>
            <br>
            <table border="0" cellspacing="0" cellpadding="0" width="550">
              <tr> 
                <td align="center" bgcolor="#E27400"><font color="#FFFFFF"><b>Ejemplo 
                  conexi&oacute;n PHP</b></font></td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFCC" valign="top"> 
                  <pre><span class="Estilo5">
function Conectarse()
{ 
	if (!($link=mysql_connect(&quot;localhost&quot;,&quot;<?php echo $basedatos; ?>&quot;,&quot;******&quot;)))
	{
		echo &quot;Error conectando a la base de datos.&quot;;<br>
		exit();
	}
	if (!mysql_select_db(&quot;<?php echo $basedatos; ?>&quot;,$link))<br>
	{
		echo &quot;Error seleccionando la base de datos.&quot;;<br>
		exit();
	}
return $link;
}</span></pre>
                </td>
              </tr>
            </table>
            <p>&nbsp; </p>
            <table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr> 
                <td align="center"> <a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=generar&dominio=<?php echo $_GET['dominio']; ?>&tipo=basedatos"> 
                  </a> 
			<div class="headers"><img src="images/minus.gif" class="showstate" onClick="expandcontent(this, 'sc1')" /><font size="2" color="#FFFFFF">Contenido de la base de datos [<?php echo $basedatos; ?>]</font></div>
			<div id="sc1" class="switchcontent" style="display:none"><br>
			<?php echo db_mysql_showstatus($basedatos); ?>
			</div>
                </td>
              </tr>
              <tr> 
                <td align="left" bgcolor="#d6d6d6"><img src="#" width="1" height="1"> 
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
    </td>
  </tr>
</table>
<script type="text/javascript">
<!--
/***********************************************
* Switch Content script II- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use. Last updated April 2nd, 2005.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var enablepersist="off" //Enable saving state of content structure using session cookies? (on/off)
var memoryduration="7" //persistence in # of days

var contractsymbol='images/minus.gif' //Path to image to represent contract state.
var expandsymbol='images/plus.gif' //Path to image to represent expand state.

/////No need to edit beyond here //////////////////////////

function getElementbyClass(rootobj, classname){
	var temparray=new Array()
	var inc=0
	var rootlength=rootobj.length
	for (i=0; i<rootlength; i++){
		if (rootobj[i].className==classname)
		temparray[inc++]=rootobj[i]
	}
	return temparray
}

function sweeptoggle(ec){
	var inc=0
	while (ccollect[inc]){
		ccollect[inc].style.display=(ec=="contract")? "none" : ""
		inc++
	}
	revivestatus()
}

function expandcontent(curobj, cid){
	if (ccollect.length>0){
		document.getElementById(cid).style.display=(document.getElementById(cid).style.display!="none")? "none" : ""
		curobj.src=(document.getElementById(cid).style.display=="none")? expandsymbol : contractsymbol
	}
}

function revivecontent(){
	selectedItem=getselectedItem()
	selectedComponents=selectedItem.split("|")
	for (i=0; i<selectedComponents.length-1; i++)
		document.getElementById(selectedComponents[i]).style.display="none"
}

function revivestatus(){
	var inc=0
	while (statecollect[inc]){
		if (ccollect[inc].style.display=="none")
			statecollect[inc].src=expandsymbol
		else
			statecollect[inc].src=contractsymbol
		inc++
	}
}

function get_cookie(Name) { 
	var search = Name + "="
	var returnvalue = "";
	if (document.cookie.length > 0) {
		offset = document.cookie.indexOf(search)
		if (offset != -1) { 
			offset += search.length
			end = document.cookie.indexOf(";", offset);
			if (end == -1) end = document.cookie.length;
			returnvalue=unescape(document.cookie.substring(offset, end))
		}
	}
return returnvalue;
}

function getselectedItem(){
	if (get_cookie(window.location.pathname) != ""){
		selectedItem=get_cookie(window.location.pathname)
		return selectedItem
	}
	else
		return ""
}

function saveswitchstate(){
	var inc=0, selectedItem=""
	while (ccollect[inc]){
		if (ccollect[inc].style.display=="none")
		selectedItem+=ccollect[inc].id+"|"
		inc++
	}
	if (get_cookie(window.location.pathname)!=selectedItem){ //only update cookie if current states differ from cookie's
		var expireDate = new Date()
		expireDate.setDate(expireDate.getDate()+parseInt(memoryduration))
		document.cookie = window.location.pathname+"="+selectedItem+";path=/;expires=" + expireDate.toGMTString()
	}
}

function do_onload(){
	uniqueidn=window.location.pathname+"firsttimeload"
	var alltags=document.all? document.all : document.getElementsByTagName("*")
	ccollect=getElementbyClass(alltags, "switchcontent")
	statecollect=getElementbyClass(alltags, "showstate")
	if (enablepersist=="on" && get_cookie(window.location.pathname)!="" && ccollect.length>0)
		revivecontent()
	if (ccollect.length>0 && statecollect.length>0)
		sweeptoggle('contract');		
}

if (window.addEventListener)
	window.addEventListener("load", do_onload, false)
else if (window.attachEvent)
	window.attachEvent("onload", do_onload)
else if (document.getElementById)
	window.onload=do_onload

if (enablepersist=="on" && document.getElementById)
	window.onunload=saveswitchstate
-->
</script>

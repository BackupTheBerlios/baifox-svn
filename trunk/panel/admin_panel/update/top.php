<?php 
     include "../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "include_permiso.php"; ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" type="text/javascript">
 <!--
   function actualizar(){
     if(window.confirm("¿Esta seguro de que desea actualizar?")){
     	parent.principal.location.href="main.php?actualizar=ok";
      }
   }
	/*************************************************************************
  	This code is from Dynamic Web Coding at http://www.dyn-web.com/
  	See Terms of Use at http://www.dyn-web.com/bus/terms.html
  	regarding conditions under which you may use this code.
  	This notice must be retained in the code as is!
	*************************************************************************/
	var timer_id;
	function scroll_iframe(frm,inc,dir) {
  		if (window.parent.frames[frm]) {
    			if (dir == "v") window.parent.frames[frm].scrollBy(0, inc);
    			else window.parent.frames[frm].scrollBy(inc, 0);
    				timer_id = setTimeout("scroll_iframe('" + frm + "'," + inc + ",'" + dir + "')", 20);
  		}
	}
	scroll_iframe("principal", 20, 'v');
//-->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<base target="principal">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr align="center"> 
    <td><a href="main.php"><img src="images/baifox.gif" width="110" height="93" border="0"></a></td>
    <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Actualizaci&oacute;n 
      Manual Baifox</font></b></td>
    <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Versi&oacute;n 
      actual<br>
      <?php echo _CFG_INTERFACE_VERSION ;?><br>
      &Uacute;ltima versi&oacute;n<br>
      <?php $lines = file("http://update.baifox.net/version.cfg"); echo $lines[0]; ?>
 </font></b></td>
    <td> 
      <input type="button" name="Submit" value="Actualizar ahora" onclick="javascript:actualizar();">
    </td>
    <td><img src="images/mundo.gif" width="135" height="69"></td>
  </tr>
</table>
</body>
</html>

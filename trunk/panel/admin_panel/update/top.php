<?php 
     include "../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "include_permiso.php"; ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr align="center"> 
    <td><img src="images/baifox.gif" width="110" height="93"></td>
    <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Actualizaci&oacute;n 
      Manual Baifox</font></b></td>
    <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Versi&oacute;n 
      actual<br>
      <?php echo _CFG_INTERFACE_VERSION ;?><br>
      &Uacute;ltima versi&oacute;n<br>
      0.0.0 </font></b></td>
    <td> 
      <input type="submit" name="Submit" value="Actualizar ahora">
    </td>
    <td><img src="images/mundo.gif" width="135" height="69"></td>
  </tr>
</table>
</body>
</html>

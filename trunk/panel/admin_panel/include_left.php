<table width="100%" border="0" cellpadding="0" cellspacing="2">
  <tr> 
    <td valign="middle" width="19%" align="left" height="26"> 
      <div align="center"><img src="images/gestion_webmasters.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Gestión:</b></font></td>
  </tr>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=gestion&seccion=clientes&pag=index">Clientes</a> 
      </font></td>
  </tr>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=gestion&seccion=dominios&pag=index">Dominios</a> 
      </font></td>
  </tr>
   <tr> 
    <td valign="middle" width="19%" align="left" height="26"> 
      <div align="center"><img src="images/gestion_webmasters.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Sistema:</b></font></td>
  </tr>
<?php  
foreach ($modulos_instalados as $modulo) { 
	if (function_exists($modulo."_info"))
		$mod_info=call_user_func($modulo."_info");
	if($mod_info["grupo"]=="sistema" AND $mod_info["visible"]=="true"){
		$mod_estado[0]=true;
		if (function_exists($modulo."_test"))
			$mod_estado=call_user_func($modulo."_test");
if($mod_estado[0]){
?>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=<?php echo $mod_info["grupo"]; ?>&seccion=<?php echo $modulo; ?>&pag=index"><?php echo $mod_info["nombre"]; ?></a> 
      </font></td>
  </tr>
<?php 
}
	}
} ?>

  <tr> 
    <td valign="middle" width="19%" align="left" height="26"> 
      <div align="center"><img src="images/gestion_webmasters.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Servicios:</b></font></td>
  </tr>
<?php  
foreach ($modulos_instalados as $modulo) { 
	if (function_exists($modulo."_info"))
		$mod_info=call_user_func($modulo."_info");
	if($mod_info["grupo"]=="servicios" AND $mod_info["visible"]=="true"){
		$mod_estado[0]=true;
		if (function_exists($modulo."_test"))
			$mod_estado=call_user_func($modulo."_test");
if($mod_estado[0]){
?>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=<?php echo $mod_info["grupo"]; ?>&seccion=<?php echo $modulo; ?>&pag=index"><?php echo $mod_info["nombre"]; ?></a> 
      </font></td>
  </tr>
<?php 
}
	}
} ?>
  <tr> 
    <td valign="middle" width="19%" align="left" height="26"> 
      <div align="center"><img src="images/gestion_webmasters.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>Configuración:</b></font></td>
  </tr>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=configuracion&seccion=usuarios&pag=index">Usuarios</a> 
      </font></td>
  </tr>
</table>
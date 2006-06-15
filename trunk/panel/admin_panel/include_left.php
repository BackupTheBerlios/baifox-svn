<table width="100%" border="0" cellpadding="0" cellspacing="2">
  <tr> 
    <td valign="middle" width="19%" align="left" height="26"> 
      <div align="center"><img src="images/icn_baifox.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><?php echo T_("Management:"); ?></b></font></td>
  </tr>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=gestion&seccion=clientes&pag=index"><?php echo T_("Clients"); ?></a> 
      </font></td>
  </tr>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=gestion&seccion=dominios&pag=index"><?php echo T_("Domains"); ?></a> 
      </font></td>
  </tr>
   <tr> 
    <td valign="middle" width="19%" align="left" height="26"> 
      <div align="center"><img src="images/icn_baifox.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><?php echo T_("System:"); ?></b></font></td>
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
      <div align="center"><img src="images/icn_baifox.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><?php echo T_("Services:"); ?></b></font></td>
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
      <div align="center"><img src="images/icn_baifox.gif" width="20" height="20"></div>
    </td>
    <td valign="middle" width="81%" height="26"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><?php echo T_("Configuration:"); ?></b></font></td>
  </tr>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="index.php?grupo=configuracion&seccion=usuarios&pag=index"><?php echo T_("Users"); ?></a> 
      </font></td>
  </tr>
  <tr> 
    <td valign="middle" width="19%" align="center" height="20">&nbsp;</td>
    <td valign="middle" height="20" width="81%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;<a class="negro" href="Javascript:Ventana('update/index.php');"><?php echo T_("Update"); ?></a> 
      </font></td>
  </tr>
</table>
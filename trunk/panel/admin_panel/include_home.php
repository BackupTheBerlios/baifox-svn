<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber6">
  <tr> 
    <td width="100%" valign="top"> 
	<font face="Arial, Helvetica, sans-serif" size="2">
      <?php
foreach ($modulos_instalados as $modulo) { 
	if (function_exists($modulo."_test")){
		$mod_estado=call_user_func($modulo."_test");
		echo $mod_estado[1];
		echo "<br>";
	}
}
?>
	</font>
    </td>
  </tr>
</table>
<br>

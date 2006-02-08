<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
?> 
<style type="text/css">
<!--
.Estilo5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
input {
	border: #000000 1px solid;  	
	color: #FFFFFF; 
 	background-color: #E27400;
	margin-left:5px;
	font-family:verdana, trebuchet MS, trebuchet, arial, sans-serif;
	font-size: 12px; 
}

-->
</style>
<body bgcolor="#FFFFFF" text="#000000">
<?php if(!$_GET['estado'] || $_GET['estado']=="completado"){ ?>
<form name="formulario" method="post" action="generar_frame.php?dominio=<?php echo $_GET['dominio']; ?>&tipo=<?php echo $_GET['tipo']; ?>&estado=generar">
  <div align="center"><span class="Estilo5">
	<?php if($_GET['estado']=="completado"){ ?>
	La copia de seguridad se ha generado correctamente,<br>
        pulse sobre el boton DESCARGAR para bajarse el fichero comprimido en formato ZIP, <br>
	una vez descargada la copia dejara de estar disponible para descarga;<br>
	puede generar la copia de seguridad tantas veces como desee.<br>
	<?php }else{ ?>
	Este proceso se puede demorar varios minutos,<br>
        por favor no cierre la ventana hasta que el proceso no haya finalizado<br>
   	<?php } ?>
     <br>
<table width="40%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center"><input type="submit" name="BtnGenerar" value="Generar Copia Seguridad"></td>
     <?php if(filesystem_backupexiste($_GET['dominio'],$_GET['tipo'])){ ?>
	<script type="text/javascript">
	<!--
		function hideDiv() {
			if (document.getElementById) { // DOM3 = IE5, NS6
				document.getElementById('hideshow').style.visibility = 'hidden';
			}else {
				if (document.layers) { // Netscape 4
					document.hideshow.visibility = 'hidden';
				}
				else { // IE 4
					document.all.hideshow.style.visibility = 'hidden';
				}
			}
		}
		function descargar_fichero(){
			document.formulario.BtnDescargar.disable=true;
			location.href="descargar.php?dominio=<?php echo $_GET['dominio']; ?>&tipo=<?php echo $_GET['tipo']; ?>";
			hideDiv();
		}
	-->
	</script>
	<td align="center"><div id="hideshow"><input type="button" name="BtnDescargar" value="Descargar Copia Seguridad" onclick="javascript:descargar_fichero();"></div></td>
     <?php } ?>
  </tr>
</table>
    </span> </div>
</form>
<?php } ?>
<span class="Estilo5">
<?php 
if($_GET['estado']=="generar"){
	echo "Creando copia de seguridad, espere por favor...";
	flush();
	if(filesystem_backupcomprimir($_GET['dominio'],$_GET['tipo'])){ ?>
<script type="text/javascript">
<!--
	location.href="generar_frame.php?dominio=<?php echo $_GET['dominio']; ?>&tipo=<?php echo $_GET['tipo']; ?>&estado=completado";
-->
</script>
<?php  }
}
?>
</span>
</body>
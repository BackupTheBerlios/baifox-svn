<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
	include "../include_permiso.php"; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_filesystem/include_funciones.php";
?> 
<?php if(!$_GET['generar']){ ?>
<form name="form1" method="post" action="generar_frame.php?dominio=<?php echo $_GET['dominio']; ?>&tipo=<?php echo $_GET['tipo']; ?>&generar=true">
  <div align="center">Este proceso se puede demorar varios minutos,<br>
    por favor no cierre la ventana hasta que el proceso no haya finalizado<br>
    <input type="submit" name="BtnGenerar" value="Generar copia seguridad">
  </div>
</form>
<?php } ?>
<?php 
if($_GET['generar'])
	filesystem_backupcomprimir($_GET['dominio'],$_GET['tipo']);
?>
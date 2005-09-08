<a href="index.php" class="negro">Portada</a>&gt; 
<?php 
		switch($_GET['grupo']){
			case "gestion":
	  			echo "Gestión";
  			break;		
			case "sistema":
	  			echo "Sistema";
  			break;		
			case "servicios":
	  			echo "Servicios";
  			break;		
			case "configuracion":
	  			echo "Configuración";
  			break;		
		}
?>
&gt; 
<?php if($_GET['pag']!="") { ?>
<a href="index.php?grupo=<?php echo $_GET['grupo']; ?>&seccion=<?php echo $_GET['seccion']; ?>&pag=index" class="negro">
<?php } ?>
<?php 
	echo strtoupper(substr($_GET['seccion'],0,1)).substr($_GET['seccion'],1);
?>
<?php if($_GET['pag']!="") { ?>
</a>  &gt; 
<?php } ?>
<?php 
		switch($_GET['pag']){
			case "index":
	  			echo "<b>Principal</b>";
  			break;
			case "nuevo":
	  			echo "<b>Nuevo</b>";
  			break;				
			case "edit":
	  			echo "<b>Editar</b>";
  			break;				
			case "accion":
	  			echo "<b>Accion</b>";
  			break;				
			case "mailus":
	  			echo "<b>Enviar Email</b>";
  			break;				
		}
?>

<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<pre>
<?php 
	$resultado=bind_control($_GET['accion']);
	foreach ($resultado as $value) {
   		echo "$value<br>";
	}
?>
</pre>
<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<pre>
<?php 
	echo "Reiniciando apache...<br>";
	$resultado=apache_control($_GET['accion']);
	foreach ($resultado as $value) {
   		echo "$value<br>";
	}
	echo "Reiniciando bind...<br>";
	$resultado=bind_control($_GET['accion']);
	foreach ($resultado as $value) {
   		echo "$value<br>";
	}
?>
</pre>
<pre>
<?php 
	$resultado=apache_control($_GET['accion']);
	foreach ($resultado as $value) {
   		echo "$value<br>";
	}
?>
</pre>
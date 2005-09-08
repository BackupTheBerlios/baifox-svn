<pre>
<?php 
	$resultado=pureftpd_cron();
	foreach ($resultado as $value) {
   		echo "$value<br>";
	}
?>
</pre>
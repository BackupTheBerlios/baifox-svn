<?php
if(!$_SESSION['SEC_ID']) {
	$_SESSION['strTemp'] = "No ha introducido la contrase�a o el Email.<br>";
	header ("Location: ../index.php?resulid=99\n\n");
	exit();
}
?>
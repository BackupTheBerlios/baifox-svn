<?php
if(!$_SESSION['SEC_ID']) {
	$strTemp = "No ha introducido la contraseņa o el Email.<br>";
	header ("Location: ../index.php?resulid=99\n\n");
	exit();
}
?>
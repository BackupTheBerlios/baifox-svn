<?php 
if($_SESSION['SEC_PERM']<100){ exit(); } 
if($_SESSION['SEC_ID']) {
	if($_GET['dominio']!=""){
		if(!array_key_exists($_GET['dominio'],$_SESSION['SEC_USER_DOMINIOS'])){
			$strTemp = "Esta intentando acceder a un dominio que no existe o no pertenece a su cuenta.<br>";
			header ("Location: ../index.php?resulid=99\n\n");
			exit();
		}
	}
}
?>
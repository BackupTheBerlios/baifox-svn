<?php
	include "config/main_config.php"; 
        require _CFG_INTERFACE_LIBRERIA; 
	unset($_SESSION['SEC_ID']);
	unset($_SESSION['SEC_PERM']);
	unset($_SESSION['SEC_USER_NOMBRE']);
	unset($_SESSION['SEC_USER_EMAIL']);
	session_unset();
	session_destroy();
	header ("Location: ../index.php?resulid=1\n\n");
	exit();
?>

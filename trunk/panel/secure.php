<?php
	include "admin_panel/config/main_config.php"; 
        require _CFG_INTERFACE_LIBRERIA; 
?>
<?php
if(!$_SESSION['SEC_ID']) {
	if ($_POST['frmUsuario']=="" || $_POST['frmPassword']=="" ) {
			$_SESSION['strTemp'] = "No ha introducido la contraseña o el Email.<br>";
			header ("Location: index.php?resulid=99\n\n");
			exit();
	} else { 
		// Escape both the password and username string to prevent users from inserting bogus data. 
		$sPass=md5(trim($_POST['frmPassword']));
		$rs=buscar_xml(_CFG_XML_USUARIOS,_CFG_XML_CONFIG_DIR,"USERNAME",$_POST['frmUsuario'],"PASSWORD",$sPass);
		// Check username and password agains the database. 
		if ($rs!=0){ 
			$_SESSION['SEC_ID']=$rs["ID"];
	 		$_SESSION['SEC_PERM']=$rs["PERMISO"];
	 		$_SESSION['SEC_USER_NOMBRE']=$rs["NOMBRE"];
	 		$_SESSION['SEC_USER_EMAIL']=$rs["EMAIL"];
			header ("Location: admin_panel/index.php\n\n");
			exit();
		}else{
			$rs=buscar_xml(_CFG_XML_CLIENTES,_CFG_XML_CONFIG_DIR,"USERNAME",$_POST['frmUsuario'],"PASSWORD",$sPass);
			if ($rs!=0){ 
				$_SESSION['SEC_ID']=$rs["ID"];
	 			$_SESSION['SEC_PERM']=$rs["PERMISO"];
	 			$_SESSION['SEC_USER_NOMBRE']=$rs["NOMBRE"];
	 			$_SESSION['SEC_USER_EMAIL']=$rs["EMAIL"];
				$_SESSION['SEC_USER_DOMINIOS']=rellenaarray_dominios($rs["ID"]);
				header ("Location: user_panel/index.php\n\n");
				exit();
			}else{
				$_SESSION['strTemp'] = "Usuario o contraseña incorrectos";
				// If there were no matching users, show the login 
				header ("Location: index.php?resulid=99\n\n");
				exit();
			}
		}
	} 
}else{
	if($_SESSION['SEC_PERM']>=500){
		header ("Location: admin_panel/index.php\n\n");
		exit();
	}elseif($_SESSION['SEC_PERM']>=100){
		header ("Location: user_panel/index.php\n\n");
		exit();
	}
}
?>
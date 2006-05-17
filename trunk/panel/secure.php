<?php
	include "admin_panel/config/main_config.php"; 
        require _CFG_INTERFACE_LIBRERIA; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
?>
<?php
	if ($_POST['frmUsuario']=="" || $_POST['frmPassword']=="" ) {
			$_SESSION['strTemp'] = "No ha introducido la contraseņa o el Email.<br>";
			header ("Location: index.php?resulid=99\n\n");
			exit();
	} else { 
		$mPassword=md5(trim($_POST['frmPassword']));
		$rs=xmlconfig_buscar(_CFG_XML_USUARIOS,"USUARIO",trim($_POST['frmUsuario']),"PASSWORD",$mPassword,"datos");
		if ($rs){ 
			$_SESSION['SEC_ID']=$rs["ID"];
	 		$_SESSION['SEC_PERM']=$rs["PERMISO"];
	 		$_SESSION['SEC_USER_NOMBRE']=$rs["NOMBRE"];
	 		$_SESSION['SEC_USER_EMAIL']=$rs["EMAIL"];
			header ("Location: admin_panel/index.php\n\n");
			exit();
		}else{
			$rs=xmlconfig_buscar(_CFG_XML_CLIENTES,"USUARIO",trim($_POST['frmUsuario']),"PASSWORD",$mPassword,"datos");
			if ($rs){ 
				$_SESSION['SEC_ID']=$rs["ID"];
	 			$_SESSION['SEC_PERM']=$rs["PERMISO"];
	 			$_SESSION['SEC_USER_NOMBRE']=$rs["NOMBRE"];
	 			$_SESSION['SEC_USER_EMAIL']=$rs["EMAIL"];
				if($rs["DOMINIOS"]<=0)
					$_SESSION['SEC_USER_TOTAL_DOMINIOS']=9999;
				else
					$_SESSION['SEC_USER_TOTAL_DOMINIOS']=$rs["DOMINIOS"];
				if($rs["ESPACIO"]<=0)
					$_SESSION['SEC_USER_TOTAL_ESPACIO']=99999;
				else
					$_SESSION['SEC_USER_TOTAL_ESPACIO']=$rs["ESPACIO"];
				if($rs["ANCHOBANDA"]<=0)
					$_SESSION['SEC_USER_TOTAL_ANCHOBANDA']=999999;
				else
					$_SESSION['SEC_USER_TOTAL_ANCHOBANDA']=$rs["ANCHOBANDA"];
				$_SESSION['SEC_USER_DOMINIOS']=xmlconfig_arraydominios($rs["ID"]);
				header ("Location: user_panel/index.php\n\n");
				exit();
			}else{
				$_SESSION['strTemp'] = "Usuario o contraseņa incorrectos";
				header ("Location: index.php?resulid=99\n\n");
				exit();
			}
		}
	} 
?>
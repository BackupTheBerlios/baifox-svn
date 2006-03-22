<?php
	include "admin_panel/config/main_config.php"; 
        require _CFG_INTERFACE_LIBRERIA; 
	require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
?>
<?php
	if ($_POST['frmUsuario']=="") {
			$_SESSION['strTemp'] = "No ha introducido el nombre de usuario.<br>";
			header ("Location: index_recuperar.php?resulid=99\n\n");
			exit();
	} else { 
		$EDIT_ID=xmlconfig_buscar(_CFG_XML_CLIENTES,"USUARIO",$_POST['frmUsuario'],"","","posicion"); 
		if ($EDIT_ID!=0){ 
			//Crea copia seguridad antes de modificar
			xmlconfig_backup(_CFG_XML_CLIENTES);

			$conf = new patConfiguration;
			$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
			$conf->parseConfigFile(_CFG_XML_CLIENTES);

			$mPassword=trim(PasswordGen());
			$datos=$conf->getConfigValue($EDIT_ID,_CFG_XML_CLIENTES);
			$datos['PASSWORD']=md5($mPassword);
			$conf->setConfigValue($EDIT_ID, $datos, "array");
			$conf->writeConfigFile(_CFG_XML_CLIENTES, "xml", array( "mode" => "pretty" ) );
			$_SESSION['strTemp'] = "Se ha generado una contraseña y se le ha enviado a su email";
			$mEmail=$datos['EMAIL'];
			$mUsuario=$_POST['frmUsuario'];
			//Enviar email			
			include "recuperar_email.php";
			header ("Location: index.php?resulid=99\n\n");
			exit();
		}else{
			$EDIT_ID=xmlconfig_buscar(_CFG_XML_USUARIOS,"USUARIO",$_POST['frmUsuario'],"","","posicion"); 
			if ($EDIT_ID!=0){ 
				//Crea copia seguridad antes de modificar
				xmlconfig_backup(_CFG_XML_USUARIOS);

				$conf = new patConfiguration;
				$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
				$conf->parseConfigFile(_CFG_XML_USUARIOS);

				$mPassword=md5(trim(PasswordGen()));
				$datos=$conf->getConfigValue($EDIT_ID,_CFG_XML_USUARIOS);
				$datos['PASSWORD']=$mPassword;
				$conf->setConfigValue($EDIT_ID, $datos, "array");
				$conf->writeConfigFile(_CFG_XML_USUARIOS, "xml", array( "mode" => "pretty" ) );
				$_SESSION['strTemp'] = "Se ha generado una contraseña y se le ha enviado a su email";
				$mEmail=$datos['EMAIL'];
				$mUsuario=$_POST['frmUsuario'];
				//Enviar email
				include "recuperar_email.php";
				header ("Location: index.php?resulid=99\n\n");
				exit();
			}else{
				$_SESSION['strTemp'] = "El usuario no existe";
				header ("Location: index_recuperar.php?resulid=99\n\n");
				exit();
			}
		}
	} 
?>
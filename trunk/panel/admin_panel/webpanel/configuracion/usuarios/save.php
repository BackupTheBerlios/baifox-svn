<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
  require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";
  
  //Crea copia seguridad antes de modificar
  xmlconfig_backup(_CFG_XML_USUARIOS);

  $conf = new patConfiguration;
  $conf->setConfigDir(_CFG_XML_CONFIG_DIR);
  $conf->parseConfigFile(_CFG_XML_USUARIOS,a);

  $mNombre=addslashes(trim($_POST['frmNombre']));
  $mEmail=addslashes(trim($_POST['frmEmail']));
  $mUsuario=addslashes(trim($_POST['frmUsuario']));
  if($_POST['frmPassword']==""){
	$datos=$conf->getConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_USUARIOS));
  	$mPassword=$datos['PASSWORD'];
  }else{
	$mPassword=md5(trim($_POST['frmPassword']));
  }
  $mEstado=$_POST['frmEstado'];
  $mPermiso=$_POST['frmPermiso'];
  
	if ($_GET['id']!= 0 ){
		$conf->setConfigValue($_GET['id'], array(
					 "ID" 	  => $_GET['id'],
					 "NOMBRE" => $mNombre,
					 "EMAIL"  => $mEmail, 
					 "USUARIO" => $mUsuario, 
					 "PASSWORD" => $mPassword,
					 "ESTADO" => $mEstado, 
					 "PERMISO" => $mPermiso)
			 	, "array");
	}else{
		$NEW_ID=xmlconfig_generaid(_CFG_XML_USUARIOS);
		$conf->setConfigValue($NEW_ID, array(
					 "ID" 	  => $NEW_ID,
					 "NOMBRE" => $mNombre,
					 "EMAIL"  => $mEmail, 
					 "USUARIO" => $mUsuario, 
					 "PASSWORD" => $mPassword,
					 "ESTADO" => $mEstado, 
					 "PERMISO" => $mPermiso)
			 	, "array");
	}
	
	$conf->writeConfigFile(_CFG_XML_USUARIOS, "xml", array( "mode" => "pretty" ) );

	header ("Location: ../../../index.php?grupo=configuracion&seccion=usuarios&pag=index\n\n");
	exit();
 ?>
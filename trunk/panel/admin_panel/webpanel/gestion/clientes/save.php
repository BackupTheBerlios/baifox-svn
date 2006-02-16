<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
  require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";

  $conf = new patConfiguration;
  $conf->setConfigDir(_CFG_XML_CONFIG_DIR);
  $conf->parseConfigFile(_CFG_XML_CLIENTES,a);

  $mNombre=addslashes(trim($_POST['frmNombre']));
  $mEmail=addslashes(trim($_POST['frmEmail']));
  $mUsuario=addslashes(trim($_POST['frmUsuario']));
  if($_POST['frmPassword']==""){
	$datos=$conf->getConfigValue(xmlconfig_buscaid($_GET['id'],_CFG_XML_CLIENTES));
  	$mPassword=$datos['PASSWORD'];
  }else{
	$mPassword=md5_encrypt(trim($_POST['frmPassword']),_CFG_INTERFACE_BLOWFISH);
  }
  $mEstado=$_POST['frmEstado'];
  $mPermiso=$_POST['frmPermiso'];
  $mDominios=$_POST['frmDominios'];
  $mEspacio=$_POST['frmEspacio'];
  $mAnchoBanda=$_POST['frmAnchoBanda'];

	if ($_GET['id']!= 0 ){
		$conf->setConfigValue($_GET['id'], array(
					 "ID" 	  => $_GET['id'],
					 "NOMBRE" => $mNombre,
					 "EMAIL"  => $mEmail, 
					 "USUARIO" => $mUsuario, 
					 "PASSWORD" => $mPassword,
  					 "ESTADO" => $mEstado, 
					 "PERMISO" => $mPermiso,
					 "DOMINIOS" => $mDominios, 
					 "ESPACIO" => $mEspacio, 
					 "ANCHOBANDA" => $mAnchoBanda
					)
			 	, "array");
	}else{
		$NEW_ID=xmlconfig_generaid(_CFG_XML_CLIENTES);
		$conf->setConfigValue($NEW_ID, array(
					 "ID" 	  => $NEW_ID,
					 "NOMBRE" => $mNombre,
					 "EMAIL"  => $mEmail, 
					 "USUARIO" => $mUsuario,
					 "PASSWORD" => $mPassword,
					 "ESTADO" => $mEstado, 
					 "PERMISO" => $mPermiso,
					 "DOMINIOS" => $mDominios, 
					 "ESPACIO" => $mEspacio, 
					 "ANCHOBANDA" => $mAnchoBanda
					 )
			 	, "array");
	}
	
	$conf->writeConfigFile(_CFG_XML_CLIENTES, "xml", array( "mode" => "pretty" ) );

	header ("Location: ../../../index.php?grupo=gestion&seccion=clientes&pag=index\n\n");
	exit();
 ?>
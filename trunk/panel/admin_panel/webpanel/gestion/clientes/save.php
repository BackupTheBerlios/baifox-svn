<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
function obtiene_password($id){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_CLIENTES);
	$rs=$conf->getConfigValue($id);

	return $rs["PASSWORD"];
}

$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_CLIENTES,a);
?>
<?php

  $mNombre=addslashes(trim($_POST['frmNombre']));
  $mEmail=addslashes(trim($_POST['frmEmail']));
  $mUsuario=addslashes(trim($_POST['frmUsuario']));
  if (trim($_POST['frmPassword'])!=""){
	$mPassword=md5(trim($_POST['frmPassword']));
  }elseif($_GET['id']!=0){
	$mPassword=obtiene_password($_GET['id']);
  }else{
	$mPassword="";
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
					 "USERNAME" => $mUsuario, 
					 "PASSWORD" => $mPassword,
  					 "ESTADO" => $mEstado, 
					 "PERMISO" => $mPermiso,
					 "DOMINIOS" => $mDominios, 
					 "ESPACIO" => $mEspacio, 
					 "ANCHOBANDA" => $mAnchoBanda
					)
			 	, "array");
	}else{
		$NEW_ID=obtiene_xml_id(_CFG_XML_CLIENTES);
		$conf->setConfigValue($NEW_ID, array(
					 "ID" 	  => $NEW_ID,
					 "NOMBRE" => $mNombre,
					 "EMAIL"  => $mEmail, 
					 "USERNAME" => $mUsuario,
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
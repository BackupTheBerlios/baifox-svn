<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
$conf = new patConfiguration;
$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
$conf->parseConfigFile(_CFG_XML_USUARIOS,a);
$rs=$conf->getConfigValue(busca_xml_id($_GET['id'],_CFG_XML_USUARIOS));

$asunto=$_POST['frmAsunto'];
$cuerpo ="";
$cuerpo .="\nEstimado usuario/a ".$rs["NOMBRE"].":\n\n";

switch($_POST['frmTipoEmail']){
case "1":
	$cuerpo .=$_POST['frmMensaje'];
break;
}

include "plantillas/firma.inc";

  mail($rs["EMAIL"],$asunto,$cuerpo,"From:". _CFG_INTERFACE_EMAIL."\nReply-To:". _CFG_INTERFACE_EMAIL);
  header ("Location: ../../../index.php?grupo=configuracion&seccion=usuarios&pag=mailus&enviado=ok&id=".$_GET['id']."\n\n");
  exit();
?>

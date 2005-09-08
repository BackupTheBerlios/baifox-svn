<?php 
     include "../../../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "../include_permiso.php"; ?>
<?php 
$asunto=$_POST['frmAsunto'];
$cuerpo ="";
$cuerpo .="\nEstimado usuario/a ".$_POST["frmNombre"].":\n\n";

switch($_POST['frmTipoEmail']){
case "1":
	$cuerpo .=$_POST['frmMensaje'];
break;
}

include "plantillas/firma.inc";

  mail($_POST['frmEmail'],$asunto,$cuerpo,"From:". _CFG_INTERFACE_EMAIL."\nReply-To:". _CFG_INTERFACE_EMAIL);
  header ("Location: ../../../index.php?grupo=servicios&seccion=vpopmail&pag=mailus&enviado=ok&email=".$_POST['frmEmail']."&id=".$_GET['id']."\n\n");
  exit();
?>

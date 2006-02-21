<?php 
     include "../../../../admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php 
include "../include_permiso.php"; 

	$cuerpo ="\n--------------------------------------------\n";
	$cuerpo .="\nNombre: ".$frmNombre;
	$cuerpo .="\nDominio: ".$frmDominio;
	$cuerpo .="\nEmail Cuenta: ".$frmEmail;
	$cuerpo .="\nEmail: ".$frmEmail2;
	$cuerpo .="\n--------------------------------------------\n";
	$cuerpo .="\nComentario: ".$frmComentario;
	$cuerpo .="\n--------------------------------------------";
	$cuerpo .="\n	         "._CFG_SERVER_NAME."               ";
	$cuerpo .="\n--------------------------------------------";

  	$asunto="["._CFG_SERVER_NAME."]-".FechaLarga();
	mail(_CFG_INTERFACE_EMAIL,$asunto,$cuerpo,"From: $frmEmail\nReply-To: $frmEmail");

	$_SESSION["strTemp"] = "Su email se ha enviado correctamente, en breve le responderemos";
	header ("Location: ../../../index.php?resulid=99\n\n");
	exit();
 ?>
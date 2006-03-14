<?php
$cuerpo ="\n--------------------------------------------";
$cuerpo .="\n	       RECUPERAR CONTRASEÑA             ";
$cuerpo .="\n--------------------------------------------";
$cuerpo .="\n";
$cuerpo .="\nSus datos de acceso com cliente son: ";
$cuerpo .="\nUsuario: $mUsuario";
$cuerpo .="\nContraseña: $mPassword";
$cuerpo .="\nEsto es un mensaje automático. No responda a este email";
$cuerpo .="\n--------------------------------------------";
mail($mEmail, "Nueva Contraseña",$cuerpo,"From: "._CFG_INTERFACE_EMAIL."\nReply-To: "._CFG_INTERFACE_EMAIL);
?>
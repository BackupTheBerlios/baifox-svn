<?php
$cuerpo ="\n--------------------------------------------";
$cuerpo .="\n	       RECUPERAR CONTRASE�A             ";
$cuerpo .="\n--------------------------------------------";
$cuerpo .="\n";
$cuerpo .="\nSus datos de acceso com cliente son: ";
$cuerpo .="\nUsuario: $mUsuario";
$cuerpo .="\nContrase�a: $mPassword";
$cuerpo .="\nEsto es un mensaje autom�tico. No responda a este email";
$cuerpo .="\n--------------------------------------------";
mail($mEmail, "Nueva Contrase�a",$cuerpo,"From: "._CFG_INTERFACE_EMAIL."\nReply-To: "._CFG_INTERFACE_EMAIL);
?>
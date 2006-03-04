<?php
define("_CFG_RUTA","");
$fichero_local=_CFG_RUTA.$_GET['path']."/".$_GET['file'];
$fichero_nombre=$_GET['file'];
 header("Content-Type: application/force-download");
 header("Content-Type: application/octet-stream");
 header("Content-Type: application/download");
 header("Content-Disposition: attachment; filename=$fichero_nombre");
 header("Content-Length: ".filesize ($fichero_local) );
 $tamano=filesize($fichero_local)-1;
 header("Content-range: bytes 0-".filesize($fichero_local)."/".$tamano);
 header("Content-Transfer-Encoding: binary");
 @readfile($fichero_local);
?>
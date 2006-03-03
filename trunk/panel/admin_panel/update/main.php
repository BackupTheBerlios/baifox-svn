<?php 
     include "../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "include_permiso.php"; ?>
<?php 
 function download($file_source, $file_target) {
        $origen = fopen($file_source, 'rb');
        $destino = fopen($file_target, 'wb');
        if ($origen===false || $destino===false) {
 	    // error leyendo el fichero
            return true;
        }
        while (!feof($origen)) {
            if (fwrite($destino, fread($origen, 1024)) === FALSE) {
                    // 'Download error: Cannot write to file ('.$file_target.')';
                    return true;
                }
        }
        fclose($origen);
        fclose($destino);
        // No error
        return false;
    }
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<?php
	if($_GET['actualizar']=="ok"){	
		$lines = file("http://update.baifox.net/update.cfg");
	 
	 	foreach ($lines as $linea) {
    			list($operacion,$tipo,$tam,$fichero,$ruta) =explode("][",substr($linea,1,strlen($linea)-3));
			$ruta_destino=str_replace("/panel/","",_CFG_INTERFACE_DIR).$ruta."/".$fichero;
			echo "----------------------------------------------<br><br>\n";
			echo "$ruta_destino<br>\n";
			if($tipo=="DIR"){
				if(file_exists($ruta_destino)){
					echo "Existe<br>\n";
				}else{
					echo "No existe<br>\n";
					echo "mkdir $ruta_destino<br>\n";
				}
			}else{
				switch($operacion){
				case "O":
					echo "Sobreescribiendo fichero<br>\n";
				break;
				case "X":
					echo "Fichero sin modificar<br>\n";
				break;
				case "U":
					echo "Fichero actualizado<br>\n";
				break;
				}
			}
 		}
	}else{ ?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" bgcolor="#FFCC66"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>&Uacute;ltimas 
      modificaciones</b></font></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFCC"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
<br>
<?php
		$lines = file("http://update.baifox.net/changelog.cfg");
	  	foreach ($lines as $linea) {
			echo "$linea<br>\n";
		}
?>
     </font></td>
  </tr>
</table>

<?php	} ?>

</body>
</html>

<?php 
     include "../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "include_permiso.php"; ?>
<?php 
 function download($fichero_origen,$ruta_origen, $fichero_destino) {
        $origen = fopen("http://update.baifox.net/baifox_download.php?file=$fichero_origen&path=$ruta_origen", 'rb');
        $destino = fopen($file_target, 'wb');
        if ($origen===false || $destino===false) {
 	    // error leyendo el fichero
            return false;
        }
        while (!feof($origen)) {
            if (fwrite($destino, fread($origen, 1024)) === FALSE) {
		    // error escribiendo el fichero
                    return false;
                }
        }
        fclose($origen);
        fclose($destino);
        return true;
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
			if($tipo=="DIR"){
				if(file_exists($ruta_destino)){
					echo "Directorio ya existe $ruta_destino<br>\n";
				}else{
					echo "Creando directorio $ruta_destino<br>\n";
					mkdir($ruta_destino);
				}
			}else{
				switch($operacion){
				case "O":
					echo "Sobreescribiendo fichero $ruta_destino<br>\n";
					if(download($fichero,$ruta,$ruta_destino))
						echo "[ERROR] Sobreescribiendo fichero $ruta_destino<br>\n";
				break;
				case "X":
					echo "Fichero sin modificar $ruta_destino<br>\n";
				break;
				case "U":
					echo "Fichero actualizado $ruta_destino<br>\n";
				break;
				}
			}
			flush();
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

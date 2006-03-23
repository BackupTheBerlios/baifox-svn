<?php 
     include "../config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 
?>
<?php include "include_permiso.php"; ?>
<?php 
 function download($fichero_origen,$ruta_origen, $fichero_destino) {
        $origen = fopen("http://update.baifox.net/baifox_download.php?file=$fichero_origen&path=$ruta_origen", "rb");
        $destino = fopen($fichero_destino, 'wb');
        if ($origen===false) {
 	    // error leyendo el fichero
	    echo "[ERROR] leyendo fichero origen<br>\n";
            return false;
        }
        if ($destino===false) {
 	    // error leyendo el fichero
	    echo "[ERROR] leyendo fichero destino<br>\n";
            return false;
        }
        while (!feof($origen)) {
            if (fwrite($destino, fread($origen, 4096)) === FALSE) {
		    // error escribiendo el fichero
	    	   echo "[ERROR] escribiendo fichero destino<br>\n";
                    return false;
                }
        }
        fclose($origen);
        fclose($destino);
        return true;
    }
    function update_version($fichero_destino,$version){
	$origen = file($fichero_destino);
        $destino = fopen($fichero_destino, 'wb');
    	if ($destino===false) {
 		// error leyendo el fichero
	   	echo "[ERROR] leyendo fichero destino<br>\n";
           	return false;
        }
	foreach ($origen as $linea){
		if(strpos($linea,"_CFG_INTERFACE_VERSION")!==false){
			if (fwrite($destino, "define(\"_CFG_INTERFACE_VERSION\",\"$version\");\n") === FALSE) {
				// error escribiendo el fichero
	   			echo "[ERROR] escribiendo fichero destino<br>\n";
           			return false;
           		}
		}else{
            		if (fwrite($destino, $linea) === FALSE) {
				// error escribiendo el fichero
	    	 		echo "[ERROR] escribiendo fichero destino<br>\n";
                 		return false;
                	}
		}
    	}
	fclose($destino);
    }
    function update_config($fichero_origen,$ruta_origen, $fichero_destino) {
		$lines_origen = file("http://update.baifox.net/baifox_download.php?file=$fichero_origen&path=$ruta_origen");
		$lines_destino = file($fichero_destino);
	 	foreach ($lines_origen as $linea_origen) {
			$encontrado=false;
	    		if(ereg("(define[(]\")(.*)(\",)", $linea_origen, $registros_origen)){
				foreach ($lines_destino as $linea_destino){
					if(ereg("(define[(]\")(.*)(\",)", $linea_destino, $registros_destino)){
						if($registros_origen[2]==$registros_destino[2])
							$encontrado=true;
					}
				}
				if(!$encontrado){
					$origen = file($fichero_destino);
        				$destino = fopen($fichero_destino, 'wb');
    					if ($destino===false) {
 	    					// error leyendo el fichero
	    					echo "[ERROR] leyendo fichero destino<br>\n";
            					return false;
        				}
					foreach ($origen as $linea){
						if(strpos($linea,"?>")!==false){
							if (fwrite($destino, $linea_origen) === FALSE) {
			    					// error escribiendo el fichero
	    	   						echo "[ERROR] escribiendo fichero destino<br>\n";
                    						return false;
                					}
							if (fwrite($destino, "?>") === FALSE) {
			    					// error escribiendo el fichero
	    	   						echo "[ERROR] escribiendo fichero destino<br>\n";
                    						return false;
                					}
						}else{
            						if (fwrite($destino, $linea) === FALSE) {
			    					// error escribiendo el fichero
	    	   						echo "[ERROR] escribiendo fichero destino<br>\n";
                    						return false;
                					}
						}
        				}
				        fclose($destino);
				}
			}
		}
    }
?>
<html>
<head>
<title>Baifox Actualización Manual</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<font face="Verdana, Arial, Helvetica, sans-serif" size="2">
<?php
	if($_GET['actualizar']=="ok"){	
		$lines = file("http://update.baifox.net/version.cfg");
		$nueva_version=$lines[0];
		$fichero_config="";
		$lines = file("http://update.baifox.net/update.cfg");
		$no_modificar = file(_CFG_INTERFACE_UPDATEIGNORE);

	 	foreach ($lines as $linea) {
			$modificar=true;
    			list($operacion,$tipo,$tam,$fichero,$ruta) =explode("][",substr($linea,1,strlen($linea)-3));
			$ruta_destino=str_replace("/panel/","",_CFG_INTERFACE_DIR).$ruta."/".$fichero;
			$ruta_relativa=$ruta."/".$fichero;
			echo "----------------------------------------------<br>\n";
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
					if($no_modificar!=false){
						foreach($no_modificar as $no_fichero){
							if(substr($no_fichero, 0, 2)!="//"){
								if($ruta_relativa==trim($no_fichero)){
									$modificar=false;
								}
							}
						}
					}else{
						$modificar=true;
					}
					if($modificar){
						if(download($fichero,$ruta,$ruta_destino))
							echo "Sobreescribiendo fichero $ruta_destino<br>\n";
						else
							echo "[ERROR] Sobreescribiendo fichero $ruta_destino<br>\n";
					}else{
						echo "Fichero sin modificar $ruta_destino<br>\n";
					}
				break;
				case "X":
					echo "Fichero sin modificar $ruta_destino<br>\n";
				break;
				case "U":
					if($fichero=="main_config.php"){
						$fichero_config=$ruta_destino;
						update_config($fichero,$ruta,$ruta_destino);
					}
					echo "Fichero actualizado $ruta_destino<br>\n";
				break;
				}
			}
			flush();
 		} 
		update_version($fichero_config,trim($nueva_version));
		echo "<br>----------------------------------------------<br>\n";
		echo "<b>Actualización finalizada</b><br>\n";
		?>
<SCRIPT language="JavaScript" type="text/javascript">
 <!--
     	parent.cabecera.location.href="top.php";
//-->
</SCRIPT>
</font>
<?php	}else{ ?>
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

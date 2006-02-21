<?php
require_once _CFG_XML_PATERROR;
patErrorManager::setErrorHandling(E_ALL, 'verbose');
require_once _CFG_XML_PATCONFIG;

function xmlconfig_info(){
	$info["nombre"]="XMLConfig";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="false";

	return $info;
}

function xmlconfig_test(){
	$test= array();

	$test[0]=true;

	$test[1]="mod_xmlconfig test...<br>";
	$test[1].="==================<br>";
	if($test[0])
		$test[1].="El módulo esta correctamente instalado<br>";
	return $test;
}

function xmlconfig_buscaid($id,$XML_RUTA){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile($XML_RUTA);
	$x=0;
  	for($i=1;$x<count($conf->getConfigValue());$i++){
   		$rs = $conf->getConfigValue($i);
		if($rs){
   		    if($rs["ID"]==$id)
			return $i;
		    $x++;
		}
	}
}

function xmlconfig_generaid($XML_RUTA){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile($XML_RUTA);
	
	if(count($conf->getConfigValue())<=0){
		return 1;
	}else{
		$array_xml=$conf->getConfigValue();
		$rs=end($array_xml);
		return $rs["ID"]+1;	
	}
}

function xmlconfig_buscar($XML_RUTA,$mcampo1,$mcadena1,$mcampo2,$mcadena2,$flag){
   $conf = new patConfiguration;
   $conf->setConfigDir(_CFG_XML_CONFIG_DIR);
   $conf->parseConfigFile($XML_RUTA);
   $total_registros=count($conf->getConfigValue());
   $x=0;
   for($i=1;$x<$total_registros;$i++){
	   $rs = $conf->getConfigValue($i);
	   if($rs){
	   	if($mcampo2!=""){
	   		if($rs[$mcampo1]==$mcadena1 && $rs[$mcampo2]==$mcadena2){
				switch($flag){
				case "posicion":
					return $i;
				break;
				case "datos":
					return $rs;
				break;
				}
			}
		}else{
	   		if($rs[$mcampo1]==$mcadena1){
				switch($flag){
				case "posicion":
					return $i;
				break;
				case "datos":
					return $rs;
				break;
				}
			}		
		}
		$x++;
	   }
   }
}

function xmlconfig_rellenacombo($XML_RUTA,$mid,$mdescripcion,$mselected){
   $conf = new patConfiguration;
   $conf->setConfigDir(_CFG_XML_CONFIG_DIR);
   $conf->parseConfigFile($XML_RUTA);
   $strselected="";
   $x=0;
   $total_registros=count($conf->getConfigValue());
   if($total_registros>0)
	$array_mostrar=array_ordenar_campo($conf->getConfigValue(),$mdescripcion);
   for($i=1;$x<$total_registros;$i++){
	   $rs = $array_mostrar[$i];
	   if($rs){
		if($mselected==$rs[$mid]){ $strselected="selected"; }else{ $strselected=""; }
		echo " <option value=\"".$rs[$mid]."\" $strselected>".$rs[$mdescripcion]."</option>";	
	   }
	   $x++;
   }
}

function xmlconfig_arraydominios($IDCLIENTE){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS);
	$total_registros=count($conf->getConfigValue());
	$dominios_usuario=Array();
	$x=0;
   	for($i=1;$x<$total_registros;$i++){
   		$rs = $conf->getConfigValue($i);
		if($rs){
			if($rs["IDCLIENTE"]==$IDCLIENTE){ 
				$dominios_usuario[$rs["DOMINIO"]]=$rs["IDFTP"];
			}
			$x++;
		}	
   	}
	return $dominios_usuario;
}

function xmlconfig_buscadbase($cadena,$flag){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_BASEDATOS);
	$total_registros=count($conf->getConfigValue());
	$dominios_usuario=Array();
	
	$x=0;
   	for($i=1;$x<$total_registros;$i++){
   		$rs = $conf->getConfigValue($i);
		if($rs){
				switch($flag){
				case "dominio":
					if($rs["DATABASE"]==$cadena){ 
						return $rs["DOMINIO"];
				 		exit();
					}
				break;
				case "database":
					if($rs["DOMINIO"]==$cadena){ 
						return $rs["DATABASE"];
				 		exit();
					}
				break;
				}
			$x++;
		}	
   	}
	
}

?>
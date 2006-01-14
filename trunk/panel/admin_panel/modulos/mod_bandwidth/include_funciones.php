<?php

function bandwidth_info(){
	$info["nombre"]="Bandwidth";
	$info["version"]="1.0";
	$info["grupo"]="servicios";

	return $info;
}

function bandwidth_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_bandwidth test...<br>";
	$test[1].= "==================<br>";
	if (!file_exists(_CFG_AWSTATS_DATADIR)){
		$test[1].= "[ERROR] No se ha creado el directorio "._CFG_AWSTATS_DATADIR."<br>";
		$test[0]=false;
	}
	if (!is_writable(_CFG_AWSTATS_DATADIR)){
		$test[1].="[ERROR] No se puede escribir en el directorio "._CFG_AWSTATS_DATADIR."<br>";
		$test[0]=false;
	}
	if($test[0])
		$test[1].= "El módulo esta correctamente instalado<br>";
	return $test;
}

function bandwidth_fechalog($linea){
		list( , , , $fecha) = explode(" ", $linea);
		$fecha = str_replace("[", "", $fecha);
		list($dia, $mes, $anio) = explode("/", $fecha, 3);
		list($anio, $hora, $minuto, $segundo) = explode(":", $anio, 4);
		$formdate = "$dia $mes $anio $hora:$minuto:$segundo";
		$fechaactual= strtotime("$formdate");
		
		return $fechaactual;
}

function bandwidth_calcular($dominio,$rotacion){
if($rotacion==0 or $rotacion==""){
	$ficherolog=_CFG_APACHE_LOGS.$dominio._CFG_LOGROTATE_CFG_AWSTATSTRING;
}else{
	$ficherolog=_CFG_APACHE_LOGS.$dominio._CFG_LOGROTATE_CFG_AWSTATSTRING.".$rotacion";
}

if(file_exists($ficherolog)){
	$lineas = file($ficherolog); 
	foreach ($lineas as $line_num => $linea) {
		list( , , , , , , , , , $tamanio) = explode(" ", $linea, 10);
		if($tamanio != "-") { $total = ($total + $tamanio); }
		$contador++;
	}
	return number_format(bitconversor($total,"byte","mbyte"), 2, '.', '');
}else{
	return 0;
}
}

function bandwidth_generar($anio,$dominio){
	$directorio=_CFG_AWSTATS_DATADIR.$dominio;
	$fichero="bandwidth-$anio.xml";

	$conf = new patConfiguration;
	$conf->setConfigDir($directorio);
	$conf->parseConfigFile($fichero,a);

	$dias=array();
	for($i=1;$i<=31;$i++){
		$dias["Dia-$i"]="0";
	}
	for($i=1;$i<=12;$i++){
		$conf->setConfigValue($i, $dias, "array");
	}
	$conf->writeConfigFile($fichero, "xml", array( "mode" => "pretty" ) );
}

function bandwidth_grabar($dia,$mes,$anio,$dominio,$total){
	$directorio=_CFG_AWSTATS_DATADIR.$dominio;
	if(file_exists($directorio)){
		$fichero="bandwidth-$anio.xml";

		if(!file_exists($directorio."/".$fichero))
			bandwidth_generar($anio,$dominio);

		$conf = new patConfiguration;
		$conf->setConfigDir($directorio);
		$conf->parseConfigFile($fichero,a);

		$rs = $conf->getConfigValue($mes);
		$rs["Dia-$dia"]=$total;
		$conf->setConfigValue($mes, $rs, "array");

		$conf->writeConfigFile($fichero, "xml", array( "mode" => "pretty" ) );
	}
}

function bandwidth_listdomains(){
$handle=GetDirArray(_CFG_APACHE_CONF); 
$array_modules= array();

 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	if(!is_dir(_CFG_APACHE_CONF.$file)){
		if(substr($file,-5)=="_conf"){
			if (trim(substr($file,-5))!="")
				$array_modules[]=substr($file,0,-5);
		}
	}
     }
 }
return $array_modules;
}

function bandwidth_cron(){
	$dominios=bandwidth_listdomains();
	foreach ($dominios as $dominio) {
   		$consumido=bandwidth_calcular($dominio,1);
		$fechaconsumo=DateAdd("d",-1,mktime()); //Sacamos la fecha de ayer
		bandwidth_grabar(date("j",$fechaconsumo),date("n",$fechaconsumo),date("Y",$fechaconsumo),$dominio,$consumido);
	}
}


function bandwidth_estadisticas_dia($dominio,$mes,$anio){
	$directorio=_CFG_AWSTATS_DATADIR.$dominio;

	if(file_exists($directorio)){
		$fichero="bandwidth-$anio.xml";

		if(file_exists($directorio."/".$fichero)){
			$conf = new patConfiguration;
			$conf->setConfigDir($directorio);
			$conf->parseConfigFile($fichero,a);

			$contenido= "<table width=\"75%\" border=\"0\" class=\"box\" align=\"center\">";
			$contenido.= "  <tr class=\"boxheader\"> ";
			$contenido.= "    <td colspan=2 align=\"center\" class=\"boxheader\">".Mes($mes)."</td>";
			$contenido.= "  </tr>";
			$contenido.= "  <tr class=\"boxheader\"> ";
			$contenido.= "    <td align=\"center\" class=\"boxheader\">Dia</td>";
			$contenido.= "    <td align=\"center\" class=\"boxheader\">Total</td>";
			$contenido.= "  </tr>";
			$rs = $conf->getConfigValue($mes);
			$total=0;
			for($dia=1;$dia<=31;$dia++){	
				$consumo=$rs["Dia-$dia"];
				$total+=$consumo;
				$contenido.= "  <tr class=\"boxbody\"> ";
				$contenido.= "    <td align=\"center\"><div class=\"fuentecelda\">$dia</div></td>";
				$contenido.= "    <td align=\"center\"><div class=\"fuentecelda\">".number_format($consumo,2,",",".")." MB</div></td>";
				$contenido.= "  </tr>";
			}
			$contenido.= "  <tr class=\"boxbody\"> ";
			$contenido.= "    <td align=\"right\"><div class=\"fuentecelda\"><b>Total Mes</b></div></td>";
			$contenido.= "    <td align=\"center\"><div class=\"fuentecelda\"><b>".number_format($total,2,",",".")." MB</b></div></td>";
			$contenido.= "  </tr>";
			$contenido.= "</table>";
		}
	}
	return $contenido;
}

function bandwidth_estadisticas_mes_total($dominio,$anio,$mes){
	$directorio=_CFG_AWSTATS_DATADIR.$dominio;

	if(file_exists($directorio)){
		$fichero="bandwidth-$anio.xml";

		if(file_exists($directorio."/".$fichero)){
			$conf = new patConfiguration;
			$conf->setConfigDir($directorio);
			$conf->parseConfigFile($fichero,a);
			$rs = $conf->getConfigValue($mes);
			$consumo=0;
			for($dia=1;$dia<=31;$dia++)
				$consumo+=$rs["Dia-$dia"];
		}
	}
	return number_format($consumo,2,",",".")." MB";
}

function bandwidth_estadisticas_mes($dominio,$anio){
	$directorio=_CFG_AWSTATS_DATADIR.$dominio;

	if(file_exists($directorio)){
		$fichero="bandwidth-$anio.xml";

		if(file_exists($directorio."/".$fichero)){
			$conf = new patConfiguration;
			$conf->setConfigDir($directorio);
			$conf->parseConfigFile($fichero,a);

			$contenido= "<table width=\"75%\" border=\"0\" class=\"box\">";
			$contenido.= "  <tr class=\"boxheader\"> ";
			$contenido.= "    <td align=\"center\" class=\"boxheader\">Mes</td>";
			$contenido.= "    <td align=\"center\" class=\"boxheader\">Total</td>";
			$contenido.= "    <td align=\"center\" class=\"boxheader\">+ Datos</td>";
			$contenido.= "  </tr>";
			for($mes=1;$mes<=12;$mes++){
				$rs = $conf->getConfigValue($mes);
				$consumo=0;
				for($dia=1;$dia<=31;$dia++)
					$consumo+=$rs["Dia-$dia"];

				$contenido.= "  <tr class=\"boxbody\"> ";
				$contenido.= "    <td><div class=\"fuentecelda\">".Mes($mes)."</div></td>";
				$contenido.= "    <td align=\"center\"><div class=\"fuentecelda\">".number_format($consumo,2,",",".")." MB</div></td>";
				$contenido.= "    <td align=\"center\"><a href=\"javascript:Carga_Datos('webpanel/".$_GET['grupo']."/".$_GET['seccion']."/','$dominio',$mes,$anio);\"><img src=\"images/estadisticas.gif\" width=\"20\" height=\"20\" border=\"0\"></a></td>";
				$contenido.= "  </tr>";
			}
			$contenido.= "</table>";
		}
	}
	return $contenido;
}
?>
<?php
require_once _CFG_XML_PATERROR;
patErrorManager::setErrorHandling(E_ALL, 'verbose');
require_once _CFG_XML_PATCONFIG;

session_start();
if (strlen(session_id())>0){
   session_register("SEC_ID");
   session_register("SEC_USER");
   session_register("SEC_USER_NOMBRE");
   session_register("SEC_USER_EMAIL");
   session_register("SEC_USER_DOMINIOS");
   session_register("SEC_PERM");
   session_register("SEC_EMAIL_ASUNTO");
   session_register("SEC_EMAIL_MENSAJE");
   session_register("strTemp");
} 

function Mes($Num) {
$Meses=array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Num--;
Return "$Meses[$Num]";
}

function Dia($Num) {
$Dias=array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
Return "$Dias[$Num]";
}

function FechaLarga() {
$nameDia=Dia(date("w"));
$mMes=Mes(date("m"));
$mDia=date("j");
$mAnio=date("Y");

$FechaLarga= "$nameDia $mDia de $mMes de $mAnio";
Return "$FechaLarga";
}

function encriptar( $pass )
{
  $cset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789./";
  $cadena = "";
  for ($i=0; $i<CRYPT_SALT_LENGTH; $i++)
    $cadena .= substr($cset, rand() & 63, 1);
  return crypt($pass, $cadena);
}

function addslashes_cmd($cadena){
	$cadena=str_replace("`","\`",$cadena);
	return $cadena;
}

function GeneraAlea()
{
	srand ((double) microtime() * 1000000);
	$randval = rand(1000,9999);
      
	Return $randval;
}

function is_leap_year($year) {
        if ((($year % 4) == 0 and ($year % 100)!=0) or ($year % 400)==0) {
                return 1;
        } else {
                return 0;
        }
}

function iso_week_days($yday, $wday) {
        return $yday - (($yday - $wday + 382) % 7) + 3;
}

function get_week_number() {

        $d = getdate();

        $days = iso_week_days($d["yday"], $d["wday"]);

        if ($days < 0) {
                $d["yday"] += 365 + is_leap_year(--$d["year"]);
                $days = iso_week_days($d["yday"], $d["wday"]);
        } else {
                $d["yday"] -= 365 + is_leap_year($d["year"]);
                $d2 = iso_week_days($d["yday"], $d["wday"]);
                if (0 <= $d2) {
                        /* $d["year"]++; */
                        $days = $d2;
                }
        }

        return (int)($days / 7) + 1;
}

function GetDirArray($sPath)
{
	//Load Directory Into Array
	$handle=opendir($sPath);
	while ($file = readdir($handle))
        $retVal[count($retVal)] = $file;

	//Clean up and sort
	closedir($handle); 	
	sort($retVal);
	return $retVal;
}

function PasswordGen()
{

	$consts='bcdgklmnprst';
	$vowels='aeiou';

	for ($x=0; $x < 6; $x++) {
		mt_srand ((double) microtime() * 1000000);
		$const[$x] = substr($consts,mt_rand(0,strlen($consts)-1),1);
		$vow[$x] = substr($vowels,mt_rand(0,strlen($vowels)-1),1);
	}
	return $const[1] . $vow[0] .$const[0] . $vow[1] . $const[2] . $const[3] . $vow[3] . $const[4];
}

function FechaEnomVis($fechaactual){
	list($mes,$dia,$anio)=split('[/.-]',$fechaactual, 3);

	return $dia."/".$mes."/".$anio;
}

function FechaEnomMySQL($fechaactual){
	list($mes,$dia,$anio)=split('[/.-]',$fechaactual, 3);

	return $anio."-".$mes."-".$dia;
}


function FechaMySQLSoloFecha($fechaactual){
	return substr($fechaactual,0,4)."-".substr($fechaactual,5,2)."-".substr($fechaactual,8,2);
}

function FechaMySQLVis($fechaactual){
	list($anio,$mes,$dia,$hora,$segundo) = split("([^0-9])",$fechaactual); 
	return $dia."/".$mes."/".$anio;
}

function FechaMySQLIngles($fechaactual){
	return substr($fechaactual,5,2)."/".substr($fechaactual,8,2)."/".substr($fechaactual,0,4);
}

function FechaVisMySQL($fechaactual){
	list($dia,$mes,$anio)=split('[/.-]',$fechaactual, 3);
	return $anio."-".$mes."-".$dia;
}

function dayDiff($timestamp1,$timestamp2) {
$dayInYear1 = getDayOfYear($timestamp1);
$dayInYear2 = getDayOfYear($timestamp2);
return ((getYear($dayInYear1)*365 + $dayInYear1) -
(getYear($dayInYear2)*365 + $dayInYear2));
}

function getDayOfYear($timestamp) {
$timepieces = getdate($timestamp);
return intval($timepieces["yday"]);
}

function getYear($timestamp) {
$timepieces = getdate($timestamp);
return intval($timepieces["year"]);
}

function MuestraFecha($fechaactual) {
	return substr($fechaactual,8,2)."/".substr($fechaactual,5,2)."/".substr($fechaactual,0,4)." ".substr($fechaactual,11,2).":".substr($fechaactual,14,2);
}


function Dividir_Array($Cadena) {
		$Array_Programas = array();

		$listastop=$Cadena; 
		if($listastop!=""){
		$i=1;
			 while(strpos($listastop, ",")){
			 	$id=substr($listastop,0,strpos($listastop, ","));
				$Array_Programas[$i]=$id;
				$listastop = substr(strstr($listastop, ","),1);
				$i++;
			 }
		}
return $Array_Programas;
}

function Dividir_Cadena($Cadena,$separador) {
		$Array_Programas = array();

		$listastop=$Cadena; 
		if($listastop!=""){
		$i=0;
			 while(strpos($listastop, $separador)){
			 	$id=substr($listastop,0,strpos($listastop, $separador));
				$Array_Programas[$i]=$id;
				$listastop = substr(strstr($listastop, $separador),1);
				$i++;
			 }
		}
		if(strlen($listastop)>0) { $Array_Programas[$i]=$listastop; }
return $Array_Programas;
}

function FechaMySQLDia($fechaactual){
	return intval(substr($fechaactual,8,2));
}

function FechaMySQLAnio($fechaactual){
	return intval(substr($fechaactual,0,4));
}

function FechaMySQLMes($fechaactual){
	return intval(substr($fechaactual,5,2));
}

function datediff($fecha_orig,$fecha_dest,$tipo)
{
	$diff=abs($fecha_dest-$fecha_orig)/(86400)-1;
	switch($tipo){
		case "d":
			return $diff;
		break;
		case "m":
			return ($diff/30);
		break;
		case "y":
			return ($diff/365);
		break;		
	}	
}

function calcDateDiff( $date1, $date2 )
{
   if( $date2 > $date1 )
   {
       die( "error: date1 has to be >= date2 in calcDateDiff($date1, $date2)" );
   }
   $diff = $date1-$date2;
   $seconds = 0;
   $hours  = 0;
   $minutes = 0;
   if($diff % 86400 > 0)
   {
       $rest = ($diff % 86400);
       $days = ($diff - $rest) / 86400;
       if( $rest % 3600 > 0 )
       {
           $rest1 = ($rest % 3600);
           $hours = ($rest - $rest1) / 3600;
           if( $rest1 % 60 > 0 )
           {
               $rest2 = ($rest1 % 60);
               $minutes = ($rest1 - $rest2) / 60;
               $seconds = $rest2;
           }else
               $minutes = $rest1 / 60;
       }else
           $hours = $rest / 3600;
   }else
       $days = $diff / 86400;
   return $days;
}

function busca_xml_id($id,$XML_RUTA){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile($XML_RUTA);

  	for($i=1;$x<count($conf->getConfigValue());$i++){
   		$rs = $conf->getConfigValue($i);
		if($rs){
   		    if($rs["ID"]==$id)
			return $i;
		    $x++;
		}
	}
}

function obtiene_xml_id($XML_RUTA){
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

function buscar_xml($mfichero,$mdirectorio,$mcampo1,$mcadena1,$mcampo2,$mcadena2){
   $conf = new patConfiguration;
   $conf->setConfigDir($mdirectorio);
   $conf->parseConfigFile($mfichero);
   $total_registros=count($conf->getConfigValue());
   for($i=1;$x<$total_registros;$i++){
	   $rs = $conf->getConfigValue($i);
	   if($rs){
	   	if($mcampo2!=""){
	   		if($rs[$mcampo1]==$mcadena1 && $rs[$mcampo2]==$mcadena2){
				return $rs;
				break;
			}
		}else{
	   		if($rs[$mcampo1]==$mcadena1){
				return $rs;
				break;
			}		
		}
		$x++;
	   }
   }
   return 0;
}

function rellenacombo_xml($mfichero,$mdirectorio,$mid,$mdescripcion,$mselected){
   $conf = new patConfiguration;
   $conf->setConfigDir($mdirectorio);
   $conf->parseConfigFile($mfichero);
   $strselected="";
   $x=0;
   $total_registros=count($conf->getConfigValue());
   for($i=1;$x<$total_registros;$i++){
	   $rs = $conf->getConfigValue($i);
	   if($rs){
		if($mselected==$rs[$mid]){ $strselected="selected"; }else{ $strselected=""; }
		echo " <option value=\"".$rs[$mid]."\" $strselected>".$rs[$mdescripcion]."</option>";
		$x++;
	   }
   }
}

function rellenaarray_dominios($IDCLIENTE){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS);
	$total_registros=count($conf->getConfigValue());
	$dominios_usuario=Array();
	
	$x=0;
   	for($i=1;$i<=$total_registros;$i++){
   		$rs = $conf->getConfigValue($i);
		if($rs){
			if($rs["IDCLIENTE"]==$IDCLIENTE){ 
				$dominios_usuario[$rs["DOMINIO"]]=$rs["IDFTP"];
		 		$x++;
			}
		}	
   	}
	return $dominios_usuario;
}

function buscardbase_dominio($dominio){
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS);
	$total_registros=count($conf->getConfigValue());
	$dominios_usuario=Array();
	
	$x=0;
   	for($i=1;$i<=$total_registros;$i++){
   		$rs = $conf->getConfigValue($i);
		if($rs){
			if($rs["DOMINIO"]==$dominio){ 
				return $rs["BASE"];
		 		exit();
			}
		}	
   	}
	
}

function execute_cmd($cmd)
{
//    exec("echo "._CFG_SUDO_PASSWORD."|"._CFG_SUDO." -v -S 1>/dev/null 2>&1\n\n");
//    exec(_CFG_SUDO." -v -p "._CFG_SUDO_PASSWORD." 1>/dev/null 2>&1\n\n");
//    exec(_CFG_SUDO." -u root $cmd 1>/dev/null 2>&1\n\n", $result_cmd);
//    exec(_CFG_SUDO." -k\n\n", $result_cmd);
     exec("cat "._CFG_SUDO_PASSWORD."|"._CFG_SUDO." -S -u root $cmd\n\n", $result_cmd);
    return $result_cmd;
}


function bitconversor($value,$flagini,$flagresul){
	$tam = Array();
	$tam['bit']  = 1;
	$tam['kbit'] = pow(1000, 1);
	$tam['mbit'] = pow(1000, 2);
	$tam['gbit'] = pow(1000, 3);
	$tam['tbit'] = pow(1000, 4);
	$tam['byte'] = 8;
	$tam['kbyte'] = pow(1024, 1) * 8;
	$tam['mbyte'] = pow(1024, 2) * 8;
	$tam['gbyte'] = pow(1024, 3) * 8;
	$tam['tbyte'] = pow(1024, 4) * 8;

	return ($value *$tam[$flagini])/ $tam[$flagresul];
}

function array_search_stringarray($listado_array,$cadena){
    foreach($listado_array as $key => $value){
	    if(strpos($value,$cadena)!==false){
                return $key;
                break;
             }
    }
}

function array_search_match($texto, $palabras){
    foreach($palabras as $value){
	 if(trim($value)==trim($texto))
	    return true;
    }
    return false;
}

function array_ordenar_campo($listado_array,$campo){
	foreach($listado_array as $rs)
		$array_indice[] = $rs[$campo];
	$array_lowercase = array_map('strtolower', $array_indice);
	array_multisort($array_lowercase, SORT_ASC,SORT_STRING, $listado_array);
	return $listado_array;
}

function word_exist($cadena,$fichero) {
	$palabras=file($fichero);
   	$resultado=array_search_match ($cadena,$palabras);
	return $resultado;
}

function modules_array($directorio){
$handle=GetDirArray($directorio); 
$array_modules= array();

 while (list ($key, $file) = each ($handle)) { 
    if ($file != "." && $file != "..") { 
	if(is_dir($directorio.$file)){
		if(substr($file,0,3)=="mod"){
			$array_modules[]=substr($file,4);
		}
	}
     }
 }
return $array_modules;
}

function isBlank( $strInput ) {
	// Returns 1 if the strInput is empty or null or just space(s)
	// expects a string as input
	
	// First trim the string
	$strTemp = trim( $strInput );
	
	// Check if there are any characters
	if ( strlen( $strTemp ) == 0 ) {
		// There aren't, the string is blank
		$Ret = 1;
	} else {
		// There are some characters in there
		$Ret = 0;
	}
	
	return ( $Ret );
}

function fnStripSLD( $strInput ) {
	// returns the sld by stripping off the tld and the dot
	// expects a non blank/empty string as input
	if ( isBlank( $strInput )) {
		$Sld = "";
	} else {
		if(substr ($strInput, -4)=="name")
		{
			$Sld=substr($strInput,0,-5);
		}else{
			$Sld=substr($strInput,0,strpos($strInput, "."));
		}
		if ( $Sld == false ) {
			$Sld = "";
		}
	}
	
	return ( $Sld );
}

function fnStripTLD( $strInput ) {
	// returns the tld by stripping off the dot sld
	// expects a non blank/empty string as input
	
	// Check if the string is blank
	if ( isBlank( $strInput )) {
		$Tld = "";
	} else {
		if(substr ($strInput, -4)=="name")
		{
			$Tld="name";
		}else{
			$Tld=substr($strInput,strpos($strInput, ".")+1,strlen($strInput));	
		}
		
		// Check if a "." was found
		if ( $Tld == false ) {
			// No ".", return blank TLD
			$Tld = "";
		}
	}
	
	return ( $Tld );
}

if(!function_exists('stripos'))
{
   function stripos($haystack,$needle,$offset = 0)
   {
     return(strpos(strtolower($haystack),strtolower($needle),$offset));
   }
}

function DateAdd($interval, $number, $date) {

    $date_time_array = getdate($date);
    $hours = $date_time_array['hours'];
    $minutes = $date_time_array['minutes'];
    $seconds = $date_time_array['seconds'];
    $month = $date_time_array['mon'];
    $day = $date_time_array['mday'];
    $year = $date_time_array['year'];

    switch ($interval) {
        case 'yyyy':
            $year+=$number;
            break;
        case 'q':
            $year+=($number*3);
            break;
        case 'm':
            $month+=$number;
            break;
        case 'y':
        case 'd':
        case 'w':
            $day+=$number;
            break;
        case 'ww':
            $day+=($number*7);
            break;
        case 'h':
            $hours+=$number;
            break;
        case 'n':
            $minutes+=$number;
            break;
        case 's':
            $seconds+=$number; 
            break;
    }
       $timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
    return $timestamp;
}
?>

<?php

function vpopmail_info(){
	$info["nombre"]="Vpopmail";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="true";

	return $info;
}

function vpopmail_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_vpopmail test...<br>";
	$test[1].= "==================<br>";
	if (!file_exists(_CFG_SUDO)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_SUDO."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_ALIAS)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_ALIAS."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_ADDDOMAIN)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_ADDDOMAIN."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_DELDOMAIN)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_DELDOMAIN."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_DOMAINLIMITS)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_DOMAINLIMITS."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_CUENTALIMITS)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_CUENTALIMITS."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_INFODOMAIN)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_INFODOMAIN."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_ADDUSER)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_ADDUSER."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_DELUSER)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_DELUSER."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_QUOTAUSER)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_QUOTAUSER."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_PASSWDUSER)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_PASSWDUSER."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_ALIASUSER)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_ALIASUSER."<br>";
		$test[0]=false;
	}

	if (!file_exists(_CFG_VPOPMAIL_INFOUSER)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_VPOPMAIL_INFOUSER."<br>";
		$test[0]=false;
	}

	if($test[0])
		$test[1].= "El módulo esta correctamente instalado<br>";
	return $test;
}

function vpopmail_listdomains(){
	$array_listado=Array();

	$exec_cmd = _CFG_VPOPMAIL_INFODOMAIN;
	$result = execute_cmd("$exec_cmd  -a|"._CFG_CMD_GREP." -e "._CFG_VPOPMAIL_CFG_DOMAIN." -e "._CFG_VPOPMAIL_CFG_USERS." |"._CFG_CMD_CUT." -d\":\" -f2");
	for($i=0;$i<count($result);$i+=2)
	{
		$array_listado[$i]["dominio"]=trim($result[$i]);
		$array_listado[$i]["cuentas"]=trim($result[$i+1]);
	}
	array_multisort($array_listado);
	return $array_listado;
}

function vpopmail_listalias($dominio){
	$array_listado=Array();
	$array_autorespond=Array();

	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	$result = execute_cmd("$exec_cmd $dominio");
	$x=0;
	$z=0;
	for($i=0;$i<count($result);$i++)
	{
		if(strpos($result[$i],"autorespond")===false AND strpos($result[$i],"ezmlm")===false  AND strpos($result[$i],"-owner")===false AND strpos($result[$i],"/allow")===false){
			list($cuenta_origen, $cuenta_destino) =split(_CFG_VPOPMAIL_CFG_CUENTAALIAS, $result[$i], 2);
			if(!array_search_match($cuenta_origen,$array_autorespond)){
				$array_listado[$x]["cuenta_origen"]=trim($cuenta_origen);
				$array_listado[$x]["cuenta_destino"]=substr(trim($cuenta_destino),1);
				$x++;
			}
		}elseif(strpos($result[$i],"autorespond")!==false){
			list($cuenta_origen, $cuenta_destino) =split(_CFG_VPOPMAIL_CFG_CUENTAALIAS, $result[$i], 2);
			$array_autorespond[$z]=trim($cuenta_origen);
			$z++;
		}
	}
	array_multisort($array_listado);
	return $array_listado;
}

function vpopmail_listautorespuesta($dominio){
	$array_listado=Array();

	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	$result = execute_cmd("$exec_cmd $dominio");
	for($i=0;$i<count($result);$i++)
	{
		if(strpos($result[$i],"autorespond")!==false){
			list($cuenta, $cadena) =split(_CFG_VPOPMAIL_CFG_CUENTAALIAS, $result[$i], 2);
			$array_listado[$i]["cuenta"]=trim($cuenta);
			if(strpos($result[$i+1],$cuenta)!==false){
				list($cuenta_origen, $cuenta_destino) =split(_CFG_VPOPMAIL_CFG_CUENTAALIAS, $result[$i+1], 2);
				$array_listado[$i]["cuenta_copia"]=substr(trim($cuenta_destino),1);
			}
		}
	}
	array_multisort($array_listado);
	return $array_listado;
}

function vpopmail_listcuentas($dominio){
	$array_listado=Array();

	$exec_cmd = _CFG_VPOPMAIL_INFOUSER;
	$result = execute_cmd("$exec_cmd  -D $dominio|"._CFG_CMD_GREP." -e "._CFG_VPOPMAIL_CFG_CUENTANAME." -e "._CFG_VPOPMAIL_CFG_CUENTAQUOTA." |"._CFG_CMD_CUT." -d\":\" -f2");
	for($i=0;$i<count($result);$i+=2)
	{
		$array_listado[$i]["cuenta"]=trim($result[$i]);
		$userquota=trim($result[$i+1]);
		if(stristr ($userquota,"S")!=false){
			$cantidad=substr($userquota,0,strpos($userquota,"S"));
			$quota=bitconversor($cantidad,"byte","mbyte")." MB";
		}else{
			$quota="ilimitado";
		}
		$array_listado[$i]["quota"]=$quota;
	}
	array_multisort($array_listado);
	return $array_listado;
}

function vpopmail_cuentaadd($usuario,$dominio,$password,$quota){
	$exec_cmd = _CFG_VPOPMAIL_ADDUSER;
	$result = execute_cmd("$exec_cmd -q $quota $usuario@$dominio $password");
	return $result;
}

function vpopmail_domainadd($dominio,$password){
	$exec_cmd = _CFG_VPOPMAIL_ADDDOMAIN;
	$result = execute_cmd("$exec_cmd $dominio $password");
	return $result;
}

function vpopmail_aliasadd($cuentaorigen,$dominio,$cuentadestino){
	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	$result = execute_cmd("$exec_cmd -i '&$cuentadestino' '$cuentaorigen@$dominio'");
	return $result;
}

function vpopmail_autorespondread($usuario,$dominio,$flag){
	list($cuenta,$cadena)=split("@",$usuario,2);
	$directorio=vpopmail_homedir($dominio)."/".strtoupper($cuenta);
	$result = execute_cmd(_CFG_CMD_CAT." $directorio/message");

	switch($flag){
        case "asunto":
		list($cadena, $asunto) =split("Subject: ", $result[1], 2);
		return $asunto;
	break;
        case "mensaje":
		unset($result[0]);
		unset($result[1]);
		unset($result[2]);
		$cuerpo=implode("\n", $result);
		return $cuerpo;
	break;
	case "copia":
		$exec_cmd = _CFG_VPOPMAIL_ALIAS;
		$result=execute_cmd("$exec_cmd $dominio");
		for($i=0;$i<count($result);$i++)
		{
			if(strpos($result[$i],$cuenta)!==false && strpos($result[$i],"autorespond")===false){
				list($cuenta, $copia) =split(_CFG_VPOPMAIL_CFG_CUENTAALIAS, $result[$i], 2);
				return substr(trim($copia),1);
			}
		}
	break;
	}
}

function vpopmail_autorespondadd($cuenta,$cuentacopia,$asunto,$mensaje,$dominio){
	$directorio=vpopmail_homedir($dominio)."/".strtoupper($cuenta);
	if(!file_exists($directorio)){
		$result = execute_cmd("mkdir $directorio");
	}
	$result = execute_cmd("echo $cuerpo>/tmp/message");

	$cuerpo="From: $cuenta@$dominio\n";
	$cuerpo.="Subject: $asunto\n";
	$cuerpo.="\n";
	$cuerpo.=$mensaje;
	$fichero_nuevo=fopen("/tmp/message","w");
	fputs($fichero_nuevo,$cuerpo);
	fclose($fichero_nuevo);
	//Mueve el fichero temporal creado
	$result = execute_cmd("mv -f /tmp/message $directorio/message");
	$result = execute_cmd("chown -R "._CFG_VPOPMAIL_USER."."._CFG_VPOPMAIL_GROUP." $directorio");
	$result = execute_cmd("chmod 700 $directorio");
	$result = execute_cmd("chmod 600 $directorio/message");
	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	//Borra primero, por si habia uno anterior definido
	$result = execute_cmd("$exec_cmd -d '$cuenta@$dominio'");
	//Crea despues los alias para el autorespond
	$result = execute_cmd("$exec_cmd -i '|"._CFG_VPOPMAIL_AUTORESPOND." 10000 5 $directorio/message $directorio' '$cuenta@$dominio'");
	if($cuentacopia!=""){
		$result = execute_cmd("$exec_cmd -i '&$cuentacopia' '$cuenta@$dominio'");
	}
	return $result;
}

function vpopmail_homedir($dominio){
	$array_listado=Array();

	$exec_cmd = _CFG_VPOPMAIL_INFODOMAIN;
	$result = execute_cmd("$exec_cmd  -a $dominio|"._CFG_CMD_GREP." -e "._CFG_VPOPMAIL_CFG_DIR." |"._CFG_CMD_CUT." -d\":\" -f2");
	return trim($result[0]);
}

function vpopmail_autoresponddel($usuario,$dominio){
	list($cuenta,$cadena)=split("@",$usuario,2);
	$directorio=vpopmail_homedir($dominio)."/".strtoupper($cuenta);
	$result = execute_cmd("rm -R $directorio");
	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	$result = execute_cmd("$exec_cmd -d $usuario");
	return $result;
}

function vpopmail_cuenta_autorespondread($usuario,$dominio,$flag){
	$directorio=vpopmail_homedir($dominio)."/$usuario/vacation";
	$result = execute_cmd(_CFG_CMD_CAT." $directorio/message");

	switch($flag){
        case "asunto":
		list($cadena, $asunto) =split("Subject: ", $result[1], 2);
		return $asunto;
	break;
        case "mensaje":
		unset($result[0]);
		unset($result[1]);
		unset($result[2]);
		$cuerpo=implode("\n", $result);
		return $cuerpo;
	break;
	case "estado":
		if($result[0]<>""){
			return true;
		}else{
			return false;
		}
	break;
	}
}

function vpopmail_cuenta_autorespondadd($cuenta,$asunto,$mensaje,$dominio){
	$directorio=vpopmail_homedir($dominio)."/$cuenta/vacation";
	$directorio_usuario=vpopmail_homedir($dominio)."/$cuenta";
	if(!file_exists($directorio)){
		$result = execute_cmd("mkdir $directorio");
	}
	//Crea el mensaje de autorespuesta
	$cuerpo="From: $cuenta@$dominio\n";
	$cuerpo.="Subject: $asunto\n";
	$cuerpo.="\n";
	$cuerpo.=$mensaje;
	$fichero_nuevo=fopen("/tmp/message","w");
	fputs($fichero_nuevo,$cuerpo);
	fclose($fichero_nuevo);
	//Mueve el fichero temporal creado
	$result = execute_cmd("mv -f /tmp/message $directorio/message");
	$result = execute_cmd("chown -R "._CFG_VPOPMAIL_USER."."._CFG_VPOPMAIL_GROUP." $directorio");
	$result = execute_cmd("chmod 700 $directorio");
	$result = execute_cmd("chmod 600 $directorio/message");
	//Crear la autorespuesta
	$result = execute_cmd("rm -f /tmp/tmpqmail");
	$result = execute_cmd("touch /tmp/tmpqmail");
	$result = execute_cmd("chmod 777 /tmp/tmpqmail");
	$result = execute_cmd(_CFG_CMD_CAT." $directorio_usuario/.qmail");
	for($i=0;$i<count($result);$i++)
	{
		execute_cmd("echo \"".addslashes_cmd(trim($result[$i]))."\" >> /tmp/tmpqmail");	
	}
	$result = execute_cmd("echo \"$directorio_usuario/Maildir/\">> /tmp/tmpqmail");
	$result = execute_cmd("echo \"|"._CFG_VPOPMAIL_AUTORESPOND." 86400 3 $directorio/message $directorio \">> /tmp/tmpqmail");
	$result = execute_cmd("mv -f /tmp/tmpqmail $directorio_usuario/.qmail");
	$result = execute_cmd("chown "._CFG_VPOPMAIL_USER."."._CFG_VPOPMAIL_GROUP." $directorio_usuario/.qmail");
	$result = execute_cmd("chmod 600 $directorio_usuario/.qmail");

	return $result;
}

function vpopmail_cuenta_autoresponddel($cuenta,$dominio){
	$directorio=vpopmail_homedir($dominio)."/$cuenta";
	$result = execute_cmd("rm -R $directorio/vacation");
	$result = execute_cmd("rm -f /tmp/tmpqmail");
	$result = execute_cmd("touch /tmp/tmpqmail");
	$result = execute_cmd("chmod 777 /tmp/tmpqmail");
	$result = execute_cmd(_CFG_CMD_CAT." $directorio/.qmail");
	for($i=0;$i<count($result);$i++)
	{
		if(strpos($result[$i],_CFG_VPOPMAIL_AUTORESPOND)===false AND strpos($result[$i],"$directorio/Maildir/")===false){
			execute_cmd("echo \"".addslashes_cmd(trim($result[$i]))."\" >> /tmp/tmpqmail");	
		}
	}
	if(filesize("/tmp/tmpqmail")>0){
		$result = execute_cmd("mv -f /tmp/tmpqmail $directorio/.qmail");
	}else{
		$result = execute_cmd("rm -f /tmp/tmpqmail");
		$result = execute_cmd("rm -f $directorio/.qmail");
	}
	$result = execute_cmd("chown "._CFG_VPOPMAIL_USER."."._CFG_VPOPMAIL_GROUP." $directorio/.qmail");
	$result = execute_cmd("chmod 600 $directorio/.qmail");

	return $result;
}

function vpopmail_domaindel($dominio){
	$exec_cmd = _CFG_VPOPMAIL_DELDOMAIN;
	$result = execute_cmd("$exec_cmd $dominio");
	return $result;
}

function vpopmail_cuentadel($usuario,$dominio){
	$exec_cmd = _CFG_VPOPMAIL_DELUSER;
	$result = execute_cmd("$exec_cmd $usuario@$dominio");
	return $result;
}

function vpopmail_aliasdel($usuario){
	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	$result = execute_cmd("$exec_cmd -d $usuario");
	return $result;
}

function vpopmail_domaintotalcuentas($dominio){
	$exec_cmd = _CFG_VPOPMAIL_INFODOMAIN;
	$result = execute_cmd("$exec_cmd -t $dominio");
	return $result[0];
}

function vpopmail_domaindirectory($dominio){
	$exec_cmd = _CFG_VPOPMAIL_INFODOMAIN;
	$result = execute_cmd("$exec_cmd -d $dominio");
	return $result[0];
}

function vpopmail_cuentaantispam($cuenta,$dominio,$flag){

	$directorio=vpopmail_homedir($dominio)."/".$cuenta;
	switch($flag){
	case "add":
		$result = execute_cmd("rm -f /tmp/tmpqmail");
		$result = execute_cmd("touch /tmp/tmpqmail");
		$result = execute_cmd("chmod 777 /tmp/tmpqmail");	
		$result = execute_cmd("echo \"".addslashes_cmd(_CFG_VPOPMAIL_CFG_ANTISPAM)."\" >> /tmp/tmpqmail");
		$result = execute_cmd(_CFG_CMD_CAT." $directorio/.qmail");
		for($i=0;$i<count($result);$i++)
		{
			$error = execute_cmd("echo \"".addslashes_cmd(trim($result[$i]))."\" >> /tmp/tmpqmail");
		}
		$result = execute_cmd("mv -f /tmp/tmpqmail $directorio/.qmail");
		$result = execute_cmd("chown "._CFG_VPOPMAIL_USER."."._CFG_VPOPMAIL_GROUP." $directorio/.qmail");
		$result = execute_cmd("chmod 600 $directorio/.qmail");
		$result = execute_cmd("rm -f /tmp/tmpqmail"); 
	break;
	case "delete":
		$result = execute_cmd("rm -f /tmp/tmpqmail");
		$result = execute_cmd("touch /tmp/tmpqmail");
		$result = execute_cmd("chmod 777 /tmp/tmpqmail");
		$result = execute_cmd(_CFG_CMD_CAT." $directorio/.qmail");
		for($i=0;$i<count($result);$i++)
		{
			if(strpos($result[$i],_CFG_VPOPMAIL_CFG_ANTISPAM)===false){
				execute_cmd("echo \"".addslashes_cmd(trim($result[$i]))."\" >> /tmp/tmpqmail");	
			}
		}
		if(filesize("/tmp/tmpqmail")>0){
			$result = execute_cmd("mv -f /tmp/tmpqmail $directorio/.qmail");
		}else{
			$result = execute_cmd("rm -f /tmp/tmpqmail");
			$result = execute_cmd("rm -f $directorio/.qmail");
		}
		$result = execute_cmd("chown "._CFG_VPOPMAIL_USER."."._CFG_VPOPMAIL_GROUP." $directorio/.qmail");
		$result = execute_cmd("chmod 600 $directorio/.qmail");
		$result = execute_cmd("rm -f /tmp/tmpqmail"); 
	break;
        case "estado":
		$resultado=false;
		$result=execute_cmd(_CFG_CMD_CAT." $directorio/.qmail");
		for($i=0;$i<count($result);$i++)
		{
			if(strpos($result[$i],_CFG_VPOPMAIL_CFG_ANTISPAM)!==false){
				$resultado=true;
			}
		}
		return $resultado;
	break;
	}
}

function vpopmail_cuentalimits($usuario,$dominio,$flag){
	$exec_cmd = _CFG_VPOPMAIL_INFOUSER;
	$result = execute_cmd("$exec_cmd $usuario@$dominio");
	switch($flag){
         case "estado":
		$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_CUENTAESTADO);
		if ($pos!=""){
			$value_result=0;
		}else{
			$value_result=1;
		}
	 break;
 	case "quota":
	 	$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_CUENTAQUOTA);
		$config_string=$result[$pos];
		$mQuotaBytes=trim(substr($config_string,strlen(_CFG_VPOPMAIL_CFG_CUENTAQUOTA)+1));
		$mQuota=bitconversor($mQuotaBytes,"byte","mbyte");
		if($mQuotaBytes==0){
			$value_result="NOQUOTA";
		}elseif($mQuota<1){
			$value_result=bitconversor($mQuotaBytes,"byte","kbyte")."K";
		}else{
			$value_result=bitconversor($mQuotaBytes,"byte","mbyte")."M";
		}
	break;
 	}	
	
	return $value_result;
}

function vpopmail_domainlimits($dominio,$flag){
	$exec_cmd = _CFG_VPOPMAIL_DOMAINLIMITS;
	$result = execute_cmd("$exec_cmd -S $dominio");
	switch($flag){
         case "estado":
		$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_ESTADO);
		if ($pos!=""){
			$value_result=0;
		}else{
			$value_result=1;
		}
	 break;
   	 case "cuentas":
	        $pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_CUENTAS);
        	$config_string=$result[$pos];
        	$value_result=substr($config_string,strlen(_CFG_VPOPMAIL_CFG_CUENTAS)+1);
	 break;
         case "alias":
		$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_ALIAS);
		$config_string=$result[$pos];
		$value_result=substr($config_string,strlen(_CFG_VPOPMAIL_CFG_ALIAS)+1);
	 break;	 
         case "redirecciones":
		$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_REDIRECCIONES);
		$config_string=$result[$pos];
		$value_result=substr($config_string,strlen(_CFG_VPOPMAIL_CFG_REDIRECCIONES)+1);
	 break;	 
         case "autorespuesta":
		$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_AUTORESPUESTA);
		$config_string=$result[$pos];
		$value_result=substr($config_string,strlen(_CFG_VPOPMAIL_CFG_AUTORESPUESTA)+1);
	 break;	  
	 case "listas":
		$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_LISTA);
		$config_string=$result[$pos];
		$value_result=substr($config_string,strlen(_CFG_VPOPMAIL_CFG_LISTA)+1);
	 break;	  
	 case "quota":
	 	$pos=array_search_stringarray($result,_CFG_VPOPMAIL_CFG_QUOTA);
		$config_string=$result[$pos];
		$mQuotaBytes=substr($config_string,strlen(_CFG_VPOPMAIL_CFG_QUOTA)+1);
		$mQuota=bitconversor($mQuotaBytes,"byte","mbyte");
		if($mQuotaBytes==0){
			$value_result="NOQUOTA";
		}elseif($mQuota<1){
			$value_result=bitconversor($mQuotaBytes,"byte","kbyte")."K";
		}else{
			$value_result=bitconversor($mQuotaBytes,"byte","mbyte")."M";
		}
	break;
	}	
	return $value_result;
}

function vpopmail_cuentaquota($usuario,$dominio,$quota){
	$exec_cmd = _CFG_VPOPMAIL_QUOTAUSER;
	$result = execute_cmd("$exec_cmd $usuario@$dominio $quota");
	return $result;
}

function vpopmail_domainquota($dominio,$quota){
	$exec_cmd = _CFG_VPOPMAIL_QUOTAUSER;
	$result = execute_cmd("$exec_cmd $dominio $quota");
	return $result;
}

function vpopmail_usershowpasswd($usuario,$dominio){
	$exec_cmd = _CFG_VPOPMAIL_INFOUSER;
	$result = execute_cmd("$exec_cmd -C $usuario@$dominio");
	return $result[0];
}

function vpopmail_userpasswd($usuario,$dominio,$password){
	if ($password!=""){
		$exec_cmd = _CFG_VPOPMAIL_PASSWDUSER;
		$result = execute_cmd("$exec_cmd $usuario@$dominio $password");
		return $result;
	}
}

function vpopmail_domainconf($dominio,$flag,$value){
	$exec_cmd = _CFG_VPOPMAIL_DOMAINLIMITS;
	switch($flag){
         case "cuentas":
		$result = execute_cmd("$exec_cmd -P $value $dominio");	
	 break;	 
         case "alias":
		$result = execute_cmd("$exec_cmd -A $value $dominio");	
	 break;	 
         case "redirecciones":
		$result = execute_cmd("$exec_cmd -F $value $dominio");
	 break;	 
         case "autorespuesta":
		$result = execute_cmd("$exec_cmd -R $value $dominio");	
	 break;	  
	 case "listas":
		$result = execute_cmd("$exec_cmd -L $value $dominio");
	 break;	  
	 case "quota":
		$result = execute_cmd("$exec_cmd -q $value $dominio");
	 break;	  
	}	
	return $result;
}

function vpopmail_cuentaonoff($usuario,$dominio,$estado){
	$exec_cmd = _CFG_VPOPMAIL_CUENTALIMITS;
	if($estado==1){
		$result = execute_cmd("$exec_cmd -x $usuario@$dominio");
	}else{
		$result = execute_cmd("$exec_cmd -pswi $usuario@$dominio");
	}
}

function vpopmail_domainonoff($dominio,$estado){
	$exec_cmd = _CFG_VPOPMAIL_DOMAINLIMITS;
	if($estado==1){
		$result = execute_cmd("$exec_cmd -g o $dominio");
	}else{
		$result = execute_cmd("$exec_cmd -g pwi $dominio");
	}
}
?>
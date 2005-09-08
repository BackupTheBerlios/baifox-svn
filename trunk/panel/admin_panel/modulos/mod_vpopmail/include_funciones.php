<?php

function vpopmail_info(){
	$info["nombre"]="Vpopmail";
	$info["version"]="1.0";
	$info["grupo"]="servicios";

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
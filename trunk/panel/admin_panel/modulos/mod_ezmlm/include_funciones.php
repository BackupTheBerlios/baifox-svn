<?php

function ezmlm_info(){
	$info["nombre"]="Ezmlm";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="false";

	return $info;
}

function ezmlm_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_ezmlm test...<br>";
	$test[1].= "==================<br>";
	if (!file_exists(_CFG_SUDO)){
		$test[1].= "[ERROR] No existe el fichero "._CFG_SUDO."<br>";
		$test[0]=false;
	}

	if($test[0])
		$test[1].= "El m�dulo esta correctamente instalado<br>";
	return $test;
}

function ezmlm_list($dominio){
	$array_listas=Array();

	$exec_cmd = _CFG_VPOPMAIL_ALIAS;
	$result = execute_cmd("$exec_cmd $dominio");
	$x=0;
	for($i=0;$i<count($result);$i++)
	{
		if(strpos($result[$i],"ezmlm-reject")!==false){
			list($cuenta_origen, $cuenta_destino) =split(_CFG_VPOPMAIL_CFG_CUENTAALIAS, $result[$i], 2);
			$array_listas[$x]=trim($cuenta_origen);
			$x++;
		}
	}
	array_multisort($array_listas);

	return $array_listas;
}

function ezmlm_setreplyto ($fichero,$cadena,$dominio,$lista)
{
  $directorio=ezmlm_homedir($dominio);
  $result = execute_cmd("cat $directorio/$lista/$fichero"); 
  $fichero_nuevo=fopen("/tmp/$fichero","w");
  foreach($result as $line)
  {
	if(strpos($line,"Reply-To")===false)
		fputs($fichero_nuevo,$line."\n");
  }
  fputs($fichero_nuevo,$cadena);
  fclose($fichero_nuevo);
  $result = execute_cmd("mv -f /tmp/$fichero $directorio/$lista");  
}

function ezmlm_crearlista($dominio,$lista,$opciones,$respuesta,$email_respuesta){
	$exec_cmd = _CFG_EZMLM_MAKE;
	$directorio=ezmlm_homedir($dominio);
	$result = execute_cmd("$exec_cmd -$opciones $directorio/$lista $directorio/.qmail-$lista $lista $dominio");

	switch($respuesta){
	case "REPLYTO_SENDER":
		ezmlm_setreplyto ("headeradd", "",$dominio,$lista);
		ezmlm_setreplyto ("headerremove", "",$dominio,$lista);
	break;
	case "REPLYTO_LIST":
		ezmlm_setreplyto ("headeradd", "Reply-To: <#l#>@<#h#>\n",$dominio,$lista);
		ezmlm_setreplyto ("headerremove", "Reply-To",$dominio,$lista);
	break;
	case "REPLYTO_ADDRESS":
		ezmlm_setreplyto ("headeradd", "Reply-To: $email_respuesta\n",$dominio,$lista);
		ezmlm_setreplyto ("headerremove", "Reply-To",$dominio,$lista);
	break;
	}

	$result = execute_cmd("echo '$dominio-$lista' >/tmp/inlocal");
	$result = execute_cmd("mv /tmp/inlocal $directorio/$lista");
	$result = execute_cmd("echo '$dominio' >/tmp/inhost");
	$result = execute_cmd("mv /tmp/inhost $directorio/$lista");

	$result = execute_cmd("chown -R "._CFG_VPOPMAIL_USER."."._CFG_VPOPMAIL_GROUP." $directorio/$lista");

	return true;
}

function ezmlm_deletelista($dominio,$lista){
	$directorio=ezmlm_homedir($dominio);
	list($lista_correo, $dominio_lista) =split("@", $lista, 2);
	$result = execute_cmd("rm -R $directorio/$lista_correo");
	$result = execute_cmd("rm $directorio/.qmail-".$lista_correo);
	$result = execute_cmd("rm $directorio/.qmail-".$lista_correo."-default");
	$result = execute_cmd("rm $directorio/.qmail-".$lista_correo."-owner");
	$result = execute_cmd("rm $directorio/.qmail-".$lista_correo."-return-default");
	$result = execute_cmd("rm $directorio/.qmail-".$lista_correo."-reject-default");
	$result = execute_cmd("rm $directorio/.qmail-".$lista_correo."-accept-default");

	return true;
}

function ezmlm_listasucritos($dominio,$lista,$flag){
	$array_listas=Array();

	list($lista_correo, $dominio_lista) =split("@", $lista, 2);
	$directorio=ezmlm_homedir($dominio);
	$exec_cmd = _CFG_EZMLM_LIST;
	switch($flag){
	case "mod":
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo/mod");
	break;
	case "digest":
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo/digest");
	break;
	default:
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo");
	break;
	}
	$x=0;
	for($i=0;$i<count($result);$i++)
	{
		$array_listas[$x]=trim($result[$i]);
		$x++;
	}
	array_multisort($array_listas);

	return $array_listas;
}

function ezmlm_addsucritos($dominio,$lista,$email,$flag){
	list($lista_correo, $dominio_lista) =split("@", $lista, 2);
	$directorio=ezmlm_homedir($dominio);
	$exec_cmd = _CFG_EZMLM_SUB;
	switch($flag){
	case "mod":
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo/mod $email");
	break;
	case "digest":
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo/digest $email");
	break;
	default:
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo $email");
	break;
	}

	return true;
}

function ezmlm_delsucritos($dominio,$lista,$email,$flag){
	list($lista_correo, $dominio_lista) =split("@", $lista, 2);
	$directorio=ezmlm_homedir($dominio);
	$exec_cmd = _CFG_EZMLM_UNSUB;
	switch($flag){
	case "mod":
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo/mod $email");
	break;
	case "digest":
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo/digest $email");
	break;
	default:
		$result = execute_cmd("$exec_cmd -N $directorio/$lista_correo $email");
	break;
	}

	return true;
}

function ezmlm_homedir($dominio){
	$array_listado=Array();

	$exec_cmd = _CFG_VPOPMAIL_INFODOMAIN;
	$result = execute_cmd("$exec_cmd  -a $dominio|"._CFG_CMD_GREP." -e "._CFG_VPOPMAIL_CFG_DIR." |"._CFG_CMD_CUT." -d\":\" -f2");
	return trim($result[0]);
}

?>
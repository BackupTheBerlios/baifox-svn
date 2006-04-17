<?php

function pureftpd_info(){
	$info["nombre"]="PureFTPd";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="true";

	return $info;
}

function pureftpd_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_pureftpd test...<br>";
	$test[1].= "==================<br>";
   	if (!($link=@mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD)))
   	{
		$test[1].= "[ERROR] Conectando al mysql <br>";
		$test[0]=false;
   	}
   	if (!@mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link))
   	{
		$test[1].= "[ERROR] Conectando a la base de datos "._CFG_INTERFACE_MYSQLDB."<br>";
		$test[0]=false;
	}
	if(@mysql_num_rows(mysql_query("SHOW TABLES LIKE '"._CFG_PUREFTPD_TABLE."'",$link))<1){
		$test[1].= "[ERROR] No se existe la tabla "._CFG_PUREFTPD_TABLE."<br>";
		$test[0]=false;
	}
	@mysql_close($link);

	if($test[0])
		$test[1].= "El módulo esta correctamente instalado<br>";
	return $test;
}

function pureftpd_listftp(){
   $array_modules=array();
   $link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
   mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);

   $result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." order by dominio",$link);

   while($rs = mysql_fetch_array($result)) {
 		$array_modules[]=$rs;
     }
   return $array_modules;
   @mysql_close($link);
}

function pureftpd_cron(){
   $array_modules=array();
   $resultado=Array();
   $link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
   mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);

   $result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." order by dominio",$link);

   while($rs = mysql_fetch_array($result)) {
		if (file_exists($rs["homedir"]) and $rs["tipo"]==1) {
			$exec_cmd = _CFG_PUREFTPD_QUOTACHECK;
			$resultado[]="Actualizando quota para ".$rs["homedir"];
			execute_cmd("$exec_cmd -u "._CFG_PUREFTPD_UID." -g "._CFG_PUREFTPD_GID." -d ".$rs["homedir"]);
		}
     }
   return $resultado;
   @mysql_close($link);
}

function pureftpd_domainread($id){
   $link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
   mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);

   $result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." WHERE id=$id",$link);
   return mysql_fetch_array($result);
   @mysql_close($link);
}

function pureftpd_passwd($dominio,$usuario,$password,$homedir,$tipo){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
	if($password!="")
		$sqladd="password=ENCRYPT('$password'),";
        mysql_query("UPDATE "._CFG_PUREFTPD_TABLE." SET dominio='$dominio',usuario='$usuario',$sqladd homedir='$homedir' where dominio='$dominio' AND usuario='$usuario';",$link);
	
	$EDIT_ID=xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario,"posicion"); 
	if($EDIT_ID!=0){
		//Crea copia seguridad antes de modificar
		xmlconfig_backup(_CFG_XML_FTP);

		//Crea la configuracion en el XML
		$conf = new patConfiguration;
		$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
		$conf->parseConfigFile(_CFG_XML_FTP,a);

		if($password!=""){
			$set_password=md5_encrypt($password,_CFG_INTERFACE_BLOWFISH);
		}else{
			$datos=xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario,"datos");
			$set_password=$datos["PASSWORD"];
		}	

		$conf->setConfigValue($EDIT_ID, array(
	 		"ID" 	  => $EDIT_ID,
	 		"DOMINIO" => $dominio,
	 		"HOMEDIR"=> $homedir,
	 		"USUARIO" => $usuario, 
	 		"PASSWORD" => $set_password,
	 		"TIPO" => $tipo)
		, "array");
		$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
	}
	//Fin fichero configuracion XML}
	@mysql_close($link);
	return true;
}

function pureftpd_crearsecundario($dominio,$usuario,$password,$homedir,$quotasize,$tipo){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
	$result=mysql_query("SELECT * FROM "._CFG_PUREFTPD_TABLE." WHERE usuario='$usuario';",$link);
	if(mysql_numrows($result)<=0){
		//Crea el usuario en la base de datos
		mysql_query("INSERT INTO "._CFG_PUREFTPD_TABLE."(id,dominio,usuario,password,homedir,quotafile,quotasize,estado,tipo) VALUES ('', '$dominio','$usuario',ENCRYPT('$password'),'$homedir',0,$quotasize,1,2);",$link);

		$EXISTE=xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario,"posicion"); 
		if($EXISTE==0){
			//Crea copia seguridad antes de modificar
			xmlconfig_backup(_CFG_XML_FTP);

			//Crea la configuracion en el XML
			$conf = new patConfiguration;
			$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
			$conf->parseConfigFile(_CFG_XML_FTP,a);
			$NEW_ID=xmlconfig_generaid(_CFG_XML_FTP);
			$conf->setConfigValue($NEW_ID, array(
		 		"ID" 	  => $NEW_ID,
	 			"DOMINIO" => $dominio,
		 		"HOMEDIR"=> $homedir,
	 			"USUARIO" => $usuario, 
	 			"PASSWORD" => md5_encrypt($password,_CFG_INTERFACE_BLOWFISH),
				"TIPO" => $tipo)
			, "array");
			$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
			//Fin fichero configuracion XML
		}
		$resultado=true;
	}else{
		$resultado=false;
	}
	mysql_free_result($result);
	@mysql_close($link);
	return $resultado;
}

function pureftpd_deletesecundario($usuario,$dominio){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
        mysql_query("DELETE FROM "._CFG_PUREFTPD_TABLE." WHERE dominio='$dominio' AND usuario='$usuario';",$link);
	//Crea la configuracion en el XML
	if($usuario!="" AND $dominio!=""){
		//Crea copia seguridad antes de modificar
		xmlconfig_backup(_CFG_XML_FTP);

		$conf = new patConfiguration;
		$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
		$conf->parseConfigFile(_CFG_XML_FTP,a);
		$conf->clearConfigValue(xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario,"posicion")); 
		$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
	}
	//Fin fichero configuracion XML}
	@mysql_close($link);
}

function pureftpd_crear($dominio,$usuario,$usuario_actual,$password,$homedir,$quotasize,$estado,$id,$tipo){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
	if($id!=0){
		if($password!="")
			$sqladd="password=ENCRYPT('$password'),";
	        mysql_query("UPDATE "._CFG_PUREFTPD_TABLE." SET dominio='$dominio',usuario='$usuario',$sqladd homedir='$homedir',quotafile=0,quotasize=$quotasize,estado=$estado where ID=$id;",$link);

		//Crea la configuracion en el XML
		$EDIT_ID=xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario_actual,"posicion"); 
		if($EDIT_ID!=0){
			//Crea copia seguridad antes de modificar
			xmlconfig_backup(_CFG_XML_FTP);

	   		$conf = new patConfiguration;
			$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
			$conf->parseConfigFile(_CFG_XML_FTP,a);

			if($password!=""){
				$set_password=md5_encrypt($password,_CFG_INTERFACE_BLOWFISH);
			}else{
				$datos=xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario_actual,"datos");
				$set_password=$datos["PASSWORD"];
			}
			$conf->setConfigValue($EDIT_ID, array(
			 	"ID" 	  => $EDIT_ID,
		 		"DOMINIO" => $dominio,
		 		"HOMEDIR"=> $homedir,
		 		"USUARIO" => $usuario, 
		 		"PASSWORD" => $set_password,
		 		"TIPO" => $tipo)
			, "array");
			$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
		}
		//Fin fichero configuracion XML
	}else{
		$result=mysql_query("SELECT * FROM "._CFG_PUREFTPD_TABLE." WHERE usuario='$usuario';",$link);
		if(mysql_numrows($result)<=0){
			//Crea el directorio
			$result = execute_cmd("mkdir $homedir");
			//Asigna permisos al directorio
			$result = execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $homedir");
			//Crea el usuario en la base de datos
			mysql_query("INSERT INTO "._CFG_PUREFTPD_TABLE."(id,dominio,usuario,password,homedir,quotafile,quotasize,estado,tipo) VALUES ('', '$dominio','$usuario',ENCRYPT('$password'),'$homedir',0,$quotasize,$estado,$tipo);",$link);

			//Crea la configuracion en el XML
			$EXISTE=xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario,"posicion"); 
			if($EXISTE==0){
				//Crea copia seguridad antes de modificar
				xmlconfig_backup(_CFG_XML_FTP);

				$conf = new patConfiguration;
				$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
				$conf->parseConfigFile(_CFG_XML_FTP,a);

				$NEW_ID=xmlconfig_generaid(_CFG_XML_FTP);
				$conf->setConfigValue($NEW_ID, array(
				 	"ID" 	  => $NEW_ID,
		 			"DOMINIO" => $dominio,
		 			"HOMEDIR"=> $homedir,
		 			"USUARIO" => $usuario, 
		 			"PASSWORD" => md5_encrypt($password,_CFG_INTERFACE_BLOWFISH),
					"TIPO" => $tipo)
				, "array");
				$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
			}
			//Fin fichero configuracion XML

			$result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." WHERE dominio='$dominio' and usuario='$usuario' order by id desc",$link);
			if($rs=mysql_fetch_array($result)){
				return $rs["id"];
			}else{
				return 0;
			}
		}else{
			return false;
		}
		mysql_free_result($result);
	}
	@mysql_close($link);
}

function pureftpd_domaindelall($dominio,$borrar_contenido){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
	$result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." WHERE dominio='$dominio'",$link);
	while($rs=mysql_fetch_array($result)){
		pureftpd_domaindel($rs["id"],$borrar_contenido);
	}
	@mysql_close($link);

	//Borramos por si quedan restos
	if($dominio!=""){
		//Crea copia seguridad antes de modificar
		xmlconfig_backup(_CFG_XML_FTP);

		$conf = new patConfiguration;
		$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
		$conf->parseConfigFile(_CFG_XML_FTP);
		$total_registros=count($conf->getConfigValue());
		for($i=1;$x<$total_registros;$i++){
			$rs=$conf->getConfigValue($i);
			if($rs["DOMINIO"]==$dominio){
				$conf->clearConfigValue($i); 
			}
			if($rs)
				$x++;
		}
		$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
	}
}

function pureftpd_domaindel($id,$borrar_contenido){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
	$result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." WHERE id=$id",$link);
	if($rs=mysql_fetch_array($result)){
		$dominio=$rs["dominio"];
		$usuario=$rs["usuario"];
		if($borrar_contenido){
			if (file_exists($rs["homedir"]) AND $rs["homedir"]!="") {
					$exec_cmd = "rm -R -f";
					$result = execute_cmd("$exec_cmd ".$rs["homedir"]);
			}
		}
	}
	mysql_query("delete from "._CFG_PUREFTPD_TABLE." where id=$id",$link);
	@mysql_close($link);

	//Crea la configuracion en el XML
	if($dominio!="" AND $usuario!=""){
		//Crea copia seguridad antes de modificar
		xmlconfig_backup(_CFG_XML_FTP);

   		$conf = new patConfiguration;
		$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
		$conf->parseConfigFile(_CFG_XML_FTP,a);
		$conf->clearConfigValue(xmlconfig_buscar(_CFG_XML_FTP,"DOMINIO",$dominio,"USUARIO",$usuario,"posicion")); 
		$conf->writeConfigFile(_CFG_XML_FTP, "xml", array( "mode" => "pretty" ) );
	}
	//Fin fichero configuracion XML
}

function pureftpd_domainonoffall($dominio,$estado){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
	mysql_query("update "._CFG_PUREFTPD_TABLE." SET estado=$estado where dominio='$dominio'",$link);
	@mysql_close($link);
}

function pureftpd_domainonoff($id,$estado){
	$link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
	mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
	mysql_query("update "._CFG_PUREFTPD_TABLE." SET estado=$estado where id=$id",$link);
	@mysql_close($link);
}

function pureftpd_quotastatus($id){
  if(is_numeric($id)){
   $link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
   mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
   $result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." where id=$id",$link);
   $rs = mysql_fetch_array($result);
   $exec_cmd = _CFG_CMD_CAT;	
   $contenido=execute_cmd("$exec_cmd ".$rs["homedir"]."/.ftpquota");
   list($ficheros, $tamanio)=split(" ", $contenido[0], 2);
   @mysql_close($link);
  }
   return $tamanio;
}

function pureftpd_showstatus($id){
   $link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
   mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
   $result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." where id=$id",$link);
   $rs = mysql_fetch_array($result);
   $exec_cmd = _CFG_CMD_CAT;	
   $contenido=execute_cmd("$exec_cmd ".$rs["homedir"]."/.ftpquota");
   list($ficheros, $tamanio)=split(" ", $contenido[0], 2);
   $contenido= "<table width=\"75%\" border=\"0\" class=\"box\">\n";
   $contenido.= "  <tr class=\"boxheader\"> \n";
   $contenido.= "    <td class=\"boxheader\"><b>Ficheros</b></td>\n";
   $contenido.= "    <td class=\"boxheader\" align=\"center\"><b>Espacio Ocupado</b></td>\n";
   $contenido.= "  </tr>\n";
   $contenido.="  <tr class=\"boxbody\"> \n";
   $contenido.="    <td align=\"right\"><div class=\"fuentecelda\">$ficheros</div></td>\n";
   $contenido.="    <td align=\"right\"><div class=\"fuentecelda\">".number_format(bitconversor($tamanio,"byte","mbyte"), 2, ',', '.')." MB</div></td>\n";
   $contenido.="  </tr>\n";
   $contenido.= "</table>\n";
   @mysql_close($link);

   return $contenido;
}
?>
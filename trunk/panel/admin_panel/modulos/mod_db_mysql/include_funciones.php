<?php

function db_mysql_info(){
	$info["nombre"]="MySQL";
	$info["version"]="1.0";
	$info["grupo"]="servicios";
	$info["visible"]="true";

	return $info;
}

function db_mysql_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_db_mysql test...<br>";
	$test[1].= "==================<br>";
   	if (!($link=@mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD)))
   	{
		$test[1].= "[ERROR] Conectando al mysql <br>";
		$test[0]=false;
   	}
   	if (!@mysql_select_db(_CFG_MYSQL_DB,$link))
   	{
		$test[1].= "[ERROR] Conectando a la base de datos "._CFG_MYSQL_DB."<br>";
		$test[0]=false;
	}

	@mysql_close($link);

	if($test[0])
		$test[1].=  "El módulo esta correctamente instalado<br>";
	return $test;
}

function db_mysql_version($tipo){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	mysql_select_db(_CFG_MYSQL_DB,$link);
	
        $result=mysql_query("SELECT VERSION() AS version;",$link);
        $rs = mysql_fetch_array($result);
	$version['version'] = $rs["version"];
        $explode = explode('.', $version['version']);
        $version['major'] = $explode[0];
        $version['minor'] = $explode[1];
        $version['patch'] = $explode[2];
        $explode = explode('-', $version['patch']);
        $version['patch'] = $explode[0];

	switch($tipo){
	case 0:
		return $version['version'];
	break;
	case 1:
		return $version['major'].".".$version['minor'];
	break;
	}	
	mysql_close($link);
}

function db_mysql_listdbase(){
   $array_modules=array();
   $link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
   mysql_select_db(_CFG_MYSQL_DB,$link);
   $result=mysql_list_dbs($link);
 
   while($rs = mysql_fetch_object($result)) {
 		$array_modules[]=$rs->Database;
     }
   return $array_modules;
}

function db_mysql_password($dominio,$dbase,$password){
	if($password!=""){
		$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
		mysql_select_db(_CFG_MYSQL_DB,$link);
		$version=db_mysql_version(1);
		switch($version){
		case "3.23":
			mysql_query("UPDATE user SET Password=PASSWORD('$password') WHERE User='$dbase';",$link);
		break;
		case "4.0":
			mysql_query("UPDATE user SET Password=PASSWORD('$password') WHERE User='$dbase';",$link);
		break;
		case "4.1":
			mysql_query("UPDATE user SET Password=OLD_PASSWORD('$password') WHERE User='$dbase';",$link);
		break;
		case "5.0":
			mysql_query("UPDATE user SET Password=OLD_PASSWORD('$password') WHERE User='$dbase';",$link);
		break;
		}
 		@mysql_query("FLUSH PRIVILEGES;",$link);
		mysql_close($link);

		//Crea la configuracion en el XML
		$EDIT_ID=xmlconfig_buscar(_CFG_XML_BASEDATOS,"DOMINIO",$dominio,"DATABASE",$dbase,"posicion"); 
		if($EDIT_ID!=0){
			//Crea copia seguridad antes de modificar
			xmlconfig_backup(_CFG_XML_BASEDATOS);

			$mPassword=md5_encrypt($password,_CFG_INTERFACE_BLOWFISH);

			$conf = new patConfiguration;
			$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
			$conf->parseConfigFile(_CFG_XML_BASEDATOS,a);
	
			$conf->setConfigValue($EDIT_ID, array(
	 			"ID" 	  => $EDIT_ID,
	 			"DOMINIO" => $dominio,
	 			"DATABASE"=> $dbase,
	 			"USUARIO" => $dbase, 
	 			"PASSWORD" => $mPassword,
	 			"ESTADO" => 1)
				, "array");
			$conf->writeConfigFile(_CFG_XML_BASEDATOS, "xml", array( "mode" => "pretty" ) );
		}
		//Fin fichero configuracion XML
	}
}

function db_mysql_dbasecrear($dominio,$dbase,$password){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	mysql_select_db(_CFG_MYSQL_DB,$link);
        @mysql_query("CREATE DATABASE `$dbase`;",$link);
	$version=db_mysql_version(1);
	switch($version){
	case "3.23":
		mysql_query("INSERT INTO user VALUES('localhost','$dbase',PASSWORD('$password'),'N','N','N','N','N','N','N','N','N','N','N','N','N','N');",$link);
		mysql_query("INSERT INTO db (Host,Db,User,Select_priv,Insert_priv,Update_priv,Delete_priv,Create_priv,Drop_priv,Grant_priv,References_priv,Index_priv,Alter_priv) values ('localhost','$dbase','$dbase','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');",$link);
	break;
	case "4.0":
		mysql_query("INSERT INTO user VALUES('localhost','$dbase',PASSWORD('$password'),'N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','','','','',0,0,0);",$link);
		mysql_query("INSERT INTO db (Host,Db,User,Select_priv,Insert_priv,Update_priv,Delete_priv,Create_priv,Drop_priv,Grant_priv,References_priv,Index_priv,Alter_priv,Create_tmp_table_priv,Lock_tables_priv) values ('localhost','$dbase','$dbase','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');",$link);
	break;
	case "4.1":
		mysql_query("INSERT INTO user VALUES('localhost','$dbase',OLD_PASSWORD('$password'),'N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','','','','',0,0,0);",$link);
		mysql_query("INSERT INTO db (Host,Db,User,Select_priv,Insert_priv,Update_priv,Delete_priv,Create_priv,Drop_priv,Grant_priv,References_priv,Index_priv,Alter_priv,Create_tmp_table_priv,Lock_tables_priv) values ('localhost','$dbase','$dbase','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');",$link);
	break;
	case "5.0":
		mysql_query("INSERT INTO user VALUES('localhost','$dbase',OLD_PASSWORD('$password'),'N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','','','','',0,0,0,0);",$link);
		mysql_query("INSERT INTO db (Host,Db,User,Select_priv,Insert_priv,Update_priv,Delete_priv,Create_priv,Drop_priv,Grant_priv,References_priv,Index_priv,Alter_priv,Create_tmp_table_priv,Lock_tables_priv) values ('localhost','$dbase','$dbase','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');",$link);
	break;
	}
        @mysql_query("FLUSH PRIVILEGES;",$link);
	mysql_close($link);

	//Crea la configuracion en el XML
	$EXISTE=xmlconfig_buscar(_CFG_XML_BASEDATOS,"DOMINIO",$dominio,"DATABASE",$dbase,"posicion"); 
	if($EXISTE==0){
		//Crea copia seguridad antes de modificar
		xmlconfig_backup(_CFG_XML_BASEDATOS);

		$conf = new patConfiguration;
		$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
		$conf->parseConfigFile(_CFG_XML_BASEDATOS,a);

		$NEW_ID=xmlconfig_generaid(_CFG_XML_BASEDATOS);
		$conf->setConfigValue($NEW_ID, array(
		 	"ID" 	  => $NEW_ID,
		 	"DOMINIO" => $dominio,
		 	"DATABASE"=> $dbase,
		 	"USUARIO" => $dbase, 
		 	"PASSWORD" => md5_encrypt($password,_CFG_INTERFACE_BLOWFISH),
		 	"ESTADO" => 1)
		, "array");
		$conf->writeConfigFile(_CFG_XML_BASEDATOS, "xml", array( "mode" => "pretty" ) );
		//Fin fichero configuracion XML
	}
}

function db_mysql_dbasedelall($dominio){
	//Crea copia seguridad antes de modificar
	xmlconfig_backup(_CFG_XML_BASEDATOS);

	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_BASEDATOS);
	$total_registros=count($conf->getConfigValue());
	for($i=1;$x<$total_registros;$i++){
		$rs=$conf->getConfigValue($i);
		if($rs["DOMINIO"]==$dominio)
			db_mysql_dbasedel($dominio,$rs["DATABASE"]);
		if($rs)
			$x++;
	}
}

function db_mysql_dbasedel($dominio,$dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	mysql_select_db(_CFG_MYSQL_DB,$link);
        @mysql_query("DROP DATABASE `$dbase`;",$link);
	@mysql_query("delete from user where User='$dbase'",$link);
        @mysql_query("delete from db where Db='$dbase' and User='$dbase';",$link);
        @mysql_query("FLUSH PRIVILEGES;",$link);
	mysql_close($link);

	//Crea la configuracion en el XML
	if($dominio!="" AND $dbase!=""){
		//Crea copia seguridad antes de modificar
		xmlconfig_backup(_CFG_XML_BASEDATOS);

   		$conf = new patConfiguration;
		$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
		$conf->parseConfigFile(_CFG_XML_BASEDATOS,a);
		$conf->clearConfigValue(xmlconfig_buscar(_CFG_XML_BASEDATOS,"DOMINIO",$dominio,"DATABASE",$dbase,"posicion")); 
		$conf->writeConfigFile(_CFG_XML_BASEDATOS, "xml", array( "mode" => "pretty" ) );
	}
	//Fin fichero configuracion XML
}

function db_mysql_quotaall($dominio){
	$total=0;
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_BASEDATOS);
	$total_registros=count($conf->getConfigValue());
	for($i=1;$x<$total_registros;$i++){
		$rs=$conf->getConfigValue($i);
		if($rs["DOMINIO"]==$dominio){
			$totalbase=db_mysql_quotastatus($rs["DATABASE"]);
			$total=$total+$totalbase;
		}
		if($rs)
			$x++;
	}
	return $total;
}

function db_mysql_quotastatus($dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	$database_tam = 0;
	if(mysql_select_db($dbase,$link)){
		$result = mysql_query("SHOW TABLE STATUS"); 
		while ($rs = mysql_fetch_array($result)) { 
			$database_tam += $rs['Data_length'] + $rs['Index_length']; 
		}
	}
	mysql_close($link);
	return $database_tam;
}

function db_mysql_checkdatabase($dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	if(mysql_select_db($dbase,$link)){
		$contenido= "<table width=\"80%\" border=\"0\" class=\"box\">\n";
		$contenido.= "  <tr class=\"boxheader\"> \n";
		$contenido.= "    <td class=\"boxheader\"><b>Tabla</b></td>\n";
		$contenido.= "    <td class=\"boxheader\" align=\"center\"><b>Estado</b></td>\n";
		$contenido.= "  </tr>\n";
		$result = mysql_query("SHOW TABLE STATUS"); 
		while ($rs = mysql_fetch_array($result)) { 
			$result1 = mysql_query("CHECK TABLE ".$rs["Name"]); 
			$rs1 = mysql_fetch_array($result1);
			$contenido.="  <tr class=\"boxbody\"> \n";
			$contenido.="    <td><div class=\"fuentecelda\">".$rs1["Table"]."</div></td>\n";
			$contenido.="    <td align=\"center\"><div class=\"fuentecelda\">".$rs1["Msg_text"]."</div></td>\n";
			$contenido.="  </tr>\n";
			mysql_free_result($result1);
		}
		$contenido.= "</table>\n";
		mysql_close($link);
	}

	return $contenido;
}

function db_mysql_repairdatabase($dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	if(mysql_select_db($dbase,$link)){
		$contenido= "<table width=\"80%\" border=\"0\" class=\"box\">\n";
		$contenido.= "  <tr class=\"boxheader\"> \n";
		$contenido.= "    <td class=\"boxheader\"><b>Tabla</b></td>\n";
		$contenido.= "    <td class=\"boxheader\" align=\"center\"><b>Estado</b></td>\n";
		$contenido.= "  </tr>\n";
		$result = mysql_query("SHOW TABLE STATUS"); 
		while ($rs = mysql_fetch_array($result)) { 
			$result1 = mysql_query("REPAIR TABLE ".$rs["Name"]); 
			$rs1 = mysql_fetch_array($result1);
			$contenido.="  <tr class=\"boxbody\"> \n";
			$contenido.="    <td><div class=\"fuentecelda\">".$rs1["Table"]."</div></td>\n";
			$contenido.="    <td align=\"center\"><div class=\"fuentecelda\">".$rs1["Msg_text"]."</div></td>\n";
			$contenido.="  </tr>\n";
			mysql_free_result($result1);
		}
		$contenido.= "</table>\n";
		mysql_close($link);
	}

	return $contenido;
}

function db_mysql_showstatus($dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	if(mysql_select_db($dbase,$link)){
		$result = mysql_query("SHOW TABLE STATUS"); 
		$database_tam = 0; 
		$database_registros=0;
		$contenido= "<table width=\"80%\" border=\"0\" class=\"box\">\n";
		$contenido.= "  <tr class=\"boxheader\"> \n";
		$contenido.= "    <td class=\"boxheader\"><b>Tabla</b></td>\n";
		$contenido.= "    <td class=\"boxheader\" align=\"center\"><b>Registros</b></td>\n";
		$contenido.= "    <td class=\"boxheader\" align=\"center\"><b>Espacio</b></td>\n";
		$contenido.= "  </tr>\n";
		while ($rs = mysql_fetch_array($result)) { 
			$database_tam += $rs['Data_length'] + $rs['Index_length']; 
			$database_registros+=$rs["Rows"];
			$contenido.="  <tr class=\"boxbody\"> \n";
			$contenido.="    <td><div class=\"fuentecelda\">".$rs["Name"]."</div></td>\n";
			$contenido.="    <td align=\"right\"><div class=\"fuentecelda\">".$rs["Rows"]."</div></td>\n";
			$contenido.="    <td align=\"right\"><div class=\"fuentecelda\">".number_format(bitconversor($rs['Data_length'] + $rs['Index_length'],"byte","kbyte"), 2, ',', '.')." Kb</div></td>\n";
			$contenido.="  </tr>\n";
		} 
		$contenido.= "  <tr class=\"boxheader\"> \n";
		$contenido.= "    <td class=\"boxheader\" align=\"right\"><b>Total</b></td>\n";
		$contenido.= "    <td class=\"boxheader\" align=\"right\"><b>$database_registros</b></td>\n";
		$contenido.= "    <td class=\"boxheader\" align=\"right\"><b>".number_format(bitconversor($database_tam,"byte","mbyte"), 2, ',', '.')." MB</b></td>\n";
		$contenido.= "  </tr>\n";
		$contenido.= "</table>\n";
		mysql_close($link);
	}

	return $contenido;
}

function db_mysql_showquotas($dominio){
		$conf = new patConfiguration;
		$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
		$conf->parseConfigFile(_CFG_XML_BASEDATOS);
		$total_registros=count($conf->getConfigValue());
		for($i=1;$x<$total_registros;$i++){
			$rs=$conf->getConfigValue($i);
			if($rs["DOMINIO"]==$dominio)
				echo $rs["DATABASE"]." - ".number_format(bitconversor(db_mysql_quotastatus($rs["DATABASE"]),"byte","mbyte"), 2, ',', '.')." MB<br>";
			if($rs)
				$x++;
		}
}
?>
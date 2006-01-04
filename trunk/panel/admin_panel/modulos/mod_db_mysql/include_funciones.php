<?php

function db_mysql_info(){
	$info["nombre"]="MySQL";
	$info["version"]="1.0";
	$info["grupo"]="servicios";

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

function db_mysql_password($dbase,$password){
	if($password!=""){
		$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
		mysql_select_db(_CFG_MYSQL_DB,$link);
		mysql_query("UPDATE user SET Password=PASSWORD('$password') WHERE User='$dbase';",$link);
 		@mysql_query("FLUSH PRIVILEGES;",$link);
		mysql_close($link);
	}
}
function db_mysql_dbasecrear($dbase,$password){
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
		mysql_query("INSERT INTO user VALUES('localhost','$dbase',PASSWORD('$password'),'N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','N','','','','',0,0,0);",$link);
		mysql_query("INSERT INTO db (Host,Db,User,Select_priv,Insert_priv,Update_priv,Delete_priv,Create_priv,Drop_priv,Grant_priv,References_priv,Index_priv,Alter_priv,Create_tmp_table_priv,Lock_tables_priv) values ('localhost','$dbase','$dbase','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');",$link);
	break;
	case "5.0":

	break;
	}
        @mysql_query("FLUSH PRIVILEGES;",$link);
	mysql_close($link);
}

function db_mysql_dbasedel($dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	mysql_select_db(_CFG_MYSQL_DB,$link);
        @mysql_query("DROP DATABASE `$dbase`;",$link);
	@mysql_query("delete from user where User='$dbase'",$link);
        @mysql_query("delete from db where Db='$dbase' and User='$dbase';",$link);
        @mysql_query("FLUSH PRIVILEGES;",$link);
	mysql_close($link);
}

function db_mysql_quotastatus($dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	mysql_select_db($dbase,$link);
	$result = mysql_query("SHOW TABLE STATUS"); 
	$database_tam = 0; 
	while ($rs = mysql_fetch_array($result)) { 
		$database_tam += $rs['Data_length'] + $rs['Index_length']; 
	}
	mysql_close($link);
	return number_format(bitconversor($database_tam,"byte","mbyte"), 2, ',', '.');
}

function db_mysql_showstatus($dbase){
	$link = mysql_connect(_CFG_MYSQL_SERVER,_CFG_MYSQL_USER,_CFG_MYSQL_PASSWORD);
	mysql_select_db($dbase,$link);

	$result = mysql_query("SHOW TABLE STATUS"); 
	$database_tam = 0; 
	$database_registros=0;
	$contenido= "<table width=\"75%\" border=\"0\" class=\"box\">\n";
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
		$contenido.="    <td align=\"right\"><div class=\"fuentecelda\">".number_format(bitconversor($rs['Data_length'] + $rs['Index_length'],"byte","kbyte"), 2, ',', '.')."</div></td>\n";
		$contenido.="  </tr>\n";
	} 
	$contenido.= "  <tr class=\"boxheader\"> \n";
	$contenido.= "    <td class=\"boxheader\" align=\"right\"><b>Total</b></td>\n";
	$contenido.= "    <td class=\"boxheader\" align=\"right\"><b>$database_registros</b></td>\n";
	$contenido.= "    <td class=\"boxheader\" align=\"right\"><b>".number_format(bitconversor($database_tam,"byte","mbyte"), 2, ',', '.')." MB</b></td>\n";
	$contenido.= "  </tr>\n";
	$contenido.= "</table>\n";
	mysql_close($link);

	return $contenido;
}
?>
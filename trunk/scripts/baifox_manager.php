#!/usr/local/bin/php
<?php 
     include "/usr/local/baifox/panel/admin_panel/config/main_config.php";
     require _CFG_INTERFACE_LIBRERIA; 

if ($argc <= 2 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
	echo "Baifox manager 1.0\n";
	echo "==============================================================\n";
	echo "Modo de empleo: baifox_manager.php [FUNCION] [VARIABLES]\n\n";
	echo "cliente_editar (idcliente) (nombre) (email) (password) (num. dominios) (espacio MB) (anchobanda MB)\n";
	echo "dominio_editar (iddominio) (idcliente) (dominio) (usuario) (password) (num. cuentas/alias...) (espacio correo MB) (espacio FTP MB)\n";
	echo "dominio_estado (iddominio) (estado[1-0])\n";
	exit();
}

switch($argv[1]){
	case "cliente_editar":
		cliente_editar($argv[2],$argv[3],$argv[4],$argv[5],$argv[6],$argv[7],$argv[8]);
	break;
	case "dominio_editar":
		dominio_editar($argv[2],$argv[3],$argv[4],$argv[5],$argv[6],$argv[7],$argv[8],$argv[9]);
	break;
	case "dominio_estado":
		dominio_estado($argv[2],$argv[3]);
	break;
	default:
		echo "Comando incorrecto o no existe\n";
	break;
}


function cliente_editar($idcliente,$nombre,$email,$password,$dominios,$espacio,$anchobanda){
        require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";

	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_CLIENTES,a);

	$conf->setConfigValue($idcliente, array(
		 "ID" 	  => $idcliente,
		 "NOMBRE" => trim($nombre),
		 "EMAIL"  => trim($email), 
		 "USUARIO" => trim($email),
		 "PASSWORD" => trim($password),
		 "ESTADO" => 1, 
		 "PERMISO" => 100,
		 "DOMINIOS" => $dominios, 
		 "ESPACIO" => $espacio, 
		 "ANCHOBANDA" => $anchobanda
		 )
	, "array");

	$conf->writeConfigFile(_CFG_XML_CLIENTES, "xml", array( "mode" => "pretty" ) );
}

function dominio_editar($iddominio,$idcliente,$dominio,$usuario,$password,$cuentas,$quotacorreo,$quotaftp){
        require_once _CFG_INTERFACE_DIRMODULES."mod_xmlconfig/include_funciones.php";

	$mPassword=md5_encrypt(trim($password),_CFG_INTERFACE_BLOWFISH);
	
	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS,a);

	$conf->setConfigValue($iddominio, array(
		 "ID" 	  => $iddominio,
		 "IDCLIENTE" => $idcliente,
		 "DOMINIO"  => $dominio, 
		 "BASE"  => $usuario, 
		 "USUARIO"  => $usuario, 
		 "PASSWORD"  => $mPassword,
		 "CUENTAS"  => $cuentas, 
		 "REDIRECCIONES"  => $cuentas, 
		 "ALIAS"  => $cuentas, 
		 "AUTORESPUESTA"  => $cuentas, 
		 "LISTA" => $cuentas,
		 "QUOTACORREO" => $quotacorreo,
		 "IDFTP" => 0,
		 "QUOTAFTP" => $quotaftp,
		 "ESTADO" => 0)
 	, "array");

	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );
}

function dominio_estado($iddominio,$estado){
	//Carga todos los modulos
	$modulos_instalados=modules_array(_CFG_INTERFACE_DIRMODULES);
	foreach ($modulos_instalados as $modulo) { 
		require _CFG_INTERFACE_DIRMODULES."mod_".$modulo."/include_funciones.php"; 
	}

    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS,a);

	$datos=$conf->getConfigValue(xmlconfig_buscaid($iddominio,_CFG_XML_DOMINIOS));
	
	if ($estado==1){
		apache_domainonoff($datos['DOMINIO'],1,false);
		pureftpd_domainonoffall($datos['DOMINIO'],1);
		vpopmail_domainonoff($datos['DOMINIO'],1);
		$datos["ESTADO"]=1;
  	}else{
		apache_domainonoff($datos['DOMINIO'],0,false);
		pureftpd_domainonoffall($datos['DOMINIO'],0);
		vpopmail_domainonoff($datos['DOMINIO'],0);
		$datos["ESTADO"]=0;
  	}
	$conf->setConfigValue(xmlconfig_buscaid($iddominio,_CFG_XML_DOMINIOS), $datos, "array");
	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );
}
?>
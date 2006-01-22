<?php include "webpanel/".$_GET['grupo']."/include_permiso.php"; ?>
<font face="Arial, Helvetica, sans-serif" size="2">
<?php 
    	$conf = new patConfiguration;
	$conf->setConfigDir(_CFG_XML_CONFIG_DIR);
	$conf->parseConfigFile(_CFG_XML_DOMINIOS,a);

	$datos=$conf->getConfigValue(busca_xml_id($_GET['id'],_CFG_XML_DOMINIOS));

	$mDominio=$datos['DOMINIO'];
  	$mBase=$datos['BASE'];
  	$mUsuario=$datos['USUARIO'];
  	$mPassword=$datos['PASSWORD'];
  	$mCuentas=$datos['CUENTAS'];
  	$mRedirecciones=$datos['REDIRECCIONES'];
  	$mAlias=$datos['ALIAS'];
  	$mAutoRespuesta=$datos['AUTORESPUESTA'];
  	$mLista=$datos['LISTA'];
  	$mQuotaCORREO=$datos['QUOTACORREO'];
  	$mQuotaFTP=$datos['QUOTAFTP'];

	echo "Generando hospedaje...<br>";

	if (function_exists("apache_info")){
	    echo "Modulo mod_apache...<br>";
            $variables=Array();
            $variables["APACHE_DOCUMENTROOT"]=_CFG_APACHE_DOCUMENTROOT.$mDominio;
            $variables["CFG_DOCUMENTROOT"]=_CFG_APACHE_DOCUMENTROOT.$mDominio;
            $variables["CFG_ESTADO"]=1;
            $variables["APACHE_CGIBIN"]=0;
            $variables["APACHE_INDEXES"]="";
            $variables["APACHE_MULTIVIEWS"]="MultiViews";
            $variables["PHP_REGISTERGLOBAL"]=1;
            $variables["PHP_SAFEMODE"]=1;
            $variables["PHP_UPLOAD"]=0;
            apache_generartemplate($mDominio,$variables);
        }
	flush();
        if (function_exists("awstats_info")){
	    echo "Modulo mod_awstats...<br>";
	    awstats_htpasswdsave($mDominio,$mUsuario,$mUsuario,$mPassword);
            awstats_cronsave($mDominio);
            awstats_filesave_conf($mDominio,$mUsuario,"");
        }
	flush();
        if (function_exists("bind_info")){
	    echo "Modulo mod_bind...<br>";
            bind_domainsave($mDominio);
            bind_filesave_hosts($mDominio,"");
        }
	flush();
        if (function_exists("mysql_info")){
	    echo "Modulo mod_mysql...<br>";
            db_mysql_dbasecrear($mBase,$mPassword);
        }
	flush();
        if (function_exists("logrotate_info")){
	    echo "Modulo mod_logrotate...<br>";
            logrotate_domainsave($mDominio);
        }
	flush();
        if (function_exists("pureftpd_info")){
	    echo "Modulo mod_pureftpd...<br>";
            $datos["IDFTP"]=pureftpd_crear($mDominio,$mUsuario,$mPassword,_CFG_APACHE_DOCUMENTROOT.$mDominio,$mQuotaFTP,1,0);
        }
	flush();
        if (function_exists("vpopmail_info")){
	    echo "Modulo mod_vpopmail...<br>";
            vpopmail_domainadd($mDominio,$mPassword);
            vpopmail_domainquota($mDominio,$mQuota);
            vpopmail_domainconf($mDominio,"cuentas",$mCuentas);
            vpopmail_domainconf($mDominio,"alias",$mAlias);
            vpopmail_domainconf($mDominio,"redirecciones",$mRedirecciones);
            vpopmail_domainconf($mDominio,"autorespuesta",$mAutoRespuesta);
            vpopmail_domainconf($mDominio,"listas",$mLista);
            vpopmail_domainconf($mDominio,"quota",$mQuotaCORREO);
        } 
	flush();
	$conf->setConfigValue(busca_xml_id($_GET['id'],_CFG_XML_DOMINIOS), $datos, "array");
	$conf->writeConfigFile(_CFG_XML_DOMINIOS, "xml", array( "mode" => "pretty" ) );
	
	echo "Proceso finalizado.<br>";
	flush();
	exit();	
?>
</font>
<?php 
define("_CFG_INTERFACE_NOMBRE","BAIFOX Panel");
define("_CFG_INTERFACE_VERSION","1.0beta");
define("_CFG_INTERFACE_EMAIL","example@example.com"); //email que se usara para el envios de email 
define("_CFG_INTERFACE_MYSQLSERVER","localhost"); //servidor que aloja la base de datos de baifox
define("_CFG_INTERFACE_MYSQLDB","baifox_panel");  //base de datos de baifox
define("_CFG_INTERFACE_MYSQLUSER",""); //usuario de la base de datos baifox
define("_CFG_INTERFACE_MYSQLPASSWORD",""); //contraseña de la base de datos baifox
define("_CFG_INTERFACE_DIR","/usr/local/baifox/panel/");
define("_CFG_INTERFACE_DIRMODULES",_CFG_INTERFACE_DIR."admin_panel/modulos/");
define("_CFG_INTERFACE_LIBRERIA",_CFG_INTERFACE_DIR."libreria.php");
define("_CFG_INTERFACE_FASTTEMPLATE",_CFG_INTERFACE_DIR."admin_panel/interface/class.FastTemplate.php");
define("_CFG_INTERFACE_PLANTILLAS",_CFG_INTERFACE_DIR."admin_panel/plantillas/");
define("_CFG_INTERFACE_BLOWFISH",""); //palabra de paso para encriptar las contraseñas

define("_CFG_USERINTERFACE_PHPMYADMIN","http://mysql.dominio.com");
define("_CFG_USERINTERFACE_WEBMAIL","http://webmail.dominio.com");
define("_CFG_USERINTERFACE_WEBMAIL_LOGIN","http://webmail.dominio.com/src/login.php?loginname=");
define("_CFG_USERINTERFACE_AWSTATS","http://estadisticas.dominio.com/cgi-bin/awstats/awstats.pl?config=");

define("_CFG_SERVER_NAME",""); // servidor.com sin las www. (servidor principal que dara los servicios, estadisticas,webmail,phpmyadmin)
define("_CFG_SERVER_NS",""); //ns1.servidor.com
define("_CFG_SERVER_IP",""); // IP servidor

//Configuración RUTAS
define("_CFG_APACHE_DESACTIVADO","/home/desactivado");
define("_CFG_APACHE_DOCUMENTROOT","/home/virtual/");
define("_CFG_APACHE_CONF","/usr/local/apache/conf/vhosts/");
define("_CFG_APACHE_LOGS","/usr/local/apache/logs/");
define("_CFG_APACHE_HTTPD","/usr/local/apache/bin/httpd");
define("_CFG_APACHE_APACHECTL","/usr/local/apache/bin/apachectl");
define("_CFG_APACHE_HTPASSWD","/usr/local/apache/bin/htpasswd");

//Ficheros XML de datos
define("_CFG_XML_CONFIG_DIR",_CFG_INTERFACE_DIR."admin_panel/config");  //No incluir barra al final
define("_CFG_XML_PATCONFIG",_CFG_INTERFACE_DIR."admin_panel/interface/patConfiguration.php");
define("_CFG_XML_PATERROR",_CFG_INTERFACE_DIR."admin_panel/interface/patErrorManager.php");
define("_CFG_XML_USUARIOS","usuarios.xml");
define("_CFG_XML_CLIENTES","clientes.xml");
define("_CFG_XML_DOMINIOS","dominios.xml");
define("_CFG_XML_BASEDATOS","database.xml");
define("_CFG_XML_FTP","ftp.xml");


define("_CFG_SUDO","/usr/bin/sudo");
define("_CFG_SUDO_USERNAME","baifox");
define("_CFG_SUDO_PASSWORD",_CFG_INTERFACE_DIR."admin_panel/config/.htpasswd"); //contraseña del usuario SUDO baifox
define("_CFG_CMD_CAT","cat");
define("_CFG_CMD_CUT","cut");
define("_CFG_CMD_GREP","grep");
define("_CFG_CMD_UNAME","uname");

//Configuración VPOPMAIL
define("_CFG_VPOPMAIL_HOMEDIR","/home/vpopmail/");
define("_CFG_VPOPMAIL_USER","vpopmail");
define("_CFG_VPOPMAIL_GROUP","vchkpw");
define("_CFG_VPOPMAIL_AUTORESPOND","/usr/bin/autorespond");
define("_CFG_VPOPMAIL_ALIAS","/home/vpopmail/bin/valias");
define("_CFG_VPOPMAIL_ADDDOMAIN","/home/vpopmail/bin/vadddomain");
define("_CFG_VPOPMAIL_DELDOMAIN","/home/vpopmail/bin/vdeldomain");
define("_CFG_VPOPMAIL_DOMAINLIMITS","/home/vpopmail/bin/vmoddomlimits");
define("_CFG_VPOPMAIL_CUENTALIMITS","/home/vpopmail/bin/vmoduser");
define("_CFG_VPOPMAIL_INFODOMAIN","/home/vpopmail/bin/vdominfo");
define("_CFG_VPOPMAIL_ADDUSER","/home/vpopmail/bin/vadduser");
define("_CFG_VPOPMAIL_DELUSER","/home/vpopmail/bin/vdeluser");
define("_CFG_VPOPMAIL_QUOTAUSER","/home/vpopmail/bin/vsetuserquota");
define("_CFG_VPOPMAIL_PASSWDUSER","/home/vpopmail/bin/vpasswd");
define("_CFG_VPOPMAIL_ALIASUSER","/home/vpopmail/bin/valias");
define("_CFG_VPOPMAIL_INFOUSER","/home/vpopmail/bin/vuserinfo");
define("_CFG_VPOPMAIL_CFG_CUENTAS","Max Pop Accounts:");
define("_CFG_VPOPMAIL_CFG_ALIAS","Max Aliases:");
define("_CFG_VPOPMAIL_CFG_REDIRECCIONES","Max Forwards:");
define("_CFG_VPOPMAIL_CFG_AUTORESPUESTA","Max Autoresponders:");
define("_CFG_VPOPMAIL_CFG_LISTA","Max Mailinglists:");
define("_CFG_VPOPMAIL_CFG_QUOTA","Default User Quota:");
define("_CFG_VPOPMAIL_CFG_ESTADO","NO_POP");
define("_CFG_VPOPMAIL_CFG_DOMAIN","domain:");
define("_CFG_VPOPMAIL_CFG_USERS","users:");
define("_CFG_VPOPMAIL_CFG_DIR","dir:");
define("_CFG_VPOPMAIL_CFG_CUENTANAME","name:");
define("_CFG_VPOPMAIL_CFG_CUENTAQUOTA","quota:");
define("_CFG_VPOPMAIL_CFG_CUENTAESTADO","pop access closed");
define("_CFG_VPOPMAIL_CFG_CUENTAALIAS","->");
define("_CFG_VPOPMAIL_CFG_ANTISPAM","|/var/qmail/bin/preline /usr/bin/procmail -p -m RUTA=`pwd` /home/vpopmail/etc/procmailrc");

define("_CFG_LOGROTATE_CFG_FILE","/etc/logrotate.conf");
define("_CFG_LOGROTATE_CFG_AWSTATSTRING","_awstats_log");

define("_CFG_BIND_BINDCTL","/etc/init.d/bind9");
define("_CFG_BIND_CFG_FILE","/etc/bind/named.conf");
define("_CFG_BIND_CFG_HOSTS","/var/named/");
define("_CFG_BIND_IGNORE_FILE",_CFG_INTERFACE_DIR."admin_panel/config/bind_ignore.txt");

define("_CFG_AWSTATS_CONF","/etc/awstats/");
define("_CFG_AWSTATS_DATADIR","/home/estadisticas/");
define("_CFG_AWSTATS_CRON","/usr/bin/actualizar_estadisticas");
define("_CFG_AWSTATS_BIN","/usr/local/apache/cgi-bin/awstats/awstats.pl");
define("_CFG_AWSTATS_PASSWD_FILE","/usr/local/apache/cgi-bin/awstats/.htpasswd");

define("_CFG_FILESYSTEM_BACKUPDIR","/home/backup/"); //directorio temporal para guardar los backups de los usuarios

define("_CFG_EZMLM_LIST","/usr/local/bin/ezmlm/ezmlm-list");
define("_CFG_EZMLM_MAKE","/usr/local/bin/ezmlm/ezmlm-make");
define("_CFG_EZMLM_SUB","/usr/local/bin/ezmlm/ezmlm-sub");
define("_CFG_EZMLM_UNSUB","/usr/local/bin/ezmlm/ezmlm-unsub");

define("_CFG_MYSQL_SERVER","localhost"); //servidor MYSQL
define("_CFG_MYSQL_USER",""); //usuario del servidor MYSQL
define("_CFG_MYSQL_PASSWORD",""); //contraseña del servidor MYSQL
define("_CFG_MYSQL_DB","mysql");
define("_CFG_MYSQL_DUMP","/usr/bin/mysqldump");

define("_CFG_PUREFTPD_VIRTUALUSER","virtual");
define("_CFG_PUREFTPD_VIRTUALGROUP","virtual");
define("_CFG_PUREFTPD_UID","1008"); //UID del usuario virtual
define("_CFG_PUREFTPD_GID","1008"); //GID del grupo virtual
define("_CFG_PUREFTPD_QUOTACHECK","/usr/local/sbin/pure-quotacheck");
define("_CFG_PUREFTPD_HOME","/home/virtual/");
define("_CFG_PUREFTPD_TABLE","tbmod_pureftpd");
?>
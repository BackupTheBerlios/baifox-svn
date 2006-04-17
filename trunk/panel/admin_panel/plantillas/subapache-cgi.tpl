<VirtualHost *:80>
# CFG_SUBDOMINIO= {DOMINIO}
# CFG_ESTADO= {CFG_ESTADO}
# CFG_DOCUMENTROOT= {CFG_DOCUMENTROOT}
ServerName {SUBDOMINIO}{DOMINIO}
ServerAlias {APACHE_ALIAS}
DocumentRoot {APACHE_DOCUMENTROOT}
CustomLog {APACHE_LOGS}{DOMINIO}{APACHE_STRING_AWSTATS} combined
php_admin_flag engine 1
php_admin_flag register_globals {PHP_REGISTERGLOBAL}
php_admin_value safe_mode {PHP_SAFEMODE}
php_admin_flag file_uploads {PHP_UPLOAD}
php_admin_value open_basedir  "{APACHE_SUBDOCUMENTROOT}:/tmp"
php_admin_flag display_errors 1
php_admin_value error_reporting 2039
php_admin_flag track_errors 0
ScriptAlias  /cgi-bin "{APACHE_DOCUMENTROOT}/cgi-bin"
    <Directory "{APACHE_DOCUMENTROOT}/cgi-bin">
        AllowOverride All
        Options None
        Order allow,deny
        Allow from all
        AddHandler cgi-script .cgi .pl 
     </Directory>
    <Directory "{APACHE_DOCUMENTROOT}">
        Options FollowSymLinks {APACHE_MULTIVIEWS} {APACHE_INDEXES}
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
Redirect /estadisticas http://estadisticas.{SERVER_NAME}/cgi-bin/awstats/awstats.pl?config={DOMINIO}
</VirtualHost>

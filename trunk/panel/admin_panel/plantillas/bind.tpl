$ttl 38400
{DOMINIO}.     IN      SOA     ns.{SERVER_NAME}. info.{SERVER_NAME}. (
                        1026180339
                        10800
                        3600
                        604800
                        38400 )
{DOMINIO}.     IN NS {SERVER_NS}.
@ IN MX 10 @
@ IN A {SERVER_IP}
* IN A {SERVER_IP}

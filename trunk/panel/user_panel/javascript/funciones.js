function confirmLink(theLink, theSqlQuery)
{
    var is_confirmed = confirm(theSqlQuery);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
} // end of the 'confirmLink()' function

function crear_documentroot(frm,prefix) {
	frm.frmDocumentRoot.value=prefix + frm.frmDominio.value;
}

function crear_homedir(frm,prefix) {
	frm.frmHomedir.value=prefix + frm.frmDominio.value;
}

function crear_basedatos(frm) {
	str=fnStripSLD(frm.frmDominio.value);
	frm.frmBase.value=str.substring(0,14);
}

function crear_usuario(frm) {
	str=fnStripSLD(frm.frmDominio.value);
	frm.frmUsuario.value=str.substring(0,14);
}

function replaceAll( str, from, to ) {
    var idx = str.indexOf( from );


    while ( idx > -1 ) {
        str = str.replace( from, to );
        idx = str.indexOf( from );
    }

    return str;
}

function strpos(str, ch) { 
	for (var i = 0; i < str.length; i++) 
		if (str.substring(i, i+1) == ch) return i; 
	return -1; 
} 

function fnStripSLD(dominio) {
	//devuelve el nombre del dominio sin la extension
	if (dominio=="") {
		sld = "";
	} else {
		cadena=dominio;
		if(cadena.substr(-4)=="name")
		{
			sld=cadena.substr(0,-5);
		}else{
			sld=cadena.substr(0,strpos(dominio, "."));
		}
		if (!sld) {
			sld = "";
		}
	}
	return sld;
}

function fnStripTLD(dominio) {
	//devuelve el nombre del dominio sin la extension
	if (dominio=="") {
		tld = "";
	} else {
		cadena=dominio;
		if(cadena.substr(-4)=="name")
		{
			tld=cadena.substr(0,-4);
		}else{
			tld=cadena.substr(strpos(dominio, ".")+1);
		}
		if (!tld) {
			tld = "";
		}
	}
	return tld;
}

function Carga_Datos(ruta,dominio,mes,anio) {
  popupWin = window.open(ruta+'datos.php?dominio='+dominio+'&mes='+mes+'&anio='+anio, 'AnchoBanda', 'resizable=no,scrollbars=yes,width=550,height=450,top=80,left=100')
}

function Ventana(fichero) {
  popupWin = window.open(fichero, 'Ventana', 'resizable=no,scrollbars=yes,width=900,height=600,top=80,left=100')
}

message_time = 5000;
gui_objects = new Object();

// display a system message
function display_message(msg, type, hold){
    if (!loaded)  // save message in order to display after page loaded
      {
      pending_message = new Array(msg, type);
      return true;
      }
    
    if (!gui_objects.message)
      return false;
      
    if (message_timer)
      clearTimeout(message_timer);
    
    var cont = msg;
    if (type)
      cont = '<div class="'+type+'">'+cont+'</div>';

    gui_objects.message._rcube = this;
    gui_objects.message.innerHTML = cont;
    gui_objects.message.style.display = 'block';
    
    if (type!='loading')
      gui_objects.message.onmousedown = function(){ hide_message(); return true; };
    
    if (!hold)
      message_timer = setTimeout(ref+'.hide_message()', message_time);
}


// make a message row disapear
function hide_message(){
    if (gui_objects.message)
      {
      gui_objects.message.style.display = 'none';
      gui_objects.message.onmousedown = null;
      }
}
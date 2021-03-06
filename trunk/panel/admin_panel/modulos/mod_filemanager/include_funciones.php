<?
function filemanager_info(){
	$info["nombre"]="FileManager";
	$info["version"]="1.0";
	$info["grupo"]="sistema";
	$info["visible"]="true";

	return $info;
}

function filemanager_test(){
	$test= array();

	$test[0]=true;

	$test[1]= "mod_filemanager test...<br>";
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
		$test[1].= "El m�dulo esta correctamente instalado<br>";
	return $test;
}

function filemanager_quotacalculate($dominio){
	$exec_cmd = _CFG_PUREFTPD_QUOTACHECK;
	execute_cmd("$exec_cmd -u "._CFG_PUREFTPD_UID." -g "._CFG_PUREFTPD_GID." -d "._CFG_APACHE_DOCUMENTROOT.$dominio."/");
}

function filemanager_quotasize($dominio){
   $link = mysql_connect(_CFG_INTERFACE_MYSQLSERVER,_CFG_INTERFACE_MYSQLUSER,_CFG_INTERFACE_MYSQLPASSWORD);
   mysql_select_db(_CFG_INTERFACE_MYSQLDB,$link);
   $result=mysql_query("select * from "._CFG_PUREFTPD_TABLE." where dominio='$dominio'",$link);
   $rs = mysql_fetch_array($result);
   $tamanio=$rs["quotasize"];
   mysql_close($link);
   return $tamanio;
}

function filemanager_quotastatus($dominio){
   $exec_cmd = _CFG_CMD_CAT;	
   $contenido=execute_cmd("$exec_cmd "._CFG_APACHE_DOCUMENTROOT.$dominio."/.ftpquota");
   list($ficheros, $tamanio)=split(" ", $contenido[0], 2);
   return $tamanio;
}

function filemanager_visualiza($dominio){
    global $cfg,$doc_root,$path_info,$url_info,$dir_actual,$islinux,$filename,$is_reachable,$fm_color,$fm_root_atual,$islinux,$quota_mb,$resolveIDs,$mat_passwd,$mat_group;
// +--------------------------------------------------
// | Header and Globals
// +--------------------------------------------------
    header("Pragma: no-cache");
    header("Cache-Control: no-store");
    foreach ($_GET as $key => $val) $$key=filemanager_htmldecode($val);
    foreach ($_POST as $key => $val) $$key=filemanager_htmldecode($val);
    foreach ($_COOKIE as $key => $val) $$key=filemanager_htmldecode($val);
    if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) $ip = $_SERVER["REMOTE_ADDR"]; //nao usa proxy
    else $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; //usa proxy
    $islinux = !(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
    //$url_info = parse_url($_SERVER["HTTP_REFERER"]);
    $url_info = parse_url("http://www.".$dominio);
    $doc_root = ($islinux) ? _CFG_APACHE_DOCUMENTROOT : ucfirst(_CFG_APACHE_DOCUMENTROOT);
    $script_filename = _CFG_INTERFACE_DIR."admin_panel/webpanel/sistema/filemanager/filemanager.php";
    $path_info = pathinfo($script_filename);
    $fm_root_atual=_CFG_APACHE_DOCUMENTROOT.$dominio."/";

    //Actualiza quota y obtiene quota
    filemanager_quotacalculate($dominio);
    $quota_mb=filemanager_quotasize($dominio);
// +--------------------------------------------------
// | Config
// +--------------------------------------------------
    $cfg = new config();
    $cfg->load();
    ini_set("display_errors",1);
    ini_set("error_reporting",$error_reporting);
    if (!isset($dir_actual)){
        $dir_actual = _CFG_APACHE_DOCUMENTROOT.$dominio."/";
        if (!$islinux) $dir_actual = ucfirst($dir_actual);
        @chmod($dir_actual,0777);
    } else $dir_actual = filemanager_formatpath($dir_actual);
    $is_reachable = (stristr($dir_actual,$doc_root)!==false);
    // Auto Expand Local Path
    if (!isset($expanded_dir_list)){
        $expanded_dir_list = "";
        $mat = explode("/",$path_info["dirname"]);
        for ($x=0;$x<count($mat);$x++) $expanded_dir_list .= ":".$mat[$x];
        setcookie("expanded_dir_list", $expanded_dir_list, 0, "/");
    }
    if (!isset($fm_root_atual)){
        if (strlen($fm_root)) $fm_root_atual = $fm_root;
        else {
            if (!$islinux) $fm_root_atual = ucfirst($path_info["dirname"]."/");
            else $fm_root_atual = $doc_root."/";
        }
        setcookie("fm_root_atual", $fm_root_atual, 0, "/");
    } elseif (isset($set_fm_root_atual)) {
        if (!$islinux) $fm_root_atual = ucfirst($set_fm_root_atual);
        setcookie("fm_root_atual", $fm_root_atual, 0, "/");
    }
    if (!isset($resolveIDs)){
        setcookie("resolveIDs", 0, $cookie_cache_time, "/");
    } elseif (isset($set_resolveIDs)){
        $resolveIDs=($resolveIDs)?0:1;
        setcookie("resolveIDs", $resolveIDs, $cookie_cache_time, "/");
    }
    if ($resolveIDs){
        exec("cat /etc/passwd",$mat_passwd);
        exec("cat /etc/group",$mat_group);
    }
    $fm_color['Bg'] = "EEEEEE";
    $fm_color['Text'] = "000000";
    $fm_color['Link'] = "992929";
    $fm_color['Mark'] = "A7D2E4";
    $fm_color['Dir'] = "FFFFCC";
    $fm_color['File'] = "FFFFFF";
    $fm_color['Ext'] = "CCCC99";
    $fm_color['Title'] = "CC6666";
    $fm_color['Action'] = "CC6666";
    $fm_color['FileFirstCell'] = "FFFFFF";

    foreach($fm_color as $tag=>$color){
        $fm_color[$tag]=strtolower($color);
    }
// +--------------------------------------------------
// | File Manager Actions
// +--------------------------------------------------
    switch ($frame){
        case 1: break; // Empty Frame
        case 2: filemanager_left(); break;
        case 3: filemanager_right(); break;
        default:
            switch($action){
                case 3: filemanager_download(); break;
                case 4: filemanager_view(); break;
                case 7: filemanager_edit_file_form(); break;
                case 8: filemanager_chmod_form(); break;
                case 10: filemanager_upload_form(); break;
                default: filemanager_html($dominio);
            }
    }
}
// +--------------------------------------------------
// | Config Class
// +--------------------------------------------------
class config {
    var $data;
    var $filename;
    function config(){
        global $script_filename;
        $this->data = array(
            'lang'=>'es',
            'upload_ext_filter'=>array(),
            'download_ext_filter'=>array(),
            'error_reporting'=>'',
            'fm_root'=>'',
            'cookie_cache_time'=>time()+60*60*24*30, // 30 Dias
            'version'=>'0.9.3'
            );
        $data = false;
        $this->filename = $script_filename;
        if (file_exists($this->filename)){
            $mat = file($this->filename);
            $objdata = trim(substr($mat[1],2));
            if (strlen($objdata)) $data = unserialize($objdata);
        }
        if (is_array($data)&&count($data)==count($this->data)) $this->data = $data;
        else $this->save();
    }
    function save(){
        $objdata = "<?".chr(13).chr(10)."//".serialize($this->data).chr(13).chr(10);
        if (strlen($objdata)){
            if (file_exists($this->filename)){
                $mat = file($this->filename);
                if ($fh = @fopen($this->filename, "w")){
                    @fputs($fh,$objdata,strlen($objdata));
                    for ($x=2;$x<count($mat);$x++) @fputs($fh,$mat[$x],strlen($mat[$x]));
                    @fclose($fh);
                }
            }
        }
    }
    function load(){
        foreach ($this->data as $key => $val) $GLOBALS[$key] = $val;
    }
}
// +--------------------------------------------------
// | File System
// +--------------------------------------------------
function filemanager_total_size($arg) {
 $total = 0;
 if (file_exists($arg)) {
   if (is_dir($arg)) {
     $handle = opendir($arg);
     while($aux = readdir($handle)) {
       if ($aux != "." && $aux != "..") $total += filemanager_total_size($arg."/".$aux);
     }
     closedir($handle);
   } else $total = filesize($arg);
 }
 return $total;
}
function filemanager_total_delete($arg) {
 if (file_exists($arg)) {
   if (is_dir($arg)) {
     execute_cmd("rm -R $arg");
   } else execute_cmd("rm $arg"); 
 }
}
function filemanager_total_copy($orig,$dest) {
 $ok = true;
 if (file_exists($orig)) {
   if (is_dir($orig)) {
     execute_cmd("cp -R $orig $dest");
     $ok=true;
   } else {
	execute_cmd("cp $orig $dest");
	$ok = true;
   }
 }
 return $ok;
}
function filemanager_total_move($orig,$dest) {
    execute_cmd("mv $orig $dest");
    return true;
}
function filemanager_download(){
    global $dir_actual,$filename;
    $file = $dir_actual.$filename;
    if(file_exists($file)){
        $is_proibido = false;
        foreach($download_ext_filter as $key=>$ext){
            if (eregi($ext,$filename)){
                $is_proibido = true;
                break;
            }
        }
        if (!$is_proibido){
            $size = filesize($file);
            header("Content-Type: application/save");
            header("Content-Length: $size");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Transfer-Encoding: binary");
            if ($fh = fopen("$file", "rb")){
                fpassthru($fh);
                fclose($fh);
            } else filemanager_alert(T_('Read Access Denied').": ".$file);
        } else filemanager_alert(T_('Read Access Denied').": ".$file);
    } else filemanager_alert(T_('File not found').": ".$file);
}

function filemanager_borrarfichero($file){
	execute_cmd("rm $file");
	if (file_exists($file)){
		return false;
	}else{
		return true;
	}
}
function filemanager_save_upload($temp_file,$filename,$dir_dest) {
    global $upload_ext_filter;
    $filename = filemanager_remove_acentos($filename);
    $file = $dir_dest.$filename;
    $filesize = filesize($temp_file);
    $is_proibido = false;
    foreach($upload_ext_filter as $key=>$ext){
        if (eregi($ext,$filename)){
            $is_proibido = true;
            break;
        }
    }
    if (!$is_proibido){
        if (!filemanager_limite($filesize)){
            if (file_exists($file)){
                if (filemanager_borrarfichero($file)){
			execute_cmd("cp $temp_file $file");
			execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $file");
			execute_cmd("chmod 644 $file");
			if (file_exists($file))
				$out = 6;
			else
				$out = 2;
                } else $out = 5;
            } else {
		execute_cmd("cp $temp_file $file");
		execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $file");
		execute_cmd("chmod 644 $file");
		if (file_exists($file))
			$out = 1;
		else
			$out = 2;
            }
        } else $out = 3;
    } else $out = 4;
    return $out;
}
function filemanager_zip_extract(){
  global $cmd_arg,$dir_actual,$islinux;
  $zip = zip_open($dir_actual.$cmd_arg);
  if ($zip) {
    while ($zip_entry = zip_read($zip)) {
        if (zip_entry_filesize($zip_entry)) {
            $complete_path = $path.dirname(zip_entry_name($zip_entry));
            $complete_name = $path.zip_entry_name($zip_entry);
            if(!file_exists($complete_path)) {
                $tmp = '';
                foreach(explode('/',$complete_path) AS $k) {
                    $tmp .= $k.'/';
                    if(!file_exists($tmp)) {
                        @mkdir($dir_actual.$tmp, 0777);
                    }
                }
            }
            if (zip_entry_open($zip, $zip_entry, "r")) {
                if ($fd = fopen($dir_actual.$complete_name, 'w')){
                    fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
                    fclose($fd);
                } else echo "fopen($dir_actual.$complete_name) error<br>";
                zip_entry_close($zip_entry);
            } else echo "zip_entry_open($zip,$zip_entry) error<br>";
        }
    }
    zip_close($zip);
  }
}
// +--------------------------------------------------
// | Data Formating
// +--------------------------------------------------
function filemanager_htmlencode($str){
    return htmlentities($str);
}
// html_entity_decode() replacement
function filemanager_html_entity_decode_for_php4_compatibility ($string)  {
   $trans_tbl = get_html_translation_table (HTML_ENTITIES);
   $trans_tbl = array_flip ($trans_tbl);
   $ret = strtr ($string, $trans_tbl);
   return  preg_replace('/\&\#([0-9]+)\;/me',
       "chr('\\1')",$ret);
}
function filemanager_htmldecode($str){
    if (is_string($str)){
       if (get_magic_quotes_gpc()) return stripslashes(filemanager_html_entity_decode_for_php4_compatibility($str));
       else return html_entity_decode($str);
    } else return $str;
}
function filemanager_rep($x,$y){
  if ($x) {
    $aux = "";
    for ($a=1;$a<=$x;$a++) $aux .= $y;
    return $aux;
  } else return "";
}
function filemanager_strzero($arg1,$arg2){
    if (strstr($arg1,"-") == false){
        $aux = intval($arg2) - strlen($arg1);
        if ($aux) return filemanager_rep($aux,"0").$arg1;
        else return $arg1;
    } else {
        return "[$arg1]";
    }
}
function filemanager_replace_double($sub,$str){
    $out=str_replace($sub.$sub,$sub,$str);
    while ( strlen($out) != strlen($str) ){
        $str=$out;
        $out=str_replace($sub.$sub,$sub,$str);
    }
    return $out;
}
function filemanager_remove_acentos($str){
    $str = trim($str);
    $str = strtr($str,"��������������������������������������������������������������!@#%&*()[]{}+=?",
                      "YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy_______________");
    $str = str_replace("..","",str_replace("/","",str_replace("\\","",str_replace("\$","",$str))));
    return $str;
}
function filemanager_formatpath($str){
    global $islinux;
    $str = trim($str);
    $str = str_replace("..","",str_replace("\\","/",str_replace("\$","",$str)));
    $done = false;
    while (!$done) {
        $str2 = str_replace("//","/",$str);
        if (strlen($str) == strlen($str2)) $done = true;
        else $str = $str2;
    }
    $tam = strlen($str);
    if ($tam){
        $last_char = $tam - 1;
        if ($str[$last_char] != "/") $str .= "/";
        if (!$islinux) $str = ucfirst($str);
    }
    return $str;
}
function filemanager_array_csort() {
  $args = func_get_args();
  $marray = array_shift($args);
  $msortline = "return(array_multisort(";
   foreach ($args as $arg) {
       $i++;
       if (is_string($arg)) {
          foreach ($marray as $row) {
               $sortarr[$i][] = $row[$arg];
           }
       } else {
          $sortarr[$i] = $arg;
       }
       $msortline .= "\$sortarr[".$i."],";
   }
   $msortline .= "\$marray));";
   eval($msortline);
   return $marray;
}
function filemanager_show_perms( $in_Perms ) {
   $sP = "<b>";
   if($in_Perms & 0x1000) $sP .= 'p';            // FIFO pipe
   elseif($in_Perms & 0x2000) $sP .= 'c';        // Character special
   elseif($in_Perms & 0x4000) $sP .= 'd';        // Directory
   elseif($in_Perms & 0x6000) $sP .= 'b';        // Block special
   elseif($in_Perms & 0x8000) $sP .= '&minus;';    // Regular
   elseif($in_Perms & 0xA000) $sP .= 'l';        // Symbolic Link
   elseif($in_Perms & 0xC000) $sP .= 's';        // Socket
   else $sP .= 'u';                              // UNKNOWN
   $sP .= "</b>";
   // owner - group - others
   $sP .= (($in_Perms & 0x0100) ? 'r' : '&minus;') . (($in_Perms & 0x0080) ? 'w' : '&minus;') . (($in_Perms & 0x0040) ? (($in_Perms & 0x0800) ? 's' : 'x' ) : (($in_Perms & 0x0800) ? 'S' : '&minus;'));
   $sP .= (($in_Perms & 0x0020) ? 'r' : '&minus;') . (($in_Perms & 0x0010) ? 'w' : '&minus;') . (($in_Perms & 0x0008) ? (($in_Perms & 0x0400) ? 's' : 'x' ) : (($in_Perms & 0x0400) ? 'S' : '&minus;'));
   $sP .= (($in_Perms & 0x0004) ? 'r' : '&minus;') . (($in_Perms & 0x0002) ? 'w' : '&minus;') . (($in_Perms & 0x0001) ? (($in_Perms & 0x0200) ? 't' : 'x' ) : (($in_Perms & 0x0200) ? 'T' : '&minus;'));
   return $sP;
}
function filemanager_formatsize($arg) {
    if ($arg>0){
        $j = 0;
        $ext = array(" bytes"," Kb"," Mb"," Gb"," Tb");
        while ($arg >= pow(1024,$j)) ++$j;
        return round($arg / pow(1024,$j-1) * 100) / 100 . $ext[$j-1];
    } else return "0 Mb";
}
function filemanager_getsize($file) {
    return filemanager_formatsize(filesize($file));
}
function filemanager_limite($new_filesize=0) {
    global $fm_root_atual;
    global $quota_mb;
    global $dominio;

    if($quota_mb){
        $total = filemanager_quotastatus($dominio);
        if (floor(($total+$new_filesize)/(1024*1024)) > $quota_mb) return true;
    }
    return false;
}
function filemanager_getuser ($arg) {
    global $mat_passwd;
    $aux = "x:".trim($arg).":";
    for($x=0;$x<count($mat_passwd);$x++){
        if (strstr($mat_passwd[$x],$aux)){
         $mat = explode(":",$mat_passwd[$x]);
         return $mat[0];
        }
    }
    return $arg;
}
function filemanager_getgroup ($arg) {
    global $mat_group;
    $aux = "x:".trim($arg).":";
    for($x=0;$x<count($mat_group);$x++){
        if (strstr($mat_group[$x],$aux)){
         $mat = explode(":",$mat_group[$x]);
         return $mat[0];
        }
    }
    return $arg;
}
// +--------------------------------------------------
// | Interface
// +--------------------------------------------------
function filemanager_html_header($plus=""){
    global $fm_color;
echo "
<html>
<head>
<title>".T_('Baifox File Manager')."</title>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset="._CFG_INTERFACE_GETTEXT_ENCODING."\">
$plus
</head>
<script language=\"Javascript\" type=\"text/javascript\">
<!--
    function Is(){
        this.appname = navigator.appName;
        this.appversion = navigator.appVersion;
        this.platform = navigator.platform;
        this.useragent = navigator.userAgent.toLowerCase();
        this.ie = ( this.appname == 'Microsoft Internet Explorer' );
        if (( this.useragent.indexOf( 'mac' ) != -1 ) || ( this.platform.indexOf( 'mac' ) != -1 )){
            this.sisop = 'mac';
        } else if (( this.useragent.indexOf( 'windows' ) != -1 ) || ( this.platform.indexOf( 'win32' ) != -1 )){
            this.sisop = 'windows';
        } else if (( this.useragent.indexOf( 'inux' ) != -1 ) || ( this.platform.indexOf( 'linux' ) != -1 )){
            this.sisop = 'linux';
        }
    }
    var is = new Is();
    function enterSubmit(keypressEvent,submitFunc){
        var kCode = (is.ie) ? keypressEvent.keyCode : keypressEvent.which
        if( kCode == 13) eval(submitFunc);
    }
    var W = screen.width;
    var H = screen.height;
    var FONTSIZE = 0;
    switch (W){
        case 640:
            FONTSIZE = 8;
        break;
        case 800:
            FONTSIZE = 10;
        break;
        case 1024:
            FONTSIZE = 11;
        break;
        default:
            FONTSIZE = 14;
        break;
    }
";
echo filemanager_replace_double(" ",str_replace(chr(13),"",str_replace(chr(10),"","
    document.writeln('
    <style>
    body {
        font-family : Arial;
        font-size: '+FONTSIZE+'px;
        font-weight : normal;
        color: ".$fm_color['Text'].";
        background-color: ".$fm_color['Bg'].";
    }
    table {
        font-family : Arial;
        font-size: '+FONTSIZE+'px;
        font-weight : normal;
        color: ".$fm_color['Text'].";
        cursor: default;
    }
    input {
        font-family : Arial;
        font-size: '+FONTSIZE+'px;
        font-weight : normal;
        color: ".$fm_color['Text'].";
    }
    textarea {
        font-family : Courier;
        font-size: 12px;
        font-weight : normal;
        color: ".$fm_color['Text'].";
    }
    A {
        font-family : Arial;
        font-size : '+FONTSIZE+'px;
        font-weight : bold;
        text-decoration: none;
        color: ".$fm_color['Text'].";
    }
    A:link {
        color: ".$fm_color['Text'].";
    }
    A:visited {
        color: ".$fm_color['Text'].";
    }
    A:hover {
        color: ".$fm_color['Link'].";
    }
    A:active {
        color: ".$fm_color['Text'].";
    }
    A.blanco:link {
        color: #FFFFFF;
    }
    A.blanco:visited {
        color: #FFFFFF;
    }
    A.blanco:hover {
        color: #FFFFFF;
    }
    A.blanco:active {
        color: #FFFFFF;
    }
    </style>
    ');
")));
echo "
//-->
</script>
";
}
function filemanager_reloadframe($ref,$frame_number,$plus=""){
    global $dir_actual,$path_info,$dominio;
    echo "
    <script language=\"Javascript\" type=\"text/javascript\">
    <!--
        ".$ref.".frame".$frame_number.".location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=".$frame_number."&dir_actual=".$dir_actual.$plus."';
    //-->
    </script>
    ";
}
function filemanager_alert($arg){
    echo "
    <script language=\"Javascript\" type=\"text/javascript\">
    <!--
        alert('$arg');
    //-->
    </script>
    ";
}
function filemanager_tree($dir_antes,$dir_corrente,$indice){
    global $fm_root_atual, $dir_actual, $islinux;
    global $expanded_dir_list;
    $indice++;
    $num_dir = 0;
    $dir_name = str_replace($dir_antes,"",$dir_corrente);
    $dir_corrente = str_replace("//","/",$dir_corrente);
    $is_proibido = false;
    if ($islinux) {
        $proibidos = "/proc#/dev";
        $mat = explode("#",$proibidos);
        foreach($mat as $key => $val){
            if ($dir_corrente == $val){
                $is_proibido = true;
                break;
            }
        }
        unset($mat);
    }
    if (!$is_proibido){
        if ($handle = @opendir($dir_corrente)){
            // Permitido
            while ($file = readdir($handle)){
                if ($file != "." && $file != ".." && is_dir("$dir_corrente/$file"))
                    $mat_dir[] = $file;
            }
            closedir($handle);
            if (count($mat_dir)){
                sort($mat_dir,SORT_STRING);
                // Com Sub-dir
                if ($indice != 0){
                    for ($aux=1;$aux<$indice;$aux++) echo "����";
                    echo " ";
                }
                if ($dir_antes != $dir_corrente){
                    if (strstr($expanded_dir_list,":$dir_corrente/$dir_name")) $op_str = "<img src=\"/admin_panel/modulos/mod_filemanager/images/menos.gif\" width=\"16\" height=\"16\" border=\"0\"><img src=\"/admin_panel/modulos/mod_filemanager/images/folderopen.gif\" width=\"16\" height=\"16\" border=\"0\">";
                    else $op_str = "<img src=\"/admin_panel/modulos/mod_filemanager/images/mas.gif\" width=\"16\" height=\"16\" border=\"0\"><img src=\"/admin_panel/modulos/mod_filemanager/images/folderclosed.gif\" width=\"16\" height=\"16\" border=\"0\">";
                    echo "<a href=\"JavaScript:go_dir('$dir_corrente/$dir_name')\"><b>$op_str</b></a>�<a href=\"JavaScript:go('$dir_corrente')\"><b>$dir_name</b></a><br>\n";
                } else {
                    echo "<a href=\"JavaScript:go('$dir_corrente')\"><img src=\"/admin_panel/modulos/mod_filemanager/images/home.gif\" width=\"16\" height=\"16\" border=\"0\"> <b>$fm_root_atual</b></a><br>\n";
                }
                for ($x=0;$x<count($mat_dir);$x++){
                    if (($dir_antes == $dir_corrente)||(strstr($expanded_dir_list,":$dir_corrente/$dir_name"))){
                        filemanager_tree($dir_corrente."/",$dir_corrente."/".$mat_dir[$x],$indice);
                    } else flush();
                }
            } else {
              // Sem Sub-dir
              if ($dir_antes != $dir_corrente){
                for ($aux=1;$aux<$indice;$aux++) echo "����";
                echo " ";
                echo "<img src=\"/admin_panel/modulos/mod_filemanager/images/linea.gif\" width=\"16\" height=\"16\" border=\"0\"><img src=\"/admin_panel/modulos/mod_filemanager/images/folderclosed.gif\" width=\"16\" height=\"16\" border=\"0\"><a href=\"JavaScript:go('$dir_corrente')\"> <b>$dir_name</b></a><br>\n";
              } else {
                echo "<a href=\"JavaScript:go('$dir_corrente')\"> <b>$fm_root_atual</b></a><br>\n";
              }
            }
        } else {
            // Negado
            if ($dir_antes != $dir_corrente){
                for ($aux=1;$aux<$indice;$aux++) echo "����";
                echo "�";
                echo "<a href=\"JavaScript:go('$dir_corrente')\"><font color=red> <b>$dir_name</b></font></a><br>\n";
            } else {
                echo "<a href=\"JavaScript:go('$dir_corrente')\"><font color=red> <b>$fm_root_atual</b></font></a><br>\n";
            }

        }
    } else {
        // Prohibido
        if ($dir_antes != $dir_corrente){
            for ($aux=1;$aux<$indice;$aux++) echo "����";
            echo "�";
            echo "<a href=\"JavaScript:go('$dir_corrente')\"><font color=red> <b>$dir_name</b></font></a><br>\n";
        } else {
            echo "<a href=\"JavaScript:go('$dir_corrente')\"><font color=red> <b>$fm_root_atual</b></font></a><br>\n";
        }
    }
}
function filemanager_show_tree(){
    global $fm_root_atual,$path_info,$setflag,$islinux,$dominio;

    filemanager_html_header();
    echo "<body marginwidth=\"0\" marginheight=\"0\">\n";
    echo "
    <script language=\"Javascript\" type=\"text/javascript\">
    <!--
        // Disable text selection
        function disableTextSelection(e){return false}
        function enableTextSelection(){return true}
        if (is.ie) document.onselectstart=new Function('return false')
        else {
            document.onmousedown=disableTextSelection
            document.onclick=enableTextSelection
        }
        var flag = ".(($setflag)?"true":"false")."
        function set_flag(arg) {
            flag = arg;
        }
        function go_dir(arg) {
            var setflag;
            setflag = (flag)?1:0;
            document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=2&setflag='+setflag+'&dir_actual=$dir_actual&ec_dir='+arg;
        }
        function go(arg) {
            if (flag) {
                parent.frame3.set_dir_dest(arg+'/');
                flag = false;
            } else {
                parent.frame3.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=3&dir_actual='+arg+'/';
            }
        }
        function set_fm_root_atual(arg){
            document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=2&set_fm_root_atual='+escape(arg);
        }
        function atualizar(){
            document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=2';
        }
    //-->
    </script>
    ";
    echo "<table width=\"100%\" height=\"100%\" border=0 cellspacing=0 cellpadding=5>\n";
    echo "<tr valign=top height=10><td align=center>";
    if (!$islinux){
        echo "<form><select name=drive onchange=\"set_fm_root_atual(this.value)\">";
        $aux="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for($x=0;$x<strlen($aux);$x++){
            if (strstr(strtoupper($fm_root_atual),$aux[$x].":/")) $is_sel="selected";
            else $is_sel="";
            echo "<option $is_sel value=\"".$aux[$x].":/\">".$aux[$x].":/";
        }
        echo "</select></form>";
    }
    echo "<a href=\"#\" onclick=\"atualizar()\"><img src=\"/admin_panel/modulos/mod_filemanager/images/refrescar.gif\" width=\"16\" height=\"16\" border=\"0\"> ".T_('Refresh')."</a></tr>";
    //if (!$islinux) $aux=substr($fm_root_atual,0,strlen($fm_root_atual)-1);
    //else
    $aux=$fm_root_atual;
    echo "<tr valign=top><td>";
            clearstatcache();
            filemanager_tree($aux,$aux,-1,0);
    echo "</td></tr>";
    echo "
        <form name=\"login_form\" action=\"".$path_info["basename"]."\" method=\"post\" target=\"_parent\">
        <input type=hidden name=action value=1>
        <tr>
        <td height=10 colspan=2 align=center><input type=button value=\"".T_('Leave')."\" onclick=\"window.parent.close();window.close();\">
        </tr>
        </form>
    ";
    echo "</table>\n";
    echo "</body>\n</html>";
}
function filemanager_getmicrotime(){
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}
function filemanager_dir_list_form() {
    global $fm_root_atual,$dir_actual,$quota_mb,$resolveIDs,$order_dir_list_by,$islinux,$cmd_name,$ip,$is_reachable,$path_info,$fm_color,$dominio;
    $ti = filemanager_getmicrotime();
    clearstatcache();
    $out = "<table border=0 cellspacing=1 cellpadding=4 width=\"100%\" bgcolor=\"#eeeeee\">\n";
    if ($opdir = @opendir($dir_actual)) {
        $entry_count = 0;
        $file_count = 0;
        $dir_count = 0;
        $total_size = 0;
        $uplink = "";
        $entry_list = array();
        $highlight_cols = 0;

        while ($file = readdir($opdir)) {
          if (($file != ".")&&($file != "..")){
            if (is_file($dir_actual.$file)){
                $ext = strtolower(strrchr($file,"."));
                $entry_list[$entry_count]["type"] = "file";
                // Fun��o filetype() returns only "file"...
                $entry_list[$entry_count]["size"] = filesize($dir_actual.$file);
                $entry_list[$entry_count]["sizet"] = filemanager_getsize($dir_actual.$file);
                if (strstr($ext,".")){
                    $entry_list[$entry_count]["ext"] = $ext;
                    $entry_list[$entry_count]["extt"] = $ext;
                } else {
                    $entry_list[$entry_count]["ext"] = "";
                    $entry_list[$entry_count]["extt"] = "�";
                }
                $file_count++;
            } elseif (is_dir($dir_actual.$file)) {
                // Recursive directory size disabled
                // $entry_list[$entry_count]["size"] = total_size($dir_actual.$file);
                $entry_list[$entry_count]["size"] = 0;
                $entry_list[$entry_count]["sizet"] = 0;
                $entry_list[$entry_count]["type"] = "dir";
                $dir_count++;
            }
            $entry_list[$entry_count]["name"] = $file;
            $entry_list[$entry_count]["date"] = date("Ymd", filemtime($dir_actual.$file));
            $entry_list[$entry_count]["time"] = date("his", filemtime($dir_actual.$file));
            $entry_list[$entry_count]["datet"] = date("d/m/Y h:i:s", filemtime($dir_actual.$file));
            if ($islinux && $resolveIDs){
                $entry_list[$entry_count]["p"] = filemanager_show_perms(fileperms($dir_actual.$file));
                $entry_list[$entry_count]["u"] = filemanager_getuser(fileowner($dir_actual.$file));
                $entry_list[$entry_count]["g"] = filemanager_getgroup(filegroup($dir_actual.$file));
            } else {
                $entry_list[$entry_count]["p"] = base_convert(fileperms($dir_actual.$file),10,8);
                $entry_list[$entry_count]["p"] = substr($entry_list[$entry_count]["p"],strlen($entry_list[$entry_count]["p"])-3);
                $entry_list[$entry_count]["u"] = fileowner($dir_actual.$file);
                $entry_list[$entry_count]["g"] = filegroup($dir_actual.$file);
            }
            $total_size += $entry_list[$entry_count]["size"];
            $entry_count++;
          }
        }
        closedir($opdir);

        if ($file_count) $highlight_cols = ($islinux)?7:5;
        else $highlight_cols = ($islinux)?6:4;

        if($entry_count){
            $or1="1A";
            $or2="2D";
            $or3="3A";
            $or4="4A";
            $or5="5A";
            $or6="6D";
            $or7="7D";
            switch($order_dir_list_by){
                case "1A": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"name",SORT_STRING,SORT_ASC); $or1="1D"; break;
                case "1D": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"name",SORT_STRING,SORT_DESC); $or1="1A"; break;
                case "2A": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"p",SORT_STRING,SORT_ASC,"g",SORT_STRING,SORT_ASC,"u",SORT_STRING,SORT_ASC); $or2="2D"; break;
                case "2D": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"p",SORT_STRING,SORT_DESC,"g",SORT_STRING,SORT_ASC,"u",SORT_STRING,SORT_ASC); $or2="2A"; break;
                case "3A": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"u",SORT_STRING,SORT_ASC,"g",SORT_STRING,SORT_ASC); $or3="3D"; break;
                case "3D": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"u",SORT_STRING,SORT_DESC,"g",SORT_STRING,SORT_ASC); $or3="3A"; break;
                case "4A": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"g",SORT_STRING,SORT_ASC,"u",SORT_STRING,SORT_DESC); $or4="4D"; break;
                case "4D": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"g",SORT_STRING,SORT_DESC,"u",SORT_STRING,SORT_DESC); $or4="4A"; break;
                case "5A": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"size",SORT_NUMERIC,SORT_ASC); $or5="5D"; break;
                case "5D": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"size",SORT_NUMERIC,SORT_DESC); $or5="5A"; break;
                case "6A": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"date",SORT_STRING,SORT_ASC,"time",SORT_STRING,SORT_ASC,"name",SORT_STRING,SORT_ASC); $or6="6D"; break;
                case "6D": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"date",SORT_STRING,SORT_DESC,"time",SORT_STRING,SORT_DESC,"name",SORT_STRING,SORT_ASC); $or6="6A"; break;
                case "7A": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"ext",SORT_STRING,SORT_ASC,"name",SORT_STRING,SORT_ASC); $or7="7D"; break;
                case "7D": $entry_list = filemanager_array_csort ($entry_list,"type",SORT_STRING,SORT_ASC,"ext",SORT_STRING,SORT_DESC,"name",SORT_STRING,SORT_ASC); $or7="7A"; break;
            }
        }

        $out .= "
        <script language=\"Javascript\" type=\"text/javascript\">
        <!--
        function getCookieVal (offset) {
            var endstr = document.cookie.indexOf (';', offset);
            if (endstr == -1) endstr = document.cookie.length;
            return unescape(document.cookie.substring(offset, endstr));
        }
        function getCookie (name) {
            var arg = name + '=';
            var alen = arg.length;
            var clen = document.cookie.length;
            var i = 0;
            while (i < clen) {
                var j = i + alen;
                if (document.cookie.substring(i, j) == arg) return getCookieVal (j);
                i = document.cookie.indexOf(' ', i) + 1;
                if (i == 0) break;
            }
            return null;
        }
        function setCookie (name, value) {
            var argv = SetCookie.arguments;
            var argc = SetCookie.arguments.length;
            var expires = (argc > 2) ? argv[2] : null;
            var path = (argc > 3) ? argv[3] : null;
            var domain = (argc > 4) ? argv[4] : null;
            var secure = (argc > 5) ? argv[5] : false;
            document.cookie = name + '=' + escape (value) +
            ((expires == null) ? '' : ('; expires=' + expires.toGMTString())) +
            ((path == null) ? '' : ('; path=' + path)) +
            ((domain == null) ? '' : ('; domain=' + domain)) +
            ((secure == true) ? '; secure' : '');
        }
        function delCookie (name) {
            var exp = new Date();
            exp.setTime (exp.getTime() - 1);
            var cval = GetCookie (name);
            document.cookie = name + '=' + cval + '; expires=' + exp.toGMTString();
        }
        function go(arg) {
            document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=3&dir_actual=$dir_actual'+arg+'/';
        }
        function resolveIDs() {
            document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=3&set_resolveIDs=1&dir_actual=$dir_actual';
        }
        var entry_list = new Array();
        // Custom object constructor
        function entry(name, type, size, selected){
            this.name = name;
            this.type = type;
            this.size = size;
            this.selected = false;
        }
        // Declare entry_list for selection procedures";
        foreach ($entry_list as $i=>$data){
            $out .= "\nentry_list['entry$i'] = new entry('".$data["name"]."', '".$data["type"]."', ".$data["size"].", false);";
        }
        $out .= "
        // Select/Unselect Rows OnClick/OnMouseOver
        var lastRows = new Array(null,null);
        function selectEntry(Row, Action){
            var MarkColor = '#".$fm_color['Mark']."';
            var Cells = Row.getElementsByTagName('td');
            if (multipleSelection){
                // Avoid repeated onmouseover events from same Row ( cell transition )
                if (Row != lastRows[0]){
                    if (Action == 'over') {
                        if (entry_list[Row.id].selected){
                            if (entry_list[Row.id].type == 'dir') DefaultColor = '#".$fm_color['Dir']."';
                            else DefaultColor = '#".$fm_color['File']."';
                            if (unselect(entry_list[Row.id])) {
                                for (var c=0; c < ".(integer)$highlight_cols."; c++) {
                                    if (c == 0 && entry_list[Row.id].type=='file' && !entry_list[Row.id].selected) Cells[c].style.backgroundColor = '#".$fm_color['FileFirstCell']."';
                                    else Cells[c].style.backgroundColor = DefaultColor;
                                }
                            }
                            // Change the last Row when you change the movement orientation
                            if (lastRows[0] != null && lastRows[1] != null){
                                var LastRowID = lastRows[0].id;
                                var LastRowDefaultColor;
                                if (entry_list[LastRowID].type == 'dir') LastRowDefaultColor = '#".$fm_color['Dir']."';
                                else LastRowDefaultColor = '#".$fm_color['File']."';
                                if (Row.id == lastRows[1].id){
                                    var LastRowCells = lastRows[0].getElementsByTagName('td');
                                    if (unselect(entry_list[LastRowID])) {
                                        for (var c=0; c < ".(integer)$highlight_cols."; c++) {
                                            if (c == 0 && entry_list[LastRowID].type=='file' && !entry_list[LastRowID].selected) LastRowCells[c].style.backgroundColor = '#".$fm_color['FileFirstCell']."';
                                            else LastRowCells[c].style.backgroundColor = LastRowDefaultColor;
                                        }
                                    }
                                }
                            }
                        } else {
                            if (select(entry_list[Row.id])){
                                for (var c=0; c < ".(integer)$highlight_cols."; c++) {
                                    if (c == 0 && entry_list[Row.id].type=='file' && !entry_list[Row.id].selected) Cells[c].style.backgroundColor = '#".$fm_color['FileFirstCell']."';
                                    else Cells[c].style.backgroundColor = MarkColor;
                                }
                            }
                            // Change the last Row when you change the movement orientation
                            if (lastRows[0] != null && lastRows[1] != null){
                                var LastRowID = lastRows[0].id;
                                if (Row.id == lastRows[1].id){
                                    var LastRowCells = lastRows[0].getElementsByTagName('td');
                                    if (select(entry_list[LastRowID])) {
                                        for (var c=0; c < ".(integer)$highlight_cols."; c++) {
                                            if (c == 0 && entry_list[LastRowID].type=='file' && !entry_list[LastRowID].selected) LastRowCells[c].style.backgroundColor = '#".$fm_color['FileFirstCell']."';
                                            else LastRowCells[c].style.backgroundColor = MarkColor;
                                        }
                                    }
                                }
                            }
                        }
                        lastRows[1] = lastRows[0];
                        lastRows[0] = Row;
                    }
                }
            } else {
                if (Action == 'click') {
                    var newColor = null;
                    if (entry_list[Row.id].selected){
                        var DefaultColor;
                        if (entry_list[Row.id].type == 'dir') DefaultColor = '#".$fm_color['Dir']."';
                        else DefaultColor = '#".$fm_color['File']."';
                        if (unselect(entry_list[Row.id])) newColor = DefaultColor;
                    } else {
                        if (select(entry_list[Row.id])) newColor = MarkColor;
                    }
                    if (newColor) {
                        lastRows[0] = lastRows[1] = Row;
                        for (var c=0; c < ".(integer)$highlight_cols."; c++) {
                            if (c == 0 && entry_list[Row.id].type=='file' && !entry_list[Row.id].selected) Cells[c].style.backgroundColor = '#".$fm_color['FileFirstCell']."';
                            else Cells[c].style.backgroundColor = newColor;
                        }
                    }
                }
            }
            return true;
        }
        // Disable text selection and bind multiple selection flag
        var multipleSelection = false;
        if (is.ie) {
            document.onselectstart=new Function('return false');
            document.onmousedown=switch_flag_on;
            document.onmouseup=switch_flag_off;
            // Event mouseup is not generated over scrollbar.. curiously, mousedown is.. go figure.
            window.onscroll=new Function('multipleSelection=false');
        } else {
            if (document.layers) window.captureEvents(Event.MOUSEDOWN);
            if (document.layers) window.captureEvents(Event.MOUSEUP);
            window.onmousedown=switch_flag_on;
            window.onmouseup=switch_flag_off;
        }
        // Using same function and a ternary operator couses bug on double click
        function switch_flag_on(e) {
            lastRows[0] = lastRows[1] = null;
            if (is.ie){
                multipleSelection = (event.button == 1);
            } else {
                multipleSelection = (e.which == 1);
            }
            return false;
        }
        function switch_flag_off(e) {
            if (is.ie){
                multipleSelection = (event.button != 1);
            } else {
                multipleSelection = (e.which != 1);
            }
            return false;
        }
        var total_dirs_selected = 0;
        var total_files_selected = 0;
        function unselect(Entry){
            if (!Entry.selected) return false;
            Entry.selected = false;
            sel_totalsize -= Entry.size;
            if (Entry.type == 'dir') total_dirs_selected--;
            else total_files_selected--;
            update_sel_status();
            return true;
        }
        function select(Entry){
            if(Entry.selected) return false;
            Entry.selected = true;
            sel_totalsize += Entry.size;
            if(Entry.type == 'dir') total_dirs_selected++;
            else total_files_selected++;
            update_sel_status();
            return true;
        }
        function is_anything_selected(){
            var selected_dir_list = new Array();
            var selected_file_list = new Array();
            for(var x=0;x<".(integer)count($entry_list).";x++){
                if(entry_list['entry'+x].selected){
                    if(entry_list['entry'+x].type == 'dir') selected_dir_list.push(entry_list['entry'+x].name);
                    else selected_file_list.push(entry_list['entry'+x].name);
                }
            }
            document.form_action.selected_dir_list.value = selected_dir_list.join('<|*|>');
            document.form_action.selected_file_list.value = selected_file_list.join('<|*|>');
            return (total_dirs_selected>0 || total_files_selected>0);
        }
        function formatsize (arg) {
            var resul = '';
            if (arg>0){
                var j = 0;
                var ext = new Array(' bytes',' Kb',' Mb',' Gb',' Tb');
                while (arg >= Math.pow(1024,j)) ++j;
                resul = (Math.round(arg/Math.pow(1024,j-1)*100)/100) + ext[j-1];
            } else resul = '0 Mb';
            return resul;
        }
        var sel_totalsize = 0;
        function update_sel_status(){
            var t = total_dirs_selected+' ".T_('directory(s)')." ".T_('And')." '+total_files_selected+' ".T_('file(s)')." ".T_('selected(s)')." = '+formatsize(sel_totalsize);
            document.getElementById(\"sel_status\").innerHTML = t;
        }
        // Select all/none/inverse
        function selectANI(Butt){
            var MarkColor = '#".$fm_color['Mark']."';
            for(var x=0;x<". (integer)count($entry_list).";x++){
                if (entry_list['entry'+x].type == 'dir'){
                    var DefaultColor = '#".$fm_color['Dir']."';
                } else {
                    var DefaultColor = '#".$fm_color['File']."';
                }
                var Row = document.getElementById('entry'+x);
                var Cells = Row.getElementsByTagName('td');
                var newColor = null;
                switch (Butt.value){
                    case '".T_('All')."':
                        if (select(entry_list[Row.id])) newColor = MarkColor;
                    break;
                    case '".T_('None')."':
                        if (unselect(entry_list[Row.id])) newColor = DefaultColor;
                    break;
                    case '".T_('Inverse')."':
                        if (entry_list[Row.id].selected){
                            if (unselect(entry_list[Row.id])) newColor = DefaultColor;
                        } else {
                            if (select(entry_list[Row.id])) newColor = MarkColor;
                        }
                    break;
                }
                if (newColor) {
                    for (var c=0; c < ".(integer)$highlight_cols."; c++) {
                        if (entry_list[Row.id].type=='file' && c==0 && !entry_list[Row.id].selected) Cells[c].style.backgroundColor = '#". $fm_color['FileFirstCell']."';
                        else Cells[c].style.backgroundColor = newColor;
                    }
                }
            }
            if (Butt.value == '".T_('All')."'){
                Butt.value = '".T_('None')."';
            } else if (Butt.value == '".T_('None')."'){
                Butt.value = '".T_('All')."';
            }
            return true;
        }
        function download(arg){
                parent.frame1.location.href='".$path_info["basename"]."?action=3&dir_actual=$dir_actual&filename='+escape(arg);
        }
        function upload(){
                var w = 400;
                var h = 200;
                window.open('".$path_info["basename"]."?action=10&dir_actual=$dir_actual', '', 'width='+w+',height='+h+',fullscreen=no,scrollbars=no,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
        }
        function execute(){
                document.form_action.cmd_arg.value = prompt('".T_('Enter the command').".');
                if(document.form_action.cmd_arg.value.length>0){
                    if(confirm('".T_('Confirm EXECUTE')." \\' '+document.form_action.cmd_arg.value+' \\' ?')) {
                        var w = 800;
                        var h = 600;
                        window.open('".$path_info["basename"]."?action=6&dir_actual=$dir_actual&cmd='+escape(document.form_action.cmd_arg.value), '', 'width='+w+',height='+h+',fullscreen=no,scrollbars=yes,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
                    }
                }
        }
        function edit_file(arg){
                var w = 800;
                var h = 600;
                if(confirm('".strtoupper(T_('Edit'))." \\' '+arg+' \\' ?')) window.open('".$path_info["basename"]."?action=7&dir_actual=$dir_actual&filename='+escape(arg), '', 'width='+w+',height='+h+',fullscreen=no,scrollbars=no,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
        }
        function config(){
                var w = 600;
                var h = 400;
                window.open('".$path_info["basename"]."?action=2', 'win_config', 'width='+w+',height='+h+',fullscreen=no,scrollbars=yes,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
        }
        function server_info(arg){
                var w = 800;
                var h = 600;
                window.open('".$path_info["basename"]."?action=5', 'win_serverinfo', 'width='+w+',height='+h+',fullscreen=no,scrollbars=yes,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
        }
        function shell(){
                var w = 800;
                var h = 600;
                window.open('".$path_info["basename"]."?action=9', '', 'width='+w+',height='+h+',fullscreen=no,scrollbars=yes,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
        }
        function view(arg){
                var w = 800;
                var h = 600;
                if(confirm('".strtoupper(T_('View'))." \\' '+arg+' \\' ?')) window.open('".$path_info["basename"]."?action=4&dir_actual=$dir_actual&filename='+escape(arg), '', 'width='+w+',height='+h+',fullscreen=no,scrollbars=yes,resizable=yes,status=yes,toolbar=no,menubar=no,location=yes');
        }
        function rename(arg){
                var nome = '';
                if (nome = prompt('".strtoupper(T_('Rename'))." \\' '+arg+' \\' ".T_('to')." ...')) document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=3&action=3&dir_actual=$dir_actual&old_name='+escape(arg)+'&new_name='+escape(nome);
        }
        function set_dir_dest(arg){
            document.form_action.dir_dest.value=arg;
            if (document.form_action.action.value.length>0) test(document.form_action.action.value);
            else alert('".T_('JavaScript Error').".');
        }
        function sel_dir(arg){
            document.form_action.action.value = arg;
            document.form_action.dir_dest.value='';
            if (!is_anything_selected()) alert('".T_('There are no selected items').".');
            else {
                if (!getCookie('sel_dir_warn')) {
                    alert('".T_('Select the destination directory on the left tree').".');
                    document.cookie='sel_dir_warn'+'='+escape('true')+';';
                }
                parent.frame2.set_flag(true);
            }
        }
        function set_chmod_arg(arg){
            document.form_action.chmod_arg.value=arg;
            if (document.form_action.action.value.length>0) test(document.form_action.action.value);
            else alert('".T_('JavaScript Error')."');
        }
        function chmod(arg){
            document.form_action.action.value = arg;
            document.form_action.dir_dest.value='';
            document.form_action.chmod_arg.value='';
            if (!is_anything_selected()) alert('".T_('There are no selected items').".');
            else {
                var w = 280;
                var h = 180;
                window.open('".$path_info["basename"]."?action=8', '', 'width='+w+',height='+h+',fullscreen=no,scrollbars=no,resizable=yes,status=no,toolbar=no,menubar=no,location=no');
            }
        }
        function test_action(){
            if (document.form_action.action.value != 0) return true;
            else return false;
        }
        function test_prompt(arg){
                var erro='';
                var conf='';
                if (arg == 1){
                    document.form_action.cmd_arg.value = prompt('".T_('Enter the directory name').".');
                } else if (arg == 2){
                    document.form_action.cmd_arg.value = prompt('".T_('Enter the file name').".');
                } else if (arg == 71){
                    if (!is_anything_selected()) erro = '".T_('There are no selected items').".';
                    else document.form_action.cmd_arg.value = prompt('".T_('Enter the file name.\\nThe extension will define the compression type.\\nEx:\\nnome.zip\\nnome.tar\\nnome.bzip\\nnome.gzip')."');
                }
                if (erro!=''){
                    document.form_action.cmd_arg.focus();
                    alert(erro);
                } else if(document.form_action.cmd_arg.value.length>0) {
                    document.form_action.action.value = arg;
                    document.form_action.submit();
                }
        }
        function strstr(haystack,needle){
            var index = haystack.indexOf(needle);
            return (index==-1)?false:index;
        }
        function valid_dest(dest,orig){
            return (strstr(dest,orig)==false)?true:false;
        }
        // ArrayAlert - Selection debug only
        function aa(){
            var str = 'selected_dir_list:\\n';
            for (x=0;x<selected_dir_list.length;x++){
                str += selected_dir_list[x]+'\\n';
            }
            str += '\\nselected_file_list:\\n';
            for (x=0;x<selected_file_list.length;x++){
                str += selected_file_list[x]+'\\n';
            }
            alert(str);
        }
        function test(arg){
                var erro='';
                var conf='';
                if (arg == 4){
                    if (!is_anything_selected()) erro = '".T_('There are no selected items').".\\n';
                    conf = '".T_('RemSel')." ?\\n';
                } else if (arg == 5){
                    if (!is_anything_selected()) erro = '".T_('There are no selected items').".\\n';
                    else if(document.form_action.dir_dest.value.length == 0) erro = '".T_('There is no selected destination directory').".';
                    else if(document.form_action.dir_dest.value == document.form_action.dir_actual.value) erro = '".T_('Origin and destination directories are equal').".';
                    else if(!valid_dest(document.form_action.dir_dest.value,document.form_action.dir_actual.value)) erro = '".T_('Destination directory is invalid').".';
                    conf = '".T_('COPY to')." \\' '+document.form_action.dir_dest.value+' \\' ?\\n';
                } else if (arg == 6){
                    if (!is_anything_selected()) erro = '".T_('There are no selected items').".';
                    else if(document.form_action.dir_dest.value.length == 0) erro = '".T_('There is no selected destination directory').".';
                    else if(document.form_action.dir_dest.value == document.form_action.dir_actual.value) erro = '".T_('Origin and destination directories are equal').".';
                    else if(!valid_dest(document.form_action.dir_dest.value,document.form_action.dir_actual.value)) erro = '".T_('Destination directory is invalid').".';
                    conf = '".T_('MOVE to')." \\' '+document.form_action.dir_dest.value+' \\' ?\\n';
                } else if (arg == 9){
                    if (!is_anything_selected()) erro = '".T_('There are no selected items').".';
                    else if(document.form_action.chmod_arg.value.length == 0) erro = '".T_('New permission not set').".';
                    conf = '".T_('CHANGE PERMISSIONS to')." \\' '+document.form_action.chmod_arg.value+' \\' ?\\n';
                }
                if (erro!=''){
                    document.form_action.cmd_arg.focus();
                    alert(erro);
                } else if(conf!='') {
                    if(confirm(conf)) {
                        document.form_action.action.value = arg;
                        document.form_action.submit();
                    }
                } else {
                    document.form_action.action.value = arg;
                    document.form_action.submit();
                }
        }
        //-->
        </script>";
        $out .= "
        <form name=\"form_action\" action=\"".$path_info["basename"]."\" method=\"post\" onsubmit=\"return test_action();\">
            <input type=hidden name=\"frame\" value=3>
	    <input type=hidden name=\"dominio\" value=\"$dominio\">
            <input type=hidden name=\"action\" value=0>
            <input type=hidden name=\"dir_dest\" value=\"\">
            <input type=hidden name=\"chmod_arg\" value=\"\">
            <input type=hidden name=\"cmd_arg\" value=\"\">
            <input type=hidden name=\"dir_actual\" value=\"$dir_actual\">
            <input type=hidden name=\"dir_antes\" value=\"$dir_antes\">
            <input type=hidden name=\"selected_dir_list\" value=\"\">
            <input type=hidden name=\"selected_file_list\" value=\"\">";
/* 
            <input type=button onclick=\"config()\" value=\"".T_('Config')."\">
            <input type=button onclick=\"server_info()\" value=\"".T_('ServerInfo')."\">
            <input type=button onclick=\"execute()\" value=\"".T_('ExecCmd')."\">
            <input type=button onclick=\"shell()\" value=\"".T_('Shell')."\">
*/
        $out .= "
            <tr>
            <td bgcolor=\"#DDDDDD\" colspan=20><nobr>
            <input type=button onclick=\"test_prompt(1)\" value=\"".T_('Create Directory')."\">
            <input type=button onclick=\"test_prompt(2)\" value=\"".T_('Create File')."\">
            <input type=button onclick=\"upload()\" value=\"".T_('Upload')."\">
            <b>$ip</b>
            </nobr>";
        if ($dir_actual != $fm_root_atual){
            $mat = explode("/",$dir_actual);
            $dir_antes = "";
            for($x=0;$x<(count($mat)-2);$x++) $dir_antes .= $mat[$x]."/";
            $uplink = "<a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&dir_actual=$dir_antes\"><img src=\"/admin_panel/modulos/mod_filemanager/images/anterior.gif\" width=\"16\" height=\"16\" border=\"0\"></a> ";
        }
        if($entry_count){
            $out .= "
                <tr><td bgcolor=\"#993333\" colspan=20><nobr>$uplink <a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&dir_actual=$dir_actual\" class=blanco>$dir_actual</a></nobr>
                <tr>
                <td bgcolor=\"#DDDDDD\" colspan=20><nobr>
                      <input type=\"button\" style=\"width:60\" onclick=\"selectANI(this)\" value=\"".T_('All')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"selectANI(this)\" value=\"".T_('Inverse')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"test(4)\" value=\"".T_('Delete')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"sel_dir(5)\" value=\"".T_('Copy')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"sel_dir(6)\" value=\"".T_('Move')."\">";
            if ($islinux) $out .= "
                      <input type=\"button\" style=\"width:100\" onclick=\"resolveIDs()\" value=\"".T_('Resolve IDs')."\">";
            $out .= "
                      <input type=\"button\" style=\"width:100\" onclick=\"chmod(9)\" value=\"".T_('Permissions')."\">";
            $out .= "
                </nobr>
                <tr><td bgcolor=\"#DDDDDD\" colspan=20><DIV ID=\"sel_status\"></DIV></td></tr>";
            $dir_out="";
            $file_out="";
            foreach ($entry_list as $ind=>$dir_entry) {
                 $file = $dir_entry["name"];
                 if ($dir_entry["type"]=="dir"){
                     $dir_out .= "
                                 <tr ID=\"entry$ind\" onmouseover=\"selectEntry(this, 'over');\" onmousedown=\"selectEntry(this, 'click');\">
				 <td align=center bgcolor=\"#".$fm_color['Dir']."\"><img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_dir.gif\" width=\"16\" height=\"16\" border=\"0\">
                                 <td align=left bgcolor=\"#".$fm_color['Dir']."\"><nobr><a href=\"JavaScript:go('$file')\">$file</a></nobr>
                                 <td bgcolor=\"#".$fm_color['Dir']."\">".$dir_entry["p"];
                     if ($islinux) $dir_out .= "<td bgcolor=\"#".$fm_color['Dir']."\">".$dir_entry["u"]."<td bgcolor=\"#".$fm_color['Dir']."\">".$dir_entry["g"];
                     $dir_out .= "
                                 <td bgcolor=\"#".$fm_color['Dir']."\">".$dir_entry["sizet"]."
                                 <td bgcolor=\"#".$fm_color['Dir']."\">".$dir_entry["datet"];
                     if ($file_count) $dir_out .= "
                                 <td bgcolor=\"#".$fm_color['Dir']."\" align=center>[dir]";
                     // Opciones de directorio
                     if ( is_writable($dir_actual.$file) || $dir_entry["u"]==_CFG_PUREFTPD_UID) $dir_out .= "
                                 <td bgcolor=\"#FFFFFF\" align=center><a href=\"JavaScript:if(confirm('".T_('Confirm DELETE')." \\'".$file."\\' ?')) document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=3&action=8&cmd_arg=".$file."&dir_actual=$dir_actual'\">".T_('Delete')."</a>
                                 <td bgcolor=\"#FFFFFF\" align=center><a href=\"JavaScript:rename('$file')\">".T_('Rename')."</a>";
                     $dir_out .= "
                                 </tr>";
                 } else {
                     $file_out .= "
                                 <tr ID=\"entry$ind\" onmouseover=\"selectEntry(this, 'over');\" onmousedown=\"selectEntry(this, 'click');\">
				 <td align=center align=left bgcolor=\"#FFFFFF\">";
		    		switch($dir_entry["ext"]){
				case ".html":
				case ".htm":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_html.gif\" width=\"20\" height=\"20\" border=\"0\">";
				break;
				case ".php":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_php.gif\" width=\"20\" height=\"20\" border=\"0\">";
				break;
				case ".asp":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_asp.gif\" width=\"20\" height=\"20\" border=\"0\">";
				break;
				case ".rar":
				case ".zip":
				case ".arj":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_zip.gif\" width=\"20\" height=\"20\" border=\"0\">";
				break;
				case ".pdf":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_pdf.gif\" width=\"20\" height=\"20\" border=\"0\">";
				break;
				case ".doc":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_word.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".xls":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_excel.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".jpeg":
				case ".jpg":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_jpg.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".png":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_png.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".bmp":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_bmp.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".js":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_js.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".mp3":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_mp3.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".css":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_css.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".ppt":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_ppt.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".swf":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_swf.gif\" width=\"19\" height=\"19\" border=\"0\">";
				break;
				case ".exe":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_exe.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".gif":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_gif.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				case ".txt":
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_txt.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				default:
					$file_out .= "<img src=\"/admin_panel/modulos/mod_filemanager/images/icon/icon_misc.gif\" width=\"16\" height=\"16\" border=\"0\">";
				break;
				}
		     $file_out .= "<td align=left bgcolor=\"#FFFFFF\"><nobr><a href=\"JavaScript:download('$file')\">$file</a></nobr>
                                 <td bgcolor=\"#".$fm_color['File']."\">".$dir_entry["p"];
                     if ($islinux) $file_out .= "<td bgcolor=\"#".$fm_color['File']."\">".$dir_entry["u"]."<td bgcolor=\"#".$fm_color['File']."\">".$dir_entry["g"];
                     $file_out .= "
                                 <td bgcolor=\"#".$fm_color['File']."\">".$dir_entry["sizet"]."
                                 <td bgcolor=\"#".$fm_color['File']."\">".$dir_entry["datet"]."
                                 <td bgcolor=\"#".$fm_color['Ext']."\">".$dir_entry["extt"];
                     // Opciones de archivo
                     if ( is_writable($dir_actual.$file) || $dir_entry["u"]==_CFG_PUREFTPD_UID) $file_out .= "
                                 <td width=\"15\" height=\"15\" bgcolor=\"#".$fm_color['Action']."\" align=center><a href=\"javascript:if(confirm('".strtoupper(T_('Delete'))." \\'".$file."\\' ?')) document.location.href='".$path_info["basename"]."?dominio=".$dominio."&frame=3&action=8&cmd_arg=".$file."&dir_actual=$dir_actual'\">".T_('Delete')."</a>
                                 <td width=\"15\" height=\"15\" bgcolor=\"#".$fm_color['Action']."\" align=center><a href=\"javascript:rename('$file')\">".T_('Rename')."</a>";
                     if ( is_readable($dir_actual.$file) && (strpos(".wav#.mp3#.mid#.avi#.mov#.mpeg#.mpg#.rm#.iso#.bin#.img#.dll#.psd#.fla#.swf#.class#.ppt#.jpg#.gif#.png#.wmf#.eps#.bmp#.msi#.exe#.com#.rar#.tar#.zip#.bz2#.tbz2#.bz#.tbz#.bzip#.gzip#.gz#.tgz#", $dir_entry["ext"]."#" ) === false)) $file_out .= "
                                 <td width=\"15\" height=\"15\" bgcolor=\"#".$fm_color['Action']."\" align=center><a href=\"javascript:edit_file('$file')\">".T_('Edit')."</a>";
                     if ( is_readable($dir_actual.$file) && strlen($dir_entry["ext"]) && (strpos(".tar#.zip#.bz2#.tbz2#.bz#.tbz#.bzip#.gzip#.gz#.tgz#", $dir_entry["ext"]."#" ) !== false)) $file_out .= "
                                 <td width=\"15\" height=\"15\" bgcolor=\"#".$fm_color['Action']."\" align=center>";
			if( $is_reachable && is_readable($dir_actual.$file) && (strpos(".txt#.sys#.bat#.ini#.conf#.swf#.php#.php3#.asp#.html#.htm#.jpg#.gif#.png#.bmp#", $dir_entry["ext"]."#" ) !== false)) $file_out .= "
                                 <td width=\"15\" height=\"15\" bgcolor=\"#".$fm_color['Action']."\" align=center><a href=\"javascript:view('$file');\">".T_('View')."</a>";
                     $file_out .= "</tr>";
                 }
            }
            if ($entry_count){
                $out .= "
                <tr>
 		      <td bgcolor=\"#".$fm_color['Title']."\"><img src=\"\" width=\"1\" height=\"1\" border=\"0\">
                      <td bgcolor=\"#".$fm_color['Title']."\"><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&or_by=$or1&dir_actual=$dir_actual\">".T_('Name')."</a>
                      <td bgcolor=\"#".$fm_color['Title']."\"><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&or_by=$or2&dir_actual=$dir_actual\">".T_('Permissions')."</a>";
                if ($islinux) $out .= "<td bgcolor=\"#".$fm_color['Title']."\"><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&or_by=$or3&dir_actual=$dir_actual\">".T_('Owner')."</a><td bgcolor=\"#".$fm_color['Title']."\"><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&or_by=$or4&dir_actual=$dir_actual\">".T_('Group')."</a>";
                $out .= "
                      <td bgcolor=\"#".$fm_color['Title']."\"><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&or_by=$or5&dir_actual=$dir_actual\">".T_('Size')."</a>
                      <td bgcolor=\"#".$fm_color['Title']."\"><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&or_by=$or6&dir_actual=$dir_actual\">".T_('Date')."</a>";
                if ($file_count) $out .= "
                      <td bgcolor=\"#".$fm_color['Title']."\"><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&or_by=$or7&dir_actual=$dir_actual\">".T_('Type')."</a>";
                $out .= "
                      <td bgcolor=\"#".$fm_color['Title']."\" colspan=20>";

            }
            $out .= $dir_out;
            $out .= $file_out;
            $out .= "
                <tr>
                <td bgcolor=\"#DDDDDD\" colspan=20><nobr>
                      <input type=\"button\" style=\"width:60\" onclick=\"selectANI(this)\" value=\"".T_('All')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"selectANI(this)\" value=\"".T_('Inverse')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"test(4)\" value=\"".T_('Delete')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"sel_dir(5)\" value=\"".T_('Copy')."\">
                      <input type=\"button\" style=\"width:60\" onclick=\"sel_dir(6)\" value=\"".T_('Move')."\">";
            if ($islinux) $out .= "
                      <input type=\"button\" style=\"width:100\" onclick=\"resolveIDs()\" value=\"".T_('Resolve IDs')."\">";
            $out .= "
                      <input type=\"button\" style=\"width:100\" onclick=\"chmod(9)\" value=\"".T_('Permissions')."\">";
            $out .= "
                </nobr></td>
                </tr>";
            $out .= "
            </form>";
            $out .= "
                <tr><td bgcolor=\"#DDDDDD\" colspan=20>$dir_count ".T_('directory(s)')." ".T_('And')." $file_count ".T_('file(s)')." = ".filemanager_formatsize($total_size)."</td></tr>";
            if ($quota_mb) {
                $out .= "
                <tr><td bgcolor=\"#DDDDDD\" colspan=20>".T_('Quota space').": ".filemanager_formatsize(($quota_mb*1024*1024))." ".T_('total')." - ".filemanager_formatsize(($quota_mb*1024*1024)-filemanager_quotastatus($dominio))." ".T_('free')."</td></tr>";
            } else {
                $out .= "
                <tr><td bgcolor=\"#DDDDDD\" colspan=20>".T_('Quota space').": ".filemanager_formatsize(disk_total_space($dir_actual))." ".T_('total')." - ".filemanager_formatsize(disk_free_space($fm_root_atual))." ".T_('free')."</td></tr>";
            }
            $tf = filemanager_getmicrotime();
            $tt = ($tf - $ti);
            $out .= "
                <tr><td bgcolor=\"#DDDDDD\" colspan=20>".T_('Time to render this page').": ".substr($tt,0,strrpos($tt,".")+5)." ".T_('sec')."</td></tr>";
            $out .= "
            <script language=\"Javascript\" type=\"text/javascript\">
            <!--
                update_sel_status();
            //-->
            </script>";
        } else {
            $out .= "
            <tr>
            <td bgcolor=\"#DDDDDD\" width=\"1%\">$uplink<td bgcolor=\"#DDDDDD\" colspan=20><nobr><a href=\"".$path_info["basename"]."?dominio=".$dominio."&frame=3&dir_actual=$dir_actual\">$dir_actual</a></nobr>
            <tr><td bgcolor=\"#DDDDDD\" colspan=20>".T_('Empty directory').".</tr>";
        }
    } else $out .= "<tr><td><font color=red>".T_('I/O Error').".<br>$dir_actual</font>";
    $out .= "</table>";
    echo $out;
}
function filemanager_upload_form(){
    global $_FILES,$dir_actual,$dir_dest,$fechar,$quota_mb,$path_info;
    $num_uploads = 5;
    filemanager_html_header();
    echo "<body marginwidth=\"0\" marginheight=\"0\">";
    if (count($_FILES)==0){
        echo "
        <table height=\"100%\" border=0 cellspacing=0 cellpadding=2 align=center>
        <form name=\"upload_form\" action=\"".$path_info["basename"]."\" method=\"post\" ENCTYPE=\"multipart/form-data\">
        <input type=hidden name=dir_dest value=\"$dir_actual\">
        <input type=hidden name=action value=10>
        <tr><th colspan=2>".T_('Upload')."</th></tr>
        <tr><td align=right><b>".T_('Destination').":<td><b><nobr>$dir_actual</nobr>";
        for ($x=0;$x<$num_uploads;$x++){
            echo "<tr><td width=1 align=right><b>".T_('File').":<td><nobr><input type=\"file\" name=\"file$x\"></nobr>";
            $test_js .= "(document.upload_form.file$x.value.length>0)||";
        }
        echo "
        <input type=button value=\"".T_('Send')."\" onclick=\"test_upload_form()\"></nobr>
        <tr><td>�<td><input type=checkbox name=fechar value=\"1\"> <a href=\"JavaScript:troca();\">".T_('Close on Complete')."</a>
        <tr><td colspan=2>�</td></tr>
        </form>
        </table>
        <script language=\"Javascript\" type=\"text/javascript\">
        <!--
            function troca(){
                if(document.upload_form.fechar.checked){document.upload_form.fechar.checked=false;}else{document.upload_form.fechar.checked=true;}
            }
            foi = false;
            function test_upload_form(){
                if(".substr($test_js,0,strlen($test_js)-2)."){
                    if (foi) alert('".T_('Sending files, please wait')."...');
                    else {
                        foi = true;
                        document.upload_form.submit();
                    }
                } else alert('".T_('No file selected').".');
            }
            window.moveTo((window.screen.width-400)/2,((window.screen.height-200)/2)-20);
        //-->
        </script>";
    } else {
        $out = "<tr><th colspan=2>".T_('Upload Finished')."</th></tr>
                <tr><th colspan=2><nobr>".T_('Destination').": $dir_dest</nobr>";
        for ($x=0;$x<$num_uploads;$x++){
            $temp_file = $_FILES["file".$x]["tmp_name"];
            $filename = $_FILES["file".$x]["name"];
            if (strlen($filename)) $resul = filemanager_save_upload($temp_file,$filename,$dir_dest);
            else $resul = 7;
            switch($resul){
                case 1:
                $out .= "<tr><td><b>".filemanager_strzero($x+1,3).".<font color=green><b> ".T_('File sent').":</font><td>".$filename."</td></tr>\n";
                break;
                case 2:
                $out .= "<tr><td colspan=2><font color=red><b>".T_('I/O Error')."</font></td></tr>\n";
                $x = $upload_num;
                break;
                case 3:
                $out .= "<tr><td colspan=2><font color=red><b>".T_('Space limit reached')." ($quota_mb Mb)</font></td></tr>\n";
                $x = $upload_num;
                break;
                case 4:
                $out .= "<tr><td><b>".filemanager_strzero($x+1,3).".<font color=red><b> ".T_('Invalid extension').":</font><td>".$filename."</td></tr>\n";
                break;
                case 5:
                $out .= "<tr><td><b>".filemanager_strzero($x+1,3).".<font color=red><b> ".T_('File could not be overwritten')."</font><td>".$filename."</td></tr>\n";
                break;
                case 6:
                $out .= "<tr><td><b>".filemanager_strzero($x+1,3).".<font color=green><b> ".T_('File overwritten').":</font><td>".$filename."</td></tr>\n";
                break;
                case 7:
                $out .= "<tr><td colspan=2><b>".filemanager_strzero($x+1,3).".<font color=red><b> ".T_('File ignored')."</font></td></tr>\n";
            }
        }
        if ($fechar) {
            echo "
            <script language=\"Javascript\" type=\"text/javascript\">
            <!--
                window.close();
            //-->
            </script>
            ";
        } else {
            echo "
            <table height=\"100%\" border=0 cellspacing=0 cellpadding=2 align=center>
            $out
            <tr><td colspan=2>�</td></tr>
            </table>
            <script language=\"Javascript\" type=\"text/javascript\">
            <!--
                window.focus();
            //-->
            </script>
            ";
        }
    }
    echo "</body>\n</html>";
}
function filemanager_chmod_form(){
    $aux = "
    <script language=\"Javascript\" type=\"text/javascript\">
    <!--
    function octalchange()
    {
        var val = document.chmod_form.t_total.value;
        var stickybin = parseInt(val.charAt(0)).toString(2);
        var ownerbin = parseInt(val.charAt(1)).toString(2);
        while (ownerbin.length<3) { ownerbin=\"0\"+ownerbin; };
        var groupbin = parseInt(val.charAt(2)).toString(2);
        while (groupbin.length<3) { groupbin=\"0\"+groupbin; };
        var otherbin = parseInt(val.charAt(3)).toString(2);
        while (otherbin.length<3) { otherbin=\"0\"+otherbin; };
        document.chmod_form.sticky.checked = parseInt(stickybin.charAt(0));
        document.chmod_form.owner4.checked = parseInt(ownerbin.charAt(0));
        document.chmod_form.owner2.checked = parseInt(ownerbin.charAt(1));
        document.chmod_form.owner1.checked = parseInt(ownerbin.charAt(2));
        document.chmod_form.group4.checked = parseInt(groupbin.charAt(0));
        document.chmod_form.group2.checked = parseInt(groupbin.charAt(1));
        document.chmod_form.group1.checked = parseInt(groupbin.charAt(2));
        document.chmod_form.other4.checked = parseInt(otherbin.charAt(0));
        document.chmod_form.other2.checked = parseInt(otherbin.charAt(1));
        document.chmod_form.other1.checked = parseInt(otherbin.charAt(2));
        calc_chmod(1);
    };

    function calc_chmod(nototals)
    {
      var users = new Array(\"owner\", \"group\", \"other\");
      var totals = new Array(\"\",\"\",\"\");
      var syms = new Array(\"\",\"\",\"\");

        for (var i=0; i<users.length; i++)
        {
            var user=users[i];
            var field4 = user + \"4\";
            var field2 = user + \"2\";
            var field1 = user + \"1\";
            var symbolic = \"sym_\" + user;
            var number = 0;
            var sym_string = \"\";
            var sticky = \"0\";
            var sticky_sym = \" \";
            if (document.chmod_form.sticky.checked){
                sticky = \"1\";
                sticky_sym = \"t\";
            }
            if (document.chmod_form[field4].checked == true) { number += 4; }
            if (document.chmod_form[field2].checked == true) { number += 2; }
            if (document.chmod_form[field1].checked == true) { number += 1; }

            if (document.chmod_form[field4].checked == true) {
                sym_string += \"r\";
            } else {
                sym_string += \"-\";
            }
            if (document.chmod_form[field2].checked == true) {
                sym_string += \"w\";
            } else {
                sym_string += \"-\";
            }
            if (document.chmod_form[field1].checked == true) {
                sym_string += \"x\";
            } else {
                sym_string += \"-\";
            }

            totals[i] = totals[i]+number;
            syms[i] =  syms[i]+sym_string;

      };
        if (!nototals) document.chmod_form.t_total.value = sticky + totals[0] + totals[1] + totals[2];
        document.chmod_form.sym_total.value = syms[0] + syms[1] + syms[2] + sticky_sym;
    }
    function troca(){
        if(document.chmod_form.sticky.checked){document.chmod_form.sticky.checked=false;}else{document.chmod_form.sticky.checked=true;}
    }

    window.onload=octalchange
    window.moveTo((window.screen.width-400)/2,((window.screen.height-200)/2)-20);
    //-->
    </script>
    ";
    filemanager_html_header($aux);
    echo "<body marginwidth=\"0\" marginheight=\"0\">
    <form name=\"chmod_form\">
    <TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"4\" ALIGN=CENTER>
    <tr><th colspan=4>".T_('Permissions')."</th></tr>
    <TR ALIGN=\"LEFT\" VALIGN=\"MIDDLE\">
    <TD><input type=\"text\" name=\"t_total\" value=\"0777\" size=\"4\" onKeyUp=\"octalchange()\"> </TD>
    <TD><input type=\"text\" name=\"sym_total\" value=\"\" size=\"12\" READONLY=\"1\"></TD>
    </TR>
    </TABLE>
    <table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" ALIGN=CENTER>
    <tr bgcolor=\"#333333\">
    <td WIDTH=\"60\" align=\"left\"> </td>
    <td WIDTH=\"55\" align=\"center\" style=\"color:#FFFFFF\"><b>".T_('Owner')."
    </b></td>
    <td WIDTH=\"55\" align=\"center\" style=\"color:#FFFFFF\"><b>".T_('Group')."
    </b></td>
    <td WIDTH=\"55\" align=\"center\" style=\"color:#FFFFFF\"><b>".T_('Other')."
    <b></td>
    </tr>
    <tr bgcolor=\"#DDDDDD\">
    <td WIDTH=\"60\" align=\"left\" nowrap BGCOLOR=\"#FFFFFF\">".T_('Read')."</td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#EEEEEE\">
    <input type=\"checkbox\" name=\"owner4\" value=\"4\" onclick=\"calc_chmod()\">
    </td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#FFFFFF\"><input type=\"checkbox\" name=\"group4\" value=\"4\" onclick=\"calc_chmod()\">
    </td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#EEEEEE\">
    <input type=\"checkbox\" name=\"other4\" value=\"4\" onclick=\"calc_chmod()\">
    </td>
    </tr>
    <tr bgcolor=\"#DDDDDD\">
    <td WIDTH=\"60\" align=\"left\" nowrap BGCOLOR=\"#FFFFFF\">".T_('Write')."</td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#EEEEEE\">
    <input type=\"checkbox\" name=\"owner2\" value=\"2\" onclick=\"calc_chmod()\"></td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#FFFFFF\"><input type=\"checkbox\" name=\"group2\" value=\"2\" onclick=\"calc_chmod()\">
    </td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#EEEEEE\">
    <input type=\"checkbox\" name=\"other2\" value=\"2\" onclick=\"calc_chmod()\">
    </td>
    </tr>
    <tr bgcolor=\"#DDDDDD\">
    <td WIDTH=\"60\" align=\"left\" nowrap BGCOLOR=\"#FFFFFF\">".T_('Execute')."</td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#EEEEEE\">
    <input type=\"checkbox\" name=\"owner1\" value=\"1\" onclick=\"calc_chmod()\">
    </td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#FFFFFF\"><input type=\"checkbox\" name=\"group1\" value=\"1\" onclick=\"calc_chmod()\">
    </td>
    <td WIDTH=\"55\" align=\"center\" bgcolor=\"#EEEEEE\">
    <input type=\"checkbox\" name=\"other1\" value=\"1\" onclick=\"calc_chmod()\">
    </td>
    </tr>
    </TABLE>
    <TABLE BORDER=\"0\" CELLSPACING=\"0\" CELLPADDING=\"4\" ALIGN=CENTER>
    <tr><td colspan=2><input type=checkbox name=sticky value=\"1\" onclick=\"calc_chmod()\"> <a href=\"JavaScript:troca();\">".T_('Sticky Bit')."</a><td colspan=2 align=right><input type=button value=\"".T_('Apply')."\" onClick=\"window.opener.set_chmod_arg(document.chmod_form.t_total.value); window.close();\"></tr>
    </table>
    </form>
    </body>\n</html>";
}
function filemanager_view(){
    global $doc_root,$path_info,$url_info,$dir_actual,$islinux,$filename,$is_reachable;
    filemanager_html_header();
    echo "<body marginwidth=\"0\" marginheight=\"0\">
    <script language=\"Javascript\" type=\"text/javascript\">
    <!--
        window.moveTo((window.screen.width-800)/2,((window.screen.height-600)/2)-20);";
    if ($is_reachable){
        $url = $url_info["scheme"]."://".$url_info["host"];
        if (strlen($url_info["port"])) $url .= ":".$url_info["port"];
        // Malditas variaveis de sistema!! No windows doc_root � sempre em lowercase... cad� o str_ireplace() ??
        $url .= str_replace($doc_root,"",$dir_actual).$filename;
        echo "
        document.location.href='$url';";
    } else {
        echo "
        alert('".T_('File beyond DOCUMENT_ROOT').":\\n".$doc_root."\\n');
        window.close();";
    }
    echo "
    //-->
    </script>
    </body>\n</html>";
}
function filemanager_edit_file_form(){
    global $dir_actual,$filename,$file_data,$save_file,$path_info,$dominio;
    $file = $dir_actual.$filename;
    if ($save_file){
	$permisos=substr(sprintf('%o', fileperms($file)),-3);
	execute_cmd("chmod 777 $file");
 	$fichero_nuevo=fopen($file,"w");
	fwrite($fichero_nuevo,filemanager_htmldecode($file_data));
	fclose($fichero_nuevo);
	execute_cmd("chmod $permisos $file");
	filemanager_quotacalculate($dominio);
    }
    $file_data=file_get_contents($file);
    filemanager_html_header();
    echo "<body marginwidth=\"0\" marginheight=\"0\">
    <table border=0 cellspacing=0 cellpadding=5 align=center>
    <form name=\"edit_form\" action=\"".$path_info["basename"]."\" method=\"post\">
    <input type=hidden name=action value=\"7\">
    <input type=hidden name=save_file value=\"1\">
    <input type=hidden name=dir_actual value=\"$dir_actual\">
    <input type=hidden name=filename value=\"$filename\">
    <tr><th colspan=2>".$file."</th></tr>
    <tr><td colspan=2><textarea name=file_data rows=33 cols=105>".filemanager_htmlencode($file_data)."</textarea></td></tr>
    <tr><td><input type=button value=\"".T_('Refresh')."\" onclick=\"document.edit_form_refresh.submit()\"></td><td align=right><input type=button value=\"".T_('Save File')."\" onclick=\"go_save()\"></td></tr>
    </form>
    <form name=\"edit_form_refresh\" action=\"".$path_info["basename"]."\" method=\"post\">
    <input type=hidden name=action value=\"7\">
    <input type=hidden name=dir_actual value=\"$dir_actual\">
    <input type=hidden name=filename value=\"$filename\">
    </form>
    </table>
    <script language=\"Javascript\" type=\"text/javascript\">
    <!--
        window.moveTo((window.screen.width-800)/2,((window.screen.height-600)/2)-20);
        function go_save(){";
    if (is_writable($file) || fileowner($file)==_CFG_PUREFTPD_UID) {
        echo "
        document.edit_form.submit();";
    } else {
        echo "
        if(confirm('".T_('File without write permisson.\\nTry to save anyway')." ?')) document.edit_form.submit();";
    }
    echo "
        }
    //-->
    </script>
    </body>\n</html>";
}
function filemanager_right(){
    global $islinux,$cmd_arg,$chmod_arg,$zip_dir,$fm_root_atual;
    global $dir_dest,$dir_actual,$dir_antes;
    global $selected_file_list,$selected_dir_list,$old_name,$new_name;
    global $action,$or_by,$order_dir_list_by;

    if (!isset($order_dir_list_by)){
        $order_dir_list_by = "1A";
        setcookie("order_dir_list_by", $order_dir_list_by , $cookie_cache_time , "/");
    } elseif (strlen($or_by)){
        $order_dir_list_by = $or_by;
        setcookie("order_dir_list_by", $or_by , $cookie_cache_time , "/");
    }
    filemanager_html_header();
    echo "<body>\n";
    if ($action){
        switch ($action){
            case 1: // crear directorio
            if (strlen($cmd_arg)){
                $cmd_arg = filemanager_formatpath($dir_actual.$cmd_arg);
                if (!file_exists($cmd_arg)){
		    execute_cmd("mkdir $cmd_arg");
		    execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $cmd_arg");
                    //mkdir($cmd_arg,0777);
                    //chmod($cmd_arg,0777);
                    filemanager_reloadframe("parent",2,"&ec_dir=".$cmd_arg);
                } else filemanager_alert(T_('File or directory already exists').".");
            }
            break;
            case 2: // crear archivo
            if (strlen($cmd_arg)){
                $cmd_arg = $dir_actual.$cmd_arg;
                if (!file_exists($cmd_arg)){
		    execute_cmd("touch $cmd_arg");
		    execute_cmd("chown "._CFG_PUREFTPD_VIRTUALUSER."."._CFG_PUREFTPD_VIRTUALGROUP." $cmd_arg");
                    //if ($fh = @fopen($cmd_arg, "w")){
                    //    @fclose($fh);
                    //}
                    //chmod($cmd_arg,0666);
                } else filemanager_alert(T_('File or directory already exists').".");
            }
            break;
            case 3: // renombrar archivo o directorio
            if ((strlen($old_name))&&(strlen($new_name))){
		execute_cmd("mv $dir_actual$old_name $dir_actual$new_name");
                //rename($dir_actual.$old_name,$dir_actual.$new_name);
                if (is_dir($dir_actual.$new_name)) filemanager_reloadframe("parent",2);
            }
            break;
            case 4: // borrar seleccion
            if(strstr($dir_actual,$fm_root_atual)){
                if (strlen($selected_file_list)){
                    $selected_file_list = explode("<|*|>",$selected_file_list);
                    if (count($selected_file_list)) {
                        for($x=0;$x<count($selected_file_list);$x++) {
                            $selected_file_list[$x] = trim($selected_file_list[$x]);
                            if (strlen($selected_file_list[$x])) filemanager_total_delete($dir_actual.$selected_file_list[$x],$dir_dest.$selected_file_list[$x]);
                        }
                    }
                }
                if (strlen($selected_dir_list)){
                    $selected_dir_list = explode("<|*|>",$selected_dir_list);
                    if (count($selected_dir_list)) {
                        for($x=0;$x<count($selected_dir_list);$x++) {
                            $selected_dir_list[$x] = trim($selected_dir_list[$x]);
                            if (strlen($selected_dir_list[$x])) filemanager_total_delete($dir_actual.$selected_dir_list[$x],$dir_dest.$selected_dir_list[$x]);
                        }
                        filemanager_reloadframe("parent",2);
                    }
                }
            }
            break;
            case 5: // copiar seleccion
            if (strlen($dir_dest)){
                if(strtoupper($dir_dest) != strtoupper($dir_actual)){
                    if (strlen($selected_file_list)){
                        $selected_file_list = explode("<|*|>",$selected_file_list);
                        if (count($selected_file_list)) {
                            for($x=0;$x<count($selected_file_list);$x++) {
                                $selected_file_list[$x] = trim($selected_file_list[$x]);
                                if (strlen($selected_file_list[$x])) filemanager_total_copy($dir_actual.$selected_file_list[$x],$dir_dest.$selected_file_list[$x]);
                            }
                        }
                    }
                    if (strlen($selected_dir_list)){
                        $selected_dir_list = explode("<|*|>",$selected_dir_list);
                        if (count($selected_dir_list)) {
                            for($x=0;$x<count($selected_dir_list);$x++) {
                                $selected_dir_list[$x] = trim($selected_dir_list[$x]);
                                if (strlen($selected_dir_list[$x])) filemanager_total_copy($dir_actual.$selected_dir_list[$x],$dir_dest.$selected_dir_list[$x]);
                            }
                            filemanager_reloadframe("parent",2);
                        }
                    }
                    $dir_actual = $dir_dest;
                }
            }
            break;
            case 6: // mover seleccion
            if (strlen($dir_dest)){
                if(strtoupper($dir_dest) != strtoupper($dir_actual)){
                    if (strlen($selected_file_list)){
                        $selected_file_list = explode("<|*|>",$selected_file_list);
                        if (count($selected_file_list)) {
                            for($x=0;$x<count($selected_file_list);$x++) {
                                $selected_file_list[$x] = trim($selected_file_list[$x]);
                                if (strlen($selected_file_list[$x])) filemanager_total_move($dir_actual.$selected_file_list[$x],$dir_dest.$selected_file_list[$x]);
                            }
                        }
                    }
                    if (strlen($selected_dir_list)){
                        $selected_dir_list = explode("<|*|>",$selected_dir_list);
                        if (count($selected_dir_list)) {
                            for($x=0;$x<count($selected_dir_list);$x++) {
                                $selected_dir_list[$x] = trim($selected_dir_list[$x]);
                                if (strlen($selected_dir_list[$x])) filemanager_total_move($dir_actual.$selected_dir_list[$x],$dir_dest.$selected_dir_list[$x]);
                            }
                            filemanager_reloadframe("parent",2);
                        }
                    }
                    $dir_actual = $dir_dest;
                }
            }
            break;
            case 8: // borrar archivo o directorio
            if (strlen($cmd_arg)){
                if (file_exists($dir_actual.$cmd_arg)) filemanager_total_delete($dir_actual.$cmd_arg);
                if (is_dir($dir_actual.$cmd_arg)) filemanager_reloadframe("parent",2);
            }
            break;
            case 9: // CHMOD
            if((strlen($chmod_arg) == 4)&&(strlen($dir_actual))){
                if ($chmod_arg[0]=="1") $chmod_arg = "0".$chmod_arg;
                else $chmod_arg = "0".substr($chmod_arg,strlen($chmod_arg)-3);
                $new_mod = $chmod_arg; //octdec($chmod_arg);
                $selected_file_list = explode("<|*|>",$selected_file_list);
                if (count($selected_file_list)) 
			for($x=0;$x<count($selected_file_list);$x++)
				if($selected_file_list[$x]!="")
					execute_cmd("chmod $new_mod ".$dir_actual.$selected_file_list[$x]);
		//@chmod($dir_actual.$selected_file_list[$x],$new_mod);
		$selected_dir_list = explode("<|*|>",$selected_dir_list);
                if (count($selected_dir_list)) 
			for($x=0;$x<count($selected_dir_list);$x++) 
				if($selected_dir_list[$x]!="")
					execute_cmd("chmod $new_mod ".$dir_actual.$selected_dir_list[$x]);
		//@chmod($dir_actual.$selected_dir_list[$x],$new_mod);
		
            }
            break;
        }
        if ($action != 10) filemanager_dir_list_form();
    } else filemanager_dir_list_form();
    echo "</body>\n</html>";
}
function filemanager_left(){
    global $expanded_dir_list,$ec_dir;
    if (!isset($expanded_dir_list)) $expanded_dir_list = "";
    if (strlen($ec_dir)){
        if (strstr($expanded_dir_list,":".$ec_dir)) $expanded_dir_list = str_replace(":".$ec_dir,"",$expanded_dir_list);
        else $expanded_dir_list .= ":".$ec_dir;
        setcookie("expanded_dir_list", $expanded_dir_list , 0 , "/");
    }
    filemanager_show_tree();
}
function filemanager_html($dominio){
    global $path_info;
    filemanager_html_header();
    echo "
    <frameset cols=\"200,*\" framespacing=\"0\">
        <frameset rows=\"0,*\" framespacing=\"0\" frameborder=no>
            <frame src=\"".$path_info["basename"]."?dominio=$dominio&frame=1\" name=frame1 border=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=no>
            <frame src=\"".$path_info["basename"]."?dominio=$dominio&frame=2\" name=frame2 border=\"0\" marginwidth=\"0\" marginheight=\"0\">
        </frameset>
        <frame src=\"".$path_info["basename"]."?dominio=$dominio&frame=3\" name=frame3 border=\"0\" marginwidth=\"0\" marginheight=\"0\">
    </frameset>
    ";
    echo "</html>";
}
?>

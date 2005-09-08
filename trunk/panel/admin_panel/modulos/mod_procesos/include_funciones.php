<?php

function procesos_info(){
	$info["nombre"]="Procesos";
	$info["version"]="1.0";
	$info["grupo"]="sistema";

	return $info;
}

function procesos_array_combine($keys, $values) {
   if(!is_array($keys)) return false;
   if(!is_array($values)) return false;
    
   $array = array();
  
       //If there are more values than keys then
       //the function will fail
   if(count($keys) < count($values)) {
               return false;
   } else {
       $count = count($keys);
       for($i=0; $i<$count; $i++)
           if(is_null($values))
               $array[$keys[$i]] = "";
           else
               $array[$keys[$i]] = $values[$i];
       }
  
   return $array;
}

function procesos_sortInt($a, $b)
{
    global $_name;
    $name = $_name;
    
    if ($a[$name] == $b[$name]) {
       return 0;
    }
    
    return ($a[$name] < $b[$name]) ? -1 : 1;
}

function procesos_sortStr($a, $b)
{
    global $_name;
    $name = $_name;
    
    return strcmp($a[$name], $b[$name]);
}


function procesos_list_processes($pid = 0){
    global $Respond;

    if ($pid == 0){
        $arg = 'xa';
    }else{
        $arg = ' p '.$pid;
    }
    $cmd = 'ps ww -o pid,ppid,pgid,user,ruser,group,rgroup,pcpu,vsz,nice,etime,time,tty,args '.$arg." | sed 's/ \+/ /g'";
    $data = `$cmd`;
    
    $lines = array();
    $lines = explode("\n", $data);
    $names = explode(' ',ltrim($lines[0]));
    $nc = count($names);
    $lc = count($lines);
    for ($i=1;$i<$lc -1;$i++){
        $tmp = explode(' ', ltrim($lines[$i]), $nc);
        $result[$i-1] = procesos_array_combine($names, $tmp);
    }

    return $result;
}

function procesos_recuperarprocesos(){
    global $Respond, $_name;
    $result = array();
    $field = array();
    $buffer = '';
    $field[0] = 'PID';
    $field[1] = 'Owner';

    if ($_GET['sort'] == 'VSZ'){
            $field[2] = 'MEM';
    }else{
            $field[2] = 'CPU';
    }
    $field[3] = 'Command';

    $results = procesos_list_processes($_GET['pid'] +1 - 1);
    //echo $Respond->getmicrotime().' ';
    $_name = $_GET['sort'];
    if (($_GET['sort'] == 'PID') or ($_GET['sort'] == 'PPID') or ($_GET['sort'] == 'PGID') or ($_GET['sort'] == 'VSZ') or ($_GET['sort'] == '%CPU')){
        usort($results, 'procesos_sortInt');
    }else{
        usort($results, 'procesos_sortStr');
    }

    if ($_GET['mode'] == 'asc'){

    }else if ($_GET['mode'] == 'desc'){
        $results = array_reverse($results);
    }
    return $results;
}

function procesos_generarinfo(){
$results=procesos_recuperarprocesos();
$output="<br>";
$output.="<table width=\"700\" align=\"center\" class=\"box\">";
$output.="  <tr class=\"boxheader\"> ";
$output.="    <td colspan=\"4\" align=\"center\" height=\"5\" class=\"boxheader\"><b>Lista de procesos</b></td>";
$output.="  </tr>";
$output.="  <tr class=\"boxheader\"> ";
$output.="    <td width=\"31\" align=\"center\" height=\"5\" class=\"boxheader\"> <b> ";
$output.=$field[0];
$output.="      </b></td>";
$output.="    <td width=\"31\" align=\"center\" height=\"5\" class=\"boxheader\"> <b> ";
$output.=$field[1];
$output.="      </b></td>";
$output.="    <td align=\"left\" width=\"5\" height=\"5\" class=\"boxheader\"> <b> ";
$output.=$field[2];
$output.="      </b></td>";
$output.="    <td align=\"left\" height=\"5\" width=\"350\" class=\"boxheader\"> <b> ";
$output.=$field[3];
$output.="      </b></td>";
$output.="  </tr>";

        $rc = count($results);
        $res = array();
        for ($i=0;$i<$rc ;$i++){
            if (!$_GET['gpid']){

                $res[0] = $results[$i]['PID'];
                $res[1] = $results[$i]['USER'];
                if ($_GET['sort'] == 'VSZ'){
                    $res[2] = $results[$i]['VSZ'] .'KB';
                }else{
                    $res[2] = $results[$i]['%CPU'];
                }

                $res[3] = $results[$i]['COMMAND'];

                if (strlen($res[3]) > 70){
                    $res[3] = substr($res[3],0,70) . ' ...';
                }
            }
        $buffer .='
        <tr class="boxbody">
          <td height="15" width="30"><div class="fuentecelda">'.$res[0].'</div></td>
          <td height="15" width="30"><div class="fuentecelda">'.$res[1].'</div></td>
          <td align="left"><div class="fuentecelda">'.$res[2].'</div></td>
          <td align="left" height="15""><div class="fuentecelda">'.$res[3].'</div></td>
        </tr>';
            if (strlen($buffer) > 2048){
                $output.=$buffer;
                $buffer = '';
            }
        }

$output.="</table>";

return $output;
}

?>
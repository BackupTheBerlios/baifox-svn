<?php 
		if ($_GET['resulid']!=""){
			include "include_resul.php";
		}
		switch($_GET['pag']){
			case "":
	  			include "include_home.php";
  			break;		
			default:
	  			include "webpanel/".$_GET['grupo']."/".$_GET['seccion']."/".$_GET['pag'].".php";
			break;
		}
?>

#!/usr/local/bin/php
<?php 
	//Generador del fichero de actualizacion
	//Solo para uso interno del proyecto
	define(SVN_URL,"");
	define(SVN_USER,"");
	define(SVN_PROJECT,"baifox");
	define(CFG_DIRECTORY,"/usr/local/src/");
	define(CFG_UPDATE,"update.cfg");
	$update_files=array("main_config.php");
	$ignore_files=array("bind_ignore.txt","clientes.xml","database.xml","dominios.xml","ftp.xml",".htpasswd","usuarios.xml","update_ignore.txt","access.log","server.log","baifox_log");

if($argv[1]=="update"){
	exec("cd ".CFG_DIRECTORY);
	if(file_exists(CFG_DIRECTORY.SVN_PROJECT))
        	exec("rm -R ".CFG_DIRECTORY.SVN_PROJECT);
        exec("svn checkout svn+ssh://".SVN_USER."@".SVN_URL." ".CFG_DIRECTORY.SVN_PROJECT);
}

if(file_exists(CFG_DIRECTORY.SVN_PROJECT)){
 	$files = load_directory(CFG_DIRECTORY.SVN_PROJECT,1); // call the function
	if(is_array($files)){
		if (!$handle = fopen(CFG_DIRECTORY.CFG_UPDATE, 'w')) {
         		echo "No se puede abrir el fichero (".CFG_DIRECTORY.CFG_UPDATE.")";
         		exit;
		}
 		foreach ($files as $lista) {
			$lista['ruta']=str_replace(CFG_DIRECTORY.SVN_PROJECT,"",$lista['ruta']);
			if (array_search($lista["nombre"],$update_files)!==false) {
				$cadena="[U][".$lista['dir']."][".$lista['size']."][".$lista["nombre"]."][".$lista['ruta']."]\n";
			}elseif (array_search($lista["nombre"],$ignore_files)!==false) {
				$cadena="[X][".$lista['dir']."][".$lista['size']."][".$lista["nombre"]."][".$lista['ruta']."]\n";
			}else{
				$cadena="[O][".$lista['dir']."][".$lista['size']."][".$lista["nombre"]."][".$lista['ruta']."]\n";
			}
			if (fwrite($handle, $cadena) === FALSE) {
       				echo "No se puede escribir en el fichero (".CFG_DIRECTORY.CFG_UPDATE.")";
       				exit;
   			}
 		}
   		fclose($handle);
	}
}

function load_directory ($startdir="./", $searchSubdirs=1, $directoriesonly=0, $maxlevel="all", $level=1) {
    //list the directory/file names that you want to ignore
    $ignoredDirectory[] = "."; 
    $ignoredDirectory[] = "..";
    $ignoredDirectory[] = ".svn";

    global $directorylist;    //initialize global array
    if (is_dir($startdir)) { 
        if ($dh = opendir($startdir)) { 
            while (($file = readdir($dh)) !== false) {
                if (!(array_search($file,$ignoredDirectory) > -1)) {
                  if (is_dir($startdir."/".$file)) {
                        //build your directory array however you choose; 
                        //add other file details that you want.
                        $directorylist[$startdir . $file]['level'] = $level;
                        $directorylist[$startdir . $file]['dir'] = "DIR";
		  	$directorylist[$startdir . $file]['size'] = filesize($startdir."/".$file);
                        $directorylist[$startdir . $file]['nombre'] = $file;
                        $directorylist[$startdir . $file]['ruta'] = $startdir;
                        if ($searchSubdirs) {
                            if ((($maxlevel) == "all") or ($maxlevel > $level)) {
                                load_directory($startdir."/".$file, $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);
                            }
                        }
                    } else {
                        if (!$directoriesonly) {
                            //if you want to include files; build your file array  
                            //however you choose; add other file details that you want.
                          $directorylist[$startdir . $file]['level'] = $level;
                          $directorylist[$startdir . $file]['dir'] = "FILE";
			  $directorylist[$startdir . $file]['size'] = filesize($startdir."/".$file);
                          $directorylist[$startdir . $file]['nombre'] = $file;
                          $directorylist[$startdir . $file]['ruta'] = $startdir;
      			}
		    }
	         }
             }
            closedir($dh);
 	}
    }
   return $directorylist;
}

?>
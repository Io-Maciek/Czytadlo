<?php
$path = 'BIN/';
if ($handle = opendir($path)) {

    while (($file = readdir($handle))) {
        $filelastmodified = filemtime($path . $file);
        if(((time()-$filelastmodified) > 259 200  ) && ($file != '..'&&$file !='.'))
        {
           unlink($path . $file);
        }

    }

    closedir($handle); 
}
?>



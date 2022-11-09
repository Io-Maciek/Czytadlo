<?php
if ( count($_FILES)>0 ) 
{
echo 'dziala';
	copy($_FILES["file"]["tmp_name"] , getcwd()."/doc/".$_FILES["file"]["name"]);

	echo $_GET["spam"];
	//header('Location: '. "/p.py/".$_POST["show"]);
}

?>
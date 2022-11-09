<?php
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	ini_set('error_reporting', E_ALL);
	//phpinfo();
?>

<!DOCTYPE html>
<html>
<head>

	<title>Czytadło</title>
    <link rel="icon" href="img/pageicon.png" type="image/png">

	<!-- BOOTSTRAP -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<!-- BOOTSTRAP -->

	<!-- STYLE -->
	<link href="indexStyle.css" rel="stylesheet">
	<!-- STYLE -->

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="projekt - system operacyjny">

</head>
<body>
<!-- 'Usuwanie' pliku i zmiana nazwy -->
<?php	//usuwanie
	if(isset($_GET['delete'])) 
	{
		//$newnamefile=$_GET['delete'];
		$newnamefile = urlencode($_GET['delete']);
		copy("doc/".$_GET['delete'],"BIN/".$newnamefile);
		unlink(getcwd()."/doc/".$_GET['delete']);
		header('Location: '. $_SERVER['SCRIPT_NAME']);
	}

?>

<!-- GŁÓWNE MENU -->

<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="/index.php">
    <img src="/img/pageicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
    Czytadło
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/index.php">Strona główna <span class="sr-only">(current)</span></a>
      </li>
	  <li class="nav-item">
	  <?php

		if(count(scandir(getcwd()."/BIN"))>2)
		{
		?>
		<a class="nav-link" href="kosz.cgi">
		<img width="25" src=".\img\binpng.png"/></img>Kosz<img width="25" src=".\img\binpng.png"/></img></a>
		<?php
		}
?>
    </li>
	  </ul>
    
      

	  <!-- Wyszukiwanie pliku DZIAŁA -->

		<?php
		if(!isset($_POST['search'])||strlen($_POST['search'])<1)
		{
		?>
		<form method="POST" class="form-inline my-2 my-lg-0">
			<input name="search" class="form-control mr-sm-2" type="search" placeholder="Wpisz nazwę pliku" aria-label="Search">
			<button class="btn btn-success my-2 my-sm-0" type="submit">Szukaj</button>
	    </form>
	  <?php
	  }
	  else
	  {
	  ?>
	  <a href="/"><button class="btn btn-outline-success my-2 my-sm-0">Anuluj wyszukiwanie</button></a>
	  <?php 
	  }
	  ?>
    
  </div>
</nav>

<!-- GŁÓWNE MENU -->


<!-- \/ MENU WGRYWANIA PLIKU \/ -->

<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
      <h5 class="text-white"><form action="" method="post" enctype="multipart/form-data">
	<div style="display: inline">
		
		<div style="display: inline">
				<input type="file" name="fileToUpload" id="fileToUpload"></input>
		</div>
		<div style="display: inline">
				<input class="btn btn-info" type="submit" value="Potwierdź" name="submit"></input>
		</div>
	</div>
	</form></h5>
      <span class="text-muted">Plik musi być w formacie PDF</span>
    </div>
  </div>
  <nav class="navbar navbar-dark bg-dark ">
  <form>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
	<?php
	if ( count($_FILES)>0 && $_FILES["fileToUpload"]["type"] == "application/pdf" ) 
	{
			copy($_FILES["fileToUpload"]["tmp_name"] , getcwd()."/doc/".$_FILES["fileToUpload"]["name"]);
			?>  <h4 style="display: inline"><span class="badge badge-primary">Wgraj plik</span></h4><?php
			}
	elseif (count($_FILES)>0 && $_FILES["fileToUpload"]["type"] != "application/pdf" ) 	
	{
		echo "<h5 style=\"display: inline\"><span class=\"badge badge-pill badge-danger\">Nieprawidlowy typ pliku</span></h5>";
		?></br>
		<?php
	}else
	{
		?>  <h4 style="display: inline"><span class="badge badge-primary">Wgraj plik</span></h4><?php
	}
	?>
	</form>
  </nav>
</div>

<!-- /\ MENU WGRYWANIA PLIKU  /\ -->


<?php
	//zmiana nazwy
	if(isset($_GET['newname'])&&strlen($_GET['newname'])>1) 
	{
		//if(strlen($_GET['newname'])<=44)
			rename(getcwd()."/doc/".$_GET["oldname"],getcwd()."/doc/".$_GET["newname"].".pdf");
			header('Location: '. $_SERVER['SCRIPT_NAME']);
	}
?>


<!-- Wyświetlanie plików -->
<br/>
<ul id="listFile">
	<?php
	$i=0;
	//zapisywanie wszystkich plkików do tabeli
		$files = scandir(getcwd()."/doc");
		sort($files);
		foreach($files as  $file ) 
		{
		
			if (  $file != "." &&  $file != ".." )//&&(isset($_POST['search'])&&strpos($file,$_POST['search'])==true))
			{
			
				//zmiana nazwy w wypadku gdyby miał błędnę znaki						
				rename("doc/".$file,"doc/".urldecode($file));
				$file=urldecode($file);
				$fileInfo = pathinfo("doc/".$file);
				$showFile = substr($file,0,-4);
				if(!isset($_POST['search'])||$_POST['search']=="" || strpos(strtolower($showFile), strtolower($_POST['search']))>-1) //strtolower dla ignorowania wielkości znaków
				{
				?>
				<!-- Wyświetlanie pliku -->
				
				<div class="container"> <?php 
				if($i!=0)
				{?>
				<hr style="height: 3px; background: black; border: 0px; opacity: 40%;">
				<?php
				}
				?>
				<li>
				  <div class="row">
					 <div class="col-sm-8">
				
					<a target="_blank" href="doc/<?php echo $file?>"><img width="29" src=".\img\pdf.png"/>
					<?php
					if($i % 2 ==0)
					{
						?>
						<h5 style="display: inline"><a id="cokolwiek" target="_blank" href="doc/<?php echo $file?>" class="badge badge-success"><?php echo $showFile ?></a></h5></a>
						<?php
					}
					else 
					{
						?>
						<h5 style="display: inline"><a id="cokolwiek" target="_blank" href="doc/<?php echo $file?>" class="badge badge-primary"><?php echo $showFile ?></a></h5></a>
						<?php
					}
					?>



					</div>
					<div class="col-sm-4">
					<form style="display: inline">

										<!-- Button trigger modal -->
					<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#moddel<?php echo $i?>">
					  Usuń
					</button>

					<!-- Modal -->
					<div class="modal fade" id="moddel<?php echo $i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Przenieść plik "<?php echo $showFile?>" do kosza?</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							<h6>Plik trafi do kosza, gdzie przez trzy dni będzie można go przywrócić. Po tym okresie plik zostanie usunięty</h6>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
							<a href="?delete=<?php echo $file ?>"><button type="button" class="btn btn-danger">Potwierdź</button></a>
						  </div>
						</div>
					  </div>
					</div>





					<!-- Guzik otwierający MODAL -->
					
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#mod<?php echo $i?>">
						Zmień nazwę
						</button>

						<!-- Zmiana nazwy MODAL -->
						 
							<div class="modal fade" id="mod<?php echo $i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">

										<h5 class="modal-title" id="exampleModalLabel">Zmiana nazwy "<?php echo $file ?>"</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>

								  </div>

								  <div class="modal-body">

										<input class="nameChange" name="oldname" type="hidden" value="<?php echo $file ?>" >
										<input placeholder="Wprowadź nową nazwę" class="nameChange" type="text" name="newname" /> .pdf
										<button class="nameChange" onclick="cancelChange(this); return false;" style="display: none">Anuluj</button>

								  </div>

								  <div class="modal-footer">

										<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
										<input class="btn btn-success" type="submit" value="Zapisz"/> 

								  </div>
								</div>
							  </div>
							</div>

							<!-- Zmiana nazwy MODAL -->

					</form>
				
				
				</div></div></li></div>
				<?php $i=$i+1;
				}


			}
		}
?>
</ul>	


<!-- Funkcja zmiany nazwy ( nie potrzebna bo robimy to modalem ) -->
<script>
/*
function zmienNazwe(x)
{
	var hideRest = document.getElementById('listFile').getElementsByClassName('nameChange');
	for (var i = 0; i < hideRest.length; i++ ) 
	{
		hideRest[i].style.display = "none";
	}
	var showRest = document.getElementById('listFile').getElementsByClassName('btn btn-info');
	for (var i = 0; i < showRest.length; i++ ) 
	{
		showRest[i].style.display = "inline";
	}

	//alert(x.parentElement.getElementsByClassName('nameChange'))
	var change = x.parentElement.getElementsByClassName('nameChange');
	for (var i = 0; i < change.length; i++ ) 
	{
		change[i].style.display = "inline";
	}
	var changer = x.parentElement.getElementsByClassName('btn btn-info');
	changer[0].style.display = "none";
}
function cancelChange(x)
{
	var hideRest = document.getElementById('listFile').getElementsByClassName('nameChange');
	for (var i = 0; i < hideRest.length; i++ ) 
	{
		hideRest[i].style.display = "none";
	}
	var showRest = document.getElementById('listFile').getElementsByClassName('btn btn-info');
	for (var i = 0; i < showRest.length; i++ ) 
	{
		showRest[i].style.display = "inline";
	}
}
*/
</script>


</body>
</html>

<!-- zrobić skrypt w BASHU który usuwa pliki z folderu co X dni -->
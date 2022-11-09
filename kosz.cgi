#!/usr/bin/perl -w
use CGI qw(-utf8);
binmode(STDOUT, ":utf8");  
binmode(STDIN, ":encoding(utf8)");
use warnings;
use locale;
use Date::Parse;
use POSIX qw(strftime);
sub urldecode {
    use URI::Escape qw( uri_unescape );
    use utf8;
    my $x = my $y = uri_unescape($_[0]);
    return $x if utf8::decode($x);
    return $y;
}

print "Content-type:text/html;charset=UTF-8\n\n";
print '<!Doctype html>';
print '<html lang=\'pl-PL\'>';
print '<head>';

print '<title>Kosz</title>';
print '<link rel="icon" href="img/pageicon.png" type="image/png">';
print '<meta http-equiv=\'content-type\' content=\'text/html\'; charset=\'utf-8\' />';
print '<meta name=\'viewport\' content=\'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\'>';
print '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
';

print '<link href=\'koszStyle.css\' rel=\'stylesheet\'>';

print '</head>';
print '<body>';
			#wa¿ne parametry
my $qq = CGI->new;
my $ww = CGI->new;

print '<script src="usuwanie.php"> 
load.function usuwanie();
</script>';
		#zapisywanie plików do tabeli

my @files;
open (my $ls_fh, "/bin/ls /var/www/html/BIN|") || die "Wyst¹pi³ b³¹d: Nie mo¿na uruchomiæ komendy \'ls\' '/bin/ls': $!\n";
while (defined (my $line = <$ls_fh>)) {
	next if $line =~ /patern_ignorowany_brak/;
	chomp $line;
	push @files, $line;
}
$ilosc=scalar @files;

		#przenoszenie na strone kosza gdy nie jest pusty

if($ilosc>0)
{
		#menu strony

print '<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="/index.php">
    <img src="/img/pageicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
    Czytad&#322o
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
         <a class="nav-link" href="http://192.168.254.237/kosz.cgi">Kosz <span class="sr-only">(current)</span></a>
      </li>
	  <li class="nav-item">
	  <a class="nav-link" href="/index.php">Strona g&#322ówna</a>
    </li>
	  </ul>
  </div>
</nav>';

my $name;
print '<br/>';

		#przywracanie pliku po klikniêciu

if(defined ($qq->param('backup')))
{
	$x=$qq->param('backup');
	system("skrypty/backup '$x'");

	if($ilosc>1)
	{
	print '<script>window.location.replace("/kosz.cgi");</script>';
	}
	else
	{
	print '<script>window.location.replace("/index.php");</script>';
	}
}
#usuwanie pliku po klikniêciu
if(defined ($ww->param('delete'))) 
{
	$x=$ww->param('delete');
	system("skrypty/delete '$x'");
	if($ilosc>1)
	{
	print '<script>window.location.replace("/kosz.cgi");</script>';
	}
	else
	{
	print '<script>window.location.replace("/index.php");</script>';
	}
}

#my $date = strftime "%m/%d/%Y", localtime;
#print str2time ($date) . "\n";
#print $date;

	#pokazywanie plików w liœcie

print "<ul>";
for ($i=0;$i<(scalar @files);$i++)
{
	#@files[$i]=urldecode(@files[$i]);
	$name=urldecode($files[$i]);
	#$name=@files[$i];

	print "<li><img width=\'43\' src=\'../img/binpng.png\'/><a class=\'badge badge-warning\'/";
	print "<h5 style=\'display: inline\'>";
	print $name;
	print "</h5></a>
			<form style=\'display: inline\' action=\'\' method=\'GET\'>
				 <input class=\"btn btn-primary\" type=\'submit\' Value=\'Przywró&#263;\'>
				 <input type=\'hidden\' Value=\'$files[$i]\' name=\'backup\'>

				 <!-- Modalne okno potwierdzenai usuniêcia -->
<button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#moddel$i\">
Usu&#324;
</button>

<!-- Modal -->
<div class=\"modal fade\" id=\"moddel$i\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Potwierd&#378; usuni&#281;cie pliku</h5>
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
      </div>
      <div class=\"modal-body\">
        Czy na pewno chcesz usun&#261;&#263; plik \"$name\" z kosza? Tej operacji nie da si&#281; cofn&#261;&#263;.
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Anuluj</button>
        </form>
			<form style=\'display: inline\' action=\'\' method=\'GET\'>

				 <input class=\"btn btn-danger\" type=\'submit\' Value=\'Potwierd&#378; usuni&#281;cie\'>
				 <input type=\'hidden\' Value=\'@files[$i]\' name=\'delete\'></a>

		  </form>
      </div>
    </div>
  </div>
</div>


			

	</li><br/>";
}




print '<script>
function test()
{

</script>';


}	# strona pustego kosza
else{

#menu strony
print '<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="/index.php">
    <img src="/img/pageicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
    Czytad&#322o
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
         <a class="nav-link" href="http://192.168.254.237/kosz.cgi">Kosz <span class="sr-only">(current)</span></a>
      </li>
	  <li class="nav-item">
	  <a class="nav-link" href="/index.php">Strona g&#322ówna</a>
    </li>
	  </ul>
  </div>
</nav>';

	print "<h2><span class='badge badge-secondary'>Kosz jest pusty.<img width='43' src='../img/binpng.png'/></span></h2>";




}




print '</body>';
print '</html>';
1;	#koñczenie skryptu i zwracanie wartoœci

#	print '';
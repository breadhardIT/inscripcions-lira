<?PHP
      
// càrrega del model i els control·ladors
require_once '../config.php';
require_once '../model.php';
require_once '../settings.php';
require_once 'class-inscripcio.php';
require_once 'class-participant.php';
require_once 'class-resultat.php';
require_once 'functions.php';


// cercar les dades de l'inscripció per aquest esdeveniment i dorsal
$inscripcio = New Inscripcio('');
$inscripcio->getInscripcioPerDorsal($_GET['esdeveniment'],$_GET['dorsal']);   

// cercar les dades del participant
$participant = New Participant('id', $inscripcio->idPersona);

// inserir el resultat
$resultat = New Resultat('inscripcio', $inscripcio->id);

$resultat->idInscripcio = $inscripcio->id;
$resultat->temps = $_GET['temps'];
$resultat->posicio = $_GET['posicio'];
$resultat->datasortida = date2UKformat($_GET['datasortida']);
$resultat->horasortida = $_GET['horasortida'];

if ($resultat->id <> '')  $resultat->update();
else $resultat->insert();

if ($inscripcio->id == '') echo "";
else echo $participant->nom. " " .$participant->cognoms. "&&&" .$participant->poblacio;

?>

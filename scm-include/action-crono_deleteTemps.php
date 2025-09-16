<?PHP
      
    // càrrega del model i els control·ladors
    require_once '../config.php';
    require_once '../model.php';
    require_once '../settings.php';
    require_once 'class-inscripcio.php';
    require_once 'class-esdeveniment.php';
    require_once 'class-resultat.php';
    require_once 'functions.php';

    // cercar les dades de l'esdeveniment
    $esdeveniment = New Esdeveniment($_GET['esdeveniment']);

    // cercar les dades de l'inscripció per aquest esdeveniment i dorsal
    $inscripcio = New Inscripcio('');
    $inscripcio->getInscripcioPerDorsal($_GET['esdeveniment'],$_GET['dorsal']);   

    // inserir el resultat
    $resultat = New Resultat('inscripcio', $inscripcio->id);

    if ($resultat->id <> '') { 
        $resultat->control = $_GET['control'];
        if ($resultat->delete()) echo "Registre eliminat";
        else  echo "Registre NO eliminat";
    }
?>

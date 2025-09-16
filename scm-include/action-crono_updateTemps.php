<?PHP
      
    // càrrega del model i els control·ladors
    require_once '../config.php';
    require_once '../settings.php';
    require_once 'functions.php';

    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'model/db.php';
    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-inscripcio.php';
    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-participant.php';
    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-resultat.php';    


    // cercar les dades de l'inscripció per aquest esdeveniment i dorsal
    // obtenir les dades de l'inscripció (id) i la persona (nom, cognoms, població i sexe)
    $query = "SELECT nom,cognoms,poblacio,sexe, tinscripcio_id FROM gmlira_participants, gmlira_inscripcions ";
    $query .= "WHERE id = tinscripcio_idPersona AND tinscripcio_idFormulari =".$_GET['esdeveniment']." AND tinscripcio_dorsal ='".$_GET['dorsal']."'";
    $consulta = DB::query($query)->getFirst(); 
    
    // inserir el resultat
    $resultat = New Resultat('inscripcio', $consulta->tinscripcio_id);

    $resultat->idInscripcio = $consulta->tinscripcio_id;
    $resultat->temps = $_GET['temps'];
    $resultat->control = $_GET['control'];    
    $resultat->datasortida = date2UKformat($_GET['datasortida'], '-');
    $resultat->horasortida = $_GET['horasortida'];

    if ($resultat->id <> '')  $resultat->update();
    else $resultat->insert();

    if ($consulta->tinscripcio_id == '') echo "Dorsal no trobat&&&-&&&-";
    else echo $consulta->nom. " " .$consulta->cognoms. "&&&" .$consulta->poblacio. "&&&" .$consulta->sexe;
?>

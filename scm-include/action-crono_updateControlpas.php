<?PHP
    global $CONFIG;   

    // càrrega del model i els control·ladors
    require_once '../config.php';
    require_once '../model.php';
    require_once '../settings.php';
    require_once 'class-inscripcio.php';
    require_once 'class-participant.php';
    require_once 'class-esdeveniment.php';
    require_once 'class-resultat.php';
    require_once 'functions.php';

    // cercar les dades de l'esdeveniment
    $esdeveniment = New Esdeveniment($_POST['esdeveniment']);
    if ($esdeveniment->estaIniciada()) {

        // cercar les dades de l'inscripció per aquest esdeveniment i dorsal
        $inscripcio = New Inscripcio('');
        $inscripcio->getInscripcioPerDorsal($_POST['esdeveniment'],$_POST['dorsal']);   
    
        // inserir el resultat
        $resultat = New Resultat('', $inscripcio->id);

        $resultat->idInscripcio = $inscripcio->id;
        $resultat->numcontrol = $_POST['numcontrol']; 
        $resultat->baixa = $_POST['baixa'];         
        $resultat->datasortida = $esdeveniment->datasortida;
        $resultat->horasortida = $esdeveniment->horasortida;        
        $resultat->insert();
    }
    
    $url = AddURLParams($CONFIG['environment'].'index.php',"ctl=gestioEsdevenimentsControlPas&esdeveniment=" .$_POST['esdeveniment']. "&control=" .$_POST['numcontrol'], false);							
    Redirect($url);
?>
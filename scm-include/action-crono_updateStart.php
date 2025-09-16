<?PHP
      
    // càrrega del model i els control·ladors
    require_once '../config.php';
    require_once '../settings.php';
    require_once 'functions.php';
    
    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'model/db.php';
    
    
    // cercar les dades de l'esdeveniment
    $idEsdeveniment = $_GET['esdeveniment'];
    $query = "SELECT tesdeveniments_datasortida,tesdeveniments_horasortida FROM gmlira_esdeveniments WHERE tesdeveniments_id = '" . $idEsdeveniment . "'";
    $consulta = DB::query($query)->getFirst();
    
    if (!isset($consulta->tesdeveniments_datasortida) || ($consulta->tesdeveniments_datasortida = "") || ($consulta->tesdeveniments_horasortida="") || !isset($consulta->tesdeveniments_horasortida)) {
        $query="UPDATE gmlira_esdeveniments SET tesdeveniments_datasortida='" .date2UKformat ($_GET['datasortida'],'-'). "', tesdeveniments_horasortida='" .$_GET['horasortida']. "' WHERE tesdeveniments_id = '" . $idEsdeveniment . "'";            
        $consulta = DB::query($query)->execute();
        echo "Data / Hora d'inici guardada en BBDD <br>";
    }
    else echo "Data / Hora d'inici NO guardada <br>";
?>

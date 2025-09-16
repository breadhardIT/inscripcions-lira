<?php

/* 
 * Marcar l'inscripció com a pagada, assignar dorsal i enviar mail al participant.
 * Sergi C. - 29/07/2014
 * 
 */

// càrrega del model i els control·ladors
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-esdeveniment.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-inscripcio.php';

$idInscripcio = $_REQUEST['id'];	
		
if (isset($idInscripcio)){
    $inscripcio = New Inscripcio($idInscripcio);          

    //Marcar com a pagat
    $consulta = $inscripcio->eliminar();       
    print("<script>alert('Modificacio realitzada');</script>");	
}

?>

<script type="text/javascript">
    window.location="<?PHP echo SCM_FORM_ROOT. 'index.php?ctl=g_inscripcioLlistat&esdeveniment='.$inscripcio->idEsdeveniment;?>"
</script>
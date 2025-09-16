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
    $esdeveniment = New Esdeveniment($inscripcio->idEsdeveniment);
       
    try {	
	
        //Marcar com a pagat
        $consulta = $inscripcio->updatePagat('S');
        //if (!$consulta) throw new Exception('Error a la transacció');
			
	// assignar dorsal: obtenir darrer dorsal, assignar a l'inscripció i sumar 1 al darrer dorsal assignat
        $consulta = $esdeveniment->obtenirNouDorsal();
        //if (!$consulta) throw new Exception('Error a la transacció');
        
        $consulta = $inscripcio->assignarDorsal($esdeveniment->dorsal);
        //if (!$consulta) throw new Exception('Error a la transacció');
       
        print("<script>alert('Modificacio realitzada');</script>");		
                        
	// enviar mail de confirmació al destinatari
	//@include ("../lib/enviarMail.php");		
    }
    catch (Exception $e) {
        //$model->rollbackTX();
        print("<script>alert('No es possible realitzar la modificacio');</script>");							
    }
}

?>

<script type="text/javascript">
    window.location="<?PHP echo SCM_FORM_ROOT.'index.php?ctl=g_inscripcioLlistat&esdeveniment='.$esdeveniment->id;?>"
</script>
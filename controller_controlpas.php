<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once APP_PATH_ABS.APP_PATH_INCLUDE.SCM_CRONO.'model/db.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.SCM_CRONO.'model/querys.php';
require_once __DIR__ .'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-esdeveniments.php';
require_once __DIR__ .'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-controldepas.php';
require_once __DIR__ .'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-inscripcions.php';
require_once __DIR__ .'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-participants.php';


class Controller_controlpas
{
   
    // *
    // PÀGINA PRINCIPAL DMIN
    public function controlPasAdmin(){       

        $esdeveniment = new Esdeveniments('');
        $esdeveniment = $esdeveniment->getEsdevenimentActiu();
            
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encara que l'esdeveniment estigui obert o tancat
            include APP_PATH_ABS.APP_PATH_CONTENT.SCM_CRONO.'controlPasAdmin.php';
        }
        else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
    }
	
    // *
    // PÀGINA PRINCIPAL
    public function controlPasHome(){       

        $esdeveniment = new Esdeveniments('');
        $esdeveniment = $esdeveniment->getEsdevenimentActiu();
            
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encara que l'esdeveniment estigui obert o tancat
            include APP_PATH_ABS.APP_PATH_CONTENT.SCM_CRONO.'controlPasHome.php';
        }
        else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
    }

    // *
    // APP PER MARCAR L'ESTAT D'UN DORSAL QUE PASSA PER UN CONTROL
    public function controlPasRegistrar($admin){       

        $idControl= $_REQUEST['c'];        
        $esdeveniment = new Esdeveniments(''); 
        $esdeveniment = $esdeveniment->getEsdevenimentActiu();
            
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encara que l'esdeveniment estigui obert o tancat
            $control_pas = New ControldePas($idControl, $esdeveniment->getId());
            if ($control_pas->existeix() ) {        
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_CRONO.'controlPas'.$admin.'Registrar.php';
            }
            else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
        }
        else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
    }

    // APP PER MARCAR L'ESTAT D'UN DORSAL QUE PASSA PER UN CONTROL
    public function controlPasDorsalBuscar($admin){       
            
        $esdeveniment = new Esdeveniments(''); 
        $esdeveniment = $esdeveniment->getEsdevenimentActiu();
            
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encara que l'esdeveniment estigui obert o tancat
            include APP_PATH_ABS.APP_PATH_CONTENT.SCM_CRONO.'controlPas'.$admin.'DorsalBuscar.php';
        }
        else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
    }
    
    // *
    // LLISTAT DE CONTROLS PELS QUE HA PASSAT UN DORSAL
    public function controlPasDorsalEstat($admin){       

        $esdeveniment = new Esdeveniments(''); 
        $esdeveniment = $esdeveniment->getEsdevenimentActiu();      
        
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encara que l'esdeveniment estigui obert o tancat

            $dorsal= $_POST['dorsal'];
            $inscripcio = New Inscripcions('','');
            $inscripcio->getIDInscripcioPerDorsal($esdeveniment->getId(),$dorsal);
            $participant = New Participants('id',$inscripcio->getIdParticipant());
            
            include APP_PATH_ABS.APP_PATH_CONTENT.SCM_CRONO.'controlPas'.$admin.'DorsalEstat.php';
        }
        else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
    }
    
    // *
    // LLISTAT DE DORSALS QUE HAN PASSAT PER UN CONTROL
    public function controlPasResum($admin){       

        $idControl= $_REQUEST['c'];        
        $esdeveniment = new Esdeveniments(''); 
        $esdeveniment = $esdeveniment->getEsdevenimentActiu();      
        
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encara que l'esdeveniment estigui obert o tancat 
            $control_pas = New ControldePas($idControl, $esdeveniment->getId());
            if ($control_pas->existeix() ) {                    
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_CRONO.'controlPas'.$admin.'Resum.php';                
            }
            else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error                    
        }
        else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
    }    
    
    // *
    // ACCIÓ QUE SERVEIX PER ACTUALITZAR LA SITUACIÓ D'UN DORSAL AL PAS PER UN CONTROL
    public function controlPasUpdate() {
        // serveix per processar contra bbdd les dades enviades des d'un formulari
        require __DIR__ .'/'.APP_PATH_INCLUDE.SCM_CRONO.'action/action-gestiocrono_updateControlpas.php'; 
    }
	
    // *
    // ACCIÓ QUE SERVEIX PER RESETEJAR TOTS ELS RESULTATS D'UNA PROVA
    public function controlPasResetResult() {
        // serveix per processar contra bbdd les dades enviades des d'un formulari
        require __DIR__ .'/'.APP_PATH_INCLUDE.SCM_CRONO.'action/action-gestiocrono_resetResultControlpas.php'; 
    }	
    
    // *
    // LLISTAT DE SEGUIMENT DELS CONTROLS DE PAS I ELS DORSALS QUE HI HAN PASSAT O S'HAN RETIRAT
    public function controlPasLlistat(){       

        $esdeveniment = new Esdeveniments(''); 
        $esdeveniment = $esdeveniment->getEsdevenimentActiu();
            
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encara que l'esdeveniment estigui obert o tancat
            include APP_PATH_ABS.APP_PATH_CONTENT.SCM_CRONO.'controlPasLlistat.php';
        }
        else {require APP_PATH_ABS.'/'.APP_PATH_CONTENT.'error404.php';} // no existeix l'esdeveniment - mostrem pàgina d'error        
    }
}
    

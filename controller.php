<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once APP_PATH_ABS.APP_PATH_INCLUDE.'model/db.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-esdeveniment.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-feec.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-inscripcio.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';


class Controller
{

    public function inscripcioInici($gestio)
    {
        // TO DO carregar origen
        
        $id= $_REQUEST['esdeveniment'];
        
        $esdeveniment = new Esdeveniment($id);
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix i està obert o tancat
            if ($gestio == SCM_METODE_GESTIO) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require APP_PATH_ABS. 'login.php';	
                    exit();
                }        
                else { include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.SCM_PATH_GESTIO.'inscripcioInici.php';}
            }    
            else {
                if ( $esdeveniment->estaObert() ) {                
                    include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioInici.php';                
                }
                 else {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioTancada.php';} // l'esdeveniment està tancat
            }
        }
        else {
            {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }
	
    public function inscripcioForm($gestio)
    {
        $origen= $_REQUEST['origen'];        
        $dni_feec= $_REQUEST['dni'];
        $llicencia_feec= $_REQUEST['llicenciaFEEC'];	
        $id= $_REQUEST['esdeveniment'];	
        
        $esdeveniment = new Esdeveniment($id);        
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix i està obert o tancat
            if ($gestio == SCM_METODE_GESTIO) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require SCM_ABSPATH. 'login.php';	
                    exit();
                }        
                else { include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.SCM_PATH_GESTIO.'inscripcioFormulari.php';}
            }    
            else {            
                if ( $esdeveniment->estaObert() ) { 
                    $feec = New Feec($llicencia_feec, $dni_feec);                

                    if ( (!$feec->estaFederat()) && ($esdeveniment->esPeriodePrevi()) ) // validar si hi ha setmana d'inscripcions reservada per federats
                        {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioTancada.php';}
                    else { include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioFormulari.php';}
                }
                else {require SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioTancada.php';}
            }
        }
        else {
            {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }
    
     public function inscripcioConfirm()
     {        
        $clau = $_REQUEST['clau'];        
        $id= $_REQUEST['id'];
        
        $esdeveniment = new Esdeveniment($id);        
        if ( $esdeveniment->existeix() ){
            if ( $esdeveniment->estaObert() ) {  // control de si l'esdeveniment existeix i està obert o tancat
                $inscripcio = new Inscripcio('');
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioConfirmacio.php';               
            }
            else {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioTancada.php';}
        }
        else {
            {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }    

     public function inscripcioLlistat($gestio)
     {
        $id= $_REQUEST['esdeveniment'];
        $esdeveniment = new Esdeveniment($id);

        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encar que l'esdeveniment estigui obert o tancat
            if ($gestio == SCM_METODE_GESTIO) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require SCM_ABSPATH. 'login.php';	
                    exit();
                }        
                $pathGestio = SCM_GESTIOPATH;
            }    
            else {
                $pathGestio = '';
            }            
            include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.$pathGestio.'inscripcioLlistat.php';
        }
        else {            
            {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }
 
    public function esdevenimentsExport($gestio) {

        $id= $_REQUEST['esdeveniment'];
        $esdeveniment = new Esdeveniment($id);

        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encar que l'esdeveniment estigui obert o tancat
            $title = New Title($esdeveniment->nom, 'Inscripcions', 'index.php?ctl=esdevenimentsLlistat'); 
            if ($gestio == SCM_METODE_GESTIO) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require SCM_ABSPATH. 'login.php';	
                    exit();
                }        
                $pathGestio = SCM_GESTIOPATH;
            }    
            else {
                $pathGestio = '';
            }            
            include SCM_ABSPATH.SCM_PATH. 'inscripcions/'.$pathGestio.'esdevenimentsExport.php';
        }
        else {            
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/error.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }
    
    public function esdevenimentsResultatExport($gestio){

        $id= $_REQUEST['esdeveniment'];
        $esdeveniment = new Esdeveniment($id);

        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encar que l'esdeveniment estigui obert o tancat
            $title = New Title($esdeveniment->nom, 'Inscripcions', 'index.php?ctl=esdevenimentsLlistat'); 
            if ($gestio == SCM_METODE_GESTIO) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require SCM_ABSPATH. 'login.php';	
                    exit();
                }        
                $pathGestio = SCM_GESTIOPATH;
            }    
            else {
                $pathGestio = '';
            }            
            include SCM_ABSPATH.SCM_PATH. 'inscripcions/'.$pathGestio.'esdevenimentsResultatExport.php';
        }
        else {            
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/error.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }            
    
     public function inscripcioResultat()
     {
        $id= $_REQUEST['esdeveniment'];
        $esdeveniment = new Esdeveniment($id);

        if ( $esdeveniment->existeix() ){  // control de si l'esdeveniment existeix, el llistat es mostra sempre encar que l'esdeveniment estigui obert o tancat
            $title = New Title($esdeveniment->nom, 'Inscripcions', 'index.php?ctl=esdevenimentsLlistat'); 
            include SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioResultat.php';
        }
        else {
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/error.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }
    
    
    // * operacions de gestió d'inscripcions * //
    public function esdevenimentsLlistat($gestio) {
        
        if ($gestio == SCM_METODE_GESTIO) {
            $Login = new Login(); // validar login
            if (!$Login->hihaLogin())  {
                require SCM_ABSPATH. 'login.php';	
                exit();
            }        
            $pathGestio = SCM_GESTIOPATH;
            $paramEsdeveniment = '';
        }    
        else {
            $pathGestio = '';
            $paramEsdeveniment = 'S';            
        }
        
        $title = New Title('', 'Inscripcions', '');  
        $dbprocedure = New DBProcedure();
        $dbprocedure = $dbprocedure->bdGetEsdevenimentLlista($paramEsdeveniment);
        $consulta = $dbprocedure->getResultat();
        require SCM_ABSPATH.SCM_PATH. 'inscripcions/'.$pathGestio.'esdevenimentsLlistat.php';
    }        
        
    public function esdevenimentsCrono() {
        
        // control de si l'esdeveniment està obert o tancat
        $idEsdeveniment= $_REQUEST['esdeveniment'];      
		
        $esdeveniment = new Esdeveniment($idEsdeveniment);
        if ( $esdeveniment->existeix() ){
            $title = New Title($esdeveniment->nom, 'Inscripcions', 'index.php?ctl=gestioEsdevenimentsLlistat'); 

            // validar login
            $Login = new Login();
            if (!$Login->hihaLogin())  {
                require SCM_ABSPATH. 'login.php';
                exit();
            }
            else {
                include SCM_ABSPATH.SCM_PATH. 'inscripcions/'.SCM_GESTIOPATH.'esdevenimentsCrono.php';
            }                                                                      
        }
        else {
            // no existeix l'esdeveniment - mostrem pàgina d'error
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioError.php';}
        }        
    }
    public function esdevenimentsControlPas() {
        
        // control de si l'esdeveniment està obert o tancat
        $idEsdeveniment= $_REQUEST['esdeveniment'];      
		
        $esdeveniment = new Esdeveniment($idEsdeveniment);
        if ( $esdeveniment->existeix() ){
            $title = New Title($esdeveniment->nom, 'Inscripcions', 'index.php?ctl=gestioEsdevenimentsLlistat'); 

            // validar login
            $Login = new Login();
            if (!$Login->hihaLogin())  {
                require SCM_ABSPATH. 'login.php';
                exit();
            }
            else {
                include SCM_ABSPATH.SCM_PATH. 'inscripcions/'.SCM_GESTIOPATH.'esdevenimentsControlPas.php';
            }                                                                      
        }
        else {
            // no existeix l'esdeveniment - mostrem pàgina d'error
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioError.php';}
        }        
    }
    
    public function esdevenimentsControlPasLlistat() {
        
        // control de si l'esdeveniment està obert o tancat
        $idEsdeveniment= $_REQUEST['esdeveniment'];      
		
        $esdeveniment = new Esdeveniment($idEsdeveniment);
        if ( $esdeveniment->existeix() ){
            $title = New Title($esdeveniment->nom, 'Inscripcions', 'index.php?ctl=gestioEsdevenimentsLlistat'); 

            // validar login
            $Login = new Login();
            if (!$Login->hihaLogin())  {
                require SCM_ABSPATH. 'login.php';
                exit();
            }
            else {
                include SCM_ABSPATH.SCM_PATH. 'inscripcions/'.SCM_GESTIOPATH.'esdevenimentsControlPasLlistat.php';
            }                                                                      
        }
        else {
            // no existeix l'esdeveniment - mostrem pàgina d'error
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioError.php';}
        }        
    }
    
    public function participantDiploma() {
        
        // control de si l'esdeveniment està obert o tancat
        $idEsdeveniment= $_REQUEST['esdeveniment'];      
		
        $esdeveniment = new Esdeveniment($idEsdeveniment);
        if ( $esdeveniment->existeix() ){
            $title = New Title($esdeveniment->nom, 'Inscripcions', 'index.php?ctl=gestioEsdevenimentsLlistat'); 

            // validar login
            $Login = new Login();
            if (!$Login->hihaLogin())  {
                require SCM_ABSPATH. 'login.php';
                exit();
            }
            else {
                include SCM_ABSPATH.SCM_PATH. 'inscripcions/'.SCM_GESTIOPATH.'participantDiploma.php';
            }                                                                      
        }
        else {
            // no existeix l'esdeveniment - mostrem pàgina d'error
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioError.php';}
        }        
    }    
    
    public function gestirunnersLlistat($entitat)
    {
        // validar login
        $Login = new Login();
        if (!$Login->hihaLogin())  {
            require SCM_ABSPATH. 'login.php';
            exit();
        }
        else {        
            $title = New Title('Llistat de '.$entitat, 'Gestirunners', '');
            include SCM_ABSPATH.SCM_PATH. 'gestirunners/'.$entitat.'Llistat.php';
        }
    }    
    
    public function gestirunnersFitxa()
    {
        // validar login
        $Login = new Login();
        if (!$Login->hihaLogin())  {
            require SCM_ABSPATH. 'login.php';
            exit();
        }
        else {        
            $idPersona = $_REQUEST['idPersona'];
            $dades = $_REQUEST['dades'];
            if (($dades == '') || (!isset($dades)) ) $dades= 'p';            
            
            $title = New Title('Fitxa personal', 'Gestirunners', '');
            $persona = New Persona($idPersona);
            include SCM_ABSPATH.SCM_PATH. 'gestirunners/personesFitxa.php';
        }
    }
    
    
    // * operacions associades a la presentació de rutes * //
    public function rutesLlistat()
    {
        $title = New Title('', 'Rutes', '');        
        require SCM_ABSPATH.SCM_PATH. 'rutes/rutesLlistat.php';
    }    
    
    
    public function rutesDetall()
    {
        // control de si la ruta existeix
        $idRuta= $_REQUEST['id'];
        $ruta = new Ruta($idRuta);
        
        if ( $ruta->existeix($ruta) ){
            $title = New Title($ruta->descripciobreu, 'Rutes', '/index.php?ctl=rutesLlistat');
            include SCM_ABSPATH.SCM_PATH. 'rutes/rutesDetall.php';
        }
        else {
            // no existeix la ruta - mostrem pàgina d'error
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/error.php';}
        }
    }   
 }
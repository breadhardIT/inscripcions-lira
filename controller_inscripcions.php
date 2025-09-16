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
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-participant.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-login.php';

class Controller_inscripcions
{

    public function login() {
        // serveix per processar contra bbdd les dades enviades des d'un formulari
        require __DIR__ .'/'.'/login.php'; 
    }
    
    public function inscripcioInici($gestio)
    {
        // TO DO carregar origen
        
        $id= $_REQUEST['esdeveniment'];
        
        $esdeveniment = new Esdeveniment($id);
        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix i està obert o tancat
            if ($gestio) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                $url = AddURLParams("index.php","ctl=login", false);							
		Redirect($url);
                    //require APP_PATH_ABS. 'login.php';	
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
            if ($gestio) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require APP_PATH_ABS. 'login.php';	
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
            if ($gestio) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    $url = AddURLParams("index.php","ctl=login", false);							
                    Redirect($url);
                    exit();
                }
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.SCM_PATH_GESTIO.'inscripcioLlistat.php';
            }    
            else {
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioLlistat.php';
            }
        }
        else {            
            {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }
    
    public function inscripcioExport($gestio) {

        $id= $_REQUEST['esdeveniment'];
        $esdeveniment = new Esdeveniment($id);

        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encar que l'esdeveniment estigui obert o tancat
            if ($gestio) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require SCM_ABSPATH. 'login.php';	
                    exit();
                }        
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.SCM_PATH_GESTIO.'inscripcioExport.php';
            }    
        }
        else {            
            {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }    
	
public function inscripcioExportTempFEEC($gestio) {

        $id= $_REQUEST['esdeveniment'];
        $esdeveniment = new Esdeveniment($id);

        if ( $esdeveniment->existeix() ){ // control de si l'esdeveniment existeix, el llistat es mostra sempre encar que l'esdeveniment estigui obert o tancat
            if ($gestio) {
                $Login = new Login(); // validar login
                if (!$Login->hihaLogin())  {
                    require SCM_ABSPATH. 'login.php';	
                    exit();
                }        
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.SCM_PATH_GESTIO.'inscripcioExportTemporalsFEEC.php';
            }    
        }
        else {            
            {require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // no existeix l'esdeveniment - mostrem pàgina d'error
        }         
    }	

     //public function inscripcioError($gestio) {        
       // $id= $_REQUEST['id'];       
        //require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.'inscripcioError.php';} // mostrem pàgina d'error
    //}
        
    public function esdevenimentsLlistat($gestio) {
        
        if ($gestio) {
            $Login = new Login(); // validar login
            if (!$Login->hihaLogin())  {
                require APP_PATH_ABS. 'login.php';	
                exit();
            }        
            $pathGestio = SCM_PATH_GESTIO;
        }    
        else {
            $pathGestio = '';
        }
        
        $query = "SELECT tesdeveniments_id, tesdeveniments_estat, tesdeveniments_nom, tesdeveniments_texte, tesdeveniments_logo, tesdeveniments_url, tesdeveniments_publicat ";
        $query .= "FROM gmlira_esdeveniments ";
        if (!$gestio) $query .= "WHERE tesdeveniments_publicat='S'";
        $consulta = DB::query($query)->get();        
        
        require APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.$pathGestio.'esdevenimentsLlistat.php';
    }
    
    public function esdevenimentsCrono() {
        
        // control de si l'esdeveniment està obert o tancat
        $idEsdeveniment= $_REQUEST['esdeveniment'];      
		
        $esdeveniment = new Esdeveniment($idEsdeveniment);
        if ( $esdeveniment->existeix() ){
            
            // validar login
            $Login = new Login();
            if (!$Login->hihaLogin())  {
                require APP_PATH_ABS. 'login.php';
                exit();
            }
            else {
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.SCM_PATH_GESTIO.'esdevenimentsCrono.php';
            }                                                                      
        }
        else {
            // no existeix l'esdeveniment - mostrem pàgina d'error
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioError.php';}
        }        
    }
    public function esdevenimentDiploma() {
        
        // control de si l'esdeveniment està obert o tancat
        $idEsdeveniment= $_REQUEST['esdeveniment'];      
		
        $esdeveniment = new Esdeveniment($idEsdeveniment);
        if ( $esdeveniment->existeix() ){

            // validar login
            $Login = new Login();
            if (!$Login->hihaLogin())  {
                require SCM_ABSPATH. 'login.php';
                exit();
            }
            else {
                include APP_PATH_ABS.APP_PATH_CONTENT.SCM_INSCRIPCIONS.SCM_PATH_GESTIO.'esdevenimentsDiploma.php';
            }                                                                      
        }
        else {
            // no existeix l'esdeveniment - mostrem pàgina d'error
            {require SCM_ABSPATH.SCM_PATH. 'inscripcions/inscripcioError.php';}
        }        
    }    
    public function formulariProcessar() {
        // serveix per processar contra bbdd les dades enviades des d'un formulari
        require __DIR__ .'/'.APP_PATH_INCLUDE.'action-inscripcio_processar.php'; 
    }
    public function g_formulariProcessar() {
        // serveix per processar contra bbdd les dades enviades des d'un formulari
        require __DIR__ .'/'.APP_PATH_INCLUDE.'action-gestio_inscripcio_processar.php'; 
    }    
    public function inscripcioPagar() {
        // serveix per processar contra bbdd les dades enviades des d'un formulari
        require __DIR__ .'/'.APP_PATH_INCLUDE.'action-inscripcio_pagada.php'; 
    }
    public function inscripcioEliminar() {
        // serveix per processar contra bbdd les dades enviades des d'un formulari
        require __DIR__ .'/'.APP_PATH_INCLUDE.'action-inscripcio_eliminar.php'; 
    }
 }
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Persona {

    public $TPERSONA_ID = '';
    public $TPERSONA_NOM = '';
    public $TPERSONA_COGNOM1 = '';
    public $TPERSONA_COGNOM2 = '';
    public $TPERSONA_DATANAIXEMENT = '';
    public $TPERSONA_DNI = '';
    public $TPERSONA_EMAIL = '';
    public $TPERSONA_ADRESA = '';
    public $TPERSONA_CP = '';
    public $TPERSONA_POBLACIO = '';
    public $TPERSONA_TELF1 = '';
    public $TPERSONA_TELF2 = '';
    public $TPERSONA_FOTOGRAFIA = '';
    public $TPERSONA_TARGETASANITARIA = '';     
    protected $TMEMBRES_TIPUS = '';     
    
    public function  __construct($id) {
            
        if ($id <> '') $this->getPersona($id);

    }    
     
    public function getPersona($id) {
        
        $result = $this->bdGetPersona($id);        
        if ($result) {
            $this->TPERSONA_ID = $id;
            $this->TPERSONA_NOM = $result["TPERSONA_NOM"];
            $this->TPERSONA_COGNOM1 = $result["TPERSONA_COGNOM1"];
            $this->TPERSONA_COGNOM2 = $result["TPERSONA_COGNOM2"];
            $this->TPERSONA_DATANAIXEMENT = $result["TPERSONA_DATANAIXEMENT"];
            $this->TPERSONA_DNI = $result["TPERSONA_DNI"];
            $this->TPERSONA_EMAIL = $result["TPERSONA_EMAIL"];            
            $this->TPERSONA_ADRESA = $result["TPERSONA_ADRESA"];
            $this->TPERSONA_CP = $result["TPERSONA_CP"];            
            $this->TPERSONA_POBLACIO = $result["TPERSONA_POBLACIO"];
            $this->TPERSONA_TELF1 = $result["TPERSONA_TELF1"];
            $this->TPERSONA_TELF2 = $result["TPERSONA_TELF2"];
            $this->TPERSONA_FOTOGRAFIA = $result["TPERSONA_FOTOGRAFIA"];        
            $this->TPERSONA_TARGETASANITARIA = $result["TPERSONA_TARGETASANITARIA"];        
            $this->TMEMBRES_TIPUS = $result["TMEMBRES_TIPUS"];                   
        }
        
        return $this;        
    }
     
    public function existeix(){
         if ($this->TPERSONA_ID != '') return true;
         else return false;
     }
    
    public function tipusMembre(){
         return $this->TMEMBRES_TIPUS;
     }     
       
    
    /*
     * OPERACIONS DE BBDD PER GESTIÓ DE PERSONES
     */
  
    public function bdGetPersona($idPersona) {
    // retorna una fila amb les dades d'una perosna a partir del seu id
    // $idPersona: identificador de l'esdeveniment
        global $model;
           
        $row = '';
        $query = "SELECT TPERSONA_ID, TPERSONA_NOM, TPERSONA_COGNOM1, TPERSONA_COGNOM2, TPERSONA_DATANAIXEMENT, TPERSONA_DNI, TPERSONA_EMAIL, ";
        $query .= "TPERSONA_ADRESA, TPERSONA_CP, TPERSONA_POBLACIO, TPERSONA_TELF1, TPERSONA_TELF2, TPERSONA_FOTOGRAFIA, TPERSONA_TARGETASANITARIA, ";
        $query .= "TMEMBRES_TIPUS ";
        $query .= "FROM runners_persona, runners_membres ";
        $query .= "WHERE TPERSONA_ID = '" .$idPersona. "'";  
        $query .= "AND TPERSONA_ID = TMEMBRES_IDPERSONA";          
        $consulta = $model->query($query);                 

        $nfilas = mysql_num_rows ($consulta);					
        if ($nfilas > 0) { 
            $row = mysql_fetch_array($consulta);  
        }
        
        return $row;
    }    
            

}
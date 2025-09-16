<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class ControldePas {

    private $id = '';
    private $idEsdeveniment = '';    
    private $descripcio = '';

    
    
    public function  __construct($id, $idEsdeveniment) {
            
        if ($id <> '') $this->getControldepas($id, $idEsdeveniment);

    }    
    
    public function __destruct() {
        return true;
    }
    
    private function getControldepas($id, $idEsdeveniment) {
        
        return $this->bdGetControldepas($id, $idEsdeveniment);        
                                 
    }
    
    public function existeix(){
         if ($this->id != '') return true;
         else return false;
     }
    
   
    /*
     * OPERACIONS DE BBDD PER GESTIÓ D'ESDEVENIMENTS
     */
    
   
    public function bdGetControldepas($id, $idEsdeveniment) {
    // retorna un objecte esdeveniment carregat a partir del seu id
    // $idEsdeveniment: identificador de l'esdeveniment

        $query = "SELECT tcontroldepas_id, tcontroldepas_idEsdeveniment, tcontroldepas_descripcio "
                . "FROM INSCRIPCIONS_CONTROLDEPAS "
                . "WHERE tcontroldepas_idEsdeveniment = '".$idEsdeveniment."' AND tcontroldepas_id = '".$id."'";
        $resultat = DB::query($query)->getFirst();
        if ($resultat) {
                $this->setId($resultat->tcontroldepas_id);
                $this->setIdEsdeveniment($resultat->tcontroldepas_idEsdeveniment);                
                $this->setDescripcio($resultat->tcontroldepas_descripcio);
        }
        return $this;        
    }    
       
    
    /*****  OPERACIONS DE GET I SET ******/
    public function getId() {
        return $this->id;
    }
    
    public function setId($param) {
        if (isset($param)) $this->id = $param;
    }
    function getIdEsdeveniment() {
        return $this->idEsdeveniment;
    }

    function getDescripcio() {
        return $this->descripcio;
    }

    function setIdEsdeveniment($idEsdeveniment) {
        $this->idEsdeveniment = $idEsdeveniment;
    }

    function setDescripcio($descripcio) {
        $this->descripcio = $descripcio;
    }

    
}
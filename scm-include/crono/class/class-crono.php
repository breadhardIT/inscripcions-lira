<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Crono {    

    private $id = '';
    private $idInscripcio = '';
    private $numcontrol = '';    
    private $data = '';
    private $baixa= '';

    
    public function  __construct($fieldCriteria,$fieldvalue) {        

        if ( ($fieldvalue <> '') && ($fieldCriteria <> '') ) {$this->getCrono($fieldCriteria, $fieldvalue);}
        
    }
    public function __destruct() {
        return true;
    }
    
    private function getCrono($fieldCriteria, $fieldvalue){
       return  $this->bdGetCrono($fieldCrietria, $fieldvalue);
    }        

    public function getCronoPerControl($idInscripcio, $numcontrol){
       return  $this->bdGetCronoPerControl($idInscripcio, $numcontrol);
    }    
    public function getDorsalRetirat($idInscripcio){
       return  $this->bdGetDorsalRetirat($idInscripcio);
    }    

/********************** OPERACIONS DE BBDD   ****************************************/    

    private function bdGetCrono($fieldname, $fieldvalue) {
        // obtenir les dades d'un participant a partir del seu dni        
        
        $query = "SELECT tcrono_id, tcrono_idInscripcio, tcrono_numcontrol, tcrono_data, tcrono_baixa ";
        $query .= "FROM INSCRIPCIONS_CRONO ";
        $query .= "WHERE tcrono_" .$fieldname. " ='" .$fieldvalue. "'";
        $resultat = DB::query($query)->getFirst();

        if ($resultat) {
                $this->id = $resultat->tcrono_id;
                $this->idInscripcio = $resultat->tcrono_idInscripcio;
                $this->numcontrol = $resultat->tcrono_numcontrol;
                $this->data = $resultat->tcrono_data;  
                $this->baixa = $resultat->tcrono_baixa;
        }
    }
    private function bdGetCronoPerControl($idInscripcio, $numcontrol){
        
        $query = "SELECT  tcrono_id, tcrono_idInscripcio, tcrono_numcontrol, tcrono_data, tcrono_baixa FROM INSCRIPCIONS_CRONO ";
        $query .= "WHERE tcrono_idInscripcio='".$idInscripcio."' AND tcrono_numcontrol='" .$numcontrol. "'";
        $resultat = DB::query($query)->getFirst();

        if ($resultat) {
                $this->id = $resultat->tcrono_id;
                $this->idInscripcio = $resultat->tcrono_idInscripcio;
                $this->numcontrol = $resultat->tcrono_numcontrol;
                $this->data = $resultat->tcrono_data;  
                $this->baixa = $resultat->tcrono_baixa;
        }
        
        return $this;
    }
    private function bdGetDorsalRetirat($idInscripcio){
        
        $query = "SELECT tcrono_id, tcrono_idInscripcio, tcrono_numcontrol, tcrono_data, tcrono_baixa  FROM INSCRIPCIONS_CRONO ";
        $query .= "WHERE tcrono_idInscripcio='".$idInscripcio."' AND tcrono_baixa='S'";
        $resultat = DB::query($query)->getFirst();

        if ($resultat) {
                $this->id = $resultat->tcrono_id;
                $this->idInscripcio = $resultat->tcrono_idInscripcio;
                $this->numcontrol = $resultat->tcrono_numcontrol;
                $this->data = $resultat->tcrono_data;  
                $this->baixa = $resultat->tcrono_baixa;
        }
        
        return $this;
    }    
    
    public function create() {        
        $valors = Array(
            'tcrono_idInscripcio' => $this->idInscripcio,
            'tcrono_numcontrol' => $this->numcontrol,
            'tcrono_baixa' => $this->baixa  
        ); 
        $resultat = DB::table('inscripcions_crono')->save($valors);     
        
        if ($resultat) return true;
        else return false;
    }    
    public function update() {
        $valors = Array(
            'tcrono_idInscripcio' => $this->idInscripcio,
            'tcrono_numcontrol' => $this->numcontrol,
            'tcrono_baixa' => $this->baixa  
        );    

        $valors['tcrono_id'] = $this->id;
        $where['tcrono_id'] = $this->id;
        $resultat = DB::table('inscripcions_crono')->save_update($valors,$where);
        
        if ($resultat) return true;
        else return false;
    }    
    public function delete() {
        
        if ( ($this->id <> "") or !isset($this->id) ) {$resultat = DB::table('inscripcions_crono')->delete($this->id);}
        
        if ($resultat) {return true;}    
        else {return false;}       

    }
    
    
    /*****************    OPERACIONS GET I SET  *******************************************/
    function getId() {
        return $this->id;
    }

    function getIdInscripcio() {
        return $this->idInscripcio;
    }

    function getNumcontrol() {
        return $this->numcontrol;
    }

    function getData() {
        return $this->data;
    }

    function getBaixa() {
        return $this->baixa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdInscripcio($idInscripcio) {
        $this->idInscripcio = $idInscripcio;
    }

    function setNumcontrol($numcontrol) {
        $this->numcontrol = $numcontrol;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setBaixa($baixa) {
        $this->baixa = $baixa;
    }


}    
    
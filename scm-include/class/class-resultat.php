<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Resultat {    

    public $id = '';
    public $idInscripcio = '';
    public $datasortida = '';
    public $horasortida = '';    
    public $numcontrol = '';    
    public $data = '';
    public $temps = '';
    public $baixa= '';

    
    public function  __construct($tipus,$id) {
        
        switch ($tipus) {
            case 'inscripcio': 
                if ($id <> '') {$consulta = $this->getResultatPerInscripcio($id);}
                break;  
            case 'id' : 
               if ($id <> '') {$consulta = $this->getResultat($id);}
               break;
         }
        
    }

    public function getResultat($id) {
        // obtenir les dades d'un participant a partir del seu ID
        
        $row = '';
        $query = "SELECT tresultats_id, tresultats_idInscripcio, tresultats_datasortida, tresultats_horasortida, tresultats_numcontrol, tresultats_data,tresultats_temps, tresultats_baixa ";
        $query .= "FROM gmlira_resultats ";
        $query .= "WHERE tresultats_id ='" .$id. "'";
        $result = DB::query($query)->getFirst();

        if (count($result) > 0) $this->carregaDades($result);
    }
    
    public function getResultatPerInscripcio($idInscripcio) {
        // obtenir les dades d'un participant a partir del seu dni
        
        global $model;  
        
        $query = "SELECT tresultats_id, tresultats_idInscripcio, tresultats_datasortida, tresultats_horasortida, tresultats_numcontrol, tresultats_data,tresultats_temps, tresultats_baixa ";
        $query .= "FROM gmlira_resultats ";
        $query .= "WHERE tresultats_idInscripcio ='" .$idInscripcio. "'";
        $result = DB::query($query)->getFirst();

        if (count($result) > 0) $this->carregaDades($result);
    }    
        
    public function carregaDades($result) {
        
                $this->id = $result->tresultats_id;
                $this->idInscripcio = $result->tresultats_idInscripcio;
                $this->datasortida = $result->tresultats_datasortida;
                $this->horasortida = $result->tresultats_horasortida; 
                $this->numcontrol = $result->tresultats_numcontrol;
                $this->data = $result->tresultats_data;  
                $this->temps = $result->tresultats_temps;  
                $this->baixa = $result->tresultats_baixa;                  
    }    
    
    public function insert() {        
                
        $query = "insert into gmlira_resultats (tresultats_idInscripcio, tresultats_datasortida, tresultats_horasortida, ";
        $query .= " tresultats_numcontrol, tresultats_temps, tresultats_baixa ) values (";
        $query .= "'$this->idInscripcio', '$this->datasortida', '$this->horasortida','$this->numcontrol', ";
        $query .= "'$this->temps', '$this->baixa')";   
        
        $consulta = DB::query($query)->execute();
        return $consulta;
    }
    
    public function update() {      
        
        $query = "update gmlira_resultats set tresultats_datasortida='$this->datasortida', tresultats_horasortida='$this->horasortida', ";
        $query .= "tresultats_numcontrol= '$this->numcontrol', tresultats_temps= '$this->temps',tresultats_baixa= '$this->baixa' ";
        $query .= "WHERE tresultats_id ='" .$this->id. "'";  
        
        $consulta = DB::query($query)->execute();
        return $consulta;
    }     
    
    public function delete() {
        
        global $model;  
        
        $query = "delete from gmlira_resultats WHERE tresultats_id ='" .$this->id. "' and tresultats_numcontrol ='" .$this->control. "'";  
        echo $query;
        $consulta = $model->query($query);    
        
        return $consulta;
    }    
}    
    
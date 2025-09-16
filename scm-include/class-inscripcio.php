<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Inscripcio {    

    public $id = '';
    public $idPersona = '';
    public $idEsdeveniment = '';
    public $preu = '';
    public $agree = '';
    public $clau = '';
    public $origen = '';
    public $feec = '';
    public $autocar = '';
    public $soci = '';
    public $clauPagamentPaypal = '';
    public $pagat = '';
    public $incidencia = '';
    public $obs = '';
    public $dorsal= '';
    
    public function  __construct($id) {
        
        $this->id = '';
        if ($id <> '') $this->getInscripcio($id);            
    }

    // retorna les dades d'una inscripcio donat el seu ID
    public function getInscripcio($id){
        global $model;       
    
        $query = "SELECT tinscripcio_idPersona, tinscripcio_idFormulari, tinscripcio_preu, tinscripcio_agree, tinscripcio_clau, ";
        $query .= "tinscripcio_origen, tinscripcio_feec, tinscripcio_autocar, tinscripcio_soci, tinscripcio_pagat, ";
        $query .= "tinscripcio_incidencia, tinscripcio_observacions, tinscripcio_dorsal ";        
        $query .= "FROM gmlira_inscripcions ";
        $query .= "WHERE tinscripcio_id = '" .$id."'";
        $consulta = DB::query($query)->getFirst();
        
        if (count($result) >0) {
            $this->id = $id;
            $this->idPersona = $result->tinscripcio_idPersona;
            $this->idEsdeveniment = $result->tinscripcio_idFormulari;
            $this->preu = $result->tinscripcio_preu;
            $this->agree = $result->tinscripcio_agree;
            $this->clau = $result->tinscripcio_clau;
            $this->origen = $result->tinscripcio_origen;
            $this->feec = $result->tinscripcio_feec;
            $this->autocar = $result->tinscripcio_autocar;
            $this->soci = $result->tinscripcio_soci;           
            $this->pagat = $result->tinscripcio_pagat;   
            $this->incidencia = $result->tinscripcio_incidencia;
            $this->agree = $result->tinscripcio_agree;
            $this->obs = $result->tinscripcio_observacions;  
            $this->dorsal = $result->tinscripcio_dorsal;              
        }        
    }
    
    // retorna les dades de pagament d'una inscripcio donada la seva clau    
    public function getDadesPagament($clau){
        
        global $model; 
        
        $query = "SELECT tinscripcio_id, tinscripcio_preu FROM gmlira_inscripcions ";
        $query .= "WHERE tinscripcio_clau = '" . $clau . "' ";
        $resultado = DB::query($query)->getFirst();

        if (count($resultado)>0) {
            $this->id = $id;
            $this->preu = $resultado->tinscripcio_preu;
        } 
        return $this;
    }

    // busca si hi ha alguna inscripció donada d'alta amb aquell dni per un esdeveniment concret       
    public function getClauInscripcioPerDni($idEsdeveniment, $dni) {
        
        global $model;
        
        $query = "SELECT tinscripcio_id, tinscripcio_clau FROM gmlira_participants, gmlira_inscripcions ";
        $query .= "WHERE tinscripcio_idFormulari = '" .$idEsdeveniment. "' AND dni ='" .$dni. "' AND id = tinscripcio_idPersona";
        $resultado = DB::query($query)->getFirst();

        if (count($resultado)>0) {
            $this->id = $resultado->tinscripcio_id;
            $this->clau = $resultado->tinscripcio_clau;
        }        
    }

    // busca si hi ha alguna inscripció donada d'alta amb aquell dorsal per un esdeveniment concret       
    public function getInscripcioPerDorsal($idEsdeveniment, $dorsal) {
        
        global $model;
        
        $query = "SELECT tinscripcio_id, tinscripcio_idPersona, nom, cognoms, poblacio FROM gmlira_participants, gmlira_inscripcions ";
        $query .= "WHERE tinscripcio_idFormulari = '" .$idEsdeveniment. "' AND tinscripcio_dorsal =" .$dorsal. " AND id = tinscripcio_idPersona";
        $resultado = DB::query($query)->getFirst();

        if (count($resultado)>0) {
            $this->id = $resultado->tinscripcio_id;
            $this->idPersona = $resultado->tinscripcio_idPersona;                    
        }
    }
    
    public function updatePagat($pagat) {
        global $model;  
        
        $query="UPDATE gmlira_inscripcions SET tinscripcio_pagat='".$pagat."' WHERE tinscripcio_id = '" . $this->id . "'";
        $consulta = DB::query($query)->get();   
        
        if ($consulta) $this->pagat = $pagat;
        
        return $consulta;
    }

    public function eliminar() {
        global $model;  
        
        $query="DELETE FROM gmlira_inscripcions WHERE tinscripcio_id = '" . $this->id . "'";
        $consulta = DB::query($query)->get();
       
        return $consulta;
    }    
    
    public function assignarDorsal($dorsal) {
        global $model; 
        
        $query="UPDATE gmlira_inscripcions SET tinscripcio_dorsal='" .$dorsal. "' WHERE tinscripcio_id = '" . $this->id . "'";        
       $consulta = DB::query($query)->get();

        if ($consulta) $this->dorsal = $dorsal;
        
        return $consulta;
    }
    
    public function insert($tipus) {
        global $model;  
        
        // insercio de les dades d'una inscripcio
        $query = "insert into gmlira_inscripcions (tinscripcio_idPersona, tinscripcio_idFormulari, tinscripcio_preu, tinscripcio_agree, tinscripcio_clau, ";
        $query .= "tinscripcio_origen, tinscripcio_feec, tinscripcio_autocar, tinscripcio_soci ";
        if ($tipus == SCM_METODE_GESTIO) $query .= ", tinscripcio_observacions, tinscripcio_incidencia, tinscripcio_dorsal";                      
        $query .= ') values (';
        $query .= "'$this->idPersona', '$this->idEsdeveniment', '$this->preu', '$this->agree', ";
        $query .= "'$this->clau', '$this->origen', '$this->feec', '$this->autocar', '$this->soci'";      
        if ($tipus == SCM_METODE_GESTIO) $query .= ", '$this->obs', '$this->incidencia', $this->dorsal";              
        $query .= ')';
        $consulta = DB::query($query)->execute(); 

        return $consulta;
    }
    
    public function update() {        
        global $model;  
        
        $query = "update gmlira_inscripcions set tinscripcio_preu=$this->preu, tinscripcio_agree='$this->agree', tinscripcio_feec='$this->feec', tinscripcio_autocar='$this->autocar', ";
        $query .= "tinscripcio_soci='$this->soci', tinscripcio_dorsal=$this->dorsal, tinscripcio_pagat='$this->pagat', tinscripcio_incidencia='$this->incidencia', tinscripcio_observacions='$this->obs'  ";
        $query .= "WHERE tinscripcio_id ='" .$this->id. "'";      
        $consulta = DB::query($query)->execute();       

        return $consulta;
    }
}
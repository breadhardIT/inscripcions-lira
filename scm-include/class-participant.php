<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Participant {
    
    public $id = '';
    public $nom = '';
    public $cognoms = '';
    public $dni = '';
    public $telefon = '';
    public $mail = '';
    public $poblacio = '';
    public $naixement = '';
    public $entitat = '';
    public $talla = '';
    public $llicencia = '';
    public $tipusllicencia = '';
    public $federacio = '';
    public $ef = '';
    public $sexe = '';
    public $adresa = '';
    public $cp = '';
    public $soci = '';
    public $vegueria = '';
    
    /*
     * @param string $tipus (identificador, dni,...)
     * $param string $id
     */
    public function  __construct($tipus,$id) {
        
        switch ($tipus) {
            case 'dni': 
                if ($id <> '') {$consulta = $this->getParticipantPerDni($id);}
                break;  
            case 'id' : 
               if ($id <> '') {$consulta = $this->getParticipant($id);}
               break;
         }
        
    }  
   
    public function getParticipant($id) {
        // obtenir les dades d'un participant a partir del seu ID
        global $model;          
        
        $row = '';
        $query = "SELECT id, nom, cognoms, dni, telefon, mail, adresa, poblacio, naixement, entitat, talla, llicencia, tipusllicencia, federacio, ef, sexe, adresa, cp, soci, vegueria ";
        $query .= "FROM gmlira_participants ";
        $query .= "WHERE id ='" .$id. "'";
        $result = DB::query($query)->getFirst();

        if (count($result) > 0) $this->carregaDades($result);
    }
    
    public function getParticipantPerDni($dni) {
        // obtenir les dades d'un participant a partir del seu dni
        
        global $model;  
        
        $query = "SELECT id, nom, cognoms, dni, telefon, mail, adresa, poblacio, naixement, entitat, talla, llicencia, tipusllicencia, federacio, ef, sexe, adresa, cp, soci, vegueria ";
        $query .= "FROM gmlira_participants ";
        $query .= "WHERE dni ='" .$dni. "'";
        $result = DB::query($query)->getFirst();

        if (count($result) > 0) $this->carregaDades($result);
    }    
    
    
    public function carregaDades($result) {
        
                $this->id = $result->id;
                $this->nom = $result->nom;
                $this->cognoms = $result->cognoms;
                $this->dni = $result->dni;
                $this->telefon = $result->telefon;
                $this->mail = $result->mail;
                $this->poblacio = $result->poblacio;
                $this->naixement = $result->naixement;
                $this->entitat = $result->entitat;
                $this->talla = $result->talla;
                $this->llicencia = $result->llicencia;
                $this->tipusllicencia = $result->tipusllicencia;
                $this->federacio = $result->federacio;
                $this->ef = $result->ef;
                $this->sexe = $result->sexe;
                $this->adresa = $result->adresa;
                $this->cp = $result->cp;
                $this->soci = $result->soci;
                $this->vegueria = $result->vegueria;
    }
    
    public function insert() {        
        global $model;  
        
        $query = "insert into gmlira_participants (nom, cognoms, dni, telefon, mail, poblacio, naixement, entitat, talla, ";
        $query .= "llicencia, tipusllicencia, federacio, ef, sexe, adresa, cp, soci, vegueria) values (";
        $query .= "'$this->nom', '$this->cognoms', '$this->dni', '$this->telefon', '$this->mail', ";
        $query .= "'$this->poblacio', '$this->naixement', '$this->entitat', '$this->talla', '$this->llicencia', ";
        $query .= "'$this->tipusllicencia', '$this->federacio', '$this->ef', '$this->sexe', '$this->adresa', ";
        $query .= "'$this->cp', '$this->soci', '$this->vegueria')"; 
	echo $query; 
        $consulta = DB::query($query)->execute();
        
        return $consulta;
    }
    
    public function update() {
        
        global $model;  
        
        $query = "update gmlira_participants set nom= '$this->nom', cognoms='$this->cognoms', ";                             
        $query .= "telefon='$this->telefon', mail='$this->mail', poblacio='$this->poblacio', adresa ='$this->adresa', ";
        $query .= "naixement='$this->naixement', entitat='$this->entitat', talla='$this->talla', llicencia='$this->llicencia', ";
        $query .= "tipusllicencia='$this->tipusllicencia', federacio='$this->federacio', ef='$this->ef', ";
        $query .= "sexe='$this->sexe', cp='$this->cp', ";
        $query .= "soci='$this->soci', vegueria='$this->vegueria' WHERE id ='" .$this->id. "'";
        $consulta = DB::query($query)->execute();    
        
        return $consulta;
    }    
}
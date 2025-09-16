<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Participants {
    
    private $id = '';
    private $dni = '';
    private $nom = '';
    private $cognoms = '';
    private $sexe = '';
    private $naixement = '';
    private $adresa = '';
    private $poblacio = '';
    private $cp = '';
    private $telefon = '';
    private $mail = '';
    private $talla = '';
    private $data = '';
        
   
    /*
     * @param string $fieldCrieria (camp pel que busquem el participant en BBDD: id, dni,...)
     * $param string $id
     */
    public function  __construct($fieldCriteria,$id) {        
        
        if ( ($id <> '') && (isset($id)) && ($fieldCriteria <> '') && (isset($fieldCriteria)) ) {$this->getParticipant($fieldCriteria, $id);}        
    }  
    
    public function __destruct() {
        return true;
    }	
    
    private function getParticipant($fieldCriteria, $id) {
        return $this->bdGetParticipant($fieldCriteria, $id);        
    }

    public function getIDParticipantPerDni($dni) {
        return $this->bdGetIDParticipantPerDni($dni);        
    }
    
    public function getIDParticipantDarrerInsert() {
        return $this->bdGetIdParticipantDarrerInsert();        
    }    
    
    public function existeix() {
         if ($this->id != '') return true;
         else return false;
    }

    /** OPERACIONS DE BBDD **/    
    
    private function bdGetParticipant($fieldCriteria, $id) {
    // obtenir les dades d'un participant a partir del seu ID
        
        global $model;          
        
        if ( ($fieldCriteria <> '') && (isset($fieldCriteria)) && ($id <> '') && (isset($id)) ) {
            $result = '';
            $query = "SELECT tparticipants_id, tparticipants_nom, tparticipants_cognoms, tparticipants_dni, tparticipants_telefon, ";
            $query .= "tparticipants_mail, tparticipants_adresa, tparticipants_poblacio, tparticipants_naixement, ";
            $query .= "tparticipants_talla, tparticipants_sexe, tparticipants_adresa, tparticipants_cp, tparticipants_data ";
            $query .= "FROM INSCRIPCIONS_PARTICIPANTS ";
            $query .= "WHERE tparticipants_".$fieldCriteria. "='" .$id. "'";
            $resultat = DB::query($query)->getFirst();

            if ($resultat) {    
                    $this->setId($resultat->tparticipants_id);
                    $this->setNom($resultat->tparticipants_nom);
                    $this->setCognoms($resultat->tparticipants_cognoms);
                    $this->setDni($resultat->tparticipants_dni);
                    $this->setTelefon($resultat->tparticipants_telefon);
                    $this->setMail($resultat->tparticipants_mail);
                    $this->setPoblacio($resultat->tparticipants_poblacio);
                    $this->setTalla($resultat->tparticipants_talla);
                    $this->setSexe($resultat->tparticipants_sexe);
                    $this->setAdresa($resultat->tparticipants_adresa); 
                    $this->setCp($resultat->tparticipants_cp);
                    $this->setData($resultat->tparticipants_data);
            }
        }    
        return $this;
    }
    
    private function bdGetIDParticipantPerDni($dni){
    // obtenir el id de participant a partir del seu DNI   
        
        $query = "SELECT tparticipants_id FROM inscripcions_participants ";
        $query .= "WHERE tparticipants_dni ='". $dni."'";
        $consulta = $model->query($query);

        $nfilas = mysqli_num_rows ($consulta);					
        if ($nfilas > 0) { 
            $row = mysqli_fetch_array($consulta);        
            if ($row) {$this->setId($row["tparticipants_id"]);}            
        }       
        return $this;
    }
    
    private function bdGetIdParticipantDarrerInsert() {    
        // obtenir darrer registre inserit a la taula.        

        global $model;        
        
        $query = "SELECT tparticipants_id FROM inscripcions_participants order by tparticipants_id desc limit 1 ";
        $consulta = $model->query($query);

        $nfilas = mysqli_num_rows ($consulta);					
        if ($nfilas > 0) { 
            $row = mysqli_fetch_array($consulta);        
            if ($row) {$this->setId($row["tparticipants_id"]);}            
        }       
        return $this;
        
    }        
    
    public function insert() {        
        global $model;  
        
        $query = "insert into inscripcions_participants ";
        $query .= "(tparticipants_nom, tparticipants_cognoms, tparticipants_dni, tparticipants_telefon, tparticipants_mail, ";
        $query .= "tparticipants_poblacio, tparticipants_naixement, tparticipants_talla, tparticipants_sexe, tparticipants_adresa, ";
        $query .= "tparticipants_cp) values (";
        $query .= "'".$this->getNom()."', '".$this->getCognoms()."', '".$this->getDni()."', '".$this->getTelefon()."', ";
        $query .= "'".$this->getMail()."', '".$this->getPoblacio()."', '".$this->getNaixement()."', '".$this->getTalla()."', ";
        $query .= "'".$this->getSexe()."', '".$this->getAdresa()."', '".$this->getCp()."')";
        $consulta = $model->query($query);    
        
        return $consulta;
    }
    
    public function update() {
        
        global $model;  
        
        $query = "update inscripcions_participants set tparticipants_nom='".$this->getNom()."', tparticipants_cognoms='".$this->getCognoms()."', ";                             
        $query .= "tparticipants_telefon='".$this->getTelefon()."', tparticipants_mail='".$this->getMail()."', ";
        $query .= "tparticipants_poblacio='".$this->getPoblacio()."', tparticipants_adresa ='".$this->getAdresa()."', tparticipants_naixement='".$this->getNaixement()."',  ";
        $query .= "tparticipants_talla='".$this->getTalla()."',tparticipants_sexe='".$this->getSexe()."', tparticipants_cp='".$this->getCp()."' ";
        $query .= "WHERE tparticipants_id ='" .$this->getId(). "'";      
        $consulta = $model->query($query);    
        
        return $consulta;
    }   
    
    
//**  FUNCIONS GET I SET **//
    function getId() {
        return $this->id;
    }

    function getDni() {
        return $this->dni;
    }

    function getNom() {
        return $this->nom;
    }

    function getCognoms() {
        return $this->cognoms;
    }

    function getSexe() {
        return $this->sexe;
    }

    function getNaixement() {
        return $this->naixement;
    }

    function getAdresa() {
        return $this->adresa;
    }

    function getPoblacio() {
        return $this->poblacio;
    }

    function getCp() {
        return $this->cp;
    }

    function getTelefon() {
        return $this->telefon;
    }

    function getMail() {
        return $this->mail;
    }

    function getTalla() {
        return $this->talla;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        if (isset($id)) $this->id = $id;
    }

    function setDni($dni) {
        if (isset($dni)) $this->dni = $dni;
    }

    function setNom($nom) {
        if (isset($nom)) $this->nom = $nom;
    }

    function setCognoms($cognoms) {
        if (isset($cognoms)) $this->cognoms = $cognoms;
    }

    function setSexe($sexe) {
        if (isset($sexe)) $this->sexe = $sexe;
    }

    function setNaixement($naixement) {
        if (isset($naixement)) $this->naixement = $naixement;
    }

    function setAdresa($adresa) {
        if (isset($adresa)) $this->adresa = $adresa;
    }

    function setPoblacio($poblacio) {
        if (isset($poblacio)) $this->poblacio = $poblacio;
    }

    function setCp($cp) {
        if (isset($cp)) $this->cp = $cp;
    }

    function setTelefon($telefon) {
        if (isset($telefon)) $this->telefon = $telefon;
    }

    function setMail($mail) {
        if (isset($mail)) $this->mail = $mail;
    }

    function setTalla($talla) {
        if (isset($talla)) $this->talla = $talla;
    }

    function setData($data) {
        if (isset($data)) $this->data = $data;
    }
   
}
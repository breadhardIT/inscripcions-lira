<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Inscripcions {    

    private $id = '';
    private $idParticipant = '';
    private $idEsdeveniment = '';
    private $origen = '';
    private $clau = '';
    private $dorsal = 0;
    private $preu = '0';
    private $pagat = '';
    private $agree = '';
    private $cursa = '';
    private $incidencia = '';
    private $observacions = '';
    private $federat = '';
    private $soci = '';
    private $autocar = '';
    private $xip = '';    
    private $vegueria = '';
    private $federacio = '';
    private $llicencia = '';
    private $tipusllicencia = '';
    private $club = '';
    private $data = '';
    private $codixip = '';
    private $tutoragree = '';  
    private $tutordni = '';
    private $tutornom = '';
    
    private $claubotopaypal ='';
    
    /*
     * @param string $fieldCrieria (camp pel que busquem l'inscripcio en BBDD: id, clau de pagament,...)
     * $param string $id
     */    
    public function  __construct($fieldCriteria, $id) {        
        if ($id <> '') $this->getInscripcio($fieldCriteria,$id);            
    }
    
    public function __destruct() {
        return true;
    }	
    
    public function getInscripcio($fieldCriteria, $id) {
        return $this->bdGetInscripcio($fieldCriteria, $id);        
    }
    
    public function getIDInscripcioPerDni($idEsdeveniment, $dni) {
        if ($dni <> '') return $this->bdGetIDInscripcioPerDni($idEsdeveniment, $dni);
    }

    public function getIDInscripcioPerDorsal($idEsdeveniment, $dorsal) {
        return $this->bdGetIDInscripcioPerDorsal($idEsdeveniment, $dorsal);
    }    
    
    public function updateField($nomfield, $valuefield) {
        return $this->bdUpdateField($nomfield, $valuefield);
    }    

    
    /***** OPERACIONS DE BBDD  *****/
    
    // retorna les dades d'una inscripcio donat el seu ID, clau de pagament
    private function bdGetInscripcio($fieldCriteria,$id){

        if ( ($fieldCriteria <> '') && (isset($fieldCriteria)) ) {
        
            $query = "SELECT tsolicitud_id, tsolicitud_idEsdeveniment, tsolicitud_idParticipant, tsolicitud_origen, tsolicitud_clau, ";
            $query .= "tsolicitud_dorsal, tsolicitud_preu, tsolicitud_pagat, tsolicitud_agree , tsolicitud_cursa, ";
            $query .= "tsolicitud_incidencia, tsolicitud_observacions, tsolicitud_federat, tsolicitud_soci, "; 
            $query .= "tsolicitud_autocar, tsolicitud_vegueria, tsolicitud_federacio, tsolicitud_llicencia, ";
            $query .= "tsolicitud_tipusllicencia, tsolicitud_club, tsolicitud_xip, tsolicitud_codixip, ";
            $query .= "tsolicitud_tutoragree, tsolicitud_tutordni, tsolicitud_tutornom, tsolicitud_data, tcodipaypal_clauboto ";
            $query .= "FROM inscripcions_solicituds, inscripcions_codipaypal ";
            $query .= "WHERE tsolicitud_".$fieldCriteria." = '" .$id."' ";
            $query .= "AND tsolicitud_idEsdeveniment = tcodipaypal_idEsdeveniment ";                
            $query .= "AND tsolicitud_soci = tcodipaypal_soci ";
            $query .= "AND tsolicitud_federat = tcodipaypal_federat ";
            $query .= "AND tsolicitud_autocar = tcodipaypal_autocar "; 
            $query .= "AND tsolicitud_xip = tcodipaypal_xip"; 
            $resultat = DB::query($query)->getFirst();

            if ($resultat) {
                    $this->setId($resultat->tsolicitud_id);
                    $this->setIdEsdeveniment($resultat->tsolicitud_idEsdeveniment);                
                    $this->setIdParticipant($resultat->tsolicitud_idParticipant);
                    $this->setOrigen($resultat->tsolicitud_origen);
                    $this->setClau($resultat->tsolicitud_clau);
                    $this->setDorsal($resultat->tsolicitud_dorsal);                
                    $this->setPreu($resultat->tsolicitud_preu);
                    $this->setPagat($resultat->tsolicitud_pagat);
                    $this->setAgree($resultat->tsolicitud_agree);
                    $this->setCursa($resultat->tsolicitud_cursa);
                    $this->setIncidencia($resultat->tsolicitud_incidencia);                
                    $this->setObservacions($resultat->tsolicitud_observacions);  
                    $this->setFederat($resultat->tsolicitud_federat);
                    $this->setSoci($resultat->tsolicitud_soci); 
                    $this->setAutocar($resultat->tsolicitud_autocar);
                    $this->setVegueria($resultat->tsolicitud_vegueria); 
                    $this->setFederacio($resultat->tsolicitud_federacio);
                    $this->setLlicencia($resultat->tsolicitud_llicencia);   
                    $this->setTipusllicencia($resultat->tsolicitud_tipusllicencia);
                    $this->setClub($resultat->tsolicitud_club);
                    $this->setXip($resultat->tsolicitud_xip);
                    $this->setTutoragree($resultat->tsolicitud_tutoragree);  
                    $this->setTutordni($resultat->tsolicitud_tutordni);
                    $this->setTutornom($resultat->tsolicitud_tutornom);
                    $this->setCodixip($resultat->tsolicitud_codixip);                                        
                    $this->setData($resultat->tsolicitud_data);        
                    $this->setClaubotopaypal($resultat->tcodipaypal_clauboto);
                }    
            }     
            return $this;
    }
    
    // busca si hi ha alguna inscripció donada d'alta amb aquell dni per un esdeveniment concret       
    private function bdGetIDInscripcioPerDni($idEsdeveniment, $dni) {
        
        // obtenir el id de l'inscripció
        $result = '';
        $query = "SELECT tsolicitud_id FROM INSCRIPCIONS_SOLICITUDS, INSCRIPCIONS_PARTICIPANTS ";
        $query .= "WHERE tsolicitud_idEsdeveniment = '" .$idEsdeveniment. "' AND tparticipants_dni ='" .$dni. "' ";
        $query .= "AND tparticipants_id = tsolicitud_idParticipant";
        $resultat = DB::query($query)->getFirst();

        if ($resultat) {
            $this->setId($resultat->tsolicitud_id);
        }    
        return $this;
    }

    // busca si hi ha alguna inscripció donada d'alta amb aquell dorsal per un esdeveniment concret       
    private function bdGetIDInscripcioPerDorsal($idEsdeveniment, $dorsal) {
       
        $query = "SELECT tsolicitud_id, tsolicitud_idParticipant FROM INSCRIPCIONS_SOLICITUDS ";
        $query .= "WHERE tsolicitud_idEsdeveniment = '" .$idEsdeveniment. "' AND tsolicitud_dorsal ='" .$dorsal. "' ";        
        $resultat = DB::query($query)->getFirst();

        if ($resultat) {
            $this->setId($resultat->tsolicitud_id); 
            $this->setIdParticipant($resultat->tsolicitud_idParticipant);
        }
        return $this;  
    }

    
    public function insert() {
        
        // insercio de les dades d'una inscripcio
        $query = "INSERT INTO inscripcions_solicituds (";
        $query .= "tsolicitud_idEsdeveniment, tsolicitud_idParticipant, tsolicitud_origen, tsolicitud_clau, tsolicitud_dorsal, ";
        $query .= "tsolicitud_preu, tsolicitud_agree, tsolicitud_cursa, tsolicitud_codixip, ";
        $query .= "tsolicitud_federat, tsolicitud_soci, tsolicitud_autocar, tsolicitud_vegueria, tsolicitud_federacio, tsolicitud_llicencia, ";
        $query .= "tsolicitud_tipusllicencia, tsolicitud_club, tsolicitud_xip, tsolicitud_tutoragree, tsolicitud_tutordni, ";
        $query .= "tsolicitud_tutornom) VALUES (";
        $query .= "'".$this->getIdEsdeveniment()."', '".$this->getIdParticipant()."', '".$this->getOrigen()."', '".$this->getClau()."', '".$this->getDorsal()."', ";
        $query .= "'".$this->getPreu()."', '".$this->getAgree()."', '".$this->getCursa()."', '".$this->getCodixip()."', ";  
        $query .= "'".$this->getFederat()."', '".$this->getSoci()."', '".$this->getAutocar()."', '".$this->getVegueria()."', '".$this->getFederacio()."', '".$this->getLlicencia()."', ";                                  
        $query .= "'".$this->getTipusllicencia()."', '".$this->getClub()."', '".$this->getXip()."', '".$this->getTutoragree()."', '".$this->getTutordni()."', ";
        $query .= "'".$this->getTutornom()."')";                                  
        $consulta = $model->query($query);    

        return $consulta;
    }   
    
    public function update() {        
        global $model;  
        
        $query = "UPDATE inscripcions_solicituds SET 
                tsolicitud_origen='$this->origen', 
                tsolicitud_preu='$this->preu',
                tsolicitud_pagat='$this->pagat',                    
                tsolicitud_agree='$this->agree',
                tsolicitud_cursa='$this->cursa',
                tsolicitud_federat='$this->federat',
                tsolicitud_soci='$this->soci', 
                tsolicitud_autocar='$this->autocar', 
                tsolicitud_vegueria='$this->vegueria', 
                tsolicitud_federacio='$this->federacio', 
                tsolicitud_llicencia='$this->llicencia',
                tsolicitud_tipusllicencia='$this->tipusllicencia', 
                tsolicitud_club='$this->club', 
                tsolicitud_xip='$this->xip', 
                tsolicitud_codixip='$this->codixip',                     
                tsolicitud_tutoragree='$this->tutoragree', 
                tsolicitud_tutordni='$this->tutordni',
                tsolicitud_tutornom='$this->tutornom',
                tsolicitud_incidencia='$this->incidencia',
                tsolicitud_observacions='$this->observacions' ";
        if ($this->dorsal <> '') $query .= ", tsolicitud_dorsal='$this->dorsal'";                              
        $query .= "WHERE tsolicitud_id ='" .$this->id. "'";      
        $consulta = $model->query($query);            

        return $consulta;
    }

    public function delete() {
        global $model;  
        
        $query="DELETE FROM inscripcions_solicituds WHERE tsolicitud_id = '" .$this->getId(). "'";
        $consulta = $model->query($query);            
       
        return $consulta;
    }
    
    /**** OPERACIONS GET I SET ****/
    function getId() {
        return $this->id;
    }

    function getIdParticipant() {
        return $this->idParticipant;
    }

    function getIdEsdeveniment() {
        return $this->idEsdeveniment;
    }

    function getOrigen() {
        return $this->origen;
    }

    function getClau() {
        return $this->clau;
    }

    function getDorsal() {
        return $this->dorsal;
    }

    function getPreu() {
        return $this->preu;
    }

    function getPagat() {
        return $this->pagat;
    }

    function getAgree() {
        return $this->agree;
    }

    function getCursa() {
        return $this->cursa;
    }

    function getIncidencia() {
        return $this->incidencia;
    }

    function getObservacions() {
        return $this->observacions;
    }

    function getFederat() {
        return $this->federat;
    }

    function getSoci() {
        return $this->soci;
    }

    function getAutocar() {
        return $this->autocar;
    }

    function getVegueria() {
        return $this->vegueria;
    }

    function getFederacio() {
        return $this->federacio;
    }

    function getLlicencia() {
        return $this->llicencia;
    }

    function getTipusllicencia() {
        return $this->tipusllicencia;
    }

    function getClub() {
        return $this->club;
    }

    function getXip() {
        return $this->xip;
    }

    function getData() {
        return $this->data;
    }

    function getTutoragree() {
        return $this->tutoragree;
    }

    function getTutordni() {
        return $this->tutordni;
    }

    function getTutornom() {
        return $this->tutornom;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdParticipant($idParticipant) {
        $this->idParticipant = $idParticipant;
    }

    function setIdEsdeveniment($idEsdeveniment) {
        $this->idEsdeveniment = $idEsdeveniment;
    }

    function setOrigen($origen) {
        $this->origen = $origen;
    }

    function setClau($clau) {
        $this->clau = $clau;
    }

    function setDorsal($dorsal) {
        $this->dorsal = $dorsal;
    }

    function setPreu($preu) {
        $this->preu = $preu;
    }

    function setPagat($pagat) {
        $this->pagat = $pagat;
    }

    function setAgree($agree) {
        $this->agree = $agree;
    }

    function setCursa($cursa) {
        $this->cursa = $cursa;
    }

    function setIncidencia($incidencia) {
        $this->incidencia = $incidencia;
    }

    function setObservacions($observacions) {
        $this->observacions = $observacions;
    }

    function setFederat($federat) {
        $this->federat = $federat;
    }

    function setSoci($soci) {
        $this->soci = $soci;
    }

    function setAutocar($autocar) {
        $this->autocar = $autocar;
    }

    function setVegueria($vegueria) {
        $this->vegueria = $vegueria;
    }

    function setFederacio($federacio) {
        $this->federacio = $federacio;
    }

    function setLlicencia($llicencia) {
        $this->llicencia = $llicencia;
    }

    function setTipusllicencia($tipusllicencia) {
        $this->tipusllicencia = $tipusllicencia;
    }

    function setClub($club) {
        $this->club = $club;
    }

    function setXip($xip) {
        $this->xip = $xip;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setTutoragree($tutoragree) {
        $this->tutoragree = $tutoragree;
    }

    function setTutordni($tutordni) {
        $this->tutordni = $tutordni;
    }

    function setTutornom($tutornom) {
        $this->tutornom = $tutornom;
    }

    function getClaubotopaypal() {
        return $this->claubotopaypal;
    }

    function setClaubotopaypal($claubotopaypal) {
        $this->claubotopaypal = $claubotopaypal;
    }

    function getCodixip() {
        return $this->codixip;
    }

    function setCodixip($codixip) {
        $this->codixip = $codixip;
    }


}
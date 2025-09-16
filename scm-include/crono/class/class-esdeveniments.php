<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Esdeveniments {

    private $id = '';
    private $idSite = '';
    private $estat = '';
    private $nom = '';
    private $texte = '';
    private $logo = '';
    private $edicio = '';
    private $gratuita = '';
    private $xip = '';
    private $convenivegueria = '';    
    private $ofertasoci = '';        
    private $autocar = '';
    private $federacio = '';
    private $samarreta = '';
    private $datatall = '';
    private $numcompte='';
    private $dorsal='';
    private $publicat ='';
    private $datasortida = '';
    private $horasortida = '';
    private $infantil = '';

    private $preubasic = '';
    private $preuassegurança = '';    
    private $preusoci = '';
    private $preuautocar = '';
    private $preuxip = '';
    
    
    public function  __construct($id) {
            
        if ($id <> '') $this->getEsdeveniment($id);
        else return $this;

    }    
    
    public function __destruct() {
        return true;
    }
    
    private function getEsdeveniment($id) {
        
        return $this->bdGetEsdeveniment($id);        
                                 
    }
    
    public function existeix(){
         if ($this->id != '') return true;
         else return false;
     }
    
    public function estaObert(){
         if ($this->estat == '1') return true;
         else return false;
     }
     
    public function teAutocar(){
         if ($this->autocar == 'S') return true;
         else return false;
     }     

    public function teConvenivegueria(){
        if ($this->convenivegueria == 'S') return true;
        else return false;
    }  

    public function teOfertasoci(){
        if ($this->ofertasoci == 'S') return true;
        else return false;
    }
    
    public function teSamarreta(){
        if ($this->samarreta == 'S') return true;
        else return false;
    }  
    
    public function teFederativa(){
        if ($this->federacio == 'S') return true;
        else return false;
    }

    public function teXip(){
        if ($this->xip == 'S') return true;
        else return false;
    }
    
    public function esGratuita(){
        if ($this->gratuita == 'S') return true;
        else return false;
    }

    public function esInfantil(){
        if ($this->infantil == 'S') return true;
        else return false;
    }
    
    public function esPeriodePrevi() {
    // retorna cert si la data actual és anterior a la data de tall marcada per obrir l'esdeveniment. en qualsevol altre cas, retorna fals.
        
        if ( ($this->datatall == '') || (!isset($this->datatall)) ) return false;
        
        $dataActual = date ("Y-m-d");
        if ($this->datatall > $dataActual) return true;
        else return false;
    }

    public function estaIniciada() {
    // retorna cert si la data y hora de sortida estan informades; en qualsevol altre cas, retorna fals.
        
        if ( ($this->datasortida == '') || (!isset($this->horasortida)) ) return false;        
        else return true;
    }                   
       
    public function getEsdevenimentActiu() {
    // retorna l'esdeveniment actiu en unn moment donat.
        
        $resultat = DB::table('inscripcions_esdeveniments')->where('tesdeveniments_estat','=','1')->getFirst();
        if ($resultat) {
            return $this->bdGetEsdeveniment($resultat->tesdeveniments_id);
        } else {return $this;}
    }    
    
    /*
     * OPERACIONS DE BBDD PER GESTIÓ D'ESDEVENIMENTS
     */
        
    public function bdGetEsdeveniment($idEsdeveniment) {
    // retorna un objecte esdeveniment carregat a partir del seu id
    // $idEsdeveniment: identificador de l'esdeveniment
        
        $resultat = DB::table('inscripcions_esdeveniments')->where('tesdeveniments_id','=',$idEsdeveniment)->getFirst();
        if ($resultat) {
                $this->setId($resultat->tesdeveniments_id);
                $this->setIdSite($resultat->tesdeveniments_idSite);                
                $this->setEstat($resultat->tesdeveniments_estat);
                $this->setNom($resultat->tesdeveniments_nom);
                $this->setTexte($resultat->tesdeveniments_texte);
                $this->setLogo($resultat->tesdeveniments_logo);
                $this->setEdicio($resultat->tesdeveniments_edicio);
                $this->setGratuita($resultat->tesdeveniments_gratuita);
                $this->setConvenivegueria($resultat->tesdeveniments_convenivegueria);
                $this->setOfertasoci($resultat->tesdeveniments_ofertasoci);
                $this->setAutocar($resultat->tesdeveniments_autocar);
                $this->setXip($resultat->tesdeveniments_xip);
                $this->setFederacio($resultat->tesdeveniments_federacio);
                $this->setSamarreta($resultat->tesdeveniments_samarreta);
                $this->setDatatall($resultat->tesdeveniments_datatall);                 
                $this->setNumcompte($resultat->tesdeveniments_numcompte);
                $this->setPublicat($resultat->tesdeveniments_publicat);
                $this->setDorsal($resultat->tesdeveniments_dorsal);
                $this->setHorasortida($resultat->tesdeveniments_horasortida);
                $this->setDatasortida($resultat->tesdeveniments_datasortida);
                $this->setInfantil($resultat->tesdeveniments_infantil);
        }
        return $this;        
    }    
    
    /*****  OPERACIONS DE GET I SET ******/
    public function getId() {
        return $this->id;
    }

    public function getEstat() {
        return $this->estat;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getTexte() {
        return $this->texte;
    }

    public function getLogo() {
        return $this->logo;
    }

    public function getEdicio() {
        return $this->edicio;
    }

    public function getGratuita() {
        return $this->gratuita;
    }

    public function getPreubasic() {
        return $this->preubasic;
    }

    public function getPreuassegurança() {
        return $this->preuassegurança;
    }

    public function getPreusoci() {
        return $this->preusoci;
    }

    public function getPreuautocar() {
        return $this->preuautocar;
    }

    public function getPreuxip() {
        return $this->preuxip;
    }

    public function getConvenivegueria() {
        return $this->convenivegueria;
    }

    public function getAutocar() {
        return $this->autocar;
    }

    public function getFederacio() {
        return $this->federacio;
    }

    public function getSamarreta() {
        return $this->samarreta;
    }

    public function getDatatall() {
        return $this->datatall;
    }

    public function getNumcompte() {
        return $this->numcompte;
    }

    public function getPublicat() {
        return $this->publicat;
    }

    public function getDatasortida() {
        return $this->datasortida;
    }

    public function getHorasortida() {
        return $this->horasortida;
    }
    
    public function getDorsal() {
        return $this->dorsal;
    }

    public function getXip() {
        return $this->xip;
    }   
    
    public function setId($param) {
        if (isset($param)) $this->id = $param;
    }

    public function setEstat($param) {
        if (isset($param)) $this->estat = $param;
    }

    public function setNom($param) {
        if (isset($param)) $this->nom = $param;
    }

    public function setTexte($param) {
        if (isset($param)) $this->texte = $param;
    }

    public function setLogo($param) {
        if (isset($param)) $this->logo = $param;
    }

    public function setEdicio($param) {
        if (isset($param)) $this->edicio = $param;
    }

    public function setGratuita($param) {
        if (isset($param)) $this->gratuita = $param;
    }

    public function setPreubasic($param) {
        if (isset($param)) $this->preubasic = $param;
    }

    public function setPreuassegurança($param) {
        if (isset($param)) $this->preuassegurança = $param;
    }

    public function setPreusoci($param) {
        if (isset($param)) $this->preusoci = $param;
    }

    public function setPreuautocar($param) {
        if (isset($param)) $this->preuautocar = $param;
    }

    public function setPreuxip($param) {
        if (isset($param)) $this->preuxip = $param;
    }

    public function setConvenivegueria($param) {
        if (isset($param)) $this->convenivegueria = $param;
    }

    public function setAutocar($param) {
        if (isset($param)) $this->autocar = $param;
    }

    public function setFederacio($param) {
        if (isset($param)) $this->federacio = $param;
    }

    public function setSamarreta($param) {
        if (isset($param)) $this->samarreta = $param;
    }

    public function setDatatall($param) {
        if (isset($param)) $this->datatall = $param;
    }

    public function setNumcompte($param) {
        if (isset($param)) $this->numcompte = $param;
    }

    public function setPublicat($param) {
        if (isset($param)) $this->publicat = $param;
    }

    public function setDatasortida($param) {
        if (isset($param)) $this->datasortida = $param;
    }

    public function setHorasortida($param) {
        if (isset($param)) $this->horasortida = $param;
    }
 
    public function setDorsal($param) {
        if (isset($param)) $this->dorsal = $param;
    }

    public function setXip($param) {
        if (isset($param)) $this->xip = $param;
    }

    function getIdSite() {
        return $this->idSite;
    }

    function setIdSite($param) {
        if (isset($param)) $this->idSite = $param;
    }

    function getOfertasoci() {
        return $this->ofertasoci;
    }

    function setOfertasoci($param) {
        if (isset($param)) $this->ofertasoci = $param;
    }
    
    public function getInfantil() {
        return $this->infantil;
    }
    
    function setInfantil($param) {
        if (isset($param)) $this->infantil = $param;
    }
    
}
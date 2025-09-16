<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once APP_PATH_ABS.APP_PATH_INCLUDE.'model/db.php';

Class Esdeveniment {

    public $id = '';
    public $estat = '';
    public $nom = '';
    public $texte = '';
    public $logo = '';
    public $edicio = '';
    public $gratuita = '';
    public $preu1 = '';
    public $conveni_vegueria = '';
    public $preu2 = '';
    public $preufeec = '';
    public $preuautocar = '';
    public $autocar = '';
    public $federacio = '';
    public $samarreta = '';
    public $datatall = '';
    public $numcompte='';
    public $publicat ='';
    public $datasortida = '';
    public $horasortida = '';
    
    
    public function  __construct($id) {
            
        if ($id <> '') $this->getEsdeveniment($id);

     }    
     
    public function getEsdeveniment($id) {
        
        $result = $this->bdGetEsdeveniment($id);        
        if (count($result) >0) {
            $this->id = $id;
            $this->estat = $result->tesdeveniments_estat;
            $this->nom = $result->tesdeveniments_nom;
            $this->texte = $result->tesdeveniments_texte;
            $this->logo = $result->tesdeveniments_logo;
            $this->edicio = $result->tesdeveniments_edicio;
            $this->gratuita = $result->tesdeveniments_gratuita;            
            $this->preu1 = $result->tesdeveniments_preu1;
            $this->conveni_vegueria = $result->tesdeveniments_convenivegueria;            
            $this->preu2 = $result->tesdeveniments_preu2;
            $this->preufeec = $result->tesdeveniments_preufeec;
            $this->preuautocar = $result->tesdeveniments_preuautocar;
            $this->autocar = $result->tesdeveniments_autocar;        
            $this->federacio = $result->tesdeveniments_federacio;        
            $this->samarreta = $result->tesdeveniments_samarreta;        
            $this->datatall = $result->tesdeveniments_datatall;                    
            $this->numcompte = $result->tesdeveniments_numcompte;                                
            $this->publicat = $result->tesdeveniments_publicat;
            $this->dorsal = $result->tesdeveniments_dorsal;
            $this->horasortida = $result->tesdeveniments_horasortida;
            $this->datasortida = $result->tesdeveniments_datasortida;            
        }
        
        return $this;
        
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

    public function teConveni(){
        if ($this->conveni_vegueria == 'S') return true;
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
    
    public function esGratuita(){
        if ($this->gratuita == 'S') return true;
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
    
    public function canviarEstat($estat) {
        
        $consulta = $this->bdUpdateEsdevenimentEstat($estat, $this->id);        
        if ($consulta) {$this->estat = $estat;}
        
        return ($consulta);        
    }
    
    public function canviarPublicacio($estat) {
        
        $consulta = $this->bdUpdateEsdevenimentPublicat($estat, $this->id);        
        if ($consulta) {$this->publicat = $estat;}   
        
        return ($consulta);
    }
    
    public function obtenirNouDorsal() {
        
        $consulta = $this->bdUpdateEsdevenimentNouDorsal(($this->dorsal + 1), $this->id);        
        if ($consulta) $this->dorsal = ($this->dorsal + 1);
        
        return $consulta;
    }    
    
    
    /*
     * OPERACIONS DE BBDD PER GESTIÓ D'ESDEVENIMENTS
     */
    
        public function bdGetLlistaEsdeveniments($publicat) {
    // retorn un resultset amb la llista d'esdeveniments
    // $publicat: S/N indica si l'esdeveniment és visible o no a la web.
        global $model;
        
        $query = "SELECT tesdeveniments_id, tesdeveniments_estat, tesdeveniments_nom, tesdeveniments_texte, tesdeveniments_logo, tesdeveniments_url, tesdeveniments_publicat ";
        $query .= "FROM gmlira_esdeveniments ";
        $query .= "WHERE tesdeveniments_publicat='".$publicat."'";
        $consulta = $model->query($query);                 

        return $consulta;
    }
    
    public function bdGetEsdeveniment($idEsdeveniment) {
    // retorna una fila amb les dades d'un esdeveniment a partir del seu id
    // $idEsdeveniment: identificador de l'esdeveniment
        global $model;
           
        $query = "SELECT tesdeveniments_estat, tesdeveniments_nom, tesdeveniments_texte, tesdeveniments_logo, tesdeveniments_edicio, ";
        $query .= "tesdeveniments_gratuita, tesdeveniments_preu1, tesdeveniments_convenivegueria, tesdeveniments_preu2, tesdeveniments_preufeec, tesdeveniments_preuautocar, tesdeveniments_autocar, ";
        $query .= "tesdeveniments_federacio, tesdeveniments_samarreta, tesdeveniments_datatall, tesdeveniments_numcompte, tesdeveniments_publicat, tesdeveniments_dorsal, ";        
        $query .= "tesdeveniments_datasortida, tesdeveniments_horasortida ";                
        $query .= "FROM gmlira_esdeveniments ";
        $query .= "WHERE tesdeveniments_id='" .$idEsdeveniment. "'";  
        return DB::query($query)->getFirst();               
        
    }    
            
    public function bdUpdateEsdevenimentEstat($estat, $idEsdeveniment) {
    // actualitza l'estat de l'esdeveniment
    // $idEsdeveniment: identificador de l'esdeveniment
    // $estat: valor de l'estat amb el que sactualitza el registre
        global $model;
                
        $query="UPDATE gmlira_esdeveniments SET tesdeveniments_estat='" .$estat. "' WHERE tesdeveniments_id = '" . $idEsdeveniment . "'";        
        $consulta = $model->query($query);                 
        
        return $consulta;
    }
    
    public function bdUpdateEsdevenimentPublicat($estat, $idEsdeveniment) {
    // actualitza el camp publicat de l'esdeveniment
    // $idEsdeveniment: identificador de l'esdeveniment
    // $publicat: valor amb el que s'actualitza el registre
        global $model;
                
        $query="UPDATE gmlira_esdeveniments SET tesdeveniments_publicat='" .$estat. "' WHERE tesdeveniments_id = '" . $idEsdeveniment . "'";
        $consulta = $model->query($query);                 
        
        return $consulta;        
    }
    
    public function bdUpdateEsdevenimentNouDorsal($dorsal, $idEsdeveniment) {
    // actualitza l'esdeveniment amb el darrer dorsal assignat
    // $idEsdeveniment: identificador de l'esdeveniment
    // $dorsal: valor del darrer dorsal assignat
        global $model;        
        
        $query="UPDATE gmlira_esdeveniments SET tesdeveniments_dorsal='" .$dorsal. "' WHERE tesdeveniments_id = '" . $idEsdeveniment . "'";
        $consulta = $model->query($query);                 
        
        return $consulta;
    }
    
    public function bdUpdateEsdevenimentSortida($idEsdeveniment, $data, $hora) {
    // actualitza l'esdeveniment amb la data/ hora de la sortida
    // $idEsdeveniment: identificador de l'esdeveniment
    // $data: data de la sortida
    // $hora: hora de la sortida        
        global $model;        
        
        $query="UPDATE gmlira_esdeveniments SET tesdeveniments_datasortida='" .$data. "', tesdeveniments_horasortida='" .$hora. "' WHERE tesdeveniments_id = '" . $idEsdeveniment . "'";            
        $consulta = $model->query($query);                 

        return $consulta;
    }    
    
  
    
    public function bdGetEsdevenimentTotalInscrits($idEsdeveniment, $cognoms, $nom) {
        // obtenir el total d'inscrits d'un esdeveniment a partir del seu ID        
        global $model;
        
        $query = "SELECT count(tinscripcio_id) as total ";
        $query .= "FROM gmlira_inscripcions, gmlira_participants " ;
        $query .= "WHERE tinscripcio_idFormulari = '" .$idEsdeveniment. "' ";		
        $query .= "AND tinscripcio_idPersona = id";
        if ($cognoms != "Tots") $query .= " AND cognoms='" .$cognoms. "'";
        if ($nom != "Tots") $query .= " AND nom='" .$nom. "'";                            
        $consulta = $model->query($query);                 
        
        $nfilas = mysql_num_rows ($consulta);					
        if ($nfilas > 0) { 
            $row = mysql_fetch_array($consulta);        
            return $row["total"];
        }
        else return 0;
    }    
}
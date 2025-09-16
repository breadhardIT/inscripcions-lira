<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Class DBProcedure {
    
    private $_consulta = '';        
    private $_array = array();            
    
    
    public function  __construct() {
            
    } 
    
    public function getResultat() {
        return $this->_consulta;
    } 
    
    public function getResultatArray() {
        while ($row = mysql_fetch_assoc($this->_consulta))
        {
            $this->_array[] = $row;
        }  
        return $this->_array;
    }     

    public function bdGetEsdevenimentLlista($publicat) {
    // retorna un resultset amb la llista d'esdeveniments
    // $publicat: S/N indica si l'esdeveniment és visible o no a la web.
        global $model;
        
        $query = "SELECT tesdeveniments_id, tesdeveniments_estat, tesdeveniments_nom, tesdeveniments_texte, tesdeveniments_logo, tesdeveniments_url, tesdeveniments_publicat ";
        $query .= "FROM gmlira_esdeveniments ";
        if ($publicat <> ''){ 
            $query .= "WHERE tesdeveniments_publicat='".$publicat."'";}
        $consulta = $model->query($query);

        if ($consulta) {$this->_consulta = $consulta;}      
        
        return $this;
    }    
    
}
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Ruta {
    
    public $id = '';
    public $descripciobreu ='';
    public $tipus ='';    
    
    public function  __construct($id) {
        if ($id <> '') {
            $m = new Model(Config::$dbname, Config::$dbuser, Config::$dbpass, Config::$dbserver);
            $consulta = $m->getRutesPerId($id);

            $nfilas = mysql_num_rows ($consulta);					
            if ($nfilas > 0) { 
                $result = mysql_fetch_array($consulta);        
                $this->id = $id;
                $this->descripciobreu = $result["trutes_descripciobreu"];           
                $this->tipus = $result["trutes_tipus"];                           
            }
        }                
    }
    
    public function existeix($id) {
        if ($this->id != '') return true;
         else return false;        
    }
}
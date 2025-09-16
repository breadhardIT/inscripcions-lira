<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Feec {
    
    public $dni = '';
    public $llicencia = ''; 
    public $codi_resposta = '';
    public $mess_resposta = '';
    public $tipusLlicencia = '';
    public $entitat = '';
	
    public function  __construct($llicencia, $dni) {
        $this->dni = $dni;
        $this->llicencia = $llicencia;		
        if ( ($llicencia <> '') && ($dni <> '') ) $this->getStatus();
        else {
            $this->codi_resposta = '200';
            $this->mess_resposta = 'NOK';
            $this->tipusLlicencia = '';
            $this->entitat = '';            
        }
    }
	
    public function getStatus() {
		
		$curl = curl_init("https://feec.playoffinformatica.com/ws/llicencies/codillicencia-".$this->llicencia."/subcategories-clubs?dni=".$this->dni);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "qrfederatsEntitats:800b3b6b333b97cdd4d581b39da148be");
		$resultat = curl_exec($curl); 
		curl_close($curl);
		
		$dades = json_decode($resultat,true);
                $this->codi_resposta = $dades["response"]["status"]['codi'];
                $this->mess_resposta = $dades["response"]["status"]['message'];                
                $this->tipusLlicencia = $dades["response"]["content"]['subcategories-clubs'][0]['nomSubCategoria'];                        
                $this->entitat = $dades["response"]["content"]['subcategories-clubs'][0]['nomClub'];     		
		
		return $this;
	}


	public function esValid() {
		if (($this->codi_resposta == '200') &&  ($this->mess_resposta == 'OK') && ($this->tipusLlicencia <> '') ) { return true;}
		else return false;
	}
        
	public function estaFederat() {
		if ( ($this->esValid()) && ($this->tipusLlicencia <> '') ){return true;}
		else return false;
	}        
}        
		

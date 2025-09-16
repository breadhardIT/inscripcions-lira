<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Title {
    
    public $title = '';
    public $categoria = ''; 
    public $urlcategoria = '';
    
    public function  __construct($title, $categoria, $urlcategoria) {
        $this->title = $title;
        $this->categoria = $categoria;
        $this->urlcategoria = $urlcategoria;
    }
}
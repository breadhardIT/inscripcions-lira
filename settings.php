<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// definició de las variables de CFG
if ( !defined('SCM_MODUL_GESTIO') ) define('SCM_MODUL_GESTIO', TRUE);
if ( !defined('SCM_MODUL_PUBLIC') ) define('SCM_MODUL_PUBLIC', FALSE);
if ( !defined('SCM_INSCRIPCIONS') ) define('SCM_INSCRIPCIONS', 'inscripcions/');
if ( !defined('SCM_CRONO') ) define('SCM_CRONO', 'crono/');

$url=$_SERVER['HTTP_HOST'];  // obtenció del domini on corre l'aplicació

define('GRID_PAGINATION_ROWS', 15);
define('PAGE_DEFAULT_GESTIO', 'g_esdevenimentsLlistat');

// càrrega del model wordpress
//require_once SCM_WP_MODEL;


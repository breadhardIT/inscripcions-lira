<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * paràmetres de configuració
 * 23.06.2014
 */

$url=$_SERVER['HTTP_HOST'];  // obtenció del domini on corre l'aplicació

// Definició de les rutes del core de l'aplicació
if ( !defined('APP_PATH') ){	
    if ($url == 'localhost') define('APP_PATH', '/inscripcions/');
    else define('APP_PATH', '/');
}

if ( !defined('APP_PATH_ABS') )	define('APP_PATH_ABS', dirname(__FILE__) . '/');
if ( !defined('APP_PATH_INCLUDE') ) define('APP_PATH_INCLUDE', 'scm-include/');
if ( !defined('APP_PATH_CONTENT') ) define('APP_PATH_CONTENT', 'scm-content/');
if ( !defined('APP_PATH_THEME') ) define('APP_PATH_THEME', 'scm-themes/');
if ( !defined('SCM_PATH_THEME') ) define('SCM_PATH_THEME', 'scm-themes/');

if ( !defined('SCM_DB_CHARSET') ) define('SCM_DB_CHARSET', 'utf8');               // Codificación de caracteres para la base de datos. 
if ( !defined('SCM_DB_COLLATE') ) define('SCM_DB_COLLATE', 'utf8_general_ci');    // Cotejamiento de la base de datos. No lo modifiques si tienes dudas.
if ( !defined('SCM_PWD_ENCRIPTACIO') ) define('SCM_PWD_ENCRIPTACIO', 'md5');      // mètode d'encriptació del login

if ( !defined('SCM_PATH_GESTIO') ) define('SCM_PATH_GESTIO', 'gestio/');

/** CONFIGURACIÓ DE DEBUG **/
/*
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);


define('WP_DEBUG', true);           // Enable WP_DEBUG mode
define('WP_DEBUG_LOG', true);       // Enable Debug logging to the /wp-content/debug.log file
define('WP_DEBUG_DISPLAY', true);   // Disable display of errors and warnings 
define('SCRIPT_DEBUG', true);       // Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
/**/

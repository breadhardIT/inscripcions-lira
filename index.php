<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Entrada a l'aplicació
 */

if ( !defined('APP_PATH_ABS') )	define('APP_PATH_ABS', dirname(__FILE__) . '/');

// càrrega del model i els control·ladors
require_once APP_PATH_ABS .  'config.php';
require_once APP_PATH_ABS .  'settings.php'; 
require_once APP_PATH_ABS .  'scm-include/functions.php';  
 
 // enrutamiento
 $map = array(

    'login' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'login', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),          
     
    // INSCRIPCIONS //    
     'esdevenimentsLlistat' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'esdevenimentsLlistat', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),          
    'inscripcioLlistat' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioLlistat', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),     
    'inscripcioInici' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioInici', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'), 
    'inscripcioForm' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioForm', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'), 
    'inscripcioConfirm' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioConfirm', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),
    'inscripcioResultat' => array('controller_file' =>'controller.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioResultat', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),     
     
    'g_inscripcioLlistat' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioLlistat', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),
    'g_inscripcioExport' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioExport', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),               
    'g_inscripcioExportTempFEEC' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioExportTempFEEC', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),               
    'gestioInscripcioInici' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioInici', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),                    
    'g_inscripcioForm' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioForm', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),

    'g_esdevenimentsLlistat' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'esdevenimentsLlistat', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),               
    'g_esdevenimentsCrono' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'esdevenimentsCrono', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),     
    'g_esdevenimentsDiploma' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'esdevenimentDiploma', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),     

    'formulariProcessar' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'formulariProcessar', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),
    'g_formulariProcessar' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'g_formulariProcessar', 'param' =>SCM_MODUL_GESTIO, 'theme' => 'gmlira_web'),     
    'inscripcioPagar' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioPagar', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),       
    'inscripcioEliminar' => array('controller_file' =>'controller_inscripcions.php','controller' =>'Controller_inscripcions', 'action' =>'inscripcioEliminar', 'param' =>SCM_MODUL_PUBLIC, 'theme' => 'gmlira_web'),            

    // CONTROL DE PAS //    
    'controlPasAdmin' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasAdmin', 'param' =>'', 'theme' => 'crono'),    	
    'controlPasAdminResum' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasResum', 'param' =>'Admin', 'theme' => 'crono'), 	
    'controlPasAdminDorsalBuscar' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasDorsalBuscar', 'param' =>'Admin', 'theme' => 'crono'),	
    'controlPasAdminDorsalEstat' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasDorsalEstat', 'param' =>'Admin', 'theme' => 'crono'),	
    'controlPasRegistrar' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasRegistrar', 'param' =>'Admin', 'theme' => 'crono'),	
    'controlPasHome' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasHome', 'param' =>'', 'theme' => 'crono'),    
    'controlPas' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasRegistrar', 'param' =>'', 'theme' => 'crono'),
    'controlPasLlistat' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasLlistat', 'param' =>'', 'theme' => 'crono'),
    'controlPasDorsalBuscar' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasDorsalBuscar', 'param' =>'', 'theme' => 'crono'),
    'controlPasDorsalEstat' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasDorsalEstat', 'param' =>'', 'theme' => 'crono'),
    'controlPasResum' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasResum', 'param' =>'', 'theme' => 'crono'), 
    'controlPasUpdate' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'ControlPasUpdate', 'param' =>'', 'theme' => 'crono'),                                  
    'controlPasResetResult' => array('controller_file' =>'controller_controlpas.php','controller' =>'controller_controlpas', 'action' =>'controlPasResetResult', 'param' =>'', 'theme' => 'crono'),                                  	
 );          
     
 // Parseo de la ruta
 if (isset($_GET['ctl'])) {
     if (isset($map[$_GET['ctl']])) {
         $ruta = $_GET['ctl'];
     } else {
         header('Status: 404 Not Found');
         echo '<html><body><h1>Error 404: No existe la ruta <i>' .
                 $_GET['ctl'] .
                 '</p></body></html>';
         exit;
     }
 } else {
     $ruta = 'esdevenimentsLlistat';
 }

$controlador = $map[$ruta]; 
// Ejecución del controlador asociado a la ruta
require_once APP_PATH_ABS . $controlador['controller_file'];
 
 //Càrrega del theme
if ( !defined('APP_THEME') )define('APP_THEME', $controlador['theme'].'/');
if ( !defined('SCM_THEME') ) define('SCM_THEME', $controlador['theme'].'/');
require_once APP_PATH_ABS.SCM_PATH_THEME.APP_THEME.'settings.php'; 
 

if (method_exists($controlador['controller'],$controlador['action'])) {
    call_user_func(array(new $controlador['controller'], $controlador['action']), $controlador['param']);
} else {

    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
            $controlador['controller'] .
            '->' .
            $controlador['action'] .
            '</i> no existe</h1></body></html>'; 
}
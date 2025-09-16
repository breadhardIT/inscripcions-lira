<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of querys
 *
 * @author 0001553
 */


/***************************/
/**** CÀRREGA DE COMBOS ****/
/***************************/

/*LLISTA DE CONTROLS DE PAS*/
$query = "SELECT tcontroldepas_id AS id,tcontroldepas_descripcio AS txt 
          FROM INSCRIPCIONS_CONTROLDEPAS
          WHERE tcontroldepas_idEsdeveniment = '%search1%'
          ORDER BY tcontroldepas_ordre ASC";
if ( !defined('COMBO_CONTROLSDEPAS') ) define('COMBO_CONTROLSDEPAS', $query);

  


?>
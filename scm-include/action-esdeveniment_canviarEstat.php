<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// càrrega del model i els control·ladors
require_once '../config.php';
require_once '../settings.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'model/db.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-esdeveniment.php';

$idEsdeveniment = $_REQUEST['id'];	
$estat = $_REQUEST['estat'];	
		
if (isset($idEsdeveniment)){
    $esdeveniment = New Esdeveniment($idEsdeveniment);
    $esdeveniment->canviarEstat($estat);
}

?>

<script type="text/javascript">
    window.location="<?PHP echo SCM_FORM_ROOT. 'index.php?ctl=g_esdevenimentsLlistat';?>"
</script>
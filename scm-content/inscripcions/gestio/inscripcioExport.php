<?php 

    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';
    ob_start();


/* captura de paràmetres enviats per post */
$idEsdeveniment = $_REQUEST['esdeveniment'];
$sortfield = $_POST['__sf']; if ($sortfield == '') $sortfield = 'tinscripcio_dorsal';       
$sortorder = $_POST['__so']; if ($sortorder == '') $sortorder = 'asc';

/* query */
$query = "SELECT  tinscripcio_id, tinscripcio_idFormulari,  UPPER(dni) as dni, UPPER(nom) as nom, UPPER(cognoms) as cognoms,  naixement, mail, entitat, sexe, telefon, federacio, llicencia, tipusllicencia, ";
$query .= "tinscripcio_clau, tinscripcio_dorsal, tinscripcio_origen, tinscripcio_soci, tinscripcio_feec, tinscripcio_autocar, ";
$query .= "tinscripcio_preu, tinscripcio_pagat, tinscripcio_incidencia, tinscripcio_observacions, gmlira_inscripcions.data as data ";
$query .= "FROM gmlira_inscripcions, gmlira_participants " ;
$query .= "WHERE tinscripcio_idFormulari = '" .$idEsdeveniment. "' ";		
$query .= "AND tinscripcio_idPersona = id ";
$resultats =  DB::query($query)->get();

/* construcció del Datagrid*/
DataGrid::getInstance($resultats)    
        
->setGridFields(array(
    'dni' => array('header' => 'DNI', 'attributes' => array('width'=>'8%', 'text-align'=>'center')),
    'nom' => array('header' => 'Nom', 'attributes' => array('width'=>'15%', 'text-align'=>'left')),
    'cognoms' => array('header' => 'Cognoms', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'naixement' => array('header' => 'Data naixement', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'mail' => array('header' => 'e-mail', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'entitat' =>  array('header' => 'Entitat', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'sexe' => array('header' => 'Sexe', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'telefon' =>  array('header' => 'Telèfon', 'attributes' => array('width'=>'8%', 'text-align'=>'center')),
    'federacio' =>  array('header' => 'Federació', 'attributes' => array('width'=>'10%', 'text-align'=>'center')),
    'llicencia' =>  array('header' => 'Llicència', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tipusllicencia' =>  array('header' => 'Tipus de llicència', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_clau' =>  array('header' => 'Clau Inscripcio', 'attributes' => array('width'=>'10%', 'text-align'=>'left')),
    'tinscripcio_dorsal' => array('header' => 'Dorsal', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_origen' => array('header' => 'Origen', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_soci' => array('header' => 'Soci', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_feec' => array('header' => 'FEEC', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_autocar' => array('header' => 'Autocar', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_preu' => array('header' => 'Preu', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_pagat' => array('header' => 'Pagat', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_incidencia' => array('header' => 'Incidencia', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_observacions' =>  array('header' => 'Observacions', 'attributes' => array('width'=>'10%', 'text-align'=>'left')),
    'data' => array('header' => 'Data', 'attributes' => array('width'=>'5%', 'text-align'=>'center'))
))

->enableSorting(true)        
->setGridSorting($sortField, $sortOrder) 
->renderDataExport(); 
?>
                
<?php $contenido = ob_get_clean() ?>
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME. 'templates/exportLayout.php'  // plantilla general de la pàgina ?>                
<?php 

    global $CONFIG;

    ob_start();     

?>

<?PHP

/* captura de paràmetres enviats per post */
$idEsdeveniment = $_REQUEST['esdeveniment'];

/* query */
$query = "SELECT  nom, cognoms, dni, entitat, sexe, federacio, llicencia, tipusllicencia, tresultats_temps, tinscripcio_dorsal ";
$query .= "FROM gmlira_participants, gmlira_inscripcions, gmlira_resultats "; 
$query .= "WHERE id = tinscripcio_idPersona ";
$query .= "AND tinscripcio_id = tresultats_idInscripcio ";
$query .= "AND tinscripcio_idFormulari = '" .$idEsdeveniment. "' ";		


/* construcció del Datagrid*/
DataExport::getInstance($query)    
->setGridAttributes(array('border' => '0'))     
        
->setGridFields(array(
    'dni' => array('header' => 'DNI', 'attributes' => array('width'=>'8%', 'text-align'=>'center')),
    'nom' => array('header' => 'Nom', 'attributes' => array('width'=>'15%', 'text-align'=>'left')),
    'cognoms' => array('header' => 'Cognoms', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'entitat' =>  array('header' => 'Entitat', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'sexe' => array('header' => 'Sexe', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'federacio' =>  array('header' => 'Federació', 'attributes' => array('width'=>'10%', 'text-align'=>'center')),
    'llicencia' =>  array('header' => 'Llicència', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tipusllicencia' =>  array('header' => 'Tipus de llicència', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'tinscripcio_dorsal' =>  array('header' => 'Dorsal', 'attributes' => array('width'=>'10%', 'text-align'=>'left')),
    'tresultats_temps' =>  array('header' => 'Temps', 'attributes' => array('width'=>'10%', 'text-align'=>'left'))
))

->enableSorting(true)        
->setGridSort($sortField, $sortOrder, 'tresultats_temps') 
->getData()

->setRowClass('separadorLineaH mayuscules')
->setAlterRowClass('separadorLineaH mayuscules')
->render(); 
?>
                
<?php $contenido = ob_get_clean() ?>
<?php include $CONFIG['theme_dir']. 'templates/exportLayout.php'  // plantilla general de la pàgina ?>                
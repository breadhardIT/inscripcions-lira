<?php 

    global $CONFIG;
    global $model;

    ob_start(); 
    
    print('<link href="'.$CONFIG['theme_dir'].'css/formulari.css" rel="stylesheet" type="text/css" /> ');
    print('<link href="'.$CONFIG['theme_dir'].'css/llistats.css" rel="stylesheet" type="text/css" /> ');   
    print('<script type="text/javascript" src="scm-include/js/general.js"></script>');

?>

<style type="text/css">
.fdg_sortable {cursor:pointer;text-decoration:underline;color:#00c;}
</style>

<?PHP

/* funcions personalitzades per aplicar a una determinada cel·la*/


/* captura de paràmetres enviats per post */
$idEsdeveniment = $_REQUEST['esdeveniment'];
$sortField = $_POST['__sf'];
$sortOrder = $_POST['__so'];
$search1 = $_POST['__s1'];
$search2 = $_POST['__s2'];
$search3 = $_POST['__s3'];
$search4 = $_POST['__s4'];
$navigationPage = $_POST['__np'];

/* query */
$query = "SELECT  tinscripcio_id, tinscripcio_idFormulari,  tinscripcio_dorsal, nom, cognoms, entitat, sexe,  ";
$query .= "tresultats_temps, tresultats_numcontrol  ";
$query .= "FROM gmlira_inscripcions, gmlira_participants, gmlira_resultats " ;
$query .= "WHERE tinscripcio_idFormulari = '" .$idEsdeveniment. "' ";		
$query .= "AND tinscripcio_idPersona = id ";
$query .= "AND tinscripcio_id = tresultats_idInscripcio ";
$query .= "AND tresultats_numcontrol = 99 ";

/* accions de fila aplicables a cada registre */


/* construcció del Datagrid*/
DataGrid::getInstance($query)    
->setGridAttributes(array('border' => '0'))

->enableSearch(true)
->setGridSearch(array(
    '__s1' => array('id'=> 'nom', 'name' => 'Nom', 'value' => $search1),
    '__s2' => array('id'=> 'cognoms', 'name' => 'Cognoms', 'value' => $search2),
    '__s3' => array('id'=> 'sexe', 'name' => 'Sexe', 'value' => $search3),    
    '__s4' => array('id'=> 'entitat', 'name' => 'Entitat', 'value' => $search4)        
))
->setNumberColumnsSearch(2)

->setGridFields(array(
    'tresultats_posicio' => array('header' => 'General', 'class' => 'centro'),    
    'nom' => array('header' => 'Nom', 'class' => 'izquierda'),
    'cognoms' => array('header' => 'Cognoms', 'class' => 'izquierda'),     
    'entitat' => array('header' => 'Entitat', 'class' => 'izquierda'),    
    'tinscripcio_dorsal' => array('header' => 'Dorsal', 'class' => 'centro'),        
    'sexe' => array('header' => 'Sexe', 'class' => 'centro'),            
    'tresultats_temps' => array('header' => 'Temps', 'class' => 'centro')
))

->enableSorting(true)        
->setGridSort($sortField,$sortOrder, 'tresultats_temps') 
->enableNavigation(true)
->setGridNavigation($navigationPage, 15)

->setStartingCounter(0)
->addColumnAfter('contador', '%counter%', 'Classif.', array('class' => 'centro'))
        
->getData()        
        
->setRowAttributes(array('onmouseover' => "this.className = 'resaltar'", 'onmouseout' => 'this.className = null'))
->setRowClass('separadorLineaH mayuscules')
->setAlterRowClass('separadorLineaH mayuscules')
->render(); 
?>        
        
  
<?php $contenido = ob_get_clean(); ?>   
<?php include $CONFIG['theme_dir']. 'templates/formLayout.php'; // plantilla general de la pàgina ?>            


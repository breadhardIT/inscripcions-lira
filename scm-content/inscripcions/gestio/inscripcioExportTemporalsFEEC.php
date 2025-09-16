<?php 

    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';
    ob_start();


/* captura de paràmetres enviats per post */
$idEsdeveniment = $_REQUEST['esdeveniment'];
$sortfield = $_POST['__sf']; if ($sortfield == '') $sortfield = 'tinscripcio_dorsal';       
$sortorder = $_POST['__so']; if ($sortorder == '') $sortorder = 'asc';

/* query */
$query = "SELECT  UPPER(nom) as nom, UPPER(cognoms) as cognoms, UPPER(dni) as dni,'' as temp1,'' as temp2, date_format(naixement, '%d-%m-%Y') as naixement, case sexe when 'M' then 'SXMAS' when 'F' then 'SXFEM' else '' END as sexe, mail, telefon, '2813' as temp3 ";
$query .= "FROM gmlira_inscripcions, gmlira_participants " ;
$query .= "WHERE tinscripcio_idFormulari = '" .$idEsdeveniment. "' ";		
$query .= "AND tinscripcio_idPersona = id ";
$query .= "AND tinscripcio_feec <> 'S' ";
$resultats =  DB::query($query)->get();

/* construcció del Datagrid*/
DataGrid::getInstance($resultats)    
        
->setGridFields(array(
    'nom' => array('header' => 'Nom', 'attributes' => array('width'=>'15%', 'text-align'=>'left')),
    'cognoms' => array('header' => 'Cognoms', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'dni' => array('header' => 'DNI', 'attributes' => array('width'=>'8%', 'text-align'=>'center')),
	'temp1' => array('header' => 'temp1', 'attributes' => array('width'=>'8%', 'text-align'=>'center')),
	'temp2' => array('header' => 'temp2', 'attributes' => array('width'=>'8%', 'text-align'=>'center')),
    'naixement' => array('header' => 'Data naixement', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'sexe' => array('header' => 'Sexe', 'attributes' => array('width'=>'5%', 'text-align'=>'center')),
    'mail' => array('header' => 'e-mail', 'attributes' => array('width'=>'25%', 'text-align'=>'left')),
    'telefon' =>  array('header' => 'Telèfon', 'attributes' => array('width'=>'8%', 'text-align'=>'center')),
    'temp3' => array('header' => 'temp3', 'attributes' => array('width'=>'5%', 'text-align'=>'center'))
))

->enableSorting(true)        
->setGridSorting($sortField, $sortOrder) 
->renderDataExport(); 
?>
                
<?php $contenido = ob_get_clean() ?>
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME. 'templates/exportLayout.php'  // plantilla general de la pàgina ?>                
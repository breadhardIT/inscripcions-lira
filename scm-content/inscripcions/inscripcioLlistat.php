
﻿<?php 
    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';

    ob_start();   

    /* captura de paràmetres enviats per post */
    $idEsdeveniment = $_REQUEST['esdeveniment'];
    $search1 = $_POST['__s1'];
    $search2 = $_POST['__s2'];
    $navigationPage = $_POST['__np'];
    $sortfield = $_POST['__sf']; if ($sortfield == '') $sortfield = 'nom';       
    $sortorder = $_POST['__so']; if ($sortorder == '') $sortorder = 'asc';

    $gridSearch = (array(
        '__s1' => array('id'=> 'nom', 'name' => 'Nom', 'value' => $search1),
        '__s2' => array('id'=> 'cognoms', 'name' => 'Cognoms', 'value' => $search2)
    ));

    /* query */
    $query = "SELECT  tinscripcio_id, tinscripcio_idFormulari,  tinscripcio_dorsal, nom, cognoms, entitat,  tinscripcio_pagat,  ";
    $query .= "tinscripcio_incidencia, concat(tinscripcio_pagat,'-',tinscripcio_clau) AS accio_pagar ";
    $query .= "FROM gmlira_inscripcions, gmlira_participants " ;
    $query .= "WHERE tinscripcio_idFormulari = '" .$idEsdeveniment. "' ";		
    $query .= "AND tinscripcio_idPersona = id ";    
    if (isset($gridSearch)) {
            foreach($gridSearch as $search) {
                if ($search['value'] <> '')
                    $query .= " AND " .$search['id'] . "='" .$search['value']. "'";
            }            
    }
    
    if ($sortfield <> '') { $sortquery = ' ORDER BY ' .$sortfield. ' ' .$sortorder;}
    else { $sortquery = ' ORDER BY nom, cognoms';}
        
    $totalRegistros = count(DB::query($query)->get());        
    $inici = Datagrid::getGridNavigationLimits($navigationPage, GRID_PAGINATION_ROWS);        
    $resultats =  DB::query($query.$sortquery." LIMIT ".$inici.", ".GRID_PAGINATION_ROWS)->get();




/* funcions personalitzades per aplicar a una determinada cel·la*/
function pagat($valor){
    if ($valor == 'S') { return "Inscrit";}
    else { return "Preinscrit";}        
}

function incidencia($valor){
    if ($valor == 'S') { return "Incidència";}
    else { return "";}        
}

function accio_pagar($valor){

    $idEsdeveniment = $_REQUEST['esdeveniment'];
    $parametres = explode("-", $valor);
    $url = '<a href="index.php?ctl=inscripcioConfirm&id='.$idEsdeveniment.'&clau='.$parametres[1].'"  title="Modificar inscripci&oacute;"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/money_euro.png" class="imgnoborder" title="clica aquí per pagar ara online"></a>&nbsp;';
    if ($parametres[0] == 'S') { return "";}
    else { return $url;}        
}
?>

        

<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/table.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/form.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/AdminLTE.css">    

<script type="text/javascript" src="<?php echo APP_PATH_INCLUDE; ?>js/general.js"></script>

<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->    
            <div class="box-body">
              <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

<?php                  

/* construcció del Datagrid*/
DataGrid::getInstance($resultats)    
->enableSearch(true)
->setGridSearch($gridSearch)               
->setGridFields(array(
    'tinscripcio_dorsal' => array('header' => 'Dorsal', 'class' => 'centro'),        
    'nom' => array('header' => 'Nom', 'class' => 'izquierda'),
    'cognoms' => array('header' => 'Cognoms', 'class' => 'izquierda'),     
    'entitat' => array('header' => 'Entitat', 'class' => 'izquierda'),        
    'tinscripcio_pagat' => array('header' => 'Estat', 'cellTemplate' => '[[pagat:%data%]]', 'class' => 'centro'),
    'tinscripcio_incidencia' => array('header' => 'Incidencia', 'cellTemplate' => '[[incidencia:%data%]]', 'class' => 'centro'),    
    'accio_pagar' => array('header' => 'Accions', 'cellTemplate' => '[[accio_pagar:%data%]]', 'class' => 'centro')
))     
        
->enableNavigation(true)       
->setGridNavigation($navigationPage,GRID_PAGINATION_ROWS, $totalRegistros)
->enableSorting(true)
->setGridSorting($sortfield, $sortorder)       
->renderDataGrid(); 
?>                  
                  
              </div>
            </div>     
          </div>
        </div>
      </div>          
    </section>                  
<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME.'templates/tableLayout.php'; // plantilla general de la pàgina ?>            


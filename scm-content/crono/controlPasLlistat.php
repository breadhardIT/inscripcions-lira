<style type="text/css">
.fdg_sortable {cursor:pointer;text-decoration:underline;color:#00c;}
</style>

<?PHP
ob_start();    

require_once APP_PATH_ABS.APP_PATH_INCLUDE.SCM_CRONO.'class/class-datagrid.php';

/* funcions personalitzades per aplicar a una determinada cel·la*/


/* captura de paràmetres enviats per post */
$sortField = $_POST['__sf'];
$sortOrder = $_POST['__so'];
$navigationPage = $_POST['__np'];

$search1 = $_POST['__s1'];
$search2 = $_POST['__s2'];
$search3 = $_POST['__s3'];
$gridSearch = (array(
    '__s1' => array('id'=> 'tsolicitud_dorsal', 'name' => 'Dorsal', 'value' => $search1),
    '__s2' => array('id'=> 'tparticipants_nom', 'name' => 'Nom', 'value' => $search2),
    '__s3' => array('id'=> 'tparticipants_cognoms', 'name' => 'Cognoms', 'value' => $search3)
));

/* query */
$query = "SELECT DISTINCT ic.tcrono_idInscripcio, tsolicitud_dorsal, tparticipants_nom, tparticipants_cognoms, 
    DATE_FORMAT(ic1.tcrono_data, '%H:%i:%S' ) as r1, 
    DATE_FORMAT(ic2.tcrono_data, '%H:%i:%S' ) as r2, 
    DATE_FORMAT(ic3.tcrono_data, '%H:%i:%S' ) as r3, 
    DATE_FORMAT(ic4.tcrono_data, '%H:%i:%S' ) as r4, 
    DATE_FORMAT(ic5.tcrono_data, '%H:%i:%S' ) as r5, 
    DATE_FORMAT(ic6.tcrono_data, '%H:%i:%S' ) as r6, 
    DATE_FORMAT(ic7.tcrono_data, '%H:%i:%S' ) as r7, 
    DATE_FORMAT(ic8.tcrono_data, '%H:%i:%S' ) as r8, 
    DATE_FORMAT(ic9.tcrono_data, '%H:%i:%S' ) as r9, 
    DATE_FORMAT(ic10.tcrono_data, '%H:%i:%S' ) as r10, 
    DATE_FORMAT(ic11.tcrono_data, '%H:%i:%S' ) as r11, 
    DATE_FORMAT(ic12.tcrono_data, '%H:%i:%S' ) as r12,
    DATE_FORMAT(TIMEDIFF(ic12.tcrono_data, ic1.tcrono_data), '%H:%i:%S' ) as time,
    CASE
        WHEN ic13.tcrono_baixa IS NOT NULL then ic13.tcrono_baixa 
        WHEN ic13.tcrono_baixa IS NULL then 'N' 
    END as tcrono_baixa
FROM INSCRIPCIONS_CRONO ic
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 1 ) ic1 on ic1.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 2 ) ic2 on ic2.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 3 ) ic3 on ic3.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 4 ) ic4 on ic4.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 5 ) ic5 on ic5.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 6 ) ic6 on ic6.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 7 ) ic7 on ic7.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 8 ) ic8 on ic8.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 9 ) ic9 on ic9.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 10 ) ic10 on ic10.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 11 ) ic11 on ic11.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_data` FROM INSCRIPCIONS_CRONO WHERE tcrono_numcontrol = 12 ) ic12 on ic12.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio`
left join (SELECT `tcrono_idInscripcio`,`tcrono_baixa` FROM INSCRIPCIONS_CRONO WHERE tcrono_baixa = 'S' ) ic13 on ic13.`tcrono_idInscripcio` = ic.`tcrono_idInscripcio` 
JOIN INSCRIPCIONS_SOLICITUDS ON ic.tcrono_idInscripcio = tsolicitud_id
JOIN INSCRIPCIONS_PARTICIPANTS ON tsolicitud_idParticipant = tparticipants_id
where tsolicitud_idEsdeveniment = '" .$esdeveniment->getId(). "'";

if (isset($gridSearch)) {
    foreach($gridSearch as $search) {
        if ($search['value'] <> '')
            $query .= " AND " .$search['id'] . "='" .$search['value']. "'";
        }            
}

//echo $query;

$totalRegistros = count(DB::query($query)->get());        
$inici = Datagrid::getGridNavigationLimits($navigationPage, GRID_PAGINATION_ROWS);
$resultats =  DB::query($query.$sortquery." LIMIT ".$inici.", ".GRID_PAGINATION_ROWS)->get();

function estat($valor){
    $str = ($valor == 'S') ? '<p class="text-red"><img src="'.APP_PATH.APP_PATH_THEME.APP_THEME.'/img/action_prohibit.png" width="20px"></p>' : '<p class="text-green"><img src="'.APP_PATH.APP_PATH_THEME.APP_THEME.'/img/action_ok.png" width="20px">';
    return $str;
}

/* construcció del Datagrid*/
$datagrid = DataGrid::getInstance($resultats);

$datagrid->setGridFields(array(
    'tparticipants_nom' => array('header' => 'Nom', 'class' => 'izquierda'),
    'tparticipants_cognoms' => array('header' => 'Cognoms', 'class' => 'izquierda'),     
    'tsolicitud_dorsal' => array('header' => 'Dorsal', 'class' => 'izquierda'),        
    'r1' => array('header' => 'C1', 'class' => 'centro'),    
    'r2' => array('header' => 'C2', 'class' => 'centro'),        
    'r3' => array('header' => 'C3', 'class' => 'centro'),        
    'r4' => array('header' => 'C4', 'class' => 'centro'),        
    'r5' => array('header' => 'C5', 'class' => 'centro'),        
    'r6' => array('header' => 'C6', 'class' => 'centro'),        
    'r7' => array('header' => 'C7', 'class' => 'centro'),        
    'r8' => array('header' => 'C8', 'class' => 'centro'),        
    'r9' => array('header' => 'C9', 'class' => 'centro'),        
    'r10' => array('header' => 'C10', 'class' => 'centro'),        
    'r11' => array('header' => 'C11', 'class' => 'centro'),        
    'r12' => array('header' => 'C12', 'class' => 'centro'),            
    'time' => array('header' => 'TEMPS', 'class' => 'centro'),                
    'tcrono_baixa' => array('header' => 'Estat', 'class' => 'centro', 'cellTemplate' => '[[estat:%data%]]',)
));

$datagrid->enableSearch(true);
$datagrid->setGridSearch($gridSearch);        
$datagrid->enableNavigation(true);
$datagrid->setGridNavigation($navigationPage, GRID_PAGINATION_ROWS, $totalRegistros);

?>        

<!-- start: CONTAINER-->
<section class="content-header">
    <h1>CONTROL DE PAS<small> Llistat</small></h1>
</section>    
    
<!-- Content Page -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">                    
                <ul class="nav nav-tabs"></ul>  <!-- pestanyes -->
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="box-header box-header-xs">    
                            <h3 class="box-title"></h3>
                        </div>      
                        <div class="box box-primary">
                            <?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'/templates/dataTableLayout.php'; ?>
                        </div>
                    </div> <!-- tab-pane -->   
                </div> <!-- tab-content -->
            </div>  <!-- nav-tabs-custom -->              
        </div>    
</section>
        
  
<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'templates/pageLayout.php'; // plantilla general de la pàgina ?>          



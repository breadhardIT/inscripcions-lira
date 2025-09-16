<?PHP
ob_start();    

require_once APP_PATH_ABS.APP_PATH_INCLUDE.SCM_CRONO.'class/class-datagrid.php';


/* captura de paràmetres enviats per post */
$navigationPage = $_POST['__np'];

/* query */
$query = "SELECT DISTINCT tcrono_idInscripcio, tsolicitud_dorsal, tparticipants_nom, tparticipants_cognoms, 
    tcrono_numcontrol,
    tcontroldepas_descripcio,
    DATE_FORMAT(tcrono_data, '%H:%i:%S' ) as r1, 
    tcrono_baixa
FROM INSCRIPCIONS_CRONO
JOIN INSCRIPCIONS_SOLICITUDS ON tcrono_idInscripcio = tsolicitud_id
JOIN INSCRIPCIONS_PARTICIPANTS ON tsolicitud_idParticipant = tparticipants_id
JOIN INSCRIPCIONS_CONTROLDEPAS ON tcontroldepas_idEsdeveniment = tsolicitud_idEsdeveniment AND tcontroldepas_id = tcrono_numcontrol
where tsolicitud_idEsdeveniment = '" .$esdeveniment->getId(). "'
AND tsolicitud_dorsal = '".$dorsal."'
ORDER BY tcrono_numcontrol ASC";


$totalRegistros = count(DB::query($query)->get());        
$inici = Datagrid::getGridNavigationLimits($navigationPage, GRID_PAGINATION_ROWS);
$resultats =  DB::query($query.$sortquery." LIMIT ".$inici.", ".GRID_PAGINATION_ROWS)->get();

function estat($valor){
    $str = ($valor == 'N') ? '<p class="text-green"><img src="'.APP_PATH.APP_PATH_THEME.APP_THEME.'/img/action_ok.png" width="20px">' : '<p class="text-red"><img src="'.APP_PATH.APP_PATH_THEME.APP_THEME.'/img/action_prohibit.png" width="20px"></p>';
    return $str;
}

/* construcció del Datagrid*/
$datagrid = DataGrid::getInstance($resultats);

$datagrid->setGridFields(array(
    'tcrono_numcontrol' => array('header' => '#', 'class' => 'centro'),            
    'tcontroldepas_descripcio' => array('header' => 'Control', 'class' => 'izquierda'),            
    'r1' => array('header' => 'Hora de pas', 'class' => 'centro'),    
    'tcrono_baixa' => array('header' => 'Estat', 'class' => 'centro', 'cellTemplate' => '[[estat:%data%]]',)
));

$datagrid->enableSearch(false);
$datagrid->enableNavigation(false);
$datagrid->setGridNavigation($navigationPage, GRID_PAGINATION_ROWS, $totalRegistros);

?>        

<!--DataTables -->
<link rel="stylesheet" href="<?php echo APP_PATH.APP_PATH_THEME.APP_THEME ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">  

<!-- start: CONTAINER-->
<section class="content-header">
    <h1><?PHP echo $esdeveniment->getNom(); ?></h1><small>CONTROL DE PAS </small>
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
                            <h3 class="box-title">Dorsal <?PHP echo $dorsal; ?></h3>
                            <h3 class="box-title"><?PHP echo $participant->getNom()." ".$participant->getCognoms(); ?></h3>
                        </div>      
                        <div class="box box-primary">
                            <?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'/templates/mobileDataTableLayout.php'; ?>
                        </div>
                    </div> <!-- tab-pane -->   
                </div> <!-- tab-content -->
            </div>  <!-- nav-tabs-custom -->              
        </div>
        <a href="index.php?ctl=controlPasAdminDorsalBuscar" class="ui-btn ui-icon-search ui-btn-icon-left" style="background-color:#cef0ce;">NOVA CERCA</a>
        <div class="ui-grid-a">
            <div class="ui-block-a"><a id="telf_emergencies" href="tel:+34638404189" class="ui-shadow ui-btn ui-corner-all ui-icon-phone ui-btn-icon-top" style="background-color:#EE0000; color:#f9fafc;">CONTROL<BR>CENTRAL</a></div>                        
            <div class="ui-block-b"><a id="registre" href="index.php?ctl=controlPasAdmin" class="ui-shadow ui-btn ui-corner-all ui-icon-home ui-btn-icon-top">MENÚ<BR> PRINCIPAL</a></div>
        </div>        
</section>
        
  
<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'templates/mobileLayoutAdmin.php'; // plantilla general de la pàgina ?>          



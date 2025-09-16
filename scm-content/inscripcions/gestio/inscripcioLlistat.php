<?php 

    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';

    ob_start();   


/* captura de paràmetres enviats per post */
$idEsdeveniment = $_REQUEST['esdeveniment'];
$search1 = $_POST['__s1'];
$search2 = $_POST['__s2'];
$search3 = $_POST['__s3'];
$search4 = $_POST['__s4'];
$search5 = $_POST['__s5'];
$search6 = $_POST['__s6'];
$navigationPage = $_POST['__np'];
$sortfield = $_POST['__sf']; if ($sortfield == '') $sortfield = 'nom';       
$sortorder = $_POST['__so']; if ($sortorder == '') $sortorder = 'asc';
    
$gridSearch = (array(
    '__s1' => array('id'=> 'nom', 'name' => 'Nom', 'value' => $search1),
    '__s2' => array('id'=> 'cognoms', 'name' => 'Cognoms', 'value' => $search2),
    '__s3' => array('id'=> 'dni', 'name' => 'DNI', 'value' => $search3),
    '__s4' => array('id'=> 'tinscripcio_origen', 'name' => 'Origen', 'value' => $search4),
    '__s5' => array('id'=> 'tinscripcio_dorsal', 'name' => 'Dorsal', 'value' => $search5),
    '__s6' => array('id'=> 'tinscripcio_clau', 'name' => 'Clau', 'value' => $search6)
));
        
/* query */
$query = "SELECT  tinscripcio_id, tinscripcio_idFormulari,  dni, tinscripcio_dorsal, nom, cognoms, ";
$query .= "tinscripcio_origen, tinscripcio_soci, tinscripcio_feec, tinscripcio_autocar, tinscripcio_preu, tinscripcio_pagat,  ";
$query .= "tinscripcio_clau, gmlira_inscripcions.data as data, tinscripcio_incidencia, tinscripcio_id AS INSCRIPCIO_ID, entitat  ";
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
    global $CONFIG;    
    if ($valor == 'S') { return ('<img src="'.SCM_PATH_THEME.SCM_THEME.'images/tick.png" class="imgnoborder">');}
    else { return '<img src="'.SCM_PATH_THEME.SCM_THEME.'images/error.png" class="imgnoborder">';}
}

function incidencia($valor){
    global $CONFIG;
    
    if ($valor == 'S') { return '<img src="'.SCM_PATH_THEME.SCM_THEME.'images/exclamation.png" class="imgnoborder">';}
    else { return '';}        
}
?>

<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/table.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/form.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/AdminLTE.css">
<script type="text/javascript" src="<?php echo APP_PATH_INCLUDE; ?>js/general.js"></script>

<script language="javascript">
	function Eliminar(id) {
		if (window.confirm("¿Estàs segur que vols eliminar el registre seleccionat?")) {
	   	   location.href = "index.php?ctl=inscripcioEliminar&id=" + id;
		}
	}
	function Pagat(id) {
		if (window.confirm("¿Estàs segur que vols marcar el registre seleccionat com a pagat?")) {
	   	   location.href = "index.php?ctl=inscripcioPagar&id=" + id;
		}
	}
	function Dorsal(id) {
		if (window.confirm("¿Estàs segur que vols marcar el registre seleccionat conforme has entregat el dorsal al participant?")) {
	   	   location.href = "source/gestio/actionInscripcioRecepcioDorsal.php?id=" + id;
		}
	}	
</script>	

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

/* accions de fila aplicables a cada registre */
$rowActions .=  '<a href="index.php?ctl=g_inscripcioForm&modo=modi&esdeveniment='.$idEsdeveniment.'&id=$INSCRIPCIO_ID$"  title="Modificar inscripci&oacute;"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/page_white_edit.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href=javascript:Pagat("$INSCRIPCIO_ID$");  title="Marcar com a pagat i notificar per mail al participant"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/money_euro.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href=javascript:Dorsal("$INSCRIPCIO_ID$");  title="Marcar com a dorsal entregat"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/sortida.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href=javascript:obrirDadesProva("$INSCRIPCIO_ID$");  title="Informar arribada o baixa"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/award.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href=javascript:Eliminar("$INSCRIPCIO_ID$");  title="Eliminar inscripci&oacute;"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/bin.png" class="imgnoborder"></a>';


/* construcció del Datagrid*/
DataGrid::getInstance($resultats)   
->enableSearch(true)
->setGridSearch($gridSearch)                                                            
           
->setGridFields(array(
    'dni' => array('header' => 'DNI', 'class' => 'centro'),        
    'tinscripcio_dorsal' => array('header' => 'Dorsal', 'class' => 'centro', 'sortable' => 'si'),    
    'nom' => array('header' => 'Nom', 'class' => 'izquierda', 'sortable' => 'si'),
    'cognoms' => array('header' => 'Cognoms', 'class' => 'izquierda', 'sortable' => 'si'),
    'tinscripcio_origen' => array('header' => 'Origen', 'attributes' => array('width'=>'5%'), 'class' => 'centro'),    
    'tinscripcio_soci' => array('header' => 'Soci', 'attributes' => array('width'=>'5%'), 'class' => 'centro'),
    'tinscripcio_feec' => array('header' => 'FEEC', 'attributes' => array('width'=>'5%'), 'class' => 'centro'),   
    'tinscripcio_autocar' => array('header' => 'Autocar', 'attributes' => array('width'=>'5%'), 'class' => 'centro'),       
    'tinscripcio_preu' => array('header' => 'Preu', 'attributes' => array('width'=>'5%'), 'class' => 'centro'),         
    'tinscripcio_pagat' => array('header' => 'Estat', 'cellTemplate' => '[[pagat:%data%]]', 'class' => 'centro', 'sortable' => 'si'),
    'tinscripcio_clau' => array('header' => 'Clau', 'attributes' => array('width'=>'5%'), 'class' => 'centro', 'sortable' => 'si'),         
    'data' => array('header' => 'Data', 'class' => 'centro', 'sortable' => 'si'),    
    'tinscripcio_incidencia' => array('header' => 'Incidencia', 'cellTemplate' => '[[incidencia:%data%]]', 'class' => 'centro')    
))
->addColumnAfter('INSCRIPCIO_ID',$rowActions , 'Accions', array('align' => 'center'))        
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

                
<?php $contenido = ob_get_clean() ?>
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME. 'templates/gestioLayout.php'  // plantilla general de la pàgina ?>                
<?php 

    require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-datagrid.php';
    
    ob_start(); 

    $navigationPage = $_POST['__np'];
    
    $query = "SELECT tesdeveniments_logo, concat(tesdeveniments_nom,'**',tesdeveniments_id) as nom, tesdeveniments_texte, ";
    $query .= "tesdeveniments_estat, concat(tesdeveniments_id,'-',tesdeveniments_estat) as activar, concat(tesdeveniments_id,'-',tesdeveniments_publicat) as publicar, tesdeveniments_id as ACCIONS_ID ";
    $query .= "FROM gmlira_esdeveniments ";
	$sortquery = "ORDER BY tesdeveniments_edicio DESC";
        
    $totalRegistros = count(DB::query($query)->get());        
    $inici = Datagrid::getGridNavigationLimits($navigationPage, GRID_PAGINATION_ROWS);        
    $resultats =  DB::query($query.$sortquery." LIMIT ".$inici.", ".GRID_PAGINATION_ROWS)->get();   

    /* funcions personalitzades per aplicar a una determinada cel·la*/
    function logo($valor){
        if ($valor <> '') return '<img src="'.SCM_PATH_THEME.SCM_THEME.'images/'.$valor.'" class="imgnoborder" style="width:100px;">';
        else return '';
    }
    function nom($valor){
        $parametres = explode("**", $valor);
        return '<a href="index.php?ctl=g_inscripcioLlistat&esdeveniment='.$parametres[1].'")>'.$parametres[0].'</a>';
    }
    function estat($valor){
        $img = ($valor == '0' ? 'bullet_red.png' : 'bullet_green.png' );
        return '<img src="'.SCM_PATH_THEME.SCM_THEME.'images/'.$img.'" class="imgnoborder">';
    }
    function activar($valor){    
    
        $parametres = explode("-", $valor);
        $img = ($parametres[1] == '0' ? 'key.png' : 'lock.png' );
        $title = ($parametres[1] == '0' ? 'Obrir' : 'Tancar' );
               
        $txt = '<a href=javascript:Activar("' . $parametres[0] . '","'.$parametres[1].'");>';
        $txt .= "<img src='".SCM_PATH_THEME.SCM_THEME."images/".$img."' class='imgnoborder' title='".$title." inscripcions esdeveniment'></a>";       

	return $txt;
    }    
    function publicar($valor){    
        
        $parametres = explode("-", $valor);
        $img = ($parametres[1] == 'S' ? 'layout_delete.png' : 'layout.png' );
        $title = ($parametres[1] == 'S' ? 'Ocultar' : 'Publicar' );        
               
        $txt = '<a href=javascript:Publicar("' . $parametres[0] . '","'.$parametres[1].'");>';
        $txt .= "<img src='".SCM_PATH_THEME.SCM_THEME."images/".$img."' class='imgnoborder' title='".$title." inscripcions esdeveniment'></a>";       

	return $txt;
    }
?>

<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/table.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/form.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/AdminLTE.css">
<script type="text/javascript" src="<?php echo APP_PATH_INCLUDE; ?>js/general.js"></script>

<script language="javascript">
function Activar(id, estat) {
	if (window.confirm("Estàs segur que vols modificar l'estat de l'esdeveniment?")) {
   	   location.href = "scm-include/action-esdeveniment_canviarEstat.php?id=" + id + "&estat=" + estat;
	}
}

function Publicar(id, estat) {
	if (window.confirm("Estàs segur que vols publicar l'esdeveniment?")) {
   	   location.href = "scm-include/action-esdeveniment_canviarPublicacio.php?id=" + id + "&estat=" + estat;
	}
}
</script>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>  <!-- /.box-header -->    
                <div class="box-body">
                <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

<?php 
/* accions de fila aplicables a cada registre */
$rowActions .=  '<a href="index.php?ctl=g_inscripcioExport&esdeveniment=$ACCIO_ID$"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/page_excel.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href="index.php?ctl=g_inscripcioExportTempFEEC&esdeveniment=$ACCIO_ID$"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/feec.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href="index.php?ctl=g_esdevenimentsCrono&esdeveniment=$ACCIO_ID$"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/sortida.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href="index.php?ctl=g_esdevenimentsControlPasLlistat&esdeveniment=$ACCIO_ID$"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/walk.png" class="imgnoborder"></a>&nbsp;';
$rowActions .=  '<a href="index.php?ctl=g_esdevenimentsResultatExport&esdeveniment=$ACCIO_ID$"><img src="'.SCM_PATH_THEME.SCM_THEME.'images/flag_finish.png" class="imgnoborder"></a>&nbsp;';

/* construcció del Datagrid*/
DataGrid::getInstance($resultats)   
->setGridFields(array(
    'tesdeveniments_logo' => array('header' => '', 'cellTemplate' => '[[logo:%data%]]', 'class' => 'centro'),        
    'nom' => array('header' => 'Prova', 'cellTemplate' => '[[nom:%data%]]','class' => 'izquierda'),    
    'tesdeveniments_texte' => array('header' => 'Observ', 'class' => 'izquierda'),    
    'tesdeveniments_estat' => array('header' => 'Estat', 'cellTemplate' => '[[estat:%data%]]', 'class' => 'centro'),
    'activar' => array('header' => 'Activar', 'cellTemplate' => '[[activar:%data%]]', 'class' => 'centro'),        
    'publicar' => array('header' => 'Publicar', 'cellTemplate' => '[[publicar:%data%]]', 'class' => 'centro')
))
->addColumnAfter('ACCIONS_ID',$rowActions , 'Accions', array('align' => 'center'))        
->enableNavigation(true)       
->setGridNavigation($navigationPage,GRID_PAGINATION_ROWS, $totalRegistros)
->renderDataGrid(); 
?>                  
                  
              </div>
            </div>     
          </div>
        </div>
      </div>          
    </section>
                  

                                            
<?php
/*
<img src='".SCM_PATH_THEME.SCM_THEME."images/page_white_edit.png' class='imgnoborder'></a>"

 <a href='index.php?ctl=g_esdevenimentsExport&esdeveniment=" .$resultado->tesdeveniments_id."'>                                                        
 
<img src='".SCM_PATH_THEME.SCM_THEME."images/page_excel.png' class='imgnoborder' title='exportar les dades inscripcions'></a>
*/
                                                        
?>

                            
<?php $contenido = ob_get_clean() ?>
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME. 'templates/gestioLayout.php'  // plantilla general de la pàgina ?>

<style type="text/css">
.fdg_sortable {cursor:pointer;text-decoration:underline;color:#00c;}
</style>

<?PHP
ob_start();    

require_once APP_PATH_ABS.APP_PATH_INCLUDE.SCM_CRONO.'class/class-datagrid.php';

/* query */
$query = "
    SELECT  tsolicitud_dorsal as dorsal, 
            ic.tcrono_numcontrol,
            DATE_FORMAT(ic.tcrono_data, '%H:%i:%S' ) as r1, 
            ic.tcrono_baixa as estat
    FROM INSCRIPCIONS_CRONO ic JOIN INSCRIPCIONS_SOLICITUDS ON ic.tcrono_idInscripcio = tsolicitud_id
    WHERE tsolicitud_idEsdeveniment = ".$esdeveniment->getId()." 
    AND ic.tcrono_numcontrol = " .$control_pas->getId(). "

    UNION

    SELECT  tsolicitud_dorsal as dorsal, 
            ic.tcrono_numcontrol,
            DATE_FORMAT(ic.tcrono_data, '%H:%i:%S' ) as r1, 
            ic.tcrono_baixa as estat
    FROM INSCRIPCIONS_CRONO ic JOIN INSCRIPCIONS_SOLICITUDS ON ic.tcrono_idInscripcio = tsolicitud_id
    WHERE tsolicitud_idEsdeveniment = ".$esdeveniment->getId()." 
    AND ic.tcrono_numcontrol < " .$control_pas->getId(). "
    AND ic.tcrono_baixa = 'S'    

    ORDER BY dorsal ASC";
$resultats =  DB::query($query)->get();

// COMPTADORS
$query = "
    SELECT  count(tsolicitud_dorsal) as total
    FROM INSCRIPCIONS_CRONO ic JOIN INSCRIPCIONS_SOLICITUDS ON ic.tcrono_idInscripcio = tsolicitud_id
    WHERE tsolicitud_idEsdeveniment = ".$esdeveniment->getId()." 
    AND ic.tcrono_numcontrol = " .$control_pas->getId()." 
    AND ic.tcrono_baixa <> 'S'";
$total_avançats =  DB::query($query)->getFirst();

$query = "
    SELECT  count(tsolicitud_dorsal) as total
    FROM INSCRIPCIONS_CRONO ic JOIN INSCRIPCIONS_SOLICITUDS ON ic.tcrono_idInscripcio = tsolicitud_id
    WHERE tsolicitud_idEsdeveniment = ".$esdeveniment->getId()." 
    AND ic.tcrono_numcontrol <= " .$control_pas->getId(). "
    AND ic.tcrono_baixa = 'S'";
$total_retirats =  DB::query($query)->getFirst();

$query = "SELECT COUNT(tsolicitud_dorsal) as total
        FROM INSCRIPCIONS_SOLICITUDS
        WHERE tsolicitud_idEsdeveniment = ".$esdeveniment->getId()."
        AND tsolicitud_dorsal IS NOT NULL";
$total_dorsals =  DB::query($query)->getFirst();

?>

<!--DataTables -->
<link rel="stylesheet" href="<?php echo APP_PATH.APP_PATH_THEME.APP_THEME ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- start: CONTAINER-->
<section class="content-header">
    <h1><?PHP echo $esdeveniment->getNom(); ?></h1><h1>ESTAT CONTROL<BR><?PHP ECHO $control_pas->getDescripcio(); ?> </h1>
</section>    
    
<!-- Content Page -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">                    
                <ul class="nav nav-tabs"></ul>  <!-- pestanyes -->
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="box box-primary">
                            <b>Avancen:</b> <?php echo $total_avançats->total; ?> - 
                            <b>Retirats:</b> <?php echo $total_retirats->total; ?><br>
                            <b>Pendents:</b> <?php echo $total_dorsals->total - $total_avançats->total - $total_retirats->total; ?> - 
                                <b>Total:</b> <?php echo $total_dorsals->total; ?>
                            <div class="ui-grid-d">                                
                                <?php
                                    $j=0;
                                    $index = array('1' => 'a', '2' => 'b','3' => 'c','4' => 'd','0' => 'e');
                                    for($i = 1; $i<=$total_dorsals->total; $i++) { 
                                        echo '<div class="ui-block-'.$index[$i % 5].'">';
                                        if ($i <> $resultats[$j]->dorsal) { 
                                            $color = '#FFFFFF';
                                            $data = $i;
                                        }
                                        else {
                                            $color = ($resultats[$j]->estat == 'S') ? '#F2C0CC' : '#cef0ce';
                                            $data = $resultats[$j]->dorsal;
                                            $j++;
                                        }    
                                        echo '<div class="ui-bar ui-bar-a" style="height:30px; background-color:'.$color.'">'.$data."</div></div>";
                                    }    
                                ?>                                    
                            </div>
                        </div>    
                    </div> <!-- tab-pane -->   
                </div> <!-- tab-content -->
            </div>  <!-- nav-tabs-custom -->              
        </div>
        <a id="registre" href="index.php?ctl=controlPasAdmin" class="ui-shadow ui-btn ui-corner-all ui-icon-home ui-btn-icon-top">MENÚ<BR> PRINCIPAL</a>
    </div>    
</section>
        
  
<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'templates/mobileLayoutAdmin.php'; // plantilla general de la pàgina ?>          



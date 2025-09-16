<?PHP     
    global $CONFIG;
    
    ob_start();
    
    print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/formulari.css" rel="stylesheet" type="text/css" /> ');
?>

            <ul id="stepForm" class="ui-accordion-container">
                <fieldset>
                    <h2>
                        <center>
                            <?PHP print('<img style="border: 0px none;" alt="" src="'.SCM_PATH_THEME.SCM_THEME.'/images/button_ok.png" width="32" height="32" border="0" />');?>
                            <span style="color: #000080;font-family:Verdana;"><strong>Proc&eacute;s d'inscripci&oacute; tancat</strong></span>
                        </center>
                    </h2>

                    <!-- texte principal -->	
                    <div id="texte" style="text-align: justify; margin: 10px 15px;">
                        <center>
                            <?PHP print($esdeveniment->texte);?>
                        </center>
                    </div>			

                    <br><br>

                    <?PHP print('<span style="color: #0000ff;">* <a href="index.php?ctl=inscripcioLlistat&esdeveniment=' .$id. '"><span style="color: #0000ff;">Llistat inscrits</span></a></span><br>'); ?>
                    <span style="color: #0000ff;"> * <?PHP print('<a href="'.$CONFIG['URL_SITE'].'">'); ?><span style="color: #0000ff;">Tornar a la pàgina principal</span></a></span>
                    <br><br><br>
                    <center><strong>¡¡ MOLTES GRÀCIES PER LA TEVA COL·LABORACIÓ !!</strong></center>
                </fieldset>
            </ul>
            

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME. 'templates/formLayout.php'; // plantilla general de la pàgina ?>            


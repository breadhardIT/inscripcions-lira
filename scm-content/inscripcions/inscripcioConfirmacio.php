<?php 
    global $CONFIG;
    global $model;
    
    ob_start(); 
   
    print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/formulari.css" rel="stylesheet" type="text/css" /> ');
    print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/llistats.css" rel="stylesheet" type="text/css" /> ');    
    
?>

<script language="javascript">
	function Pagat(id) {
		if (window.confirm("¿Estàs segur que vols marcar el registre seleccionat com a pagat?")) {
	   	   location.href = "source/gestio/inscripcioPagar.php?id=" + id;
		}
	}
</script>
    
<?PHP	

	if ((!isset($clau)) || ($clau == '')) {
		$s_text .= "<script language=\"JavaScript\" type=\"text/javascript\">";
		$s_text .= "window.location.href='error_500.php'";
		$s_text .= "</script>";
		print ($s_text);				
	}
	else {
            if (!$esdeveniment->esGratuita()) {
		$inscripcio->getDadesPagament($clau);
		$preu = $inscripcio->preu;	
			
		if ($preu == '') {
			$s_text .= "<script language=\"JavaScript\" type=\"text/javascript\">";
			$s_text .= "window.location.href='error_500.php'";
			$s_text .= "</script>";
			print ($s_text);	
		}			
            }
	}
?>
                        
                <ul id="stepForm" class="ui-accordion-container">
                        <fieldset>
                                <legend> Pas 2</legend>
                                <h2>
                                    <center>
                                    <?PHP print('<img style="border: 0px none;" alt="" src="'.SCM_PATH_THEME.SCM_THEME.'/images/button_ok.png" width="32" height="32" border="0" />'); ?>
                                    <span style="color: #000080;font-family:Verdana;"><strong>PREINSCRIPCIÓ NÚM.<?PHP print ($clau); ?> REBUDA</strong></span>
                                    </center>
                                </h2>

                                <!-- texte principal -->	                                
                                <div id="texte" style="text-align: justify; margin: 10px 15px;">
                                        Hem rebut correctament la teva sol·licitud d'inscripció per la <?PHP print($esdeveniment->nom);?>
                                        <br><br><br>
                                        <?PHP if (!$esdeveniment->esGratuita())  : ?>
                                                <center><b>I M P O R T A N T</b></center>
                                                Per donar la inscripció per completada, s’haurà de realitzar un <b>ingrés individual per participant</b> (a través de transferència bancària) al núm. de compte del BBVA nº ES93 0182-2968-54-0201530930, indicant clarament com a referència o concepte el DNI del participant.
<b>És molt important que l’ingrés sigui individual i no es validaran les inscripcions col·lectives</b>.<br><!--O bé mitjançant paypal clicant sobre aquest enllaç: -->
                                        <?php endif; ?>
                                </div>
                                
                                <!-- PAGAMENT -->
                                    <?PHP if (!$esdeveniment->esGratuita())  : ?>  
					Preu: <?php echo $preu; ?>                                
<!--
                                        <form id="formID" action="<?php ECHO SCM_PAYPAL_URL; ?>" method="post" target="_top">
                                            <fieldset>
                                                <input type="hidden" name="cmd" value="<?php ECHO SCM_PAYPAL_CMD; ?>">
                                                <input type="hidden" name="landing_page" value="<?php ECHO SCM_PAYPAL_LANDING_PAGE; ?>">
                                                <input type="hidden" name="business" value="<?php ECHO SCM_PAYPAL_BUSINESS; ?>">
                                                <input type="hidden" name="charset" value="<?php ECHO SCM_DB_CHARSET; ?>">
                                                <input type="hidden" name="item_name" value="<?PHP echo $esdeveniment->nom; ?>">
                                                <input type="hidden" name="item_number" value="<?PHP echo $clau; ?>">
                                                <input type="hidden" name="currency_code" value="<?php ECHO SCM_PAYPAL_CURRENCY_CODE; ?>">
                                                <input type="hidden" name="no_note" value="<?php ECHO SCM_PAYPAL_NO_NOTE; ?>"/>
                                                <input type="hidden" name="no_shipping" value="<?php ECHO SCM_PAYPAL_NO_SHIPPING; ?>"/>
                                                <input type="hidden" name="amount" value="<?php echo $preu; ?>">
                                                <input type="hidden" name="return" value="<?php ECHO SCM_PAYPAL_RETURN; ?>">
                                                <input type="hidden" name="cancel_return" value="<?php ECHO SCM_PAYPAL_CANCEL; ?>">
                                                <input type="hidden" name="notify_url" value="<?php ECHO SCM_PAYPAL_STATUS; ?>">        
                                                <table>
                                                    <tr>
                                                        <td>							
                                                            <input type="hidden" name="on0" value="Preu">Fer ara el pagament on-line -- <?php echo $preu; ?>  €
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="currency_code" value="EUR">
                                                            <input id="enviar" type="submit" name="submit" value="Pagament" class="submitbutton"/>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <label class='error'>Nota: el pagament via paypal té 1€ de recàrrec sobre el preu de l'inscripció per despeses de gestió</label>
                                            </fieldset>
                                        </form>
-->                                       
                                    <?php endif;?>
                                <br><br>
                                <span style="color: #0000ff;">* <a href="javascript:window.print();"><span style="color: #0000ff;">Imprimir</span></a></span><br>				
                                <?PHP print('<span style="color: #0000ff;">* <a href="index.php?ctl=inscripcioLlistat&esdeveniment=' .$id. '"><span style="color: #0000ff;">Llistat inscrits</span></a></span><br>'); ?>
                                <?PHP print('<span style="color: #0000ff;">* <a href="index.php?ctl=inscripcioInici&esdeveniment=' .$id. '"><span style="color: #0000ff;">Fer una nova sol·licitud</span></a></span><br>'); ?>		
                                <span style="color: #0000ff;"> * <a href="index.php"><span style="color: #0000ff;">Tornar a la pàgina principal</span></a></span>
                                <br><br><br>
                                <center><strong>¡¡ MOLTES GRÀCIES PER LA TEVA COL·LABORACIÓ !!</strong></center>
                        </fieldset>
                </ul>

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME.'templates/formLayout.php'; // plantilla general de la pàgina ?>


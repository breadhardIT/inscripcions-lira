
<?php 
    global $CONFIG;
    
    ob_start(); 
   
    print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/formulari.css" rel="stylesheet" type="text/css" /> ');
    print('<script type="text/javascript" src="'.SCM_PATH_THEME.SCM_THEME.'js/jquery.js"></script>');
    print('<script type="text/javascript" src="'.SCM_PATH_THEME.SCM_THEME.'js/jquery.validate.js"></script>');
    print('<script type="text/javascript" src="'.SCM_PATH_THEME.SCM_THEME.'js/messages_ca.js"></script>');
    print('<script type="text/javascript" src="'.SCM_PATH_THEME.SCM_THEME.'js/jquery.validator.js"></script>  ');

    // calendari
    print('<link type="text/css" rel="stylesheet" href="'.SCM_PATH_THEME.SCM_THEME.'css/calendar.css" media="screen"></LINK>');
    print('<SCRIPT type="text/javascript" src="'.SCM_PATH_THEME.SCM_THEME.'js/calendar.js"></script>');
    
    require_once SCM_PATH_THEME.SCM_THEME.'theme.php';
    
?>

<script type="text/javascript">   
$(document).ready(function(){	
      
	// activar - desactivar licencia
	$("#ef").change(activaLlicencia);		
		
	// càlcul del preu
	//$("#soci").change(preompleEntitat);				
	$("#ef").change(calculaPreu);		
	$("#soci").change(calculaPreu);	
	$("#vegueria").change(calculaPreu);		
	$("#autocar").change(calculaPreu);		        
	
	// add * to required field labels
	$('label.required').append('&nbsp;<strong>*</strong>&nbsp;');
	
	// validate signup form on keyup and submit
	$("#formID").validate({
		rules: {
			nom: "required",
			cognoms: "required",
			dni: {
				required: true,
				nifES: true
			},
			sexe: "required",
			telefon: {
				required: true,
				minlength: 9,
				maxlength: 9,
                digits: true				
			}
		}
	});
});
</script>

            <form id="formID" action="index.php?ctl=formulariProcessar" enctype="multipart/form-data" method="post"  novalidate="novalidate">
                <!-- Camps ocults -->
                <input type="hidden" name="recipients" value="inscripcions@gmlira.cat" />
                <?PHP print('<input type="hidden" name="good_url" value="'.SCM_FORM_ROOT.'index.php" />'); ?>
                <input type="hidden" name="bad_url" value="/index.php?ctl=inscripcioError" />
                
                <input type="hidden" name="clau_inscripcio" value="" />			
                <?PHP print('<input type="hidden" name="idFormulari" value="' .$id. '" />');?>
                <?PHP print('<input type="hidden" name="origen" value="web" />') ?>
                <?PHP print('<input type="hidden" name="p1" value="'.$esdeveniment->preu1.'" />') ?>
                <?PHP print('<input type="hidden" name="p2" value="'.$esdeveniment->preu2.'" />') ?>
                <?PHP print('<input type="hidden" name="p_fecc" value="'.$esdeveniment->preufeec.'" />') ?>
                <?PHP print('<input type="hidden" name="p_aut" value="'.$esdeveniment->preuautocar.'" />') ?>    

                <ul id="stepForm" class="ui-accordion-container">
                    <fieldset>
                        <legend> Pas 1 de 3 </legend>
                        <div class="requiredNotice">*Camp obligatori</div>
                        <h3 class="stepHeader">Omple la teva inscripció</h3>

                        <label class="input required">DNI</label>
                        <?PHP
						if ($feec->esValid()) {
							print('<input class="input" id="dni" style="width: 130px;" type="text" maxlength="9" name="dni" disabled value="' .$feec->dni. '" >');
							print('<input type="hidden" name="dni" value="'.$feec->dni.'"');                                                                        							
						}
						else {						
                            print('<input class="input" id="dni" style="width: 130px;" type="text" maxlength="9" name="dni" ');
                            //print ('remote="scm-include/action-existeix_nif.php?id=' .$id. '"');
						}
                            print('/><br />');
                        ?>					
                        <label class="input required">Nom</label>
                        <input id="nom" style="width: 130px;" type="text" maxlength="50" name="nom" /><br />
                        <label class="input required">Cognoms</label>
                        <input id="cognoms" style="width: 280px;" type="text" maxlength="100" name="cognoms" /><br />
                        <label class="input required">Sexe</label>
                        <select id="sexe" name="sexe" class="input"><option selected="selected" value="">------</option><option value="M">Home</option><option value="F">Dona</option></select><br />
						<label class="input required">Data de naixement</label>
                        <input id="naixement" style="width: 80px;" type="text" name="naixement" autocomplete="off" />
                        <input type="button" onclick="displayCalendar(document.forms['formID'].naixement,'dd/mm/yyyy',this)" class="calendar"> (dd/mm/aaaa)<br />

                        <div class="formspacer"></div>
						<!--		
                        <label class="input">Adreça:</label>
                        <input id="adresa" name="adresa" style="width: 280px;" type="text" maxlength="100" /><br />
                        <label class="input required">Localitat:</label>
                        <input id="poblacio" style="width: 280px;" type="text" maxlength="100" name="poblacio" /><br />
                        <label class="input required">Codi Postal:</label>
                        <input id="cp" style="width: 80px;" type="text" maxlength="5" name="cp" /><br /> 
						-->					
                        <label class="input required">Telèfon / Mobil:</label>
                        <input id="telefon" style="width: 80px;" type="text" maxlength="9" name="telefon" /><br />

			<label class="input required">Email:</label>
                        <input id="mail" style="width: 280px;" type="text" maxlength="100" name="mail" /><br />

                        <?PHP                        
                            if ($esdeveniment->teSamarreta()) {
                                print('<label class="input required">Talla samarreta:</label>');
                                print('<select id="talla" name="talla" class="input"><option selected="selected" value="">----</option><option value="S">S</option><option value="M">M</option><option value="L">L</option><option value="XL">XL</option></select><br />');
                            }        
			
                            if ($esdeveniment->teFederativa()) {
                                print('<div class="formspacer"></div>');
                                if ($feec->esValid()) {
                                    print('<label class="input required">Federat:</label>');
                                    print('<select id="ef" name="ef" class="inputclass" disabled><option value="">----</option><option value="S" selected="selected">Si</option><option value="N">No</option></select><br />');
                                    print('<input type="hidden" name="ef" value="S" />');
                                    
                                    print('<label class="input required">Federació:</label>');
                                    print('<select id="federacio" name="federacio" class="inputclass" disabled><option value="">----</option><option selected="selected" value="FEEC">FEEC</option><option value="FEDME">FEDME</option><option value="UIAA">UIAA</option></select><br />');					                                    
                                    print('<input type="hidden" name="federacio" value="FEEC" />');                                    
                                    
                                    print('<label class="input required">Nº de llicència</label>');
                                    print('<input id="llicencia" style="width: 80px;" type="text" maxlength="10" name="llicencia" value="'.$feec->llicencia.'" disabled /><br />');
                                    print('<input type="hidden" name="llicencia" value="'.$feec->llicencia.'" />');                                                                        
                                    
                                    print('<label class="input required">Tipus</label>');
                                    print('<input id="tipusllicencia" style="width: 180px;" type="text" name="tipusllicencia" value="'.$feec->tipusLlicencia.'" disabled /><br />');					
                                    print('<input type="hidden" name="tipusllicencia" value="'.$feec->tipusLlicencia.'" />');                                                                        
                                } else {
                                    print('<label class="input required">Federat:</label>');
                                    print('<select id="ef" name="ef" class="inputclass"><option selected="selected" value="">----</option><option value="S">Si</option><option value="N">No</option></select><br />');
                                    print('<label class="input required">Federació:</label>');
                                    print('<select id="federacio" name="federacio" class="inputclass" disabled><option selected="selected" value="">----</option><option value="FEEC">FEEC</option><option value="FEDME">FEDME</option><option value="UIAA">UIAA</option></select><br />');					
                                    print('<label class="input required">Nº de llicència</label>');
                                    print('<input id="llicencia" style="width: 80px;" type="text" maxlength="10" name="llicencia" value="" disabled /><br />');
                                    print('<label class="input required">Tipus</label>');
                                    print('<input id="tipusllicencia" style="width: 80px;" type="text" maxlength="10" name="tipusllicencia" value="" disabled /><br />');					
                                }    
                            }            
                            if ($esdeveniment->teConveni()) {                        
                                print('<label class="input required">Ets soci del GMLV:</label>');					
                                print('<select id="soci" name="soci" class="input"><option selected="selected" value="">----</option><option value="S">Sí</option><option value="N">No</option></select><br />');

                                print('<label class="input required">Adscrit a la III Vegueria:</label>');
                                print('<select id="vegueria" name="vegueria" class="input"><option selected="selected" value="">----</option><option value="S">Sí</option><option value="N">No</option></select><br />');
                            }
                        ?>

                        <label class="input">Entitat:</label>                                                        
                        <input id="entitat" style="width: 280px;" type="text" maxlength="280" name="entitat" <?PHP if ($feec->esValid()) {echo 'value="'.$feec->entitat.'" ';} ?> /><br />
						
                        <div class="formspacer"></div>
                        <label class="input required">Accepto el reglament</label>
                        <input class="checkbox" id="agree" type="checkbox" name="agree" /><br />                        	

                        <?PHP
                            if ($esdeveniment->teAutocar()) {
                                print('<label class="input required">Autocar</label>');
                                print('<select id="autocar" name="autocar" class="input"><option selected="selected" value="">----</option><option value="S">Sí</option><option value="N">No</option></select><br />');                            
                            }
                            else {
                                print('<input type="hidden" name="autocar" value="N" />');
                            }
                            if (!$esdeveniment->esGratuita()) {
                                print('<div class="formspacer"></div>');                                
                                print('<label class="input required">Preu de la inscripció</label>');
                                print('<div id="preuinscripcio"><b>&nbsp;');
                                if ($feec->esValid()){
                                    echo $esdeveniment->preu2.'&euro;</b></div>';
                                    echo '<input type="hidden" name="preuinscripcio" value="'.$esdeveniment->preu2.'" />'; }			
                                else { 
                                    echo '0&euro;</b></div>';
                                    echo '<input type="hidden" name="preuinscripcio" value="0" />'; }
                            }
                        ?>                        
                        <div class="buttonWrapper"><input id="enviar" type="submit" name="enviar" value="Fer inscripció" class="submitbutton"/></div>
                    </fieldset>
                </ul>
                <?PHP pintarLOPD(); ?>
            </form>


<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME.'templates/formLayout.php'; // plantilla general de la pàgina ?>
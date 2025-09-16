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
    
?>

<script type="text/javascript">  
$(document).ready(function(){	

	// activar - desactivar licencia
	//$("#soci").change(preompleEntitat);		
	
	// activar - desactivar licencia
	$("#ef").change(activaLlicencia);		
		
	// càlcul del preu
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
			naixement: {
				required: true,
				date: true
			},
			telefon: {
				required: true,
				minlength: 9,
				maxlength: 9,
                digits: true				
			},
			mail: {
				required: true,
				email: true
			},
			ef: "required",
			soci: "required",
			talla: "required",
			agree: "required"
		}
	});
});
</script>

<?PHP			
    // obtener parámetros de la request
    $modo = $_REQUEST['modo'];
    $idEsdeveniment = $_REQUEST['esdeveniment'];		
    $idInscripcio = $_REQUEST['id'];		    
    $dorsal = 0;                                        //valor per defecte
    $dni = $_REQUEST['dni'];                            // si és una alta i venim del formulari de cerca
    $llicenciaFEEC = $_REQUEST['llicenciaFEEC'];        // si és una alta i venim del formulari de cerca    
    
    if (!$idInscripcio) $idInscripcio = "";

    // Obtenim les dades de BBDD per preomplir el formulari
    if ($modo == 'modi') {
	$inscripcio = New Inscripcio($idInscripcio);
        $participant = New Participant ('id', $inscripcio->idPersona);
    }
    
    // cercar les dades del participant per dni a la BBDD 
    if (($modo == 'alta') && ($dni <> '')) {
	$participant = New Participant ('dni', $dni);       
    }
    
    // validació FEEC
    $feec = New Feec($llicenciaFEEC, $dni)
    
?>
		
<form id="formID" action="index.php?ctl=g_formulariProcessar" enctype="multipart/form-data" method="post"  novalidate="novalidate">
    <!-- Camps ocults -->
    <input type="hidden" name="recipients" value="inscripcions@gmlira.cat" />
    <?PHP print('<input type="hidden" name="good_url" value="'.SCM_FORM_ROOT.'index.php" />'); ?>
    <input type="hidden" name="bad_url" value="/error_500.php" />
    <?PHP print('<input type="hidden" name="clau_inscripcio" value="' .$inscripcio->clau. '" />');?>			
    <?PHP print('<input type="hidden" name="idInscripcio" value="' .$idInscripcio. '" />');?>
    <?PHP print('<input type="hidden" name="modo" value="' .$modo. '"/>'); ?>    
    <?PHP print('<input type="hidden" name="idEsdeveniment" value="' .$idEsdeveniment. '"/>'); ?>        
    <?PHP print('<input type="hidden" name="origen" value="gestio" />'); ?>
    <?PHP print('<input type="hidden" name="p1" value="'.$esdeveniment->preu1.'" />'); ?>
    <?PHP print('<input type="hidden" name="p2" value="'.$esdeveniment->preu2.'" />'); ?>
    <?PHP print('<input type="hidden" name="p_fecc" value="'.$esdeveniment->preufeec.'" />'); ?>
    <?PHP print('<input type="hidden" name="p_aut" value="'.$esdeveniment->preuautocar.'" />'); ?>  
    
    <ul id="stepForm" class="ui-accordion-container">
		<fieldset>
			<div class="requiredNotice">*Camp obligatori</div>
			<h3 class="stepHeader">Consulta \ Modificació</h3>
	
			<label class="input required">DNI</label>
			<?PHP
				print('<input class="input" id="dni" style="width: 130px;" type="text" maxlength="50" name="dni" value="' . $participant->dni. '" ');
				if ($modo == 'alta') print ('remote="scm-include/action-existeix_nif.php?id=' .$idEsdeveniment. '" /><br />');
                                if ($modo == 'modi') {print ("disabled /><br />");print('<input type="hidden" name="dni" value="'.$participant->dni.'"/>');}
			?>
			<label class="input required">Nom</label>
			<?PHP	print('<input id="nom" style="width: 130px;" type="text" maxlength="50" name="nom" value="' . $participant->nom . '"/><br />'); ?>
			<label class="input required">Cognoms</label>
			<?PHP		print('<input id="cognoms" style="width: 280px;" type="text" maxlength="100" name="cognoms" value="' . $participant->cognoms . '" /><br />'); ?>
			<label class="input required">Sexe</label>
			<select id="sexe" name="sexe" class="input">
			<?PHP
				print('<option value=""'); if (!isset($participant->sexe)) print(' selected="selected"'); print('>------</option>');
				print('<option value="M"'); if ($participant->sexe == 'M') print(' selected="selected"'); print('>Home</option>');
				print('<option value="F"'); if ($participant->sexe == 'F') print(' selected="selected"'); print('>Dona</option>');
			?>
			</select><br />
			<label class="input required">Any de naixement</label>			
			<?PHP		print('<input id="naixement" style="width: 80px;" type="text" name="naixement" value="' .$participant->naixement. '" />');?>
			<input type="button" onclick="displayCalendar(document.forms['formID'].naixement,'yyyy/mm/dd',this)" class="calendar">	(aaaa/mm/dd)				
			<br />			
			<div class="formspacer"></div>

			<label class="input">Adreça:</label>
			<?PHP		print('<input id="adresa" style="width: 280px;" type="text"  name="adresa" maxlength="100" value="' .$participant->adresa. '"  /><br />');?>			
			<label class="input">Localitat:</label>
			<?PHP		print('<input id="poblacio" style="width: 280px;" type="text" maxlength="100" name="poblacio" value="' .$participant->poblacio. '"  /><br />');?>
			<label class="input">Codi postal:</label>
			<?PHP		print('<input id="cp" style="width: 80px;" type="text"  name="cp" maxlength="5" value="' .$participant->cp. '"  /><br />');?>			
			<label class="input required">Telèfon / Mobil:</label>
			<?PHP		print('<input id="telefon" style="width: 80px;" type="text" maxlength="9" name="telefon" value="' .$participant->telefon. '"  /><br />');?>
			<label class="input required">Email:</label>
			<?PHP		print('<input id="mail" style="width: 280px;" type="text" maxlength="100" name="mail" value="' .$participant->mail. '"  /><br />');?>
			<label class="input required">Talla samarreta:</label>
			<select id="talla" name="talla" class="input">
			<?PHP
					print('<option value=""'); if (!isset($participant->talla)) print(' selected="selected"'); print('>----</option>');
					print('<option value="S"'); if ($participant->talla == 'S') print(' selected="selected"'); print('>S</option>');
					print('<option value="M"'); if ($participant->talla == 'M') print(' selected="selected"'); print('>M</option>');
					print('<option value="L"'); if ($participant->talla == 'L') print(' selected="selected"'); print('>L</option>');
					print('<option value="XL"'); if ($participant->talla == 'XL') print(' selected="selected"'); print('>XL</option>');
					print('</select><br />');
			?>	
			
			<div class="formspacer"></div>
			<label class="input required">Federat:</label>
			<select id="ef" name="ef" class="inputclass">
                            <option selected="selected" value="">----</option>
                            <?PHP			
				print('<option value="N"'); if ($participant->ef == 'N') print(' selected="selected"'); print('>No</option>');
				print('<option value="S"'); if ($participant->ef == 'S') print(' selected="selected"'); print('>Si</option>');
                            ?>
			</select>
                        <?PHP  print('<span style="color:#ff0000;">'); ($feec->esValid()) ? print('&nbsp;(VALIDAT  FEEC)</SPAN>') : print('&nbsp;(NO  validat FEEC)</SPAN>'); ?>
                        <br />	
			
			<?PHP if (($participant->ef == 'N') || ($participant->ef == ''))  $disabled='disabled';?>			
			<label class="input required">Federacio:</label>
			<?PHP			
				print('<select id="federacio" name="federacio" class="inputclass" ' . $disabled. '>');
				print('<option value=""'); if ($participant->federacio == '') print(' selected="selected"'); print('>----</option>');
				print('<option value="FEEC"'); if ($participant->federacio == 'FEEC') print(' selected="selected"'); print('>FEEC</option>');
				print('<option value="FEDME"'); if ($participant->federacio == 'FEDME') print(' selected="selected"'); print('>FEED</option>');
				print('<option value="UIAA"'); if ($participant->federacio == 'UIAA') print(' selected="selected"'); print('>UIAA</option>');				
			?>			
			</select><br />
			<label class="input required">Nº de llicència:</label>
			<?PHP	($feec->esValid()) ? $aux=$feec->llicencia : $aux=$participant->llicencia; print('<input id="llicencia" style="width: 80px;" type="text" maxlength="6" name="llicencia" value="' .$aux. '" ' .$disabled. ' /><br />');?>			
			<label class="input required">Tipus de llicència:</label>
			<?PHP	($feec->esValid()) ? $aux=$feec->tipusLlicencia : $aux=$participant->tipusllicencia; print('<input id="tipusllicencia" style="width: 200px;" type="text" maxlength="35" name="tipusllicencia" value="' .$aux. '" ' .$disabled. ' />');
                        ?>
                        <br />
			<div class="formspacer"></div>			
			<label class="input required">Ets soci del GMLV:</label>
			<select id="soci" name="soci" class="inputclass">
			<?PHP			
				print('<option value="N"'); if ($participant->soci == 'N') print(' selected="selected"'); print('>No</option>');
				print('<option value="S"'); if ($participant->soci == 'S') print(' selected="selected"'); print('>Si</option>');
			?>
			</select><br />				
			<label class="input required">Adscrit a la III Vegueria:</label>
			<select id="vegueria" name="vegueria" class="inputclass">
			<?PHP			
				print('<option value="N"'); if ($participant->vegueria == 'N') print(' selected="selected"'); print('>No</option>');
				print('<option value="S"'); if ($participant->vegueria == 'S') print(' selected="selected"'); print('>Si</option>');
			?>			
			</select><br />			
			<label class="input">Entitat:</label>
			<?PHP	($feec->esValid()) ? $aux=$feec->entitat : $aux=$participant->entitat; print('<input id="entitat" style="width: 280px;" type="text" maxlength="280" name="entitat" value="' .$aux. '"  /><br />');?>

			<div class="formspacer"></div>							
			<label class="input required">Accepto el reglament de la cursa</label>
			<?PHP		
					print('<input class="checkbox" id="agree" type="checkbox" name="agree"'); 
					  if ($inscripcio->agree == 'on') print(' checked value="' . $inscripcio->agree . '"');
					print('/><br /><br />');
			?>		
			<label class="input required">Dorsal</label>
			<?PHP		
				print('<input id="dorsal" style="width: 40px;" type="text" maxlength="4" name="dorsal" value="' . $inscripcio->dorsal. '" ');
				//print('remote="../lib/existeixDorsal.php?id=' .$id. '"');				
				print('/><br />');
			?>
			<label class="input required">PAGAT</label>
			<select id="pagat" name="pagat" class="input">
			<?PHP
					  print('<option value="N"'); if ($inscripcio->pagat == 'N') print(' selected="selected"'); print('>No</option>');
					  print('<option value="S"'); if ($inscripcio->pagat == 'S') print(' selected="selected"'); print('>Sí</option>');
			?>
			</select><br />			
			<label class="input required">INCID&Egrave;NCIA</label>
			<select id="incidencia" name="incidencia" class="input">
			<?PHP
					  print('<option value="N"'); if ($inscripcio->incidencia == 'N') print(' selected="selected"'); print('>No</option>');
					  print('<option value="S"'); if ($inscripcio->incidencia == 'S') print(' selected="selected"'); print('>Sí</option>');
			?>			
			</select><br />
                        <label class="input required">Autocar</label>
                        <select id="autocar" name="autocar" class="input">
                        <?PHP
                            print('<option value="N"'); if ($inscripcio->autocar == 'N') print(' selected="selected"'); print('>No</option>');
                            print('<option value="S"'); if ($inscripcio->autocar == 'S') print(' selected="selected"'); print('>Sí</option>');                                
                        ?>  
			</select><br />                            
			<label class="input required">Preu de l'inscripci&oacute;</label>
			<?PHP		print('<input id="preuinscripcio" style="width: 60px;" type="text" maxlength="280" name="preuinscripcio" value="' .$inscripcio->preu. '"  /> €<br />');?>
			<label class="input required">Observacions</label>
			<?PHP		print('<input id="observacions" style="width: 350px;" type="text" maxlength="280" name="observacions" value="' . $inscripcio->obs. '"  /> <br />');?>

			<div class='buttonWrapper'>
				<a href='' class='submitbutton'/></a>
				<?PHP 
					$accio = "location.href='index.php?ctl=g_inscripcioLlistat&esdeveniment=" .$idEsdeveniment. "';";
					print('<input id="tornar" type="button" name="tornar" value="Tornar a la llista" class="submitbutton" onClick="' .$accio. '">'); 
				?>
				<input id='enviar' type='submit' name='enviar' value='Modificar' class='submitbutton'/>
			</div>
			
		</fieldset>
		</ul>
		</form>

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME.'templates/gestioLayout.php'; // plantilla general de la pàgina ?>
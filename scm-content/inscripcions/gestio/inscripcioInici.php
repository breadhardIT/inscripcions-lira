<?php 
    global $CONFIG;
    
    ob_start(); 
   
    print('<link href="'.$CONFIG['theme_dir'].'css/formulari.css" rel="stylesheet" type="text/css" /> ');
    print('<script type="text/javascript" src="'.$CONFIG['theme_dir'].'js/jquery.js"></script>');
    print('<script type="text/javascript" src="'.$CONFIG['theme_dir'].'js/jquery.validate.js"></script>');
    print('<script type="text/javascript" src="'.$CONFIG['theme_dir'].'js/messages_ca.js"></script>');
    print('<script type="text/javascript" src="'.$CONFIG['theme_dir'].'js/jquery.validator.js"></script>  ');

    // calendari
    print('<link type="text/css" rel="stylesheet" href="'.$CONFIG['theme_dir'].'css/calendar.css" media="screen"></LINK>');
    print('<SCRIPT type="text/javascript" src="'.$CONFIG['theme_dir'].'js/calendar.js"></script>');
    
?>

<script type="text/javascript">  
$(document).ready(function(){	

	// add * to required field labels
	$('label.required').append('&nbsp;<strong>*</strong>&nbsp;');
	
	// validate signup form on keyup and submit
	$("#formID").validate({
		rules: {
			dni: {
				required: true,
				nifES: true
			}
		}
	});
});
</script>

<?Php print('<form id="formID" action="index.php?ctl=gestioInscripcioForm&modo=alta&esdeveniment=' .$id. '" enctype="multipart/form-data" method="post"  novalidate="novalidate">'); ?>
    <!-- Camps ocults -->
    
    <ul id="stepForm" class="ui-accordion-container">
		<fieldset>
			<div class="requiredNotice">*Camp obligatori</div>
			<h3 class="stepHeader">Consulta \ Modificació</h3>
	
			<label class="input required">DNI</label>
			<?PHP
				print('<input class="input" id="dni" style="width: 130px;" type="text" maxlength="50" name="dni" value="" ');
				print ('remote="scm-include/action-existeix_nif.php?id=' .$id. '"');
				print('/><br />');
			?>

                        <label class="input required">Nº de llicència:</label>
			<?PHP		print('<input id="llicenciaFEEC" style="width: 80px;" type="text" maxlength="10" name="llicenciaFEEC" value="" /><br />');?>			
                        
			<div class='buttonWrapper'>
				<a href='' class='submitbutton'/></a>
				<?PHP 
					$accio = "location.href='index.php?ctl=esdevenimentsLlistat'";
					print('<input id="tornar" type="button" name="tornar" value="Tornar a la llista" class="submitbutton" onClick="' .$accio. '">'); 
				?>
				<input id='enviar' type='submit' name='enviar' value='Cercar' class='submitbutton'/>
			</div>
			
		</fieldset>
		</ul>
		</form>
		<!-- FI Cos de la pàgina -->

<?php $contenido = ob_get_clean(); ?>   
<?php include $CONFIG['theme_dir']. 'templates/gestioLayout.php'; // plantilla general de la pàgina ?>

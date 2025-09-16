<?PHP ob_start(); ?>

    <form id="formID" action="index.php?ctl=controlPasDorsalEstat" enctype="multipart/form-data" method="post"  novalidate="novalidate">
        <div class="ui-field-contain">
            <label class="input"><h2><b><?PHP echo $esdeveniment->getNom(); ?></b></h2></label>            
        </div>
        <div class="ui-field-contain">        
            <label class="input"><b><h1>Dorsal</h1></b></label> 
            <input type=text id="dorsal" name="dorsal" size=4 value="" placeholder="Introdueix el n&uacute;mero de dorsal" ><br>  
        </div>
        <br>
        <button class="ui-btn ui-btn-icon-left ui-icon-check" type="submit" style="background-color:#cef0ce;">CERCAR</button>
        <div class="ui-grid-a">
            <div class="ui-block-a"><a id="telf_emergencies" href="tel:+34638404189" class="ui-shadow ui-btn ui-corner-all ui-icon-phone ui-btn-icon-top" style="background-color:#EE0000; color:#f9fafc;">CONTROL<BR>CENTRAL</a></div>                        
            <div class="ui-block-b"><a id="registre" href="index.php?ctl=controlPasHome" class="ui-shadow ui-btn ui-corner-all ui-icon-home ui-btn-icon-top">MENÚ<BR> PRINCIPAL</a></div>
        </div>
    </form>      

<!-- jquery validator -->
<link rel="stylesheet" href="<?php echo APP_PATH.APP_PATH_THEME.APP_THEME ?>js/jqueryvalidator/jquery.validator.css">
<script type="text/javascript" src="<?php echo APP_PATH.APP_PATH_THEME.APP_THEME ?>/js/jqueryvalidator/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH.APP_PATH_THEME.APP_THEME ?>/js/jqueryvalidator/messages_ca.js"></script>
<script type="text/javascript" src="<?php echo APP_PATH.APP_PATH_THEME.APP_THEME ?>/js/jqueryvalidator/jquery.validator.js"></script>

<script>
        $(document).ready(function() {        
           
            $("#formID").validate({
		rules: {
                    dorsal: "required"
		}
            });
        });			
</script>
<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'templates/mobileLayout.php'; // plantilla general de la pàgina ?>



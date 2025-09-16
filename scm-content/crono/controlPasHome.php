<?PHP ob_start(); ?>

<?php require_once APP_PATH_ABS.APP_PATH_INCLUDE.SCM_CRONO.'class/class-utils.php'; ?>

    <div class="ui-field-contain">
        <label class="input"><h2><b><?PHP echo $esdeveniment->getNom(); ?></b></h2></label>            
        <div class="form-group">
            <label class="control-label">Control</label>                    
            <?php echo Utils::creaCombo('idControl', str_replace('%search1%', $esdeveniment->getId(), COMBO_CONTROLSDEPAS), false);?>    
        </div>
    </div>
    <div class="ui-grid-a">
        <div class="ui-block-a"><a id="registre" href="#" class="ui-shadow ui-btn ui-corner-all ui-icon-check ui-btn-icon-top" style="background-color:#cef0ce; ">REGISTRAR<BR>DORSAL</a></div>                        
        <div class="ui-block-b"><a id="buscar" href="index.php?ctl=controlPasDorsalBuscar" class="ui-shadow ui-btn ui-corner-all ui-icon-search ui-btn-icon-top" style="background-color:#cef0ce; ">CERCAR<BR>DORSAL</a></div>                                                
    </div>    

    <div class="ui-grid-a">
        <div class="ui-block-a"><a id="telf_emergencies" href="tel:+34638404189" class="ui-shadow ui-btn ui-corner-all ui-icon-phone ui-btn-icon-top" style="background-color:#EE0000; color:#f9fafc;">CONTROL<BR> CENTRAL</a></div>                        
        <div class="ui-block-b"><a id="resum" href="#" class="ui-shadow ui-btn ui-corner-all ui-icon-GRID ui-btn-icon-top" >RESUM<BR>CONTROL</a></div>                
    </div>
    
    
<script>
        $(document).ready(function() {        
           
            $('#idControl').on('change', function() {  
                var a = $(this).find("option:selected").val();
                if (a  == '' ) {{$('#registre').attr('href', '#');}}
                else {
                    $('#registre').attr('href', 'index.php?ctl=controlPas&c='+a);
                    $('#resum').attr('href', 'index.php?ctl=controlPasResum&c='+a);
                }
            });
        });			
</script>    

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'templates/mobileLayout.php'; // plantilla general de la pàgina ?>          



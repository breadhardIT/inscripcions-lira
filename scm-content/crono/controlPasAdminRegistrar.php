<?PHP ob_start(); ?>

    <form id="formID" action="index.php?ctl=controlPasUpdate" enctype="multipart/form-data" method="post"  novalidate="novalidate">
        
        <input type="hidden" id="esdeveniment" name="esdeveniment" value="<?PHP echo $esdeveniment->getId(); ?>"/>
        <input type="hidden" id="numcontrol" name="numcontrol" value="<?PHP echo $control_pas->getId(); ?>"/>
        <input type="hidden" id="baixa" name="baixa" value="N"/>
        <input type="hidden" id="urlReturn" name="urlReturn" value="index.php?ctl=controlPasRegistrar&c=<?PHP echo $control_pas->getId(); ?>"/>        
        <input type="hidden" id="admin" name="admin" value="1"/>        		
        
        <div class="ui-field-contain">
            <label class="input"><h2><b><?PHP echo $esdeveniment->getNom(); ?></b></h2></label>            
            <label class="input"><h2><b>Control <?PHP echo $control_pas->getId()." ".$control_pas->getDescripcio(); ?></b></h2></label>
        </div>
        <div class="ui-field-contain">        
            <label class="input"><b><h1>Dorsal</h1></b></label> 
            <input type=text id="dorsal" name="dorsal" size=4 value="" placeholder="Introdueix el n&uacute;mero de dorsal" ><br>  
        </div>   
        <div class="ui-grid-a">
            <div class="ui-block-a"><a id="registre" href="javascript:document.forms[0].baixa.value = 'N';document.forms[0].submit();" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-top ui-icon-check" onclick="document.forms[0].baixa.value = 'N';document.forms[0].submit();" style="background-color:#cef0ce; margin-right: .3125em; margin-left: .3125em;">ENDAVANT</a></div>
            <div class="ui-block-b"><a id="registre" href="javascript:document.forms[0].baixa.value = 'S';document.forms[0].submit();" class="ui-shadow ui-btn ui-corner-all ui-btn-icon-top ui-icon-delete" onclick="document.forms[0].baixa.value = 'S';document.forms[0].submit();" style="background-color:#F2C0CC; margin-right: .3125em; margin-left: .3125em;">RETIRAT</a></div>
    
        </div>   
        <div class="ui-grid-a">
            <div class="ui-block-a"><a id="telf_emergencies" href="tel:+34638404189" class="ui-shadow ui-btn ui-corner-all ui-icon-phone ui-btn-icon-top" style="background-color:#EE0000; color:#f9fafc;">CONTROL<BR>CENTRAL</a></div>                        
            <div class="ui-block-b"><a id="registre" href="index.php?ctl=controlPasAdmin" class="ui-shadow ui-btn ui-corner-all ui-icon-home ui-btn-icon-top">MENÚ<BR> PRINCIPAL</a></div>
        </div>       	
    </form>      

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'templates/mobileLayoutAdmin.php'; // plantilla general de la pàgina ?>



<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $CONFIG;

ob_start(); 
    
print('<link href="'.$CONFIG['theme_dir'].'css/formulari.css" rel="stylesheet" type="text/css" /> ');
print('<link href="'.$CONFIG['theme_dir'].'css/llistats.css" rel="stylesheet" type="text/css" /> ');   
print('<script type="text/javascript" src="app/js/general.js"></script>');

?>

<section id="content">
    <article id="post" class="post type-post status-publish format-standard hentry">
        <div class="entry">                        
                        
            <form id="formID" action="" enctype="multipart/form-data" method="post"  novalidate="novalidate">    
                <ul id="stepForm" class="ui-accordion-container">
                    <fieldset>
                        <!-- texte principal -->	                                
                        <div id="texte" style="text-align: justify; margin: 10px 15px;">
                            <?PHP 
                            print('<iframe frameBorder="0" src="http://es.wikiloc.com/wikiloc/spatialArtifacts.do?event=view&id=' .$ruta->id.'&measures=on&title=on&near=on&images=on&maptype=T" width="500" height="400"></iframe>');
                            ?>
                        </div>
                    </fieldset>
                </ul>
            </form>
        </div>
    </article>
</section>

<?php $contenido = ob_get_clean(); ?>   
<?php include $CONFIG['theme_dir']. 'templates/formLayout.php'; // plantilla general de la pàgina ?>           
<!-- FI Cos de la pàgina -->	
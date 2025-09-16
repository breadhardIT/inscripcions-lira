<?php 

    global $CONFIG;
    global $model;

    ob_start(); 
    
    print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/formulari.css" rel="stylesheet" type="text/css" /> ');
    print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/llistats.css" rel="stylesheet" type="text/css" /> ');    

?>

            <form id="formID" method="POST">
                <ul id="stepForm" class="ui-accordion-container">
                    <fieldset>
                        <?PHP
                            $nfilas = count ($consulta);					
                            if ($nfilas > 0) {
                                // taula de dades				
                                print ("<TABLE border='0' width='100%'>\n");
                                foreach ($consulta as $resultado) {
                                    print ("<TR>\n");					
                                        print ("<TD CLASS='centro separadorLineaH mayuscules' width=5%><img src='".SCM_PATH_THEME.SCM_THEME."images/".$resultado->tesdeveniments_logo."' width='125' height='93'></TD>\n");
                                        print ("<TD CLASS='izquierda separadorLineaH mayuscules' width=50%>");
                                            print('<h3 class=" widget widget-title">');
                                            print("<a href='" .$resultado->tesdeveniments_url."'>" . $resultado->tesdeveniments_nom. "</a>");
                                            print("</h3>");
                                            print("<br><span class='tweet-text'>".$resultado->tesdeveniments_texte."</span>");
                                        print("</TD>\n");	  
                                        print ("<TD CLASS='centro separadorLineaH mayuscules ");
                                            if ($resultado->tesdeveniments_estat == '0') 
                                                print(" vermell' width=15%> Inscripcions Tancades"); 
                                            else  print(" verd' width=15%> Inscripcions Obertes");
                                        print("</TD>\n");	  
                                    print ("</TR>\n");
                                    }
                                print ("</TD></TR>\n");
                                print ("</TABLE>\n");
                            }
                            else {
                                // taula de dades				
                                print ("<TABLE border='0'>\n");
                                print ("<TR><td>\n");
                                print ("<font class='subtitol_bold'>No hi ha resultats disponibles</font>");
                                print ("</TD></TR>\n");
                                print ("</TABLE>\n");
                            }  
                        ?>
                    </fieldset>
                </ul>
            </form>

<?php $contenido = ob_get_clean() ?>
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME.'templates/formLayout.php'  // plantilla general de la pàgina ?>
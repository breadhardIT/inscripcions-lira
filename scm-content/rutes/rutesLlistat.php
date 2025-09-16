<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $CONFIG;
global $model;

ob_start(); 
    
print('<link href="'.$CONFIG['theme_dir'].'css/formulari.css" rel="stylesheet" type="text/css" /> ');
print('<link href="'.$CONFIG['theme_dir'].'css/llistats.css" rel="stylesheet" type="text/css" /> ');   
print('<script type="text/javascript" src="app/js/general.js"></script>');

?>

<!-- Cos de la pàgina -->
<form id="formID" method="POST">
    <ul id="stepForm" class="ui-accordion-container">
        <fieldset>

            <?PHP			
                // obtener parámetros de la request
                $id = $_REQUEST['esdeveniment'];			
                $actualizar = $_REQUEST['actualizar'];			
                            $cognoms = $_REQUEST['cognoms'];			
                            $nom = $_REQUEST['nom'];
                            $sort = $_REQUEST['sort'];
                            $page = $_REQUEST['page'];

                            if (!$cognoms) $cognoms = "";
                            if (!$nom) $nom = "";			
                            if (!$sort) $sort = "";		
                            if (!$page) $page = "";					

                            $numRegistres = 15;
                            if (!$page) {
                                    $inicio = 0;
                                    $page = 1;
                            }
                            else {	$inicio = ($page - 1) * $numRegistres; }		

                            // Obtenir total de registre
                            if (!$cognoms) $cognoms = "Tots";
                            if (!$nom) $nom = "Tots";

                            $totalRegistros = $model->getRutesLlistatTotal(); 
                            $totalPaginas = ceil($totalRegistros / $numRegistres);

                            // Obtenir dades per la llista
                            $consulta = $model->getRutesLlistat($inicio, $numRegistres);
 
                            // info sobre els criteris de selecció
                            $llistaCamps = array("Cognoms","cognoms",$cognoms,"Nom","nom",$nom);								
                            $llistaResultats = array("Cognoms",$cognoms,"Nom",$nom);				
                            $llistaCampsOcults = array("page",$page, "sort",$sort, "id", $id);		
                            pintarResultatsCercaWeb($llistaCamps, $llistaResultats, $llistaCampsOcults, '');

                            // Mostrar resultados de la consulta
                            print ('<div class="formspacer"></div>');

                $nfilas = mysql_num_rows ($consulta);
                if ($nfilas > 0) { 

                                //càlcul del nº de registros
                                $ini = ((($page - 1) * $numRegistres) + 1);
                                if (($page * $numRegistres) > $totalRegistros ){$fi = $totalRegistros;}
                                else $fi = ($page * $numRegistres);		

                                // taula de dades				
                                print ("<TABLE border='0'>\n");
                                print ("<TR>\n");
                                print ("<TH>Tipus</a></TH>\n");								
                                print ("<TH>Ruta</TH>\n");
                                print ("</TR>\n");
                                for ($i=0; $i<$nfilas; $i++) {
                                    $resultat = mysql_fetch_array ($consulta);	

                                    $onmouseover= "this.className = 'resaltar'";
                                    print ('<TR onmouseover="' .$onmouseover. '" onmouseout="this.className = null">');			
                                    print ("<TD CLASS='izquierda separadorLineaH mayuscules' width=25%>" .$resultat["trutes_tipus"]. "</TD>\n");
                                    print ("<TD CLASS='izquierda separadorLineaH mayuscules' width=30%><a href='index.php?ctl=rutesDetall&id=".$resultat["trutes_id"]."'>" .$resultat["trutes_descripciobreu"]. "</a></TD>\n");	  
                                    print ("</TR>\n");
                                }

                                // NAVEGACIÓ
                                paginacio($page, $totalRegistros, $totalPaginas); 

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
            
<?php $contenido = ob_get_clean(); ?>   
<?php include $CONFIG['theme_dir']. 'templates/formLayout.php'; // plantilla general de la pàgina ?>            
<!-- FI Cos de la pàgina -->	
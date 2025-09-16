<?PHP

// procés d'actualització de les dades rebudes en un formulari d'inscripcio


// càrrega del model i els control·ladors
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-participant.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-inscripcio.php';


// Obtener valores introducidos en el formulario

	$nom = $_REQUEST["nom"];
	$cognoms = addslashes($_REQUEST["cognoms"]);
	$dni = $_REQUEST["dni"];
	$telefon = $_REQUEST["telefon"];
	$mail = $_REQUEST["mail"];
	$poblacio = addslashes($_REQUEST["poblacio"]);
	$naixement = $_REQUEST["naixement"];
	$entitat = addslashes($_REQUEST["entitat"]);
	$talla = $_REQUEST["talla"];
	$llicencia = $_REQUEST["llicencia"];
	$tipusllicencia = $_REQUEST["tipusllicencia"];
	$federacio = $_REQUEST["federacio"];
	$ef = $_REQUEST["ef"];	
	$sexe = $_REQUEST["sexe"];
	$adresa = addslashes($_REQUEST["adresa"]);
	$cp = $_REQUEST["cp"];		
	$soci = $_REQUEST["soci"];		
	$vegueria = $_REQUEST["vegueria"];		
	$autocar = $_REQUEST["autocar"];		        

	$idEsdeveniment =  $_REQUEST["idEsdeveniment"];		
	$preu = $_REQUEST["preuinscripcio"];
	$agree = $_REQUEST["agree"];
	$origen = $_REQUEST["origen"];		
        $dorsal = $_REQUEST["dorsal"];
        $pagat = $_REQUEST["pagat"];
        $incidencia = $_REQUEST["incidencia"];
        $observacions = $_REQUEST["observacions"];        
	
	$good_url = $_REQUEST["good_url"];
	$bad_url = $_REQUEST["bad_url"];
        $modo = $_REQUEST["modo"];
        $idInscripcio = $_REQUEST["idInscripcio"];
        $clau_inscripcio = $_REQUEST["clau_inscripcio"];

        $soci_aux = 'N';
        if (($soci == 'S') || ($vegueria == 'S')) {$soci_aux= 'S';}        
                
        // obtenir les dades de la persona i de l'inscripció
        $participant = new Participant('dni', $dni);
        $participant->nom = $nom;
        $participant->cognoms = $cognoms;
        $participant->dni = $dni;
        $participant->telefon = $telefon;
        $participant->mail = $mail;
        $participant->adresa = $adresa;
        $participant->poblacio = $poblacio;
        $participant->naixement = $naixement;
        $participant->entitat = $entitat;
        $participant->talla = $talla;
        $participant->llicencia = $llicencia;
        $participant->tipusllicencia = $tipusllicencia;
        $participant->federacio = $federacio;
        $participant->ef = $ef;
        $participant->sexe = $sexe;
        $participant->cp = $cp;
        $participant->soci = $soci;
        $participant->vegueria = $vegueria;        
        
        $inscripcio = New Inscripcio($idInscripcio);
        $inscripcio->idEsdeveniment = $idEsdeveniment;
        $inscripcio->preu = $preu;
        $inscripcio->agree = $agree;
        $inscripcio->clau = $clau_inscripcio;
        $inscripcio->origen = $origen;
        $inscripcio->feec = $ef;
        $inscripcio->autocar = $autocar;
        $inscripcio->soci = $soci_aux;
        $inscripcio->dorsal = $dorsal;
        $inscripcio->pagat = $pagat; 
        $inscripcio->incidencia = $incidencia;
        $inscripcio->obs = $observacions;                   
               
        try {						
				
            // inici de la transacció
             //$model->beginTX();
                       
            if($modo == 'modi') {                
                $consulta = $participant->update();					
                //if (!$consulta) throw new Exception('Error a la transacció');
    
                $consulta = $inscripcio->update();				
                //if (!$consulta) throw new Exception('Error a la transacció');   
            }                       
                        
            if ($modo == 'alta') {
                if ($participant->id == '') {
                    $consulta = $participant->insert(); 					
                    //if (!$consulta) throw new Exception('Error a la transacció');
            
                    // cridar el mètode d'obtenció del darrer id de participant
                    $participant->id = $model->getParticipantMaxId(); // mirar de resoldre per no cridar el model!!!!!                 
                    //if ($participant->id == '') throw new Exception('Error a la transacció'); 
                }
                else {
                    $consulta = $participant->update();	
                    //if (!$consulta) throw new Exception('Error a la transacció'); 
                }
                            
		$fecha = new DateTime();
		$clau_inscripcio = $fecha->format('U');	
                
                // crear objecte inscripció i cridar el mètode d'inserció 
                $inscripcio->idPersona = $participant->id;
                if ($preu == '') $inscripcio->preu = 0;                
                $consulta = $inscripcio->insert(SCM_MODUL_GESTIO);
		//if (!$consulta) throw new Exception('Error a la transacció');					                             
            }
							
            // commit de la transacció
            //$model->commitTX();    
								
            $url = AddURLParams($good_url,"ctl=g_inscripcioLlistat&esdeveniment=" .$idEsdeveniment, false);							
            Redirect($url);
        }
        catch (Exception $e) {
            $model->rollbackTX();
            //Redirect($bad_url);
        }
?>		

<?PHP

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
	//$naixement = $_REQUEST["naixement"];
        $naixement = date2UKformat ($_REQUEST["naixement"],'/');        
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

	$idEsdeveniment =  $_REQUEST["idFormulari"];		
	$preuinscripcio = $_REQUEST["preuinscripcio"];
	$agree = $_REQUEST["agree"];
	$origen = $_REQUEST["origen"];		
	
	$good_url = $_REQUEST["good_url"];
	$bad_url = $_REQUEST["bad_url"];	

    $soci_aux = 'N';
    if (($soci == 'S') || ($vegueria == 'S')) {$soci_aux= 'S';}	
        

    // validar si hi ha una inscripció per aquest nif i esdeveniment  
    $inscripcio = new Inscripcio('');       
    $inscripcio->getClauInscripcioPerDni($idEsdeveniment,$dni);
	if($inscripcio->clau <> '') {
		$url = AddURLParams($good_url,"ctl=inscripcioConfirm&clau=" .$inscripcio->clau. "&id=" .$idEsdeveniment, false);							
		Redirect($url);		
	}
	else
	{
        // verificar si ja existeix la persona donada d'alta al sistema
        $participant = new Participant('dni', $dni);            
            
        try {						
		// inici de la transacció
                // Instancia la classe Model, que contè la gestió d'accés a la BBDD
                //$model->beginTX();

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
                    
                if ($participant->id == '') {
                    // crear objecte participant, inicialitzar les dades i inserir-les en BBDD
                    $consulta = $participant->insert();
                    //if (!$consulta) throw new Exception('Error a la transacció');  
       
                    // cridar el mètode d'obtenció del id de participant
                    usleep(450000);
					//$participant->id = $participant->getParticipantPerDni($dni);
                    $participant->id = $participant->maxid(); // mirar de resoldre per no cridar el model!!!!!                 
                    if ($participant->id == '') throw new Exception('Error a la transacció');
                }
                else {
                    // crear objecte participant i actualitzar les dades en BBDD
                    $consulta = $participant->update();
                    //if (!$consulta) throw new Exception('Error a la transacció');                        
                }

		$fecha = new DateTime();
		$clau_inscripcio = $fecha->format('U');	

                // crear objecte inscripció i cridar el mètode d'inserció              
                $inscripcio->idPersona = $participant->id;
                $inscripcio->idEsdeveniment = $idEsdeveniment;
                $inscripcio->preu = ($preuinscripcio == '') ? 0 : $preuinscripcio;
                $inscripcio->pagat = ($preuinscripcio == '') ? 'S' : 'N';
                $inscripcio->agree = $agree;
                $inscripcio->clau = $clau_inscripcio;
                $inscripcio->origen = $origen;
                $inscripcio->feec = $ef;
                $inscripcio->autocar = $autocar;
                $inscripcio->soci = $soci_aux;
                $consulta = $inscripcio->insert('');
                
		//if (!$consulta) throw new Exception('Error a la transacció');					

                // commit de la transacció
		//$model->commitTX();
										
		$url = AddURLParams($good_url,"ctl=inscripcioConfirm&clau=" .$clau_inscripcio. "&id=" .$idEsdeveniment, false);							
		Redirect($url);
            }
            catch (Exception $e) {
                //$model->rollbackTX(); 
				echo $e;
				//Redirect($bad_url);
            }
	}
?>
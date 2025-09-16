<?PHP
    global $CONFIG;   
    
    require_once APP_PATH_ABS.'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-esdeveniments.php';
    require_once APP_PATH_ABS.'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-inscripcions.php';
    require_once APP_PATH_ABS.'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-participants.php';
    require_once APP_PATH_ABS.'/'.APP_PATH_INCLUDE.SCM_CRONO.'class/class-crono.php';

    $baixa = $_POST['baixa'];
    $numcontrol = $_POST['numcontrol'];
	$admin = $_POST['admin'];
    
    // cercar les dades de l'esdeveniment
    $esdeveniment = New Esdeveniments($_POST['esdeveniment']);
    if ($esdeveniment->existeix()) {

        // cercar les dades de l'inscripció per aquest esdeveniment i dorsal
        $inscripcio = New Inscripcions('','');
        $inscripcio->getIDInscripcioPerDorsal($_POST['esdeveniment'],$_POST['dorsal']);

        if ($inscripcio->getId() <> '') {

            // inserir el resultat
            $crono = New Crono('', '');
            $crono->getCronoPerControl($inscripcio->getId(), $numcontrol);
            
            if ($crono->getId() <> '') {
                print("<script>alert('AQUEST DORSAL JA HA ESTAT MARCAT PER AQUEST CONTROL');</script>"); 
				if ($admin == "1") {
					print("<script>alert('AMB AQUESTA ACCIÓ CANVIARÀS EL SEU ESTAT');</script>");					
					$crono->setBaixa($baixa);
					$tx = $crono->update();
				}	
            }
            else {
                $crono->getDorsalRetirat($inscripcio->getId());
                if ($crono->getId() == '') {
                    $crono->setIdInscripcio($inscripcio->getId());
                    $crono->setNumcontrol($numcontrol); 
                    $crono->setBaixa($baixa);
                    $tx= $crono->create();
                } else {
                    print("<script>alert('AQUEST DORSAL S\'HA RETIRAT AL CONTROL NUM. ".$crono->getNumcontrol()."');</script>");          
                }
            }  
            
            if ($tx) {
                if ($baixa == 'S') print("<script>alert('DORSAL RETIRAT OK');</script>");
                else  print("<script>alert('DORSAL AVANÇA OK');</script>");
            } else {
                  print("<script>alert('Error a l'actualitzar el dorsal);</script>");
            }    
            
        } else {
            // si no existeix la inscripció per aquell dorsal es llença misstage error
            print("<script>alert('DORSAL NO EXISTENT');</script>");
        }
    }
?>
<script type="text/javascript">    
    window.location="<?PHP echo $_POST["urlReturn"]; ?>";
</script>
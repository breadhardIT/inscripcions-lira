<?PHP

      
// càrrega del model i els control·ladors
require_once '../config.php';
require_once '../model.php';
require_once '../settings.php';
require_once 'class-inscripcio.php';


//Se utiliza echo "true" para indicar que el nif está disponible y echo "false" para indicar que el mismo ya está siendo utilizado	    
$inscripcio = New Inscripcio('');
$inscripcio->getClauInscripcioPerDni($_GET['id'],$_GET['dni']);   


if($inscripcio->clau == '') echo "true";
else echo "false";

?>

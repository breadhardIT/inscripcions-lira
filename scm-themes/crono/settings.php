<?php
// AWAKE RUNNERS configuration file

$url=$_SERVER['HTTP_HOST'];  // obtenció del domini on corre l'aplicació

/** CONFIGURACIÓ DE BBDD **/
if ($url == 'localhost') {
    define('SCM_DB_NAME', 'crono');           // El nombre de tu base de datos de WordPress 
    define('SCM_DB_USER', 'root');          // Tu nombre de usuario de MySQL 
    define('SCM_DB_PASSWORD', 'judithmr');  // Tu contraseña de MySQL
    define('SCM_DB_HOST', 'localhost');     // Host de MySQL (es muy probable que no necesites cambiarlo)
}
else {
    define('SCM_DB_NAME', 'gmlira_inscripcions');   // El nombre de tu base de datos de WordPress 
    define('SCM_DB_USER', 'gmlira');          // Tu nombre de usuario de MySQL 
    define('SCM_DB_PASSWORD', 'EpnF4T3C2dB9nEjf');        // Tu contraseña de MySQL
    define('SCM_DB_HOST', ' mysql.tecnofirm.net');           // Host de MySQL (es muy probable que no necesites cambiarlo) 
}
?>
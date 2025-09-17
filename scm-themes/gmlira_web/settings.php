<?php
// GMLIRA configuration file

// inclou definici� de parametres de configuraci� 
$CONFIG['DEFAULT_PAGE'] ='1';
$CONFIG['DEFAULT_PAGE_GESTIO'] ='ctl=gestioEsdevenimentsLlistat';

$CONFIG['environment'] = '/';

$CONFIG['TITLE'] = 'Grup Muntanyenc Lira Vendrellenca';
$CONFIG['URL_SITE'] = 'http://inscripcions.gmlira.cat';
$CONFIG['IMATGE_DEFAULT'] = 'images/gmlv.png';

if ($url == 'localhost') {
    define('SCM_DB_NAME', 'runnerselvendrell');           // El nombre de tu base de datos de WordPress 
    define('SCM_DB_USER', 'root');          // Tu nombre de usuario de MySQL 
    define('SCM_DB_PASSWORD', 'judithmr');  // Tu contraseña de MySQL
    define('SCM_DB_HOST', 'localhost');     // Host de MySQL (es muy probable que no necesites cambiarlo)
    
    define('SCM_PAYPAL_CMD', '_xclick');
    define('SCM_PAYPAL_LANDING_PAGE', 'Billing');
    define('SCM_PAYPAL_BUSINESS','runnerselvendrell-facilitator@gmail.com');
    define('SCM_PAYPAL_CURRENCY_CODE', 'EUR');
    define('SCM_PAYPAL_NO_NOTE','1');
    define('SCM_PAYPAL_NO_SHIPPING', '1');
    define('SCM_PAYPAL_RETURN', ''); //La URL de retorno, es la página donde será redirigido luego de realizar el pago.
    define('SCM_PAYPAL_CANCEL', ''); // La URL donde será redirigido si el client cancela el pago
    define('SCM_PAYPAL_STATUS', ''); // La URL donde se hará la verificación del pago  
    define('SCM_PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');  

    define('SCM_FORM_ROOT', '/gmlira_inscripcions/'); // arrel de les rutes de retorn als actions dels forms
    
    define('SCM_WP_MODEL', 'C:\Programas\AppServ\www\blog_gmlira\wp-load.php'); // arrel de la ruta de càrrega del model WP        
}
else {
    define('SCM_DB_NAME', 'gmlira_inscripcions');   // El nombre de tu base de datos de WordPress 
    define('SCM_DB_USER', 'gmlira');          // Tu nombre de usuario de MySQL 
    define('SCM_DB_PASSWORD', 'EpnF4T3C2dB9nEjf');        // Tu contraseña de MySQL
    define('SCM_DB_HOST', 'mysql.tecnofirm.net');           // Host de MySQL (es muy probable que no necesites cambiarlo) 
    
    define('SCM_PAYPAL_NAME', 'gmlira');
    define('SCM_PAYPAL_CMD', '_xclick');
    define('SCM_PAYPAL_LANDING_PAGE', 'Billing');
    define('SCM_PAYPAL_BUSINESS','inscripcions@gmlira.cat');
    define('SCM_PAYPAL_CURRENCY_CODE', 'EUR');
    define('SCM_PAYPAL_NO_NOTE','1');
    define('SCM_PAYPAL_NO_SHIPPING', '1');
    define('SCM_PAYPAL_RETURN', 'http://blog.gmlira.cat'); //La URL de retorno, es la página donde será redirigido luego de realizar el pago.
    define('SCM_PAYPAL_CANCEL', ''); // La URL donde será redirigido si el client cancela el pago
    define('SCM_PAYPAL_STATUS', ''); // La URL donde se hará la verificación del pago
    define('SCM_PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');
    
    define('SCM_FORM_ROOT', '/'); // arrel de les rutes de retorn als actions dels forms
    
    define('SCM_WP_MODEL', '/var/www/vhosts/gmlira.cat/subdominis/blog/wp-load.php'); // arrel de la ruta de càrrega del model WP    
}

// càrrega del model wordpress
//require_once SCM_WP_MODEL;

?>
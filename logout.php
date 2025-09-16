<?php
/* 
 * Cierra la sesión como usuario validado
 */
//session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/model.php';
require_once __DIR__ . '/settings.php';    
require_once __DIR__ . '/scm-include/class-login.php';

Login::logout();
header('location:login.php'); //saltamos a login.php

?>


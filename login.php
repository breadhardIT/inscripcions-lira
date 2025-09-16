<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( !defined('APP_PATH_ABS') )	define('APP_PATH_ABS', dirname(__FILE__) . '/');

require_once APP_PATH_ABS.'config.php';
require_once APP_PATH_ABS.'settings.php'; 
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'model/db.php';
require_once APP_PATH_ABS.APP_PATH_INCLUDE.'class/class-login.php';	

if ($_SERVER['REQUEST_METHOD']=='POST') { // ¿Nos mandan datos por el formulario?

    //verificamos el usuario y contraseña mandados
    $Login = new Login();
    if ($Login->inici($_POST['usuario'],$_POST['password'])) {	
	
       //acciones a realizar cuando un usuario se identifica
       //EJ: almacenar en memoria sus datos, registrar un acceso a una tabla de datos
       //Estas acciones se veran en los siguientes tutorianes en http://www.emiliort.com
	   
        //saltamos al inicio del área restringida
	header('location:index.php?ctl='.PAGE_DEFAULT_GESTIO);
        die();
    } else {
        //acciones a realizar en un intento fallido
        //Ej: mostrar captcha para evitar ataques fuerza bruta, bloqueas durante un rato esta ip, ....
        //Estas acciones se veran en los siguientes tutorianes en http://www.emiliort.com

        //preparamos un mensaje de error y continuamos para mostrar el formulario
        $mensaje='Usuari o contrasenya incorrectes.';
    }
} //fin if post
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <?PHP print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/login.css" rel="stylesheet" type="text/css" /> '); ?>
        <title>Grup Muntanyenc Lira Vendrellenca</title>
    </head>
    <body>
	<div id="cosprincipal" class="cosprincipal">	
            <?php					
                //si hay algún mensaje de error lo mostramos escapando los carácteres html
                if (!empty($mensaje)) echo('<h2>'.htmlspecialchars($mensaje).'</h2>');
            ?>
            <form action="index.php?ctl=login" method="post" class="login">
		<div>
                    <?PHP print("<img border='0' class='logo' src='"  .SCM_PATH_THEME.SCM_THEME. "images/gmlv.png' width='115' height='115'>"); ?>
                    <h1>Grup Muntanyenc<br>Lira Vendrellenca</h1>
		</div>
		<div>
                    <?PHP print("<img border='0' class='icons' src='" .SCM_PATH_THEME.SCM_THEME. "images/user_suit.png'>"); ?>
                    <input name="usuario" type="text" size="50" value="usuari" onfocus="if(this.value=='usuari') this.value=''"
    onblur="if(this.value=='') this.value='usuari'" />
		</div>
		<div>
                    <?PHP print("<img border='0' class='icons' src='"  .SCM_PATH_THEME.SCM_THEME. "images/key.png'>"); ?>
                    <input name="password" type="password" size="50" value="password" onfocus="if(this.value=='password') this.value=''"
    onblur="if(this.value=='') this.value='usuari'" />
		</div>
		<div><input name="login" type="submit" value="entrar >>"></div>
            </form>
	</div>
    </body>
</html>
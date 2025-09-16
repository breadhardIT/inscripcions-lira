<?PHP

    global $CONFIG;   
    ob_start(); 
    
    print('<link href="'.SCM_PATH_THEME.SCM_THEME.'css/diploma.css" rel="stylesheet" type="text/css" /> ');

?>

<?PHP     
    $temps = $_REQUEST['temps'];
    $participant = $_REQUEST['participant'];
?>

<body>
	<div id="nom">
            <h2><?PHP print($participant);?></h2>
	</div>
        
        <?PHP $aux = explode(":", $temps);  ?> 
        <div id="hora">
            <h3><?PHP  print($aux[0]);?></h3>	
        </div>    
        <div id="minuts">
            <h3><?PHP print($aux[1]);?></h3>            
        </div>
</body>

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME. 'templates/popupLayout.php'; // plantilla general de la pàgina ?>

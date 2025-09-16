<?PHP ob_start(); ?>
<?PHP
     
    global $CONFIG;   
	
	print("<script>alert('AMB AQUESTA ACCIÓ ESBORRARÀS TOTS EL RESULTATS REGISTRATS AL SISTEMA');</script>");
	
    $query = "TRUNCATE gmlira_inscripcions.INSCRIPCIONS_CRONO";
    $resultat = DB::query($query)->execute();
		
    print("<script>alert('RESULTATS ESBORRATS OK');</script>");
?>
<script type="text/javascript">    
    window.location="index.php?ctl=controlPasAdmin";
</script>

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'templates/mobileLayoutAdmin.php'; // plantilla general de la pàgina ?>  
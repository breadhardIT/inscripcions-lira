<?php
/*
 * layout principal pàgines mobil
 */   
?>

<html>    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
        <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <?php
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
        ?>        
    </head>    
    <body class="ui-mobile-viewport ui-overlay-a">
        <div data-role="page">
            <div data-role="header">
                <h1>CONTROL DE PAS</h1>
            </div>
            <div data-role="main" class="ui-content" style="text-align: center;">
                <img src="<?PHP echo APP_PATH.APP_PATH_THEME.APP_THEME?>img/logo_gmlira_transp.png" width="150">  

                <?php echo $contenido; ?>
                
            </div>
        </div>            
    </body>
</html>    
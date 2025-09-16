<?php
/*
 * layout principal pàgines aplicació
 */   
?>

<html>    
    <?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'/templates/mainHeadTemplate.php'; ?>
    
    <body class="skin-blue layout-top-nav">
        <div class="wrapper" style="height: auto; min-height: 100%;">        
            <!-- start: main header -->            
            <?php include APP_PATH_ABS.APP_PATH_THEME.APP_THEME.'/templates/homeHeaderTemplate.php'; ?>
            <!-- end: main header -->            

            <!-- start: content-wrapper -->                        
            <div class="content-wrapper">
                    <?php echo $contenido; ?>
            </div>
            <!-- end: content-wrapper -->            
            
            <!-- start: FOOTER -->
            <footer class="main-footer">
                <div class="container"></div>
            </footer>    
            <!-- end: FOOTER -->                
        </div>
    </body>
</html>    
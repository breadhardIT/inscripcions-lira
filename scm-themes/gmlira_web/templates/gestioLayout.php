<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * layout principal pàgines aplicació
 */

    
global $CONFIG;
?>

<!-- Fonts  -->
    <link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/fonts/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/fonts/glyphicons-halflings.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- end: Font -->



<body class="page">
    
<?php //get_header(); ?>

<div class="grid grid-pad">
	<div class="col-1-1">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">    
                    
                    <article id="" class=" page type-page status-publish hentry">
                        <header class="entry-header">
                            <h1 class="page-entry-title">Inscripcions</h1>
                        </header><!-- .entry-header -->

                            <?php echo $contenido; ?>

                    </article><!-- #post-## -->
    
            </main><!-- #main -->
        </div><!-- #primary -->
	</div>
</div>
<?php //get_footer(); ?>

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

    
<?php //get_header(); ?>

<div class="grid grid-pad">
    <div class="col-9-12">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">    
                    
                    <article id="" class=" page type-page status-publish hentry">
                        <header class="entry-header">
                            <h1 class="page-entry-title">Inscripcions <?php echo $esdeveniment->nom; ?></h1>
                        </header><!-- .entry-header -->
                        <?php echo $contenido; ?>                        
                    </article><!-- #post-## -->
    
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
    <?php //get_sidebar(); ?>
</div>
<?php //get_footer(); ?>

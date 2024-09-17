<?php
/*
Template Name: Order Template
*/

get_header();
?>

<div class="wrapper">
    
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="clearfix"></div>
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();
            ?>
          
            
        <?php
            the_content();
            
            // End of the loop.
            endwhile;
            ?>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
</div><!-- .container -->

<?php get_footer(); ?>

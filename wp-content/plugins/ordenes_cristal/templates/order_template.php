<?php
/*
Template Name: Order Template
*/

get_header();
?>

<div class="container">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();

            ?>
                <h1>hola</h1>

            <?php
                // End of the loop.
            endwhile;
            ?>
        </main><!-- .site-main -->
    </div><!-- .content-area -->
</div><!-- .container -->

<?php get_footer(); ?>

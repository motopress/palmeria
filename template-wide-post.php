<?php
/**
 *
 * Template Name: Wide
 * Template Post Type: post, mphb_room_type, mphb_room_service
 *
 * The template for displaying wide single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Palmeria
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/content', get_post_type() );

                get_template_part('template-parts/biography');

                palmeria_the_post_navigation();

                palmeria_related_posts($post);

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();

<?php
/**
 * Template part for displaying page content in template-front-page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Palmeria
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="front-page-header-wrapper">

        <?php palmeria_post_thumbnail('palmeria-x-large'); ?>

        <div class="wrapper">
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->
            <?php
            if(has_excerpt()):
            ?>
                <div class="page-excerpt">
                    <?php
                    the_excerpt();
                    ?>
                </div>
            <?php
            endif;
            ?>
        </div>

    </div>

    <?php
    if(is_active_sidebar('sidebar-front-page')):
    ?>
    <div class="front-page-sidebar">
        <?php
        dynamic_sidebar('sidebar-front-page');
        ?>
    </div>
    <?php
    endif;

    ?>
    <div class="wrapper">
        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'palmeria' ),
                'after'  => '</div>',
            ) );
            ?>
        </div><!-- .entry-content -->
    </div>

    <?php
        palmeria_child_pages_list();
    ?>

    <?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Edit <span class="screen-reader-text">%s</span>', 'palmeria' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

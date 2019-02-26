<?php
/**
 * The template part for displaying an Author biography
 *
 * @package Palmeria
 */

if( ("post" != get_post_type()) || (!get_the_author_meta('description')) ) {
    return;
}


if ( function_exists('jetpack_author_bio') ) :

    if( boolval( get_option( 'jetpack_content_author_bio', true ) ) ) :
    ?>
        <div class="post-author">
            <?php
                jetpack_author_bio();
            ?>
        </div>
    <?php
    endif;
else :
    ?>
    <div class="post-author">
        <div class="author-avatar">
            <?php echo get_avatar(get_the_author_meta('ID'), 120) ?>
        </div>
        <div class="author-heading">
            <h2 class="author-title"><span class="author-name"><?php echo esc_html(get_the_author_meta('display_name'));?> </span></h2>
        </div>
        <p class="author-bio">
            <?php the_author_meta( 'description' ); ?>
            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                <?php printf( esc_html__( 'All posts by %s', 'palmeria' ), get_the_author() ); ?>
            </a>
        </p>

    </div><?php
endif;
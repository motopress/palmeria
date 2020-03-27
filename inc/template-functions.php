<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Palmeria
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function palmeria_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if(has_post_thumbnail()){
        $classes[] = 'has-thumbnail';
    }

	return $classes;
}
add_filter( 'body_class', 'palmeria_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function palmeria_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'palmeria_pingback_header' );

function palmeria_comment_form_default_fields($fields){

    if(isset($fields['url'])){
        unset($fields['url']);
    }

    return $fields;
}
add_filter('comment_form_default_fields', 'palmeria_comment_form_default_fields');

function palmeria_read_more_link($link) {

    if( ( is_home() || is_archive()) && get_theme_mod('palmeria_blog_layout', PALMERIA_BLOG_LAYOUT_2) == PALMERIA_BLOG_LAYOUT_2 ){
        return '<span class="read-more-wrapper">'.$link.'</span>';
    }

    return $link;
}
add_filter( 'the_content_more_link', 'palmeria_read_more_link' );

function palmeria_calculate_image_srcset_meta(){
    return false;
}

function palmeria_filter_getwid_pagination($pagination_atts){

    $pagination_atts['prev_text'] = esc_html__('Previous', 'palmeria');
    $pagination_atts['next_text'] = esc_html__('Next', 'palmeria');

    return $pagination_atts;
}

add_filter('getwid/blocks/custom_post_type/pagination_args', 'palmeria_filter_getwid_pagination');
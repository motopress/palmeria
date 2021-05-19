<?php
/**
 * Palmeria Theme Customizer
 *
 * @package Palmeria
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function palmeria_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'palmeria_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'palmeria_customize_partial_blogdescription',
		) );
	}

    $wp_customize->add_panel('palmeria_theme_options', array(
        'title' => esc_html__('Theme Options', 'palmeria')
    ));
    $wp_customize->add_section('palmeria_blog', array(
        'title' => esc_html__('Blog Options', 'palmeria'),
        'panel' => 'palmeria_theme_options'
    ));
    $wp_customize->add_setting('palmeria_blog_layout', array(
        'default' => PALMERIA_BLOG_LAYOUT_2,
        'transport' => 'refresh',
        'type' => 'theme_mod',
        'sanitize_callback' => 'palmeria_sanitize_select'
    ));
    $wp_customize->add_control('palmeria_blog_layout', array(
        'label' => esc_html__('Blog Layout', 'palmeria'),
        'type' => 'select',
        'section' => 'palmeria_blog',
        'choices' => array(
            PALMERIA_BLOG_LAYOUT_1 => esc_html__('Classic Wide', 'palmeria'),
            PALMERIA_BLOG_LAYOUT_2 => esc_html__('Classic Boxed', 'palmeria'),
        ),
        'settings' => 'palmeria_blog_layout'
    ));

    $wp_customize->add_section('palmeria_colors', array(
        'title' => esc_html__('Theme Colors', 'palmeria'),
        'panel' => 'palmeria_theme_options'
    ));

    $wp_customize->add_setting('palmeria_header_overlay_color', array(
        'default' => PALMERIA_HEADER_OVERLAY_COLOR,
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'palmeria_header_overlay_color', array(
        'label' => esc_html__('Header Overlay Color', 'palmeria'),
        'section' => 'palmeria_colors',
    )));

    $wp_customize->add_setting('palmeria_header_overlay_opacity', array(
        'default' => 50,
        'transport' => 'postMessage',
        'type' => 'theme_mod',
        'sanitize_callback' => 'absint'

    ));
    $wp_customize->add_control('palmeria_header_overlay_opacity', array(
        'label' => esc_html__('Header Overlay Opacity', 'palmeria'),
        'type' => 'number',
        'section' => 'palmeria_colors',
        'input_attrs' => array(
            'min' => 1,
            'step' => 1,
            'max' => 100,
        ),
        'settings' => 'palmeria_header_overlay_opacity'

    ));

    $wp_customize->add_setting('palmeria_accent_color', array(
        'default' => PALMERIA_ACCENT_COLOR,
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'palmeria_accent_color', array(
        'label' => esc_html__('Accent Color', 'palmeria'),
        'section' => 'palmeria_colors',
    )));

    $wp_customize->add_section('palmeria_footer', array(
        'title' => esc_html__('Footer Options', 'palmeria'),
        'panel' => 'palmeria_theme_options'
    ));

	/* translators: %1$s: current year, %2$s: blogname. */
	$footer_default_text = _x('%2$s &copy; %1$s All Rights Reserved.<br> <span style="opacity: .8;">Powered by <a href="https://motopress.com/products/category/hotel-rental-wordpress-themes/" rel="nofollow">MotoPress</a>.</span>', 'Default footer text. %1$s - current year, %2$s - site title.', 'palmeria');
    $wp_customize->add_setting('palmeria_footer_text', array(
        'default' => $footer_default_text,
        'transport' => 'postMessage',
        'type' => 'theme_mod',
        'sanitize_callback' => 'wp_kses_post'
    ));
    $wp_customize->add_control('palmeria_footer_text', array(
        'label' => esc_html__('Footer Text', 'palmeria'),
        'description' => esc_html__('Use %1$s to insert the current year and %2$s - the site title. Doesn`t work for Live Preview.', 'palmeria'),
        'section' => 'palmeria_footer',
        'type' => 'textarea',
        'settings' => 'palmeria_footer_text'
    ));
    /**
     * Booking settings
     */
    if(class_exists('HotelBookingPlugin')) {

        $wp_customize->add_section('palmeria_booking', array(
            'title' => esc_html__('Booking Options', 'palmeria'),
            'panel' => 'palmeria_theme_options'
        ));
        $wp_customize->add_setting('palmeria_accommodation_list_layout', array(
            'default' => PALMERIA_ACCOMMODATION_LIST_LAYOUT_2,
            'transport' => 'refresh',
            'type' => 'theme_mod',
            'sanitize_callback' => 'palmeria_sanitize_select'

        ));
        $wp_customize->add_control('palmeria_accommodation_list_layout', array(
            'label' => esc_html__('Rooms List Layout', 'palmeria'),
            'type' => 'select',
            'section' => 'palmeria_booking',
            'choices' => array(
                PALMERIA_ACCOMMODATION_LIST_LAYOUT_1 => esc_html__('Classic', 'palmeria'),
                PALMERIA_ACCOMMODATION_LIST_LAYOUT_2 => esc_html__('Masonry', 'palmeria'),
            ),
            'settings' => 'palmeria_accommodation_list_layout'

        ));
        $wp_customize->add_setting('palmeria_search_accommodation_list_layout', array(
            'default' => PALMERIA_ACCOMMODATION_LIST_LAYOUT_2,
            'transport' => 'refresh',
            'type' => 'theme_mod',
            'sanitize_callback' => 'palmeria_sanitize_select'

        ));
        $wp_customize->add_control('palmeria_search_accommodation_list_layout', array(
            'label' => esc_html__('Search Result Rooms List Layout', 'palmeria'),
            'type' => 'select',
            'section' => 'palmeria_booking',
            'choices' => array(
                PALMERIA_ACCOMMODATION_LIST_LAYOUT_1 => esc_html__('Classic', 'palmeria'),
                PALMERIA_ACCOMMODATION_LIST_LAYOUT_2 => esc_html__('Masonry', 'palmeria'),
            ),
            'settings' => 'palmeria_search_accommodation_list_layout'

        ));
    }

    if(class_exists('WooCommerce')){

	    $wp_customize->add_section( 'palmeria_shop', array(
		    'title' => esc_html__( 'Shop Options', 'palmeria' ),
		    'panel' => 'palmeria_theme_options'
	    ) );

	    $wp_customize->add_setting( 'palmeria_shop_image', array(
		    'sanitize_callback' => 'palmeria_sanitize_image'
	    ) );

	    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'palmeria_shop_image', array(
		    'label'    => esc_html__( 'Shop Pages Header Image', 'palmeria' ),
		    'section'  => 'palmeria_shop',
		    'settings' => 'palmeria_shop_image',
		    'description' => esc_html__( 'By installing this image, it will be displayed as a header image on all WooCommence pages.', 'palmeria' ),
	    ) ) );
    }

}
add_action( 'customize_register', 'palmeria_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function palmeria_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function palmeria_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function palmeria_customize_preview_js() {
	wp_enqueue_script( 'palmeria-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), palmeria_get_theme_version(), true );
}
add_action( 'customize_preview_init', 'palmeria_customize_preview_js' );

function palmeria_sanitize_select( $input, $setting ){

    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible select options
    $choices = $setting->manager->get_control( $setting->id )->choices;

    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

/**
 * Sanitize text
 */
function palmeria_sanitize_text($txt){
    return wp_kses_post($txt);
}

function palmeria_header_overlay_css(){

    $background = get_theme_mod('palmeria_header_overlay_color', PALMERIA_HEADER_OVERLAY_COLOR);
    $opacity = get_theme_mod('palmeria_header_overlay_opacity', PALMERIA_HEADER_OVERLAY_OPACITY);

    $css = 'body.page-template-template-front-page .site-content .site-main > .hentry .front-page-header-wrapper::after,
            .custom-header::after {    
                background: '.$background.';
                opacity: .'.$opacity.';
            }';

    if( $background != PALMERIA_HEADER_OVERLAY_COLOR || $opacity != PALMERIA_HEADER_OVERLAY_OPACITY ){
        return $css;
    }else{
        return '';
    }

}

function palmeria_accent_color_css(){

    $color = get_theme_mod('palmeria_accent_color', PALMERIA_ACCENT_COLOR);

    $css = 'button:hover, button:focus,
        input[type="button"]:hover,
        input[type="button"]:focus,
        input[type="reset"]:hover,
        input[type="reset"]:focus,
        input[type="submit"]:hover,
        input[type="submit"]:focus,
        .more-link:hover,
        .more-link:focus,
        .button:hover,
        body.infinite-scroll .site-main #infinite-handle button:hover,
        .button:focus,
        body.infinite-scroll .site-main #infinite-handle button:focus{
            background-color: '.$color.';
            border-color: '.$color.';
        }
        .wp-block-getwid-custom-post-type__post-title a:hover,
        .wp-block-getwid-post-carousel__post-title a:hover,
        .wp-block-getwid-recent-posts__post-title a:hover,
        .related-posts ul li a.post-title:hover,
        .entry-meta > span a:hover,
        .comments-area .comment-list .comment .comment-meta .comment-reply-link:hover,
        .comments-area .comment-list .pingback .comment-meta .comment-reply-link:hover,
        body.blog .hentry .entry-header .entry-title a:hover,
        body.archive .hentry .entry-header .entry-title a:hover,
        body.search .hentry .entry-header .entry-title a:hover,
        .post-navigation .nav-previous a .post-title:hover, .post-navigation .nav-next a .post-title:hover,
        .search-form .search-submit:hover,
        a, a:visited, a:hover, a:focus, a:active,
        .mphb-calendar .datepick-ctrl a,
        .datepick-popup .datepick-ctrl a,
        .datepick-popup .mphb-datepick-popup .datepick-month td .datepick-today,
        .mphb-view-details-button,
        .mphb-view-details-button:hover, .mphb-view-details-button:focus,
        .mphb-view-details-button:visited,
        .mphb_sc_services-wrapper .type-mphb_room_service .mphb-service-title a:hover,
        .mphb_sc_search_results-wrapper .mphb-room-type-title:hover,
        .mphb_sc_rooms-wrapper .mphb-room-type-title:hover,
        .mphb_sc_room-wrapper .mphb-room-type-title:hover{
            color:'.$color.';
        }
        .wp-block-button .wp-block-button__link:focus,
        .wp-block-button .wp-block-button__link:hover,
        .wp-block-file a.wp-block-file__button:hover, 
        .wp-block-file a.wp-block-file__button:focus,
        .wp-block-getwid-images-slider .slick-arrow:hover, 
        .wp-block-getwid-media-text-slider .slick-arrow:hover, 
        .wp-block-getwid-post-slider .slick-arrow:hover, 
        .wp-block-getwid-post-carousel .slick-arrow:hover,
        .wp-block-getwid-images-slider.has-arrows-inside .slick-arrow:hover, 
        .wp-block-getwid-media-text-slider.has-arrows-inside .slick-arrow:hover, 
        .wp-block-getwid-post-slider.has-arrows-inside .slick-arrow:hover, 
        .wp-block-getwid-post-carousel.has-arrows-inside .slick-arrow:hover,
        .mphb-calendar.mphb-datepick .datepick-month td .datepick-selected,
        .datepick-popup .mphb-datepick-popup .datepick-month td .datepick-selected,
        .datepick-popup .mphb-datepick-popup .datepick-month td a.datepick-highlight,
        .mphb-calendar.mphb-datepick .datepick-month td .mphb-booked-date,
        body .mphb-flexslider.flexslider ul.flex-direction-nav a:hover,
        body .flexslider ul.flex-direction-nav a:hover{
            background-color: '.$color.'; 
        }' ;

    if( $color != PALMERIA_ACCENT_COLOR ){
        return $css;
    }else{
        return '';
    }

}


function palmeria_customizer_css(){

    $all_css = palmeria_header_overlay_css();
    $all_css .= palmeria_accent_color_css();

    wp_add_inline_style('palmeria-style', $all_css);

}

add_action('wp_enqueue_scripts', 'palmeria_customizer_css');



function palmeria_sanitize_image( $input, $setting ) {
	return esc_url_raw( palmeria_validate_image( $input, $setting->default ) );
}

function palmeria_validate_image( $input, $default = '' ) {
	// Array of valid image file types
	// The array includes image mime types
	// that are included in wp_get_mime_types()
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
	);
	// Return an array with file extension
	// and mime_type
	$file = wp_check_filetype( $input, $mimes );
	// If $input has a valid mime_type,
	// return it; otherwise, return
	// the default.
	return ( $file['ext'] ? $input : $default );
}

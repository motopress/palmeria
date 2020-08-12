<?php
/**
 * Palmeria functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Palmeria
 */

if ( ! function_exists( 'palmeria_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function palmeria_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Palmeria, use a find and replace
		 * to change 'palmeria' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'palmeria', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size(892);

		add_image_size('palmeria-cropped', 892, 594, true);
		add_image_size('palmeria-thumbnail-cropped', 150, 100, true);
		add_image_size('palmeria-square', 892, 892, true);
		add_image_size('palmeria-x-large', 2560);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'palmeria' ),
			'menu-2' => esc_html__( 'Footer', 'palmeria' ),
			'menu-3' => esc_html__( 'Footer Socials', 'palmeria' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'palmeria_custom_background_args', array(
			'default-color' => 'f6f6f6',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 50,
			'flex-width'  => true,
			'flex-height' => true,
		) );

        add_post_type_support( 'page', 'excerpt' );

        add_theme_support('align-wide');

        add_theme_support( 'editor-color-palette', array(
            array(
                'name' => esc_html__( 'black', 'palmeria' ),
                'slug' => 'black',
                'color' => '#2c2c2c',
            ),
            array(
                'name' => esc_html__( 'dark gray', 'palmeria' ),
                'slug' => 'dark-gray',
                'color' => '#3e3f46',
            ),
            array(
                'name' => esc_html__( 'gray', 'palmeria' ),
                'slug' => 'gray',
                'color' => '#ddd',
            ),
            array(
                'name' => esc_html__( 'light gray', 'palmeria' ),
                'slug' => 'light-gray',
                'color' => '#afb2bb',
            ),
            array(
                'name' => esc_html__( 'whitesmoke', 'palmeria' ),
                'slug' => 'whitesmoke',
                'color' => '#f6f6f6',
            ),
            array(
                'name' => esc_html__( 'red', 'palmeria' ),
                'slug' => 'red',
                'color' => '#b34a4a',
            )

        ) );


        add_theme_support('responsive-embeds');
        add_theme_support('editor-styles');

        /*
        * This theme styles the visual editor to resemble the theme style,
        * specifically font, colors, icons, and column width.
        */
        add_editor_style( array( 'css/editor-style.css', palmeria_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'palmeria_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function palmeria_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'palmeria_content_width', 672 );
}
add_action( 'after_setup_theme', 'palmeria_content_width', 0 );

function palmeria_adjust_content_width() {
    global $content_width;

    if(is_page_template('template-wide-page.php') || is_page_template('template-wide-post.php') || is_page_template('template-front-page.php')){
        $content_width = 896;
    }

}
add_action( 'template_redirect', 'palmeria_adjust_content_width');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function palmeria_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'palmeria' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'palmeria' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Sidebar', 'palmeria' ),
		'id'            => 'sidebar-front-page',
		'description'   => esc_html__( 'Add widgets here.', 'palmeria' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title hidden">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'palmeria_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function palmeria_scripts() {

    wp_enqueue_style('palmeria-fonts', palmeria_fonts_url(), array(), null);

	wp_enqueue_style( 'palmeria-style', get_stylesheet_uri(), array(), palmeria_get_theme_version() );

    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/fontawesome/css/all.css', array(), '5.11.2');

	wp_enqueue_script( 'palmeria-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), palmeria_get_theme_version(), true );

	wp_enqueue_script( 'palmeria-navigation', get_template_directory_uri() . '/js/navigation.js', array(), palmeria_get_theme_version(), true );

	wp_enqueue_script( 'palmeria-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), palmeria_get_theme_version(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'palmeria_scripts' );

/**
 * Define globals
 */

define('PALMERIA_ACCOMMODATION_LIST_LAYOUT_1', 'classic');
define('PALMERIA_ACCOMMODATION_LIST_LAYOUT_2', 'masonry');

define('PALMERIA_BLOG_LAYOUT_1', 'classic-wide-blog');
define('PALMERIA_BLOG_LAYOUT_2', 'classic-boxed-blog');

define('PALMERIA_ACCENT_COLOR', '#b34a4a');

define('PALMERIA_HEADER_OVERLAY_COLOR', '#3e3e46');
define('PALMERIA_HEADER_OVERLAY_OPACITY', 50);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Demo import.
 */
require get_template_directory() . '/inc/demo-import.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * TGM init.
 */
require get_template_directory() . '/inc/tgmpa-init.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load MP Hotel Booking Compatibility file.
 */
if( class_exists('HotelBookingPlugin') ){
    require get_template_directory() . '/inc/mphb-functions.php';
}

function palmeria_get_theme_version() {
    $theme_info = wp_get_theme( get_template() );

    return $theme_info->get( 'Version' );
}



if ( ! function_exists( 'palmeria_fonts_url' ) ) :
    /**
     * Register Google fonts for palmeria.
     *
     * Create your own palmeria_fonts_url() function to override in a child theme.
     *
     * @since palmeria 1.0.0
     *
     * @return string Google fonts URL for the theme.
     */
    function palmeria_fonts_url() {
        $fonts_url     = '';
        $font_families = array();

        /**
         * Translators: If there are characters in your language that are not
         * supported by Libre Baskerville, translate this to 'off'. Do not translate
         * into your own language.
         */
        $meriweather = esc_html_x( 'on', 'Libre Baskerville font: on or off', 'palmeria' );
        if ( 'off' !== $meriweather) {
            $font_families[] = 'Libre Baskerville:400,400i,700,700i';
        }
        /**
         * Translators: If there are characters in your language that are not
         * supported by Open Sans, translate this to 'off'. Do not translate
         * into your own language.
         */
        $osans = esc_html_x( 'on', 'Open Sans font: on or off', 'palmeria' );
        if ( 'off' !== $osans) {
            $font_families[] = 'Open Sans:300,400,400i,700, 700i';
        }

        $query_args    = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext,cyrillic' ),
        );
        if ( $font_families ) {
            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return esc_url_raw( $fonts_url );
    }
endif;

/**
 * Filters the title of the default page template displayed in the drop-down.
 */
function palmeria_default_page_template_title() {
    return esc_html__( 'Boxed', 'palmeria' );
}
add_filter( 'default_page_template_title', 'palmeria_default_page_template_title' );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 */
function palmeria_widget_tag_cloud_args( $args ) {
    $args['largest']  = 0.75;
    $args['smallest'] = 0.75;
    $args['unit']     = 'rem';

    return $args;
}
add_filter( 'widget_tag_cloud_args', 'palmeria_widget_tag_cloud_args' );

if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
<?php
/**
 *
 * Demo data
 *
 **/

function palmeria_ocdi_import_files() {
    $import_notice = '<h4>' . esc_html__( 'Important note before importing sample data.', 'palmeria' ) . '</h4>';
    $import_notice .= esc_html__( 'Data import is generally not immediate and can take up to 10-15 minutes.', 'palmeria' ) . '<br/>';
    $import_notice .= esc_html__( 'After you import this demo, you will have to configure the Contact Form separately.', 'palmeria' );

    $import_notice = wp_kses(
        $import_notice,
        array(
            'a' => array(
                'href' => array(),
            ),
            'ol' => array(),
            'li' => array(),
            'h4' => array(),
            'br' => array(),
        )
    );

    return array(
        array(
            'import_file_name'             => 'Demo Import 1',
            'import_file_url'              => 'https://raw.githubusercontent.com/motopress/palmeria/master/assets/demo-data/palmeria.xml',
            'import_widget_file_url'       => 'https://raw.githubusercontent.com/motopress/palmeria/master/assets/demo-data/palmeria-widgets.wie',
            'import_preview_image_url'     => '',
            'import_notice'                => $import_notice,
            'preview_url'                  => 'https://themes.getmotopress.com/palmeria/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'palmeria_ocdi_import_files' );

function palmeria_ocdi_after_import_setup() {

    // Assign menus to their locations.
    $menu1 = get_term_by( 'slug', 'primary-menu', 'nav_menu' );
    $menu2 = get_term_by( 'slug', 'socials-menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'menu-1' => $menu1->term_id,
            'menu-2' => $menu1->term_id,
            'menu-3' => $menu2->term_id
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Welcome to Palmeria Hotel' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );


    // Assign Hotel Booking default pages.
    $search_results_page = get_page_by_title('Search Results');
    $booking_confirmation_page = get_page_by_title('Booking Confirmation');
    $terms_conditions_page = get_page_by_title('Terms & Conditions');
    $booking_confirmed_page = get_page_by_title('Booking Confirmed');
    $booking_cancelled_page = get_page_by_title('Booking Cancelled');

    update_option('mphb_search_results_page', $search_results_page->ID);
    update_option('mphb_checkout_page', $booking_confirmation_page->ID);
    update_option('mphb_terms_and_conditions_page', $terms_conditions_page->ID);
    update_option('mphb_booking_confirmation_page',$booking_confirmed_page->ID);
    update_option('mphb_user_cancel_redirect_page', $booking_cancelled_page->ID);

    //update taxonomies
    $update_taxonomies = array(
        'post_tag',
        'category'
    );
    foreach ($update_taxonomies as $taxonomy ) {
        palmeria_ocdi_update_taxonomy( $taxonomy );
    }

    // skip hotel booking wizard
    update_option( 'mphb_wizard_passed', true);

    //set site default logo
    $args = array(
        'post_type' => 'attachment',
        'name' => 'ciestra_logo',
        'posts_per_page' => 1,
        'post_status' => 'inherit',
    );
    $_logo = get_posts( $args );
    $logo = $_logo ? array_pop($_logo) : null;
    if($logo){
        set_theme_mod('custom_logo', $logo->ID);
    }


}
add_action( 'pt-ocdi/after_import', 'palmeria_ocdi_after_import_setup' );

// Disable generation of smaller images (thumbnails) during the content import
//add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

// Disable the branding notice
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function palmeria_ocdi_update_taxonomy( $taxonomy ) {
    $get_terms_args = array(
        'taxonomy' => $taxonomy,
        'fields' => 'ids',
        'hide_empty' => false,
    );

    $update_terms = get_terms($get_terms_args);
    if ( $taxonomy && $update_terms ) {
        wp_update_term_count_now($update_terms, $taxonomy);
    }
}

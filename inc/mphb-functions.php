<?php
function palemria_mphb_scripts(){
    wp_enqueue_style('palmeria-mphb-style', get_template_directory_uri() . '/css/motopress-hotel-booking.css', array(), palmeria_get_theme_version());
}
add_action('wp_enqueue_scripts', 'palemria_mphb_scripts');

add_filter( 'mphb_loop_room_type_gallery_main_slider_image_size', function ($size){
    return 'palmeria-square';
});

add_filter( 'mphb_loop_room_type_thumbnail_size', function ($size){
    return 'palmeria-square';
});

add_filter( 'mphb_loop_room_type_gallery_nav_slider_image_size', function ($size){
    return 'palmeria-thumbnail-cropped';
});

add_filter('mphb_loop_room_type_gallery_use_nav_slider', 'palmeria_remove_mphb_nav_gallery');
function palmeria_remove_mphb_nav_gallery(){
    return false;
}

add_filter('mphb_sc_rooms_wrapper_class', 'palmeria_mphb_accommodation_list_type');
if(!function_exists('palmeria_mphb_accommodation_list_type')){
    function palmeria_mphb_accommodation_list_type($classes){

        $list_layout =  get_theme_mod('palmeria_accommodation_list_layout', PALMERIA_ACCOMMODATION_LIST_LAYOUT_2);
        if($list_layout){
            $classes.= ' '.$list_layout;
        }


        return $classes;
    }
}

add_filter('mphb_sc_search_results_wrapper_class', 'palmeria_mphb_sr_accommodation_list_type');
if(!function_exists('palmeria_mphb_sr_accommodation_list_type')){
    function palmeria_mphb_sr_accommodation_list_type($classes){

        $list_layout =  get_theme_mod('palmeria_search_accommodation_list_layout', PALMERIA_ACCOMMODATION_LIST_LAYOUT_1);
        if($list_layout){
            $classes.= ' '.$list_layout;
        }


        return $classes;
    }
}

add_action('mphb_sc_search_results_before_loop', 'palmeria_mphb_rooms_wrapper_before', 10);
add_action('mphb_sc_rooms_before_loop', 'palmeria_mphb_rooms_wrapper_before', 10);
function palmeria_mphb_rooms_wrapper_before(){
    ?>
    <div class="mphb-rooms-shortcode-wrapper">
    <?php
}

add_action('mphb_sc_search_results_after_loop', 'palmeria_mphb_rooms_wrapper_after', 10);
add_action('mphb_sc_rooms_after_loop', 'palmeria_mphb_rooms_wrapper_after', 10);
function palmeria_mphb_rooms_wrapper_after(){
    ?>
    </div>
    <?php
}

remove_action( 'mphb_render_single_room_type_metas', array( '\MPHB\Views\SingleRoomTypeView', 'renderGallery' ), 10 );

function palmeria_single_mphb_room_type_gallery(){

    remove_filter('mphb_loop_room_type_gallery_use_nav_slider', 'palmeria_remove_mphb_nav_gallery');
    add_filter( 'mphb_loop_room_type_gallery_main_slider_image_link',  'palmeria_single_mphb_room_type_gallery_link');
    add_filter( 'mphb_loop_room_type_gallery_main_slider_image_size', 'palmeria_single_mphb_room_type_gallery_image_size' );

    MPHB\Views\LoopRoomTypeView::renderGallery();

    remove_filter( 'mphb_loop_room_type_gallery_main_slider_image_size', 'palmeria_single_mphb_room_type_gallery_image_size' );
    remove_filter( 'mphb_loop_room_type_gallery_main_slider_image_link',  'palmeria_single_mphb_room_type_gallery_link');
    add_filter('mphb_loop_room_type_gallery_use_nav_slider', 'palmeria_remove_mphb_nav_gallery');

}

function palmeria_single_mphb_room_type_gallery_link(){
    return 'none';
}

function palmeria_single_mphb_room_type_gallery_image_size(){
    return 'palmeria-cropped';
}

add_action('mphb_sc_services_before_loop', 'palmeria_services_inner_wrapper_open');
function palmeria_services_inner_wrapper_open(){
    ?>
    <div class="services-inner-wrapper">
    <?php
}

add_action('mphb_sc_services_after_loop', 'palmeria_services_inner_wrapper_close', 5);
function palmeria_services_inner_wrapper_close(){
    ?>
    </div>
    <?php
}

remove_action( 'mphb_sc_services_service_details', array('\MPHB\Views\LoopServiceView', 'renderPrice'), 40 );


add_filter( 'mphb_pagination_args', 'palmeria_mphb_pagination_atts');

function palmeria_mphb_pagination_atts($paginationAtts ){

    $paginationAtts['prev_text'] = esc_html__('Previous', 'palmeria');
    $paginationAtts['next_text'] = esc_html__('Next', 'palmeria');

    return $paginationAtts;
}



function palmeria_mphb_customizer_css(){

    $color = get_theme_mod('palmeria_accent_color', PALMERIA_ACCENT_COLOR);

    $css = '.mphb-calendar .datepick-ctrl a,
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

function palmeria_enqueue_customizer_css(){

    wp_add_inline_style('palmeria-mphb-style', palmeria_mphb_customizer_css());

}

add_action('wp_enqueue_scripts', 'palmeria_enqueue_customizer_css');

add_action('mphb_render_loop_service_before_featured_image', 'palmeria_services_shortcode_image_link_open', 15);
function palmeria_services_shortcode_image_link_open(){
    ?>
    <a href="<?php the_permalink();?>">
    <?php
}

add_action('mphb_render_loop_service_before_featured_image', 'palmeria_services_shortcode_image_link_close', 5);
function palmeria_services_shortcode_image_link_close(){
    ?>
    </a>
    <?php
}

function palmeria_mphbr_list_comments_args_filter($args){

    $args['avatar_size'] = 60;

    return $args;

}
add_filter('mphbr_list_comments_args', 'palmeria_mphbr_list_comments_args_filter');
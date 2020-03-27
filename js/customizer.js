/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    "use strict";

    function append_css_to_head(id, style){
        var oldstyle = $('head').find('#'+id);
        if(oldstyle.length){
            oldstyle.remove();
            $('head').append(style);
        }else{
            $('head').append(style);
        }
    }

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
			$('.main-navigation .primary-menu > li > a').css({
                'color': to
            });
			$('.sidebar-open i').css({
               'background' : to
            });
		} );
	} );

    wp.customize( 'palmeria_header_overlay_color', function (value) {
        value.bind( function (to) {

            var id = 'customize-preview-header-overlay',
                css = '<style id="'+id+'">' +
                    'body.page-template-template-front-page .site-content .site-main > .hentry .front-page-header-wrapper::after,' +
                    '.custom-header::after {' +
                    'background:' + to + ';'+
                    ' } ' +
                    '</style>';

            append_css_to_head(id, css);

        } );
    } );

    wp.customize( 'palmeria_header_overlay_opacity', function (value) {
        value.bind( function (to) {

            var opacity = parseInt(to) === 100 ? 1 : parseInt(to) === 0 ? 0 : '.' + to,
                id = 'customize-preview-header-opacity',
                css = '<style id="'+id+'">' +
                    'body.page-template-template-front-page .site-content .site-main > .hentry .front-page-header-wrapper::after,' +
                    '.custom-header::after {' +
                    'opacity: ' + opacity + ';'+
                    ' } ' +
                    '</style>';

            append_css_to_head(id, css);

        } );
    } );

    wp.customize( 'palmeria_accent_color', function (value) {
        value.bind( function (to) {

            var id = 'customize-preview-accent-color',
                css = '<style id="'+id+'">' +
                    'button:hover, button:focus,'+
                    'input[type="button"]:hover,'+
                    'input[type="button"]:focus,'+
                    'input[type="reset"]:hover,'+
                    'input[type="reset"]:focus,'+
                    'input[type="submit"]:hover,'+
                    'input[type="submit"]:focus,'+
                    '.more-link:hover,'+
                    '.more-link:focus,'+
                    '.button:hover,'+
                    'body.infinite-scroll .site-main #infinite-handle button:hover,'+
                    '.button:focus,'+
                    'body.infinite-scroll .site-main #infinite-handle button:focus'+
                    '{' +
                    'background-color: ' + to + ';'+
                    'border-color: ' + to + ';'+
                    ' } ' +
                    '.related-posts ul li a.post-title:hover,' +
                    '.entry-meta > span a:hover,' +
                    '.comments-area .comment-list .comment .comment-meta .comment-reply-link:hover, ' +
                    '.comments-area .comment-list .pingback .comment-meta .comment-reply-link:hover,'+
                    'body.blog .hentry .entry-header .entry-title a:hover,' +
                    'body.archive .hentry .entry-header .entry-title a:hover,' +
                    'body.search .hentry .entry-header .entry-title a:hover,' +
                    '.post-navigation .nav-previous a .post-title:hover, .post-navigation .nav-next a .post-title:hover,' +
                    '.search-form .search-submit:hover,' +
                    'a, a:visited, a:hover, a:focus, a:active,' +
                    '.mphb-calendar .datepick-ctrl a,' +
                    '.datepick-popup .datepick-ctrl a,' +
                    '.datepick-popup .mphb-datepick-popup .datepick-month td .datepick-today,' +
                    '.mphb-view-details-button,' +
                    '.mphb-view-details-button:hover, .mphb-view-details-button:focus,' +
                    '.mphb-view-details-button:visited,' +
                    '.mphb_sc_services-wrapper .type-mphb_room_service .mphb-service-title a:hover,' +
                    '.mphb_sc_search_results-wrapper .mphb-room-type-title:hover,' +
                    '.mphb_sc_rooms-wrapper .mphb-room-type-title:hover,' +
                    '.mphb_sc_room-wrapper .mphb-room-type-title:hover,'+
                    '.wp-block-getwid-custom-post-type__post-title a:hover,'+
                    '.wp-block-getwid-post-carousel__post-title a:hover,'+
                    '.wp-block-getwid-recent-posts__post-title a:hover'+
                    '{' +
                    'color:'+to+';' +
                    '}' +
                    '.wp-block-button .wp-block-button__link:hover,'+
                    '.wp-block-button .wp-block-button__link:focus,' +
                    '.wp-block-getwid-images-slider .slick-arrow:hover,'+
                    '.wp-block-getwid-media-text-slider .slick-arrow:hover,'+
                    '.wp-block-getwid-post-slider .slick-arrow:hover,'+
                    '.wp-block-getwid-post-carousel .slick-arrow:hover,'+
                    '.wp-block-getwid-images-slider.has-arrows-inside .slick-arrow:hover,'+
                    '.wp-block-getwid-media-text-slider.has-arrows-inside .slick-arrow:hover,'+
                    '.wp-block-getwid-post-slider.has-arrows-inside .slick-arrow:hover,'+
                    '.wp-block-getwid-post-carousel.has-arrows-inside .slick-arrow:hover,'+
                    '.mphb-calendar.mphb-datepick .datepick-month td .datepick-selected,' +
                    '.datepick-popup .mphb-datepick-popup .datepick-month td .datepick-selected,' +
                    '.datepick-popup .mphb-datepick-popup .datepick-month td a.datepick-highlight,' +
                    '.mphb-calendar.mphb-datepick .datepick-month td .mphb-booked-date,' +
                    'body .mphb-flexslider.flexslider ul.flex-direction-nav a:hover,' +
                    'body .flexslider ul.flex-direction-nav a:hover,' +
                    '.wp-block-file a.wp-block-file__button:hover,'+
                    '.wp-block-file a.wp-block-file__button:focus'+
                    '{' +
                    'background-color: ' + to + ';'+
                    '}' +
                    '</style>';

            append_css_to_head(id, css);

        } );
    } );

    wp.customize('palmeria_footer_text', function (value) {

        value.bind( function (to) {
            $('#colophon .site-info').html(to);
        })

    });

} )( jQuery );

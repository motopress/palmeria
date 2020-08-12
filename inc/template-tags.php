<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Palmeria
 */

if ( ! function_exists( 'palmeria_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function palmeria_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

        if(!is_single()){
            echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'; // WPCS: XSS OK.
        }else{
            echo '<span class="posted-on">' . $time_string . '</span>'; // WPCS: XSS OK.
        }

	}
endif;

if ( ! function_exists( 'palmeria_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function palmeria_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'palmeria' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if(!function_exists('palmeria_posted_in')):
    function palmeria_posted_in(){
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( esc_html__( ', ', 'palmeria' ) );
        if ( $categories_list ) {
            /* translators: 1: list of categories. */
            printf( '<span class="cat-links">%1$s</span>', $categories_list ); // WPCS: XSS OK.
        }
    }
endif;

if(!function_exists('palmeria_sticky_post')):
    function palmeria_sticky_post(){
        if(is_sticky()){
            ?>
            <span class="featured-post">
                    <?php
                    echo esc_html__('Featured', 'palmeria');
                    ?>
            </span>
            <?php
        }
    }
endif;

if ( ! function_exists( 'palmeria_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function palmeria_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

	        palmeria_sticky_post();

		    palmeria_posted_on();

		    palmeria_posted_by();

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'palmeria' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'palmeria' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'palmeria' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'palmeria' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}

        }

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'palmeria' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

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
	}
endif;

if ( ! function_exists( 'palmeria_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function palmeria_post_thumbnail($size = 'post-thumbnail') {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail($size); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( $size, array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;



if(!function_exists('palmeria_posts_pagination')){
    function palmeria_posts_pagination(){
        the_posts_pagination( array(
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'palmeria' ) . '</span>',
            'mid_size'           => 1,
            'prev_text'    => esc_html__('Previous', 'palmeria'),
            'next_text'    => esc_html__('Next', 'palmeria'),
        ) );
    }
}

if ( ! function_exists( 'palmeria_related_posts' ) ) :
    /**
     * Displays related posts
     */
    function palmeria_related_posts( $post ) {
        if ( 'post' === get_post_type() ) {
            $categories = wp_get_post_categories( $post->ID );
            if ( $categories ) {
                $args     = array(
                    'category__in'        => $categories,
                    'post__not_in'   => array( $post->ID ),
                    'posts_per_page' => 3,
                );
                $my_query = new wp_query( $args );
                if ( $my_query->have_posts() ):
                    ?>
                    <div class="related-posts">
                        <h3 class="related-posts-title"><?php esc_html_e( 'Related Posts', 'palmeria' ); ?></h3>
                        <!-- .related-posts-title -->
                        <ul>
                            <?php
                            while ( $my_query->have_posts() ) {
                                $my_query->the_post();
                                ?>
                                <li>
                                    <?php
                                    if(has_post_thumbnail()):
                                        ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
                                            the_post_thumbnail('palmeria-cropped');
                                            ?>
                                        </a>
                                    <?php
                                    endif;
                                    ?>
                                    <a href="<?php the_permalink() ?>" rel="bookmark"
                                       title="<?php the_title(); ?>" class="post-title"><?php the_title(); ?></a>
                                    <?php
                                    palmeria_posted_on();
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div><!-- .related-posts -->
                <?php
                endif;
                ?>
                <?php
            }
            wp_reset_postdata();
        }
    }

endif;

if(!function_exists('palmeria_custom_header')):
    function palmeria_custom_header(){
        if(is_page_template('template-front-page.php')){
            return;
        }
        ?>
        <div class="custom-header">
            <?php

            if(function_exists('is_woocommerce') && is_woocommerce() && get_theme_mod('palmeria_shop_image', null)){
                ?>
                <img src="<?php echo esc_url(get_theme_mod('palmeria_shop_image')); ?>" alt="">
                <?php
            }elseif (has_post_thumbnail() && is_singular()) {
                the_post_thumbnail('palmeria-x-large');
            } else {
                ?>
                <img src="<?php header_image(); ?>" height="<?php echo esc_attr(get_custom_header()->height); ?>"
                     width="<?php echo esc_attr(get_custom_header()->width); ?>" alt="<?php esc_attr(get_bloginfo('name'));?>"/>
                <?php
            }
            ?>
        </div>
        <?php
    }
endif;

if(!function_exists('palmeria_child_pages_list')):
    function palmeria_child_pages_list(){
        $args = array(
            'post_type' => 'page',
            'posts_per_page'    => -1,
            'post_parent'   => get_the_ID(),
            'orderby'  => 'menu_order',
            'order' => 'ASC',
            'post_status'   => 'publish'
        );

        $query = new WP_Query($args);

        if($query->have_posts()):
            ?>
        <div class="child-pages-list">
            <?php
            while($query->have_posts()):
                $query->the_post();
                ?>
                <div id="page-<?php the_ID()?>" <?php post_class()?>>
                    <?php
                    add_filter('wp_calculate_image_srcset_meta', 'palmeria_calculate_image_srcset_meta', 10, 4);
                    palmeria_post_thumbnail('palmeria-x-large');
                    remove_filter('wp_calculate_image_srcset_meta', 'palmeria_calculate_image_srcset_meta');
                    ?>
                    <div class="entry-content-wrapper">
                        <div class="inner-wrapper">
                            <header class="entry-header">
                                <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
                            </header>
                            <div class="entry-content">
                                <?php
                                the_content( esc_html__('More info', 'palmeria'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            ?>
        </div>
        <?php
        endif;

        wp_reset_postdata();
    }
endif;

if ( ! function_exists( 'palmeria_the_post_navigation' ) ) :
    /**
     * Displays the post navigation.
     */
    function palmeria_the_post_navigation() {
        the_post_navigation( array(
            'next_text' => '<span class="arrow"><i></i><i></i><i></i></span>'.
                '<h4 class="post-title">%title</h4>',
            'prev_text' => '<span class="arrow"><i></i><i></i><i></i></span>'.
                '<h4 class="post-title">%title</h4>',
        ) );
    }
endif;
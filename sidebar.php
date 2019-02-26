<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Palmeria
 */

if ( ! is_active_sidebar( 'sidebar-1' ) && ! has_nav_menu( 'menu-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area absolute-sidebar">
    <button class="sidebar-close" id="sidebar-close">
        <i></i>
        <i></i>
    </button>
    <div class="clear"></div>
    <div class="inner-wrapper">
        <?php
        if(has_nav_menu('menu-1')):
            ?>
            <nav id="site-mobile-navigation" class="main-navigation mobile-navigation">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'mobile-menu',
                    'menu_class'     => 'primary-menu'
                ) );
                ?>
            </nav><!-- #site-navigation -->
        <?php
        endif;
        ?>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div>

</aside><!-- #secondary -->

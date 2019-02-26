<?php
/**
 * Template for displaying search forms in Palmeria
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
        <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'palmeria' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'palmeria' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    </label>
    <button type="submit" class="search-submit"><i class="fas fa-search"></i><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'palmeria' ); ?></span></button>
</form>
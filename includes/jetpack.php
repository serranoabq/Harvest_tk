<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package harvest_tk
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function harvest_tk_jetpack_setup() {
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'infinite-scroll', array(
			'container' => 'content',
			'footer'    => 'page',
		) );
	}
}
add_action( 'after_setup_theme', 'harvest_tk_jetpack_setup' );

<?php
/**
 * harvest_tk functions and definitions
 *
 * @package harvest_tk
 */
 
 // Store the theme's directory path and uri in constants
 define('THEME_DIR_PATH', get_template_directory());
 define('THEME_DIR_URI', get_template_directory_uri());

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 960; /* pixels */

if ( ! function_exists( 'harvest_tk_setup' ) ) :
// Set up theme defaults and register support for various WordPress features.
function harvest_tk_setup() {
	global $cap, $content_width;

	// translation support
	load_theme_textdomain( 'harvest_tk', THEME_DIR_PATH . '/languages' );

	// Let WP handle titles`
	add_theme_support( 'title-tag' );

	// Enable post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Define some image sizes
	add_image_size( 'harvest_tk-featured-image', 640, 9999 );
	add_image_size( 'harvest_tk-person', 500, 500 );
	add_image_size( 'harvest_tk-hero', 1280, 1000, true );
	add_image_size( 'harvest_tk-thumbnail-avatar', 100, 100, true );

	// Add support for custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	) );
	
	// Register navigation menus
	register_nav_menus( array(
		'primary'  => __( 'Header bottom menu', 'harvest_tk' ),
		) );

	// Use HTML5 for search, comments, gallery and captions
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Add support for custom background
	add_theme_support( 'custom-background', apply_filters( 'harvest_tk_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	// Style the visual editor
	add_editor_style();

	// Add posts and comments RSS feed
	add_theme_support( 'automatic-feed-links' );

	// Add Church Theme Content support
	if( function_exists( 'harvest_tk_add_ctc' ) ) 
		harvest_tk_add_ctc();

	if( is_user_logged_in() ){
		if( function_exists( 'ctcex_update_recurring_events' ) ) 
			ctcex_update_recurring_events();
	} 
	
}
endif; // harvest_tk_setup
add_action( 'after_setup_theme', 'harvest_tk_setup' );

// Register widgetized area and update sidebar with default widgets
function harvest_tk_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'harvest_tk' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );
}
add_action( 'widgets_init', 'harvest_tk_widgets_init' );

// Enqueue scripts and styles
function harvest_tk_scripts() {

	// Import the necessary TK Bootstrap WP CSS additions
	wp_enqueue_style( 'harvest_tk-bootstrap-wp', THEME_DIR_URI . '/includes/css/bootstrap-wp.css' );

	// load bootstrap css
	wp_enqueue_style( 'harvest_tk-bootstrap', THEME_DIR_URI . '/includes/resources/bootstrap/css/4.0/bootstrap.min.css' );

	// load Font Awesome css
	wp_enqueue_style( 'harvest_tk-font-awesome', THEME_DIR_URI . '/includes/css/font-awesome.min.css', false, '4.1.0' );

	// load harvest_tk styles
	wp_enqueue_style( 'harvest_tk-style', get_stylesheet_uri() );

	// load bootstrap js
	wp_enqueue_script('harvest_tk-bootstrapjs', THEME_DIR_URI . '/includes/resources/bootstrap/js/4.0/bootstrap.min.js', array('jquery') );

	// load bootstrap wp js
	wp_enqueue_script( 'harvest_tk-bootstrapwp', THEME_DIR_URI . '/includes/js/bootstrap-wp.js', array('jquery') );

	wp_enqueue_script( 'harvest_tk-skip-link-focus-fix', THEME_DIR_URI . '/includes/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'harvest_tk-keyboard-image-navigation', THEME_DIR_URI . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	
	harvest_tk_deregister_scripts();
	
}
add_action( 'wp_enqueue_scripts', 'harvest_tk_scripts' );

// Handle scripts that we don't want loaded all the time
function harvest_tk_deregister_scripts() {
	global $wp_query, $post;
	
	if( ! ( strpos( json_encode( $wp_query ), '[contact-form-7' ) || strpos( json_encode( $post ), '[contact-form-7' ) ) )  {
			wp_deregister_script( 'contact-form-7' );
			wp_deregister_style( 'contact-form-7' );
	}

}

// Helper function for theme options
function harvest_tk_option( $option, $default = false ) {
	if( class_exists( 'CTC_Extender' )  && ctcex_has_option( $option ) )
		return ctcex_get_option( $option, $default );
	
	return get_theme_mod( $option, $default );
}

// Add custom logo
function harvest_tk_the_custom_logo( $new_class = '' ) {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		$custom_logo = get_custom_logo();
		$base_class = 'custom-logo-link'; 
		$custom_logo = str_replace( $base_class, "$base_class $new_class", $custom_logo );
		echo $custom_logo; 
	} 
}


// Implement the Custom Header feature.
require THEME_DIR_PATH . '/includes/custom-header.php';

// Custom template tags for this theme.
require THEME_DIR_PATH . '/includes/template-tags.php';

// Customizer additions.
require THEME_DIR_PATH . '/includes/customizer.php';

// Load Jetpack compatibility file.
require THEME_DIR_PATH . '/includes/jetpack.php';

// Load custom WordPress nav walker.
require THEME_DIR_PATH . '/includes/bootstrap-wp-navwalker.php';

// Load CTC support.
require THEME_DIR_PATH . '/includes/ctc-support.php';

// Load RSS feed custom functions.
require THEME_DIR_PATH . '/includes/feeds.php';

// Load additional display support.
require THEME_DIR_PATH . '/includes/display.php';

// Adds WooCommerce support
// add_action( 'after_setup_theme', 'woocommerce_support' );
// function woocommerce_support() {
	// add_theme_support( 'woocommerce' );
// }

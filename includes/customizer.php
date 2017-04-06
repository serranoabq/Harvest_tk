<?php
/**
 * harvest_tk Theme Customizer
 *
 * @package harvest_tk
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function harvest_tk_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' 	              => 'harvest_tk_header_bgcolor',
		'type'              => 'color', 
		'label'             => __( 'Header Background Color', 'harvest_tk' ),
		'default'           => 'default',
		'section'           => 'colors',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	
	
	// Podcasting options
	harvest_tk_customize_createSection( $wp_customize, array(
		'id' => 'podcast',
		'title' => __( 'Podcasting', 'harvest_tk' ),
		'description' => __( 'Settings for audio podcast', 'harvest_tk' ),
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' => 'harvest_tk_podcast_desc',
		'label' => __( 'Podcast Description', 'harvest_tk' ),
		'type' => 'textarea',
		'default' => get_bloginfo( 'description' ),
		'section' => 'podcast',
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' => 'harvest_tk_podcast_author',
		'label' => __( 'Podcast Author', 'harvest_tk' ),
		'type' => 'text',
		'default' => get_bloginfo( 'name' ),
		'section' => 'podcast',
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id'           => 'harvest_tk_podcast_logo',
		'label'        => __( 'Podcast Logo', 'harvest_tk' ),
		'type'         => 'image',
		'default'      => '',
		'section'      => 'podcast',
		'description'  => __( 'Logo used in podcast feed. Must be 1400 x 1400 jpg or png.', 'harvest_tk' ),
	) );
	
	// RSS
	harvest_tk_customize_createSection( $wp_customize, array(
		'id' => 'rss',
		'title' => __( 'RSS Options', 'harvest_tk' ),
		'description' => __( 'Settings for RSS feed', 'harvest_tk' ),
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' => 'harvest_tk_feed_logo',
		'label' => __( 'RSS Feed Logo', 'harvest_tk' ),
		'type' => 'image',
		'default' => '',
		'section' => 'rss',
		'description' => __( 'Logo used in RSS feed', 'harvest_tk' ),
	) );
	
	
	harvest_tk_customize_createPanel( $wp_customize, array(
		'id'              => 'harvest_tk_options_panel', 
		'title'           => 'Theme Options',
		'description'     => __( 'Configure your theme settings', 'harvest_tk' )
	) );
		
	harvest_tk_customize_createSection( $wp_customize, array(
		'id' => 'theme-options',
		'title' => __( 'Theme Options', 'harvest_tk' ),
		'description' => __( 'Other theme settings', 'harvest_tk' ),
		'active_callback' => 'is_front_page', 
	) );
	
	// Front-page panels
	$panels = 12;
	// New panels
	for($i = 1; $i <= $panels; $i++ ){
		harvest_tk_customize_createSection( $wp_customize, array(
			'id' 	            => "harvest_tk_panel_$i",
			'title'           => __( 'Panel', 'harvest_tk' ) . ' ' . $i, 
			'description'     => __( 'Add a background image to your panel by setting a featured image in the page editor. If you don&rsquo;t select a page, this panel will not be displayed.', 'harvest_tk' ),
			'active_callback' => 'is_front_page', 
			'panel'           => 'harvest_tk_options_panel', 
		) );
		
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_page',
			'type'              => 'dropdown-pages', 
			'label'             => __( 'Panel Content', 'harvest_tk' ),
			'default'           => false,
			'section'           => "harvest_tk_panel_$i",
			'sanitize_callback' => 'harvest_tk_sanitize_numeric_value',
		) );
		
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_bgcolor',
			'type'              => 'color', 
			'label'             => __( 'Panel Background Color', 'harvest_tk' ),
			'default'           => '',
			'section'           => "harvest_tk_panel_$i",
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_opacity',
			'type'              => 'select', 
			'label'             => __( 'Featured Image Opacity', 'harvest_tk' ),
			'default'           => 'default',
			'section'           => "harvest_tk_panel_$i",
			'sanitize_callback' => 'sanitize_hex_color',
			'description'       => __( 'Set the opacity of the featured image over the panel background.', 'harvest_tk' ),
			'choices'           => array(
				'0.25'            => __( '25%', 'harvest_tk' ),
				'0.5'             => __( '50%', 'harvest_tk' ),
				'0.75'            => __( '75%', 'harvest_tk' ),
				'1'               => __( '100%', 'harvest_tk' ),
			),
		) );
		
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id'                => 'harvest_tk_panel_'. $i . '_showtitle',
			'label'             => __( 'Show Title', 'harvest_tk' ),
			'type'              => 'checkbox',
			'default'           => false,
			'section'           => "harvest_tk_panel_$i",
			'transport'         => 'postMessage',
			'description'       => __( 'Check to display the page title in the section.', 'harvest_tk' ),
		) );
	
	}
	
}
add_action( 'customize_register', 'harvest_tk_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function harvest_tk_customize_preview_js() {
	wp_enqueue_script( 'harvest_tk_customizer', get_template_directory_uri() . '/includes/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'harvest_tk_customize_preview_js' );


// Shortcut for creating a Customizer Setting
function harvest_tk_customize_createSetting( $wp_customize, $args ) {
	$default_args = array(
		'id' 	              => '', // required
		'type'              => '', // required. This refers to the control type. 
		                           // All settings are theme_mod and accessible via get_theme_mod.  
															 // Other types include: 'number', 'checkbox', 'textarea', 'radio',
															 // 'select', 'dropdown-pages', 'email', 'url', 'date', 'hidden',
															 // 'image', 'color'
		'label'             => '', // required
		'default'           => '', // required
		'section'           => '', // required
		'sanitize_callback' => '', // optional
		'transport'         => '', // optional
		'description'       => '', // optional
		'priority'          => null, // optional
		'choices'           => '', // optional
		'panel'             => '', // optional
	);
	
	$args = wp_parse_args( $args, $default_args );
	
	// Available types and arguments
	$available_types = array( 'text', 'number', 'checkbox', 'textarea', 'radio', 'select', 'dropdown-pages', 'email', 'url', 'date', 'hidden', 'image', 'color' );
	$setting_def_args = array( 'default'=> '', 'sanitize_callback'=>'', 'transport'=>'' );
	$control_def_args = array( 'type'=>'', 'label'=>'', 'description'=>'', 'priority'=>'', 'choices'=>'', 'section'=>'' );
	
	// Check for non-empty inputs, too
	if( empty( $args[ 'id' ] ) ||  
			empty( $args[ 'section' ] ) ||  
			empty( $args[ 'type' ] ) )
		return;
		
	// Check for a right type
	if( ! in_array( $args[ 'type' ], $available_types ) ) $args[ 'type' ] = 'text';
	
	$id = $args[ 'id' ];
	unset( $args[ 'id' ] );
	
	// Split setting arguments and control arguments
	$setting_args = array_intersect_key( $args, $setting_def_args );
	$control_args = array_intersect_key( $args, $control_def_args );
	
	$wp_customize->add_setting( $id, $setting_args );
	
	if( 'image' == $args[ 'type' ] ) {
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			$id,
			array(
				'label'      => $args[ 'label' ],
				'section'    => $args[ 'section' ],
				'settings'   => $id,
				'description'=> $args[ 'description' ]
			)
		) );
	} elseif( 'color' == $args[ 'type' ] ) {
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			$id,
			array(
				'label'      => $args[ 'label' ],
				'section'    => $args[ 'section' ],
				'settings'   => $id,
				'description'=> $args[ 'description' ]
			)
		) );
	} else {
		$wp_customize->add_control( $id, $control_args );
	}
}

// Shortcut for creating a Customizer Section
function harvest_tk_customize_createSection( $wp_customize, $args ) {
	$default_args = array(
		'id' 	            => '', // required
		'title'           => '', // required
		'priority'        => null, // optional
		'description'     => '', // optional
		'active_callback' => '', // optional
		'panel'           => '', // optional
	);
	
	$args = wp_parse_args( $args, $default_args );
	
	// Check for required inputs
	if( empty( $args[ 'id' ] ) ||  empty( $args[ 'title' ] ) ) return;
	
	$id = $args[ 'id' ];
	unset( $args[ 'id' ] );
	$wp_customize->add_section( $id, $args );
}

// Shortcut for creating a Customizer Panel
function harvest_tk_customize_createPanel( $wp_customize, $args ) {
	$default_args = array(
		'id'              => '', // required
		'title' 	        => '', // required
		'priority'        => null, // optional
		'description'     => '', // optional
		'active_callback' => '', // optional
	);
	
	$args = wp_parse_args( $args, $default_args );
	
	if( empty ( $args[ 'id' ] ) ||  empty( $args[ 'title' ] ) ) return;
	
	$id = $args[ 'id' ];
	unset( $args[ 'id' ] );
	$wp_customize->add_panel( $id, $args );
}

// Snitize numeric values
function harvest_tk_sanitize_numeric_value( $input ) {
	if ( is_numeric( $input ) ) {
		return intval( $input );
	} else {
		return 0;
	}
}

// Sanitize true/false checkboxes
function harvest_tk_sanitize_checkbox( $input ) {
	if ( ! in_array( $input, array( true, false ) ) ) {
		$input = false;
	}
	return $input;
}

// Sanitize opacity control
function harvest_tk_sanitize_opacity( $input ) {
	$choices = array( 'default', 0.25, 0.5, 0.75, 1 );
	if ( ! in_array( $input, $choices ) ) {
		$input = 'default';
	}
	return $input;
}

// Ouptut Customizer css
function harvest_tk_customizer_css{
	if( get_theme_mod( 'harvest_tk_header_bgcolor') ): ?>
		.pre-content-bg, .site-header {
			background-color: <?php echo esc_attr( get_theme_mod( 'harvest_tk_header_bgcolor' ) ); ?>
		}
	<?php endif; 
	
	for( $i = 1; $i < 12; $i++ ){
		$bgcolor = get_theme_mod( 'harvest_tk_panel_' + $i + '_bgcolor' );
		$bgopacity = get_theme_mod( 'harvest_tk_panel_' + $i + '_opacity' );
		if ( $bgcolor || $bgopacity ): 
			// CSS for setting bg color and panel bg opacity once I have that defined
		endif;
	}
}
add_action( 'wp_head', 'harvest_tk_customizer_css' );
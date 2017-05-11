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
		'default'           => '#467290',
		'section'           => 'colors',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	
	
	// Podcasting options
	harvest_tk_customize_createSection( $wp_customize, array(
		'id'                => 'podcast',
		'title'             => __( 'Podcasting', 'harvest_tk' ),
		'description'       => __( 'Settings for audio podcast', 'harvest_tk' ),
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id'           => 'harvest_tk_podcast_desc',
		'label'        => __( 'Podcast Description', 'harvest_tk' ),
		'type'         => 'textarea',
		'default'      => get_bloginfo( 'description' ),
		'section'      => 'podcast',
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id'           => 'harvest_tk_podcast_author',
		'label'        => __( 'Podcast Author', 'harvest_tk' ),
		'type'         => 'text',
		'default'      => get_bloginfo( 'name' ),
		'section'      => 'podcast',
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
		'id'           => 'rss',
		'title'        => __( 'RSS Options', 'harvest_tk' ),
		'description'  => __( 'Settings for RSS feed', 'harvest_tk' ),
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id'           => 'harvest_tk_feed_logo',
		'label'        => __( 'RSS Feed Logo', 'harvest_tk' ),
		'type'         => 'image',
		'default'      => '',
		'section'      => 'rss',
		'description'  => __( 'Logo used in RSS feed', 'harvest_tk' ),
	) );
	
	
	harvest_tk_customize_createPanel( $wp_customize, array(
		'id'              => 'harvest_tk_options_panel', 
		'title'           => 'Theme Options',
		'description'     => __( 'Configure your theme settings', 'harvest_tk' )
	) );
	
	// CTC default images 
	harvest_tk_customize_createSection( $wp_customize, array(
		'id'              => 'harvest_tk_ctc_defaults_section',
		'title'           => __( 'Default Images', 'harvest_tk' ),
		'description'     => __( 'Choose default images for use with sermons, events, and locations, ', 'harvest_tk' ),
		'panel'           => 'harvest_tk_options_panel', 
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' 	              => 'harvest_tk_sermon_dafault_image',
		'type'              => 'image', 
		'label'             => __( 'Default Sermon Image', 'harvest_tk' ),
		'default'           => '',
		'section'           => "harvest_tk_ctc_defaults_section",
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' 	              => 'harvest_tk_event_dafault_image',
		'type'              => 'image', 
		'label'             => __( 'Default Event Image', 'harvest_tk' ),
		'default'           => '',
		'section'           => "harvest_tk_ctc_defaults_section",
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' 	              => 'harvest_tk_location_dafault_image',
		'type'              => 'image', 
		'label'             => __( 'Default Location Image', 'harvest_tk' ),
		'default'           => '',
		'section'           => "harvest_tk_ctc_defaults_section",
	) );
	
	// Front-page hero 
	harvest_tk_customize_createSection( $wp_customize, array(
		'id'              => 'harvest_tk_hero_section',
		'title'           => __( 'Front Page Hero Slider', 'harvest_tk' ),
		'description'     => __( 'Enter the shortcode for the hero slider at the top of the  homepage', 'harvest_tk' ),
		'panel'           => 'harvest_tk_options_panel', 
		'active_callback' => 'is_front_page', 
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' 	              => 'harvest_tk_hero',
		'type'              => 'textarea', 
		'label'             => __( 'Hero Slider Shortcode', 'harvest_tk' ),
		'default'           => '',
		'section'           => "harvest_tk_hero_section",
	) );
	
	// Panels 
	harvest_tk_customize_createSection( $wp_customize, array(
		'id'              => 'harvest_tk_panels',
		'title'           => __( 'Front Page Panels', 'harvest_tk' ),
		'panel'           => 'harvest_tk_options_panel', 
		'active_callback' => 'is_front_page', 
	) );
	harvest_tk_customize_createSetting( $wp_customize, array(
		'id' 	              => 'harvest_tk_panel_count',
		'type'              => 'select', 
		'label'             => __( 'Front page panel count', 'harvest_tk' ),
		'description'       => __( 'Select how many panels to show on the front page', 'harvest_tk' ),
		'default'           => 12,
		'section'           => "harvest_tk_panels",
		'sanitize_callback' => 'harvest_tk_sanitize_numeric_value',
		'transport'         => 'postMessage',
		'choices'           => range( 0, 12, 1),
	) );
	
	// Front-page panels
	$panels = 12;
	// New panels
	for($i = 1; $i <= $panels; $i++ ){
		// Create section
		harvest_tk_customize_createSection( $wp_customize, array(
			'id' 	            => "harvest_tk_panel_$i",
			'title'           => __( 'Panel', 'harvest_tk' ) . ' ' . $i, 
			'description'     => __( 'Edit the settings for each panel, including the panel title, panel type, background image and background color. Panels that use a Static Page type, use the page\'s Featured Image as the background.', 'harvest_tk' ),
			'active_callback' => 'harvest_tk_panel_check', 
			'panel'           => 'harvest_tk_options_panel', 
		) );
		
		// Panel Title
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_title',
			'type'              => 'text', 
			'label'             => __( 'Title', 'harvest_tk' ),
			'default'           => harvest_tk_panel_default_title( $i ),
			'section'           => "harvest_tk_panel_$i",
			'transport'         => 'postMessage',
			'active_callback'   => 'harvest_tk_panel_notpage_check',
		) );
	
		// Show Panel title or not
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id'                => 'harvest_tk_panel_'. $i . '_showtitle',
			'label'             => __( 'Show Title', 'harvest_tk' ),
			'type'              => 'checkbox',
			'default'           => false,
			'section'           => "harvest_tk_panel_$i",
			'transport'         => 'postMessage',
		) );
	
		
		// Panel Type
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_type',
			'type'              => 'select', 
			'label'             => __( 'Content Type', 'harvest_tk' ),
			'default'           => '',
			'section'           => "harvest_tk_panel_$i",
			'sanitize_callback' => 'harvest_tk_sanitize_type',
			'choices'           => array(
				'sermon'          => __( 'Recent Sermon', 'harvest_tk' ),
				'event'           => __( 'Upcoming Events', 'harvest_tk' ),
				'location'        => __( 'Locations', 'harvest_tk' ),
				'page'            => __( 'Static Page', 'harvest_tk' ),
			),
		) );
		
		// Panel Page if Type is 'page'
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_page',
			'type'              => 'dropdown-pages', 
			'label'             => __( 'Page Content', 'harvest_tk' ),
			'default'           => false,
			'section'           => "harvest_tk_panel_$i",
			'sanitize_callback' => 'harvest_tk_sanitize_numeric_value',
			'active_callback'   => 'harvest_tk_panel_page_check',
		) );
		
		// Panel background image
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_bgimage',
			'type'              => 'image', 
			'label'             => __( 'Background Image', 'harvest_tk' ),
			'default'           => '',
			'section'           => "harvest_tk_panel_$i",
			'active_callback'   => 'harvest_tk_panel_notpage_check',
			'transport'         => 'postMessage',
		) );
		
		// Panel background opacity
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_opacity',
			'type'              => 'select', 
			'label'             => __( 'Background Image Opacity', 'harvest_tk' ),
			'default'           => 'default',
			'section'           => "harvest_tk_panel_$i",
			'sanitize_callback' => 'harvest_tk_sanitize_opacity',
			'transport'         => 'postMessage',
			'choices'           => array(
				'0'               => '0% (opaque)',
				'0.25'            => '25%',
				'0.5'             => '50%',
				'0.75'            => '75%',
				'1'               => '100%',
			),
		) );
		
		// Panel background color
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id' 	              => 'harvest_tk_panel_'. $i . '_bgcolor',
			'type'              => 'color', 
			'label'             => __( 'Background Color', 'harvest_tk' ),
			'default'           => '',
			'section'           => "harvest_tk_panel_$i",
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		) );
		
		// Use (inverted) white text 
		harvest_tk_customize_createSetting( $wp_customize, array(
			'id'                => 'harvest_tk_panel_'. $i . '_whitetext',
			'label'             => __( 'Use white text', 'harvest_tk' ),
			'type'              => 'checkbox',
			'default'           => false,
			'section'           => "harvest_tk_panel_$i",
			'transport'         => 'postMessage',
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


function harvest_tk_customizer_script(){
?>
	<script>
		jQuery( document ).ready( function($){
			
			var api = wp.customize;
			
			panel_count = 12;
			$( '#customize-control-harvest_tk_panel_count select' ).change( function() {
				panel_count =  $(this).val();
				for( var i = 1; i <= 12; i++ ){
					if( i <= panel_count ) {
						$( '#accordion-section-harvest_tk_panel_' + i ).css( { 'display' : '' } );
						api.section('harvest_tk_panel_' + i ).activate();
					} else {
						$( '#accordion-section-harvest_tk_panel_' + i ).css( { 'display' : 'none' } );
						api.section('harvest_tk_panel_' + i ).deactivate();
					}
				}
			});
			
			for( var i = 1; i <= 12; i++ ){
				var type_control = '#customize-control-harvest_tk_panel_' + i + '_type select';
				
				$( type_control ).change( function() {
					var panel = $( this ).attr('data-customize-setting-link').replace( 'harvest_tk_panel_' ,'').replace( '_type', '');
					var panel_type = $( this ).val();
					$( '#customize-control-harvest_tk_panel_' + panel + '_page' ).css( {'display': 'page' == panel_type ? 'list-item': 'none' } );
					$( '#customize-control-harvest_tk_panel_' + panel + '_title' ).css( {'display': 'page' != panel_type ? 'list-item': 'none' } );
					$( '#customize-control-harvest_tk_panel_' + panel + '_bgimage' ).css( {'display': 'page' != panel_type ? 'list-item': 'none' } );
				});
				
				checkExpanded( i );
			
			}
			
			function checkExpanded( panel ){
				var parent = 'harvest_tk_panel_' + panel;
				api.section( parent ).expanded.bind( function( expanding ) {
					var data = {'section': parent, 'expanded': expanding };
					api.previewer.send( 'section-scroll', data );
				});
			}
			
		});
	</script>
<?php	
}
add_action( 'customize_controls_print_footer_scripts', 'harvest_tk_customizer_script' );

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
		'active_callback'   => '', // optional
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
	$control_def_args = array( 'type'=>'', 'label'=>'', 'description'=>'', 'priority'=>'', 'choices'=>'', 'section'=>'', 'active_callback'=>'' );
	
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

// Sanitize numeric values
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
	$choices = array( 'default', 0, 0.25, 0.5, 0.75, 1 );
	if ( ! in_array( $input, $choices ) ) {
		$input = 'default';
	}
	return $input;
}

// Sanitize panel type control
function harvest_tk_sanitize_type( $input ) {
	$choices = array( 'sermon', 'event', 'page', 'location' );
	if ( ! in_array( $input, $choices ) ) {
		$input = 'page';
	}
	return $input;
}

// Ouptut Customizer css
function harvest_tk_customizer_css(){ ?>

	<style type="text/css">
	
	<?php if( get_theme_mod( 'harvest_tk_header_bgcolor') ): ?>
		.pre-content-bg, .site-header, .dropdown-menu {
			background-color: <?php echo esc_attr( get_theme_mod( 'harvest_tk_header_bgcolor' ) ); ?>
		}
	<?php endif; 
	
	for( $i = 1; $i <= 12; $i++ ){
		$bgcolor = get_theme_mod( 'harvest_tk_panel_' . $i . '_bgcolor' );
		$bgopacity = get_theme_mod( 'harvest_tk_panel_' . $i . '_opacity' );
		
		if ( $bgcolor ): 
	?>	
			.harvest_tk_panel_<?php echo $i; ?>{
				background-color: <?php echo esc_attr( $bgcolor ); ?>;
			}
			.harvest_tk_panel_<?php echo $i; ?> .month,
			.harvest_tk_panel_<?php echo $i; ?> .time {
				background-color: <?php echo esc_attr( $bgcolor ); ?>;
			}
		
	<?php 
		endif; 
		
		if ( in_array( $bgopacity, array( 0, 0.25, 0.5, 0.75, 1 ) ) ): 
	?>
			.harvest_tk_panel_<?php echo $i; ?> .harvest_tk_panel-background{
				opacity: <?php echo esc_attr( $bgopacity ); ?>;
			}
			
	<?php 
		endif;
	} ?>
	</style>

<?php	
}
add_action( 'wp_head', 'harvest_tk_customizer_css' );

// Get the default title based on the panel type
function harvest_tk_panel_default_title( $panel ){
	$type = get_theme_mod( "harvest_tk_panel_$panel" . '_type' );
	switch( $type ){
		case 'event':
			return __( 'Upcoming Events', 'harvest_tk' );
			break;
		case 'sermon':
			return __( 'Latest Sermon', 'harvest_tk' );
			break;
		case 'location':
			return __( 'Locations', 'harvest_tk' );
			break;
		/* case 'person':
			return __( 'People', 'harvest_tk' ); 
			break; */
		default:
			return '';
			break;
	}
}

// Active callback: Returns TRUE if the panel number is less than the panel count
function harvest_tk_panel_check( $control ){
	$count = get_theme_mod( 'harvest_tk_panel_count', 12 );
	$current_section = str_ireplace( 'harvest_tk_panel_' , '', $control->id );
	return is_front_page() && (int)$current_section <= (int)$count;
}

// Active callback: Returns TRUE if the panel type is 'page' 
function harvest_tk_panel_page_check( $control ){
	$panel = str_ireplace( 'harvest_tk_panel_' , '', $control->id );
	$panel = str_ireplace( '_page', '' , $panel );
	$type = get_theme_mod( "harvest_tk_panel_$panel" . '_type' );
	return 'page' == $type;
}

// Active callback: Returns TRUE if the panel type is NOT 'page'
function harvest_tk_panel_notpage_check( $control ){
	$panel = str_ireplace( 'harvest_tk_panel_' , '', $control->id );
	$panel = str_ireplace( '_title', '' , $panel );
	$panel = str_ireplace( '_bgimage', '' , $panel );
	$type = get_theme_mod( "harvest_tk_panel_$panel" . '_type' );
	return 'page' != $type;
}


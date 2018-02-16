<?php
// Add Church Theme Content support

function harvest_tk_ctc_notice(){
	echo '<div class="error"><p><a href="/wp-admin/plugin-install.php?tab=plugin-information&plugin=church-theme-content&TB_iframe=true&width=600&height=550">'. __( 'Church Theme Content Plugin is required!', 'harvest_tk' ).'</a></p></div>';
}
function harvest_tk_ctcex_notice(){
	echo '<div class="error"><p>'. __( 'CTC_Extender Plugin is required!', 'harvest_tk' ).'</p></div>';
}

function harvest_tk_add_ctc(){

	if( ! class_exists( 'Church_Theme_Content' ) ) {
		add_action( 'admin_notices', 'harvest_tk_ctc_notice' );
		return;
	}
	if( ! class_exists( 'CTC_Extender' ) ) {
		add_action( 'admin_notices', 'harvest_tk_ctcex_notice' );
	}

	add_theme_support( 'church-theme-content' );

	// Events
	add_theme_support( 'ctc-events', array(
			'taxonomies' => array(
				'ctc_event_category',
			),
			'fields' => array(
				'_ctc_event_start_date',
				'_ctc_event_end_date',
				'_ctc_event_start_time',
				'_ctc_event_end_time',
				'_ctc_event_recurrence',
				'_ctc_event_recurrence_end_date',
				'_ctc_event_recurrence_period',       // Not default in CTC
				'_ctc_event_recurrence_monthly_type', // Not default in CTC
				'_ctc_event_recurrence_monthly_week', // Not default in CTC
				'_ctc_event_venue',
				'_ctc_event_address',
			),
			'field_overrides' => array()
	) );

	// Sermons
	add_theme_support( 'ctc-sermons', array(
			'taxonomies' => array(
					//'ctc_sermon_topic',
					'ctc_sermon_series',
					'ctc_sermon_speaker',
			),
			'fields' => array(
					'_ctc_sermon_video',
					'_ctc_sermon_audio',
			),
			'field_overrides' => array()
	) );

	// People
	add_theme_support( 'ctc-people', array(
			'taxonomies' => array(
					'ctc_person_group',
			),
			'fields' => array(
					'_ctc_person_position',
					'_ctc_person_phone',
					'_ctc_person_email',
					'_ctc_person_urls',
			),
			'field_overrides' => array()
	) );

	// Locations
	add_theme_support( 'ctc-locations', array(
			'taxonomies' => array(),
			'fields' => array(
					'_ctc_location_address',
					'_ctc_location_phone',
					'_ctc_location_times',
					'_ctc_location_slider',
					'_ctc_location_pastor',
			),
			'field_overrides' => array()
	) );

	// Groups
	add_theme_support( 'ctcex_groups' );
}

// Add default image into the sermon
add_filter( 'ctc_sermon_image', 'harvest_tk_sermon_image' );
function harvest_tk_sermon_image( $img ){
  // Fall back 1: Default image through customizer
  if( empty( $img ) )
    $img = get_theme_mod( 'harvest_tk_sermon_dafault_image' );

  // Fall back 2: Feed logo
  if( empty( $img ) )
		$img = harvest_tk_option( 'feed_logo', '' );

	// Fall back 2: Site logo
	if( empty( $img ) )
		$img = harvest_tk_option( 'logo', '' );

	return $img;

}

// Add default image into the event
add_filter( 'ctc_event_image', 'harvest_tk_event_image' );
function harvest_tk_event_image( $img ){
  // Fall back 1: Default image through customizer
  if( empty( $img ) )
    $img = get_theme_mod( 'harvest_tk_event_dafault_image' );

  // Fall back 2: Feed logo
  if( empty( $img ) )
		$img = harvest_tk_option( 'feed_logo', '' );

	// Fall back 3: Site logo
	if( empty( $img ) )
		$img = harvest_tk_option( 'logo', '' );

	return $img;

}

// Add default image into the person
add_filter( 'ctc_person_image', 'harvest_tk_person_image' );
function harvest_tk_person_image( $img ){
	// Slightly different version than above because CTC_Extender already applies a default image (so this will never be empty)
	$default_image = get_theme_mod( 'harvest_tk_person_dafault_image' );
  if( empty( $default_img ) )
    $img = $default_image;

	return $img;

}

// This helper is used to get an expression for recurrence
function harvest_tk_get_recurrence_note( $post_obj ) {
	if( class_exists( 'CTC_Extender' ) )
		return ctcex_get_recurrence_note ( $post_obj );
	else
		return '';
}

// Helper is used to get options
function harvest_tk_get_option( $option, $default = '' ){
	if( class_exists( 'CTC_Extender' ) )
		return ctcex_get_option( $option, $default );
	else {
		$out = get_option( $option, $default );
		return $out;
	}
}

// GetCTC default data
function harvest_tk_get_default_data( $post_id ) {
	$data = array(
		'permalink'   => get_permalink( $post_id ),
		'name'        => get_the_title( $post_id ),
	);
	return $data;
}

// Get sermon data for use in templates
function harvest_tk_get_sermon_data( $post_id ){
	$default_img = harvest_tk_option( 'feed_logo', '');
	if( empty( $default_img ) ) $default_img = harvest_tk_option( 'logo', '' );
	if( class_exists( 'CTC_Extender' ) )
		return ctcex_get_sermon_data( $post_id, $default_img );
	else
		return harvest_tk_get_default_data( $post_id );
}

// Get event data for use in templates
function harvest_tk_get_event_data( $post_id ){
	if( class_exists( 'CTC_Extender' ) )
		return ctcex_get_event_data( $post_id );
	else
		return harvest_tk_get_default_data( $post_id );
}

// Get location data for use in templates
function harvest_tk_get_location_data( $post_id ){
	if( class_exists( 'CTC_Extender' ) )
		return ctcex_get_location_data( $post_id );
	else
		return harvest_tk_get_default_data( $post_id );
}

// Get person data for use in templates
function harvest_tk_get_person_data( $post_id ){
	if( class_exists( 'CTC_Extender' ) )
		return ctcex_get_person_data( $post_id );
	else
		return harvest_tk_get_default_data( $post_id );
}

// Get group data for use in templates
function harvest_tk_get_group_data( $post_id ){
	if( class_exists( 'CTC_Extender' ) )
		return ctcex_get_group_data( $post_id );
	else
		return harvest_tk_get_default_data( $post_id );
}

// Adjust the sermon series query
add_action( 'pre_get_posts', 'harvest_tk_pre_sermon_series' );
function harvest_tk_pre_sermon_series( $query ){
	global $wp_query;

	if( ! array_key_exists( 'ctc_sermon_series', $query->query_vars ) )
		return;

	$args = array(
		'order' => 'ASC',
		'orderby' => 'date',
		);

	$query_terms = array_merge( $args, $query->query_vars );
	$query->query_vars = $query_terms;

}

// Adjust the event query
add_action( 'pre_get_posts', 'harvest_tk_pre_events' );
function harvest_tk_pre_events( $query ){
	if( is_admin() ) return; // don't filter the back end
	
	$query_term = $query->query_vars;
	$ct1 = array_key_exists( 'ctc_event_category', $query_term ) && ! empty( $query_term['ctc_event_category'] );
	$ct3 = array_key_exists( 'post_type', $query_term )  && 'ctc_event' == $query_term['post_type'];
	if( ! ( $ct1 || $ct3 ) ) return;

	$args = array(
		'order' => 'ASC',
		'orderby' => 'meta_value',
		'meta_key' => '_ctc_event_start_date_start_time',
		'meta_type' => 'DATETIME',
		'posts_per_page' => 9,
		'meta_query' => array(
			array(
				'key' => '_ctc_event_end_date_end_time',
				'value' => date_i18n( 'Y-m-d H:i:s' ), // today localized
				'compare' => '>=', // later than today
				'type' => 'DATETIME',
			),
		)
	);

	$query_terms = array_merge( $args, $query->query_vars );
	$query->query_vars = $query_terms;

}

// Adjust the location and people query
add_action( 'pre_get_posts', 'harvest_tk_pre_locations_and_people' );
function harvest_tk_pre_locations_and_people( $query ){
	if( is_admin() ) return; // don't filter the back end
	
	if( ! array_key_exists( 'post_type', $query->query_vars ) )
		return;

	if( ! in_array( $query->query_vars[ 'post_type' ], array( 'ctc_location', 'ctc_person' ) ) )
		return;

	$args = array(
		'order' => 'ASC',
		'orderby' => 'order',
		'posts_per_page' => -1,
	);

	$query_terms = array_merge( $args, $query->query_vars );
	$query->query_vars = $query_terms;

}

// Get the name from CTC extender
function harvest_tk_get_ctc_name( $ctc_type, $is_singular = false ) {

	switch ( $ctc_type ) {
		case 'ctc_sermon':
			$names = __( 'Sermons/Sermon', 'harvest_tk' );
			$option = 'ctc-sermons';
			break;
		case 'ctc_event':
			$names = __( 'Events/Event', 'harvest_tk' );
			$option = 'ctc-events';
			break;
		case 'ctc_person':
			$names = __( 'People/Person', 'harvest_tk' );
			$option = 'ctc-people';
			break;
		case 'ctc_location':
			$names = __( 'Locations/Location', 'harvest_tk' );
			$option = 'ctc-locations';
			break;
		case 'ctcex_group':
			$names = __( 'Groups/Group', 'harvest_tk' );
			$option = 'ctcex-groups';
			break;
		case 'default':
			return '';
	}

	$name_array = explode( '/', harvest_tk_get_option( $option , $names ) );

	$name_plural = array_shift ( $name_array );
	$name_singular = $name_array;

	return $is_singular ? $name_singular : $name_plural;

}

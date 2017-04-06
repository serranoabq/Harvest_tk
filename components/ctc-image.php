<?php
/**
 * Template part to display CTC image within the header -- only works on CTC event, sermon and location posts
 *
 * @package harvest_tk
 */
	global $ctc_data, $do_media;

	$cpt = get_post_type();
	
	switch ( $cpt ){
	 case 'ctc_event':
		$ctc_data = harvest_tk_get_event_data( get_the_ID() );
		break;
	 case 'ctc_sermon':
		$ctc_data = harvest_tk_get_sermon_data( get_the_ID() );
		break;
	 case 'ctc_location':
		$ctc_data = harvest_tk_get_location_data( get_the_ID() );
		break;
	 case 'ctc_person':
		$ctc_data = harvest_tk_get_person_data( get_the_ID() );
		break;
	 default:
		if( has_post_thumbnail( get_the_ID() ) ){
			// For other post and pages, we'll use the featured image
			$ctc_data[ 'img' ] = get_the_post_thumbnail_url( get_the_ID() );
			$ctc_data[ 'img_id' ] = get_post_thumbnail_id( get_the_ID() );
		} else {
			return;
		}
	}
	
	$has_audio = ! empty( $ctc_data[ 'audio' ] );
	$has_video = ! empty( $ctc_data[ 'video' ] );
	$has_image = ! empty( $ctc_data[ 'img' ] );
	$has_map = ! empty( $ctc_data[ 'map_used' ] ) && $ctc_data[ 'map_used' ];

	// Determine possible media to display
	$pos_media = array();
	if( $has_audio ) 
		$pos_media[] = 'audio';
	if( $has_video )
		$pos_media[] = 'video';
	
	if( 'ctc_person' == $cpt && ! $has_image ){
		$person_img = harvest_tk_person_image( '', $ctc_data[ 'gender' ] );
		$ctc_data[ 'img' ] = $person_img;
		$has_image = ! empty( $ctc_data[ 'img' ] );
	}
	
	// On sermons, with no media, there's nothing to do
	if( 'ctc_sermon' == $cpt && count( $pos_media ) == 0 )
		return;
	
	if( is_tax( 'ctc_sermon_series' ) ){
		$has_video = false;
		$has_audio = false;
		$pos_media = array();
		$term = get_queried_object();
		$term_id = $term->id;
		$term_img = ctcex_tax_img_url( $term_id );
		$has_image = ! empty( $term_img );
	}
	
	// Some logic to display video or audio
	if( count( $pos_media ) == 0 )
		$do_media = false;
	elseif( count( $pos_media ) == 1 )
		$do_media = $pos_media[ 0 ];
	else {
		$do_media = isset( $_GET[ 'media' ] ) ? $_GET[ 'media' ] : ''; 
		$do_media = empty( $do_media ) ? 'video' : $do_media;
		$do_media = in_array( $do_media, $pos_media ) ? $do_media : 'video';
	}
	
	// Bail if there's nothing to show
	if( ! $has_video && ! $has_image && ! $has_map && ! $has_audio )
		return;
	
	if ( $do_media == 'video' ): 
		// Let's do video!
		$video = $ctc_data[ 'video' ];
		$has_iframe = ( false !== strripos( $video, '<iframe') );
		if( $has_iframe ){ 
			// It's a full embed code 
			// It's up to the user to style the embed code appropriately
			
?>		

		<div class="ctc-media">
			<div class="embed-responsive embed-responsive-16by9">
				<?php echo $video; ?>
			</div>
		</div>
		
<?php
			
		} else {
			// No iframe so assume a video URL
			$video = esc_url( $ctc_data[ 'video' ] );
			$video_args = array(
				'src'    => $video,
				'height' => 540,
				'width'  => 960, 
				'poster' => $ctc_data[ 'img' ]
			);

?>		

		<div class="ctc-media">
			<?php echo wp_video_shortcode( $video_args ); ?>
		</div>
		
<?php
			
		} // has_iframe		
  
	elseif ( $has_map ):
		// The image is a map (a feature of CTC Extender) based on event address
		$map_url = esc_url( $ctc_data[ 'map_url' ] );
		$api_key = 'AIzaSyBpzPm7J6-tkqom76246jehm8dRj2pu1Ds'; // Mine
		$map_img_url = add_query_arg( [ 'key' => $api_key ], $ctc_data[ 'img' ] );

?>

		<div class="ctc-media">
			<a href="<?php echo $map_url; ?>" target="_blank">
				<img src="<?php echo $map_img_url; ?>"/>
			</a> 
		</div> 

<?php

	elseif ( $has_image ):
		if( is_tax( 'ctc_sermon_series' ) ){
			$id = harvest_tk_get_attachment_id( $term_img );
		} else {
			$id = ! empty( $ctc_data[ 'img_id' ] ) ? $ctc_data[ 'img_id' ] : harvest_tk_get_attachment_id( $ctc_data[ 'img' ] );
		}	
		
		$person_class = 'ctc_person' == $cpt ? 'w-25 rounded-circle' : '';
		$thumb_size = 'ctc_person' == $cpt ? 'harvest_tk-person' : 'harvest_tk-hero';
?>

		<div class="ctc-media <?php echo $person_class; ?>">
			
			<?php echo wp_get_attachment_image( $id, $thumb_size, '', ['class'=>'ctc-image'] ); ?>
			
			<?php if( $do_media == 'audio' ): echo wp_audio_shortcode( array( 'src' => $ctc_data[ 'audio' ] ) ); endif; ?>
			
		</div> 

<?php
	elseif ( $has_audio ):
		// No image to display, so show only the player
		$audio = esc_url( $ctc_data[ 'audio' ] );
?>

		<div class="ctc-media">
			<?php echo wp_audio_shortcode( array( 'src' => $audio ) ); ?>
		</div> 

<?php
endif; 
 
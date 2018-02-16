<?php
/**
 * Template part to display CTC image within the header -- only works on CTC event, sermon and location posts
 *
 * @package harvest_tk
 */
	global $ctc_data, $do_media;

	$cpt = get_post_type();
	
	$has_hero = false;
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
	 case 'ctcex_group':
		$ctc_data = harvest_tk_get_group_data( get_the_ID() );
		break;
	 default:
		if( has_post_thumbnail( get_the_ID() ) ) {
			// Use featured image if available
			$ctc_data[ 'img' ] = get_the_post_thumbnail_url( get_the_ID() );
			$ctc_data[ 'img_id' ] = get_post_thumbnail_id( get_the_ID() );
		} 
		$hero = get_theme_mod( 'harvest_tk_hero' );
		
		if( is_front_page() && ! empty( $hero ) ) {
			// Front page hero slider
			$ctc_data[ 'img' ] = do_shortcode( get_theme_mod( 'harvest_tk_hero' ) );				
			$ctc_data[ 'img_id' ] = '';
			$has_hero = true;
		}
	}
	
	// Check capabilities
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
	
	// A CTC person could use a default gender image
	if( 'ctc_person' == $cpt && ! $has_image ){
		$person_img = harvest_tk_person_image( '', $ctc_data[ 'gender' ] );
		$ctc_data[ 'img' ] = $person_img;
		$has_image = ! empty( $ctc_data[ 'img' ] );
	}
	
	// On sermons, with no media, there's nothing to do
	if( 'ctc_sermon' == $cpt && count( $pos_media ) == 0 )
		return;
	
	// On series, try to use the series image
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
	
	
	/** Let's put out the information based on request and capabilities **/ 
	
	if ( $do_media == 'video' ): 		// Let's do video!
		$video = $ctc_data[ 'video' ];
		$has_iframe = ( false !== strripos( $video, '<iframe') );
		
		if( $has_iframe ){ // It's a full embed code 
			// It's up to the user to style the embed code appropriately
			// Warning this could break things!
			
?>		

		<div class="ctc-media">
			<div class="embed-responsive embed-responsive-16by9">
				<?php echo $video; ?>
			</div>
		</div>
		
<?php
			
		} else { // No iframe so assume a video URL
			$video = esc_url( $ctc_data[ 'video' ] );
			$video_args = array(
				'src'      => $video,
				'height'   => 540,
				'width'    => 960, 
				'poster'   => $ctc_data[ 'img' ],
				'autoplay' => true,
			);
			$img_src = '';
			
			// Get video markup
			$video_src = str_replace( "'video'", '"video"', wp_video_shortcode( $video_args ) ); 
			$video_src = preg_replace( '~\R~u', '', $video_src ); 
			
			// If an image is available, lazy load the video
			if( $has_image ){
				$id = ! empty( $ctc_data[ 'img_id' ] ) ? $ctc_data[ 'img_id' ] : harvest_tk_get_attachment_id( $ctc_data[ 'img' ] );
				$img_src = wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image'] );
				$img_src .= '<div class="play-button"></div>';
			}
?>		

		<div class="ctc-media <?php echo $has_image ? 'video-overlay' : '' ; ?>">
			<?php echo $has_image ? $img_src : $video_src; ?>
			<?php if( $has_image ): // Lazy load JS code ?>
			<script>

				jQuery(document).ready( function($){
					var vid_src = '<?php echo $video_src; ?>';
					$( '.video-overlay .play-button' ).click( function () {
						$( '.video-overlay .ctc-image' ).trigger( 'click' );
					} );
					$( '.video-overlay .ctc-image' ).click( function(){
						$( this ).replaceWith( vid_src );
						$( '.video-overlay .play-button' ).hide();
						$( '.video-overlay' ).addClass( 'embed-loaded' );
						$( window.wp.mediaelement.initialize );
					} );
				});
			</script>
			<?php endif; ?>
		</div>
		
<?php
			
		} // has_iframe		
  
	elseif ( $has_map ): 	// The image is a map (a feature of CTC Extender) based on event address
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

	elseif ( $has_image ):  // It has an image; if there's audio it spits it out under the image
	
		// Sermon series archives can use the taxonomy image
		if( is_tax( 'ctc_sermon_series' ) ){
			$id = harvest_tk_get_attachment_id( $term_img );
		} else {
			$id = ! empty( $ctc_data[ 'img_id' ] ) ? $ctc_data[ 'img_id' ] : harvest_tk_get_attachment_id( $ctc_data[ 'img' ] );
		}	
		
		// Slight change in style for people
		$person_class = 'ctc_person' == $cpt ? 'w-25 rounded-circle' : '';
		$thumb_size = 'ctc_person' == $cpt ? 'harvest_tk-person' : 'harvest_tk-hero';
		
		$img_src = $has_hero ? $ctc_data[ 'img' ] : wp_get_attachment_image( $id, $thumb_size, '', ['class'=>'ctc-image'] );
?>

		<div class="ctc-media <?php echo $person_class; ?>">
			
			<?php echo $img_src; ?>
			
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
 
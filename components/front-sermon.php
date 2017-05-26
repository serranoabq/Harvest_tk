<?php
/**
 * Front page - Sermon panel 
 * @package harvest_tk
 */
	$panel_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_title' );
	$show_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_showtitle', false );
	$preview_title_class = !$show_title && is_customize_preview() ? 'hidden-xs-up' : '';
	$wht = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_whitetext', false );
	$white_text_class = $wht ? 'text-white' : '';
	$bgcolor = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor', '' );
	$bgimage = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgimage' );
	
	$query = array(
		'post_type' 			=> 'ctc_sermon', 
		'order' 					=> 'DESC',
		'orderby' 				=> 'date',
		'posts_per_page'		=> 1,
	); 	
	$posts = new WP_Query( $query ); 

	if ( $posts -> have_posts() ): $posts -> the_post();
	
		$ctc_data = harvest_tk_get_sermon_data( get_the_ID() );
		$has_image = ! empty( $ctc_data[ 'img' ] );
		$has_audio = ! empty( $ctc_data[ 'audio' ] );
		$has_video = ! empty( $ctc_data[ 'video' ] );
		$id = ! empty( $ctc_data[ 'img_id' ] ) ? $ctc_data[ 'img_id' ] : harvest_tk_get_attachment_id( $ctc_data[ 'img' ] );
		
		
?>

<article id="latest-sermon" <?php post_class( "harvest_tk_panel m-0 py-5 px-3 px-md-5 harvest_tk_panel_$harvest_tk_panel front-sermon" ); ?> style="background-color:<?php echo $bgcolor; ?>">
	
	<?php if( $bgimage || is_customize_preview() ) : ?>
		
		<div class="harvest_tk_panel-background" style="background-image:url(<?php echo esc_url( $bgimage ); ?>)"></div>
		
	<?php endif; ?>
	
	<div class="container px-0 py-5 <?php echo $white_text_class; ?>">
	
		<?php if( $show_title || is_customize_preview() ): ?>
		
			<div class="panel-header pb-4 <?php echo $preview_title_class; ?>"><h1><?php echo $panel_title; ?></h1></div>
		
		<?php endif; ?>
		
		<div class="harvest_tk_panel-content row">
		
			<div id="media-content" class="col-md-8 col-lg-9 ctc-media-content">
	<?php 
					if( $has_video ): // 
					
						$video = $has_video ? $ctc_data[ 'video' ] : '';
						$has_iframe = ( false !== strripos( $video, '<iframe') );
						if( $has_iframe ): // Use iframe
	?>
					
							<div class="ctc-media">
							
								<div class="embed-responsive embed-responsive-16by9">
									<?php echo $video; ?>
								</div>
								
							</div> <!-- .ctc-media -->
					
	<?php  
						else: // Use video shortcode
						
							$video = esc_url( $ctc_data[ 'video' ] );
							$video_args = array(
								'src'      => $video,
								'height'   => 540,
								'width'    => 960, 
								'poster'   => $ctc_data[ 'img' ],
								'autoplay' => true,
							);
							$img_src = '';
							$video_src = str_replace( "'video'", '"video"', wp_video_shortcode( $video_args ) ); 
							$video_src = preg_replace( '~\R~u', '', $video_src ); 
							
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
											$( window.wp.mediaelement.initialize );
										} );
									});
								</script>
							
							<?php endif; // lazy load check ?>

						</div> <!-- .ctc-media -->
						
	<?php 		endif; // iframe check
					
					elseif( $has_image ): // Use image if no video
					
						$img_src = wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image'] );
	?>
						<div class="ctc-media">
						
							<?php echo $img_src; ?>
			
							<?php if( $has_audio ): echo wp_audio_shortcode( array( 'src' => $ctc_data[ 'audio' ] ) ); endif; ?>
							
						</div> <!-- .ctc-media -->
							
	<?php		endif; ?>
				
			</div> <!-- #media-content -->
			
			<div id="media-details" class="col-md-4 col-lg-3 pl-5">
			
				<div class="row h-100 pt-3 pt-md-0">
				
					<div id="sermon-details" class="col-12 col-sm-6 col-md-12 ctc-details">
					
						<h2 class="sermon-title"><?php the_title(); ?></h2>
						
						<?php if( ! empty( $ctc_data[ 'speakers' ] ) ): ?>
						
							<div class="ctc_speaker"><?php echo $ctc_data[ 'speakers' ]; ?></div>
						
						<?php endif; ?>
						
						<?php if( ! empty( $ctc_data[ 'series' ] ) ): ?>
						
							<div class="ctc_series"><?php echo sprintf( __( '<b>Series:</b> %s', 'harvest_tk'), $ctc_data[ 'series' ] ); ?></div>
						
						<?php endif; ?>
						
						<div class="ctc_date"><?php the_date(); ?></div>
						
					</div> <!-- #sermon-details -->
					
					<div id="archive_push" class="col-12 col-sm-6 col-md-12 align-self-end pt-4" style="font-family: Nunito, sans-serif; font-weight: 200" >
						
							<?php echo sprintf( __( 'Catch the rest of this series or any of our previous messages by checking out our <a href="%s" title="Sermon Archive" class="font-weight-bold text-uppercase">archive</a>', 'harvest_tk' ), get_post_type_archive_link( 'ctc_sermon' ) ); ?>
							
					</div> <!-- #archive_push -->
					
				</div> <!-- .row (inner) -->
				
			</div> <!-- #media-details -->

		</div> <!-- .harvest_tk_panel-content -->
		
	</div> <!-- .container (outer) -->
	
	<?php if( is_customize_preview() ): ?>
		
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #latest-sermon -->

<?php 
	endif;
	wp_reset_postdata();
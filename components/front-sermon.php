<?php
/**
 * @package harvest_tk
 */
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
<style>
.panel-header {
	padding: 15px 0;
}
.panel-header h3 {
    
}
#latest-sermon *{
	transition: all 0.5s ease;
}
#latest-sermon .container{
	// margin: 0;
	// padding: 0;
	// width: 100%;
}
.ctc-media-content{
	// line-height: 0;
}
#latest-sermon .ctc-media{
	box-shadow: none;
}

#latest-sermon .ctc-details{
	position: relative;
	bottom: 0;
	background-color: none;
	padding: 15px 30px;
	width: 100%;
}

@media (max-width: 992px){
	#latest-sermon{
		padding: 0 !important;
	}
	#latest-sermon .container{
		margin: 0;
		width: 100%;
		padding: 0;
	}
	#latest-sermon .ctc-details{
		position: absolute !important;
		bottom: <?php echo ( $has_audio && !$has_video ) ? '30px' : '0'; ?>;
		background-color: rgba(0,0,0,0.5);
		padding-left: 30px;
	}
	.panel-header{
		position: absolute;
		width: 100%;
		z-index: 10;
		text-align: center;
		top:10px;
	}
}
@media (min-width: 576px){
	.ctc-details{
		
	}
	#latest-sermon .container{
		
	}
	#latest-sermon .ctc-details{
		// position: absolute !important;
	}
}
@media (min-width: 768px){
	#latest-sermon .container{
		margin: 0 auto;
	}
	
}
</style>
<article id="latest-sermon" <?php post_class( "harvest_tk_panel m-0 p-5 harvest_tk_panel_$harvest_tk_panel" ); ?> style="background-color:<?php echo get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor' ); ?>">
	<div class="container">
		<div class="panel-header"><h3><?php _e( 'Latest Message', 'harvest_tk' ); ?></h3></div>
		
		<div class="row">
			<div class="col-lg-9 ctc-media-content">
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
							</div>
					
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
												//$( '')
												$( window.wp.mediaelement.initialize );
											} );
										});
									</script>
								
								<?php endif; // lazy load check ?>

							</div>
	<?php 		endif; // iframe check
					
					elseif( $has_image ): // Use image if no video
						$img_src = wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image'] );
	?>
							<div class="ctc-media">
							
								<?php echo $img_src; ?>
				
								<?php if( $has_audio ): echo wp_audio_shortcode( array( 'src' => $ctc_data[ 'audio' ] ) ); endif; ?>
								
							</div>
							
	<?php		endif; ?>
				
			</div> <!-- .ctc-media-content -->
			
			
			<div class="col-lg-3 ctc-details">
				<h4 class="sermon-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="text-muted ctc_speaker"><?php echo $ctc_data[ 'speakers' ]; ?></div>
				<div class="text-muted ctc_date"><?php the_date(); ?></div>
			</div>
		</div> <!-- .ctc-details -->
		
		
		<?php if( is_customize_preview() ): ?>
		
			<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
		
		<?php endif; ?>
	</div>
</article><!-- #post-## -->

<?php 
	endif;
	wp_reset_postdata();
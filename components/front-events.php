<?php
/**
 * Front page - Events panel 
 * @package harvest_tk
 */

 $query = array(
		'post_type' 			=> 'ctc_event', 
		'posts_per_page'		=> 3,
	); 
	$posts = new WP_Query( $query ); 

	if ( $posts -> have_posts() ):
	
	// 1 - two column, 960max on right; title on left
	// 2 - two column, half & half
	// 3 - two column, 960max on right, two more on left 
?>


<article id="recent-events" <?php post_class( "harvest_tk_panel m-0 p-5 harvest_tk_panel_$harvest_tk_panel" ); ?> style="background-color:<?php echo get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor' ); ?>">

	<div class="container p-0">
	
		<div class="panel-header"><h3><?php _e( 'Upcoming Events', 'harvest_tk' ); ?></h3></div>
		
		<div class="row">
		<?php 
			$i = 0;
			while ( $posts -> have_posts() ): $posts -> the_post(); 
				$ctc_data = harvest_tk_get_event_data( get_the_ID() );
				$date_str = date_i18n( 'F j, Y', strtotime( $ctc_data[ 'start' ] ) );
				$id = empty( $ctc_data[ 'img_id' ] ) ? harvest_tk_get_attachment_id( $ctc_data[ 'img' ] ) : $ctc_data[ 'img_id' ];
				$i++;
		?>
		<?php if (1 == $i): ?>
			<div class="col-12 col-lg-8 p-0 m-0">
				<div class="card card-inverse animated fadeInRight">
					<a href="<?phpo echo the_permalink();?>">
					<?php echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image img-responsive'] ); ?>
					</a>
				</div>
			</div>
			</div class="col-12 col-lg-4 p-0 m-0">
		<?php else: ?>
				<div class="col-12 col-md-6 col-lg-12 p-0 m-0">
					<div class="card card-inverse animated fadeInRight">
						<a href="<?phpo echo the_permalink();?>">
						<?php echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image img-responsive'] ); ?>
						</a>
					</div>
				</div>
			<?php if( $i == $posts->post_count ): ?></div><?php endif; ?>
		<?php endif; ?>
			<?php /*
			<a href="<?php echo $ctc_data[ 'permalink' ]; ?>"><?php the_title(); ?></a>
			<?php echo $date_str . ' @ ' . $ctc_data[ 'time' ]; ?><br/>
			*/ ?>
			
		<?php endwhile; ?>
		</div>
		
	</div>
	
	<?php if( is_customize_preview() ): ?>
	
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #post-## -->

<?php 
	endif;
	wp_reset_postdata();
<?php
/**
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
	<div class="container">
		<div class="panel-header"><h3><?php _e( 'Upcoming Events', 'harvest_tk' ); ?></h3></div>
		
		<?php while ( $posts -> have_posts() ): $posts -> the_post(); ?>
			<?php 
				$ctc_data = harvest_tk_get_event_data( get_the_ID() );
				$date_str = date_i18n( 'F j, Y', strtotime( $ctc_data[ 'start' ] ) );
				
			?>
			<a href="<?php echo $ctc_data[ 'permalink' ]; ?>"><?php the_title(); ?></a>
			<?php echo $date_str . ' @ ' . $ctc_data[ 'time' ]; ?><br/>
			
			
		<?php endwhile; ?>
		
	</div>
	
	<?php if( is_customize_preview() ): ?>
	
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #post-## -->

<?php 
	endif;
	wp_reset_postdata();
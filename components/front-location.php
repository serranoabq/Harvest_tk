<?php
/**
 * Front page - Locations panel 
 * @package harvest_tk
 */

	$panel_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_title' );
	$show_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_showtitle', false );
	$preview_title_class = !$show_title && is_customize_preview() ? 'hidden-xs-up' : '';
	$wht = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_whitetext', false );
	$white_text_class = $wht ? 'text-white' : '';
	$bgcolor = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor', '' );
	$bgimage = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgimage' );
	
	// Generate location card
	if ( ! function_exists( 'harvest_tk_location_card' ) ) :
		function harvest_tk_location_card( $post_id ){
			
			$ctc_data = harvest_tk_get_location_data( $post_id );
			$times = $ctc_data[ 'times' ]; 
			$address = nl2br( $ctc_data[ 'address' ] );
			$title = $ctc_data[ 'name' ];
			?>
			
			<h3><?php echo $title;?></h3>
			<div class="ctc-times"><?php echo $times;?></div>
			<div class="mt-4">
				<a href="<?php echo $ctc_data[ 'map_url' ]; ?>" target="_blank" alt="<?php _e( 'Map and Directions', 'harvest_tk' ); ?>" class="btn btn-secondary font-weight-bold text-uppercase">
					<?php _e( 'Directions', 'harvest_tk' ); ?>
				</a>
			</div>
			
			<?php
		}
	endif;
	
  $query = array(
		'post_type' 			=> 'ctc_location', 
		'orderby' 				=> 'order',
		'order'           => 'ASC',
		'posts_per_page'  => -1,
	); 
	$posts = new WP_Query( $query ); 

	if ( $posts -> have_posts() ):

	?>

<article id="locations" <?php post_class( "harvest_tk_panel m-0 py-5 px-3 px-md-5 harvest_tk_panel_$harvest_tk_panel" ); ?> style="background-color:<?php echo $bgcolor; ?>">

	<?php if( $bgimage || is_customize_preview() ) : ?>
		
		<div class="harvest_tk_panel-background" style="background-image:url(<?php echo esc_url( $bgimage ); ?>)"></div>
		
	<?php endif; ?>
	
	<div class="container px-0 py-3 py-sm-5 <?php echo $white_text_class; ?>">
		
		<?php if( $show_title || is_customize_preview() ): ?>
		
			<div class="panel-header pb-4 <?php echo $preview_title_class; ?>"><h1><?php echo $panel_title; ?></h1></div>
		
		<?php endif; ?>
		
		<div class="harvest_tk_panel-content row text-center">
		
		<?php while ( $posts -> have_posts() ): $posts -> the_post(); ?>
		
			<div class="col-sm-4 py-3">
			
				<?php echo harvest_tk_location_card( get_the_ID() ); ?>
			
			</div> <!-- .col -->
			
		<?php endwhile; ?>
		
		</div> <!-- .harvest_tk_panel-content -->
		
	</div> <!-- .container -->
	
	<?php if( is_customize_preview() ): ?>
	
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #locations -->

<?php 
	endif;
	wp_reset_postdata();
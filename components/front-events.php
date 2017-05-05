<?php
/**
 * Front page - Events panel 
 * @package harvest_tk
 */

	$panel_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_title' );
	$show_title = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_showtitle', false );
	$preview_title_class = !$show_title && is_customize_preview() ? 'hidden-xs-up' : '';
	$wht = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_whitetext', false );
	$white_text_class = $wht ? 'text-white' : '';
	$bgcolor = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor', '' );
	$bgimage = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgimage' );
	
	// Generate event card display
	function harvest_tk_event_card( $post_id ){
		
		$ctc_data = harvest_tk_get_event_data( $post_id );
		$title = $ctc_data[ 'name' ];
		$permalink = $ctc_data[ 'permalink' ];
		$has_image = ! empty( $ctc_data[ 'img' ] );
		$has_map = ! empty( $ctc_data[ 'map_used' ] ) && $ctc_data[ 'map_used' ];
		
		if ( $has_map ) {
			
			$map_url = esc_url( $ctc_data[ 'map_url' ] );
			$api_key = 'AIzaSyBpzPm7J6-tkqom76246jehm8dRj2pu1Ds'; // Mine
			$map_img_url = add_query_arg( [ 'key' => $api_key ], $ctc_data[ 'img' ] );
			$img = "<img src='$map_img_url' />";
			
		} elseif( $has_image ){
			
			$id = empty( $ctc_data[ 'img_id' ] ) ? harvest_tk_get_attachment_id( $ctc_data[ 'img' ] ) : $ctc_data[ 'img_id' ];
			$img = wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image img-responsive'] );
			
		}
		?>
		
		<div class="card card-inverse rounded-0 border-0">
			<a href="<?php echo $permalink;?>">
				<?php echo $has_image || $has_map ? $img : ''; ?>
				<?php echo harvest_tk_event_cal( $ctc_data[ 'start'], $ctc_data[ 'time' ] ); ?>
				<div class="card-img-overlay p-2">
					<div class="card-title m-0"><?php echo $title;?></div>
				</div>
			</a>
		</div>
		
		<?php
	}
	
	// Generate calendar icon
	function harvest_tk_event_cal( $ctc_date, $ctc_time ){
		
		$day_str = date_i18n( 'j', strtotime( $ctc_date ) );
		$mon_str = date_i18n( 'M', strtotime( $ctc_date ) );
		$time_str = $ctc_time;
		?>
		
		<div class="ctc_cal rounded">
			<div class="month" style="background-color: <?php echo $bgcolor ;?>"><?php echo $mon_str; ?></div>
			<div class="day"><?php echo $day_str; ?></div>
			<div class="time" style="background-color: <?php echo $bgcolor ;?>"><?php echo $time_str; ?></div>
		</div>
		
		<?php
	}
	
  $query = array(
		'post_type' 			=> 'ctc_event', 
		'posts_per_page'		=> 3,
	); 
	$posts = new WP_Query( $query ); 

	if ( $posts -> have_posts() ):

	?>

<article id="recent-events" <?php post_class( "harvest_tk_panel m-0  py-5 px-3 px-md-5 harvest_tk_panel_$harvest_tk_panel front-events" ); ?> style="background-color:<?php echo $bgcolor; ?>">

	<?php if( $bgimage || is_customize_preview() ) : ?>
		
		<div class="harvest_tk_panel-background" style="background-image:url(<?php echo esc_url( $bgimage ); ?>)"></div>
		
	<?php endif; ?>
	
	<div class="container px-0 py-5 <?php echo $white_text_class; ?>">
	
		<?php if( $show_title || is_customize_preview() ): ?>
		
			<div class="panel-header pb-4 <?php echo $preview_title_class; ?>"><h1><?php echo $panel_title; ?></h1></div>
		
		<?php endif; ?>
		
		<div class="harvest_tk_panel-content row no-gutters">
		
		<?php $i = 1; while ( $posts -> have_posts() ): $posts -> the_post(); ?>
		
			<?php if (1 == $i): ?>
			
				<div class="col-12 col-lg-8 mb-3 mb-md-0">
				
					<?php echo harvest_tk_event_card( get_the_ID() ); ?>
					
				</div> <!-- .col (first) -->
				
				<div class="col-12 col-lg-4">
				
					<div class="row no-gutters">
			
			<?php else: ?>
			
						<div class="col-12 col-md-6 col-lg-12 mb-3 mb-md-0">
						
							<?php echo harvest_tk_event_card( get_the_ID() ); ?>
							
						</div> <!-- .col (inner) -->
						
				<?php if( $i == $posts->post_count ): ?>
				
					</div> <!-- .row (inner) -->
					
				</div> <!-- .col (second) -->
				
				<?php endif; ?>
			
			<?php endif; $i++; ?>
		
		<?php endwhile; ?>
		
		</div> <!-- .harvest_tk_panel-content -->
		
		<div class="row justify-content-end p-3">
		
			<a href="<?php echo get_post_type_archive_link( 'ctc_event' ); ?>" class="btn btn-primary"><?php _e( 'All Events', 'harvest_tk' ); ?></a>
			
		</div> <!-- .row -->
		
	</div> <!-- .container -->
	
	<?php if( is_customize_preview() ): ?>
	
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #recent-events -->

<?php 
	endif;
	wp_reset_postdata();
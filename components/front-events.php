<?php
/**
 * Front page - Events panel 
 * @package harvest_tk
 */

	$bgcolor = get_theme_mod( "harvest_tk_panel_$harvest_tk_panel" . '_bgcolor' );
	
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
		<div class="card card-inverse">
			<a href="<?php echo $permalink;?>">
				<?php echo $has_image || $has_map ? $img : ''; ?>
				<div class="card-img-overlay" style="<?php echo $has_image || $has_map ? 'top:auto;' : ''; ?>">
					<?php echo harvest_tk_event_cal( $ctc_data[ 'start'], $ctc_data[ 'time' ] ); ?>
					<div class="card-title m-0"><?php echo $title;?></div>
				</div>
			</a>
		</div>
		<?php
	}
	
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
<style>
	.card { 
		overflow: hidden;
	}
	.card-img-overlay {
		background-color:rgba(0,0,0,0.3);
	}
	.ctc_cal {
		overflow: hidden;
		width: 60px;
		height: 60px;
		background-color: gray;
		font-size: 1em;
		color: #fff;
		text-align: center;
		margin-right: 10px;
		float: left;
	}
	.ctc_cal > .month {
		height: 20px;
		line-height: 20px;
		font-weight: bold;
		font-size: 14px;
		filter: hue-rotate(180deg)  saturate(200%);
	}
	.ctc_cal > .day {
		height: 25px;
		line-height: 25px;
		font-weight: bold;
		font-size: 24px;
	}
	.ctc_cal > .time {
		height: 15px;
		line-height: 15px;
		font-size: 12px;
		filter: hue-rotate(180deg) saturate(200%);
	}
</style>

<article id="recent-events" <?php post_class( "harvest_tk_panel m-0 p-5 harvest_tk_panel_$harvest_tk_panel" ); ?> style="background-color:<?php echo $bgcolor; ?>">

	<div class="container p-0">
	
		<div class="panel-header"><h3><?php _e( 'Upcoming Events', 'harvest_tk' ); ?></h3></div>
		
		<div class="row no-gutters">
		<?php 
			$i = 1;
			while ( $posts -> have_posts() ): $posts -> the_post(); 
		?>
		<?php if (1 == $i): ?>
			<div class="col-12 col-lg-8">
				<?php echo harvest_tk_event_card( get_the_ID() ); ?>
			</div>
			<div class="col-12 col-lg-4">
				<div class="row no-gutters">
		<?php else: ?>
					<div class="col-12 col-md-6 col-lg-12">
						<?php echo harvest_tk_event_card( get_the_ID() ); ?>
					</div>
			<?php if( $i == $posts->post_count ): ?>
				</div> <!-- .row (inner) -->
			</div> <!-- .col (second) -->
			<?php endif; ?>
		<?php endif; $i++; ?>
		<?php endwhile; ?>
		</div> <!-- .row (outer)-->
		<div class="row justify-content-end p-3">
			<a href="<?php echo get_post_type_archive_link( 'ctc-event' ); ?>" class="btn btn-primary"><?php _e( 'All Events', 'harvest_tk' ); ?></a>
		</div>
	</div>
	
	<?php if( is_customize_preview() ): ?>
	
		<div class="harvest_tk_panel-preview_frame"><span><?php echo __('Panel', 'harvest_tk' ) . ' ' . $harvest_tk_panel; ?></span></div>
	
	<?php endif; ?>
	
</article><!-- #post-## -->

<?php 
	endif;
	wp_reset_postdata();
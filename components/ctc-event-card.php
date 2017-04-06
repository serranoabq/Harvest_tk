<?php
/**
 * Template part for displaying events in card format
 *
 * @package harvest_tk
 */
	if( ! get_the_ID() ) return; // Bail if not in the Loop 
?>
		<?php
			$ctc_data = harvest_tk_get_event_data( get_the_ID() );
			$date_str = sprintf( '%s%s',  date_i18n( 'F j, Y', strtotime( $ctc_data[ 'start' ] ) ), $ctc_data[ 'start' ] != $ctc_data[ 'end' ] ? ' - '. date_i18n( 'F j, Y', strtotime( $ctc_data[ 'end' ] ) ) : '' );
			$time_str = sprintf( '%s%s',  $ctc_data[ 'time' ], $ctc_data[ 'endtime' ] ? ' - '. $ctc_data[ 'endtime' ] : '' );
			$id = empty( $ctc_data[ 'img_id' ] ) ? harvest_tk_get_attachment_id( $ctc_data[ 'img' ] ) : $ctc_data[ 'img_id' ];
		?>
	
	<div class="d-flex col-sm-6 col-md-4">
		<div class="card text-center ctc-card">
		
			<a href="<?php echo the_permalink(); ?>">
			
				<?php echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] ); ?>
				
				<div class="card-block p-0 m-2">
				
					<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					
					<div class="ctc_capability">
					
						<div class="card-subtitle text-muted ctc_date"><?php echo $date_str; ?></div>
						<div class="card-subtitle text-muted ctc_time"><?php echo $time_str; ?></div>
						
							
					</div>
					
				</div>
				
			</a>
			
		</div>
	</div>
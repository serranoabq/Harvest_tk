<?php
/**
 * Template part for displaying locations in card format
 *
 * @package harvest_tk
 */
	if( ! get_the_ID() ) return; // Bail if not in the Loop 
?>
		<?php
			$ctc_data = harvest_tk_get_location_data( get_the_ID() );
			$times = $ctc_data[ 'times' ];
			$address = nl2br( $ctc_data[ 'address' ] );
			$id = $ctc_data[ 'img_id' ] ? $ctc_data[ 'img_id' ] :harvest_tk_get_attachment_id( $ctc_data[ 'img' ] );
		?>
	
	<div class="d-flex col-sm-6 col-md-4">
		<div class="card text-center ctc-card">
		
			<?php echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] ); ?>
				
			<div class="card-block p-0 m-2">
			
				<h5 class="card-title"><?php the_title(); ?></h5>
				
				<div class="ctc_capability">
				
					<div class="card-subtitle text-muted ctc_date"><?php echo $address; ?></div>
					
					<p><?php echo $times; ?></p>
						
				</div>
				
			</div>
			
		</div>
	</div>
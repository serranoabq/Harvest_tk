<?php
/**
 * Template for display CTC sermon details on the sidebar of an sermon page
 *
 * Presumes CTC data was retrieved from calling template
 *
 * @package harvest_tk
 */
	
	$ctc_data = harvest_tk_get_location_data( get_the_ID() );
	$address_str = $ctc_data[ 'address' ];
	$times = $ctc_data[ 'times' ];
	$phone = $ctc_data[ 'phone' ];
	$pastor = $ctc_data[ 'pastor' ];
	$map_url = $ctc_data[ 'map_url' ];
	
?>

	<div class="col-md-4">
		<div class="ctc-details">
		
<?php if( $times ) {	?>

			<div class="ctc-location-times li"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $times; ?></div>

<?php } if( $address_str ) {	?>

			<div class="ctc-location-address li"><i class="fa fa-map-marker" aria-hidden="true"></i><a href="<?php echo nl2br( $address_str ); ?>"><?php echo $address_str; ?></a></div>

<?php } if( $phone ) {	?>

			<div class="ctc-location-phone li"><i class="fa fa-phone" aria-hidden="true"></i><?php echo $phone; ?></div>

<?php } if( $map_url ) { ?>	

			<div class="ctc-location-directions">
				<a href="<?php echo $map_url; ?>" target="_blank" class="btn btn-primary">
					<i class="fa fa-map-marker" aria-hidden="true"></i> <?php _e( 'Get Directions', 'harvest_tk' ); ?> 
				</a>
			</div>
			
<?php } ?> 

		</div> <!-- .ctc-details -->
	</div>
	
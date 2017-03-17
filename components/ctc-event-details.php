<?php
/**
 * Template for display CTC Event details on the sidebar of an event page
 *
 * Presumes CTC data was retrieved from calling template
 *
 * @package harvest_tk
 */
	global $ctc_data;
	if ( empty( $ctc_data ) )
		$ctc_data = harvest_tk_get_event_data( get_the_ID() );
	
	$date_str = sprintf( '%s%s',  date_i18n( 'F j, Y', strtotime( $ctc_data[ 'start' ] ) ), $ctc_data[ 'start' ] != $ctc_data[ 'end' ] ? ' - '. date_i18n( 'F j, Y', strtotime( $ctc_data[ 'end' ] ) ) : '' );
	$time_str = sprintf( '%s%s',  $ctc_data[ 'time' ], $ctc_data[ 'endtime' ] ? ' - '. $ctc_data[ 'endtime' ] : '' );
	$recurrence_note = $ctc_data[ 'recurrence_note' ];
	$venue_str = $ctc_data[ 'venue' ];
	$address_str = $ctc_data[ 'address' ];
	$map_url = $ctc_data[ 'map_url' ];
	$categories = $ctc_data[ 'categories' ];

?>

	<div class="ctc-details">
<?php if( $date_str ) {	?>

		<div class="ctc-event-date li"><i class="fa fa-calendar"></i><?php echo $date_str; ?></div>

<?php } if( $time_str ) {	?>

		<div class="ctc-event-time li"><i class="fa fa-clock-o"></i><?php echo $time_str; ?></div>

<?php } if( $recurrence_note ) {	?>

		<div class="ctc-event-recurrence li"><i class="fa fa-repeat"></i><?php echo $recurrence_note; ?></div>
		
<?php } if( $categories ) {	?>

		<div class="ctc-event-categories li"><i class="fa fa-tag"></i><?php echo $categories; ?></div>
	

<?php } if( $venue_str ) { ?>	

		<div class="ctc-event-venue li"><i class="fa fa-building"></i><?php echo $venue_str; ?></div>
	
<?php } if( $address_str ) { ?>

		<div class="ctc-event-address li"><i class="fa fa-map-marker"></i><?php echo nl2br( $address_str ); ?></div>

<?php } if( $map_url ) { ?>	

		<div class="ctc-event-directions">
			<a href="<?php echo $map_url; ?>" target="_blank" class="btn btn-default btn-lg">
				<i class="fa fa-map-marker" aria-hidden="true"></i> <?php _e( 'Get Directions', 'harvest_tk' ); ?> 
			</a>
		</div>
		
<?php } ?> 
	</div> <!-- .ctc-event-details -->
<?php
/**
 * Template for display CTCEX group details on the sidebar of an group page
 *
 * Presumes CTC data was retrieved from calling template
 *
 * @package harvest_tk
 */
	
	$ctc_data = harvest_tk_get_group_data( get_the_ID() );
	
	$day = empty( $ctc_data[ 'day' ] ) ? '': date_i18n( 'l', strtotime( 'next ' . $ctc_data[ 'day' ] ) );
	
	$time = empty( $ctc_data[ 'time' ] ) || empty( $day ) ? '' : date_i18n( 'g:iA', strtotime( $ctc_data[ 'time' ] ) );
	
	$demos = empty ( $ctc_data[ 'demographic' ] ) ? __( 'Anyone', 'harvest_tk' ) : $ctc_data[ 'demographic' ];
	
	$leader = empty ( $ctc_data[ 'leader' ] ) ? '' : $ctc_data[ 'leader' ];
	$leader_em = empty ( $ctc_data[ 'leader_em' ] ) ? '' : $ctc_data[ 'leader_em' ];
	$leader = $leader_em ? "<a href='mailto:$leader_em'>$leader</a>" : $leader;
	$leader_ph = empty ( $ctc_data[ 'leader_ph' ] ) ? '' : $ctc_data[ 'leader_ph' ];
	
	$zip = empty ( $ctc_data[ 'zip' ] ) ? '' : $ctc_data[ 'zip' ];
	$has_childcare = empty ( $ctc_data[ 'has_childcare' ] ) ? false : boolval( $ctc_data[ 'has_childcare' ] );

	 
?>

	<div class="ctc-details col-md-4">
		
<?php if( $day ) {	?>

			<div class="ctc-date-time li"><i class="fa fa-clock-o aria-hidden="true"></i><?php _ex( "{$day}s at {$time}", 'day of the week and time (as in "Sundays at 7:00pm")', 'harvest_tk' ); ?></div>

<?php } if( $leader ) {	?>

			<div class="ctc-leader li"><i class="fa fa-user aria-hidden="true"></i><b><?php _e( 'Led by:', 'harvest_tk' ); ?></b> <?php echo $leader; ?></div>

<?php } if( $leader_ph ) {	?>

			<div class="ctc-phone li"><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:<?php echo $leader_ph; ?>" rel="nofollow"><?php echo $leader_ph; ?></a></div>

<?php } if( $demos ) {	?>

			<div class="ctc-demographic li"><i class="fa fa-tag" aria-hidden="true"></i><b><?php _e( 'For:', 'harvest_tk' ); ?></b> <?php echo $demos; ?></div>

<?php } if( $zip ) {	?>

			<div class="ctc-location li"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $zip; ?></div>

<?php } if( $has_childcare ) {	?>

			<div class="ctc-childcare li"><i class="fa fa-child" aria-hidden="true"></i><?php _e( 'Childcare available', 'harvest_tk' ); ?></a></div>

<?php } ?>

	</div> <!-- .ctc-details -->
	

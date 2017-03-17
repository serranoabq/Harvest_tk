<?php
/**
 * Template for display CTC sermon details on the sidebar of an sermon page
 *
 * Presumes CTC data was retrieved from calling template
 *
 * @package harvest_tk
 */
	global $ctc_data;
	if ( empty( $ctc_data ) )
		$ctc_data = harvest_tk_get_sermon_data( get_the_ID() );
	
	$series_str = $ctc_data[ 'series' ];
	$speaker_str = $ctc_data[ 'speakers' ];
	$users = strripos( $speaker_str, ', and' ) === false ? 'user' : 'users';
	$audio_src = $ctc_data[ 'audio' ];
?>

	<div class="ctc-details">
<?php if( $speaker_str ) {	?>

		<div class="ctc-sermon-speaker li"><i class="fa fa-<?php echo $users; ?>"></i><?php echo $speaker_str; ?></div>

<?php } if( $series_str ) {	?>

		<div class="ctc-sermon-series li"><i class="fa fa-folder-open"></i><?php echo $series_str; ?></div>

<?php } if( $audio_src ) { ?>	

		<div class="ctc-sermon-download">
			<a href="<?php echo $audio_src; ?>" class="btn btn-default btn-lg">
				<i class="fa fa-download" aria-hidden="true"></i><?php _e( 'Download Audio', 'harvest_tk' ); ?> 
			</a>
		</div>
		
<?php } ?> 
	</div> <!-- .ctc-sermon-details -->
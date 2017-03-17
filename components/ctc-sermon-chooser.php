<?php
/**
 * Template for display a chooser for viewing either video or audio
 *
 * @package harvest_tk
 */
	global $ctc_data, $do_media;
	if ( empty( $ctc_data ) )
		$ctc_data = harvest_tk_get_sermon_data( get_the_ID() );
	
	$has_audio = ! empty( $ctc_data[ 'audio' ] );
	$has_video = ! empty( $ctc_data[ 'video' ] );

	if ( ! $has_audio || ! $has_video )
		return;
	$active = 'btn-primary active';
	$inactive = 'btn-secondary';
?>

	<div class="ctc-sermon-chooser">
		<div class="btn-group" role="group" aria-label="Choose Audio or Video">
			<a href="<?php echo add_query_arg( [ 'media' => 'video' ] ); ?>" class="btn btn-default <?php echo $do_media=='video' ? $active: $inactive; ?>">Video</a>
			<a href="<?php echo add_query_arg( [ 'media' => 'audio' ] ); ?>" class="btn btn-default <?php echo $do_media=='audio' ? $active: $inactive; ?>">Audio</a>
		</div>
	</div> <!-- .ctc-sermon-chooser -->
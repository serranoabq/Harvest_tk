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

	// Bail if either audio or video is missing
	if ( ! $has_audio || ! $has_video )
		return;
	
	$active = 'btn-primary active';
	$inactive = 'btn-secondary';
?>

	<div class="ctc-sermon-chooser col-12">
		<div class="btn-group" role="group" aria-label="<?php _e( 'Choose Audio or Video', 'harvest_tk' ); ?>">
			<a href="<?php echo add_query_arg( [ 'media' => 'video' ] ); ?>" class="btn <?php echo $do_media=='video' ? $active: $inactive; ?>" title="<?php _e( 'Play Video', 'harvest_tk' ); ?>"><?php _e( 'Watch', 'harvest_tk' ); ?></a>
			<a href="<?php echo add_query_arg( [ 'media' => 'audio' ] ); ?>" class="btn <?php echo $do_media=='audio' ? $active: $inactive; ?>" title="<?php _e( 'Play Audio', 'harvest_tk' ); ?>"><?php _e( 'Listen', 'harvest_tk' ); ?></a>
			<a href="<?php echo $ctc_data[ 'audio' ]; ?>" class="btn btn-secondary" title="<?php _e( 'Download Audio', 'harvest_tk' ); ?>" ><i class="fa fa-download" aria-hidden="true"></i></a>
		</div>
	</div> <!-- .ctc-sermon-chooser -->
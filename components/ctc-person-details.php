<?php
/**
 * Template for display CTC sermon details on the sidebar of an sermon page
 *
 * Presumes CTC data was retrieved from calling template
 *
 * @package harvest_tk
 */
	
	$ctc_data = harvest_tk_get_person_data( get_the_ID() );
	$urls = explode( "\r\n", $ctc_data[ 'url' ] );
	
	$position = empty ( $ctc_data[ 'position' ] ) ? '' : $ctc_data[ 'position' ];
	
	$phone = empty( $ctc_data[ 'phone' ] ) ? '' : empty( $ctc_data[ 'phone' ] );
	
	$email = empty( $ctc_data[ 'email' ] ) ? '' : empty( $ctc_data[ 'email' ] );
	
?>

	<div class="col-12">
		<div class="ctc-details">
		
<?php if( $position ) {	?>

			<div class="ctc-position li d-inline-block"><i class="fa fa-user aria-hidden="true"></i><?php echo $position; ?></div>

<?php } if( $email ) {	?>

			<div class="ctc-email li"><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>

<?php } if( $phone ) {	?>

			<div class="ctc-phone li"><i class="fa fa-phone" aria-hidden="true"></i><a href="mailto<?php echo $phone; ?>"><?php echo $phone; ?></a></div>

<?php } ?>

		</div>
	
<?php if( count( $urls ) > 0 ) { ?>	

		<div class="ctc-urls">
			
		<?php 
			foreach( $urls as $url_item ): 
				$host = strtolower( parse_url( $url_item, PHP_URL_HOST ) );
				$fas = array( 'facebook', 'twitter', 'instagram' );
				if( false === stripos( 'facebook.com', $host ) ) array_shift( $fas );
				if( false === stripos( 'twitter.com', $host ) ) array_shift( $fas );
				if( false === stripos( 'instagram.com', $host ) ) array_shift( $fas );
				$fa = '';
				if( ! empty( $fas ) ) {
					$fa = '<i class="fa fa-' . $fas[0] .'" aria-hidden="true"></i>';
				}
		?>
		
			<div class="ctc-url li"><?php echo $fa; ?><a href="<?php echo esc_url( $url_item ); ?>"><?php echo $url_item; ?></a></div>
		
		<?php endfor; ?>		
		
		</div> <!-- .ctc-urls -->
		
<?php } ?> 

		</div> <!-- .ctc-details -->
	</div>
	
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
	
	$phone = empty( $ctc_data[ 'phone' ] ) ? '' : $ctc_data[ 'phone' ];
	
	$email = empty( $ctc_data[ 'email' ] ) ? '' : $ctc_data[ 'email' ] ;
	 
?>

	<div class="ctc-details col-12">
		
<?php if( $position ) {	?>

			<div class="ctc-position li d-inline-block mr-4"><i class="fa fa-user aria-hidden="true"></i><?php echo $position; ?></div>

<?php } if( $email ) {	?>

			<div class="ctc-email li d-inline-block mr-4"><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>

<?php } if( $phone ) {	?>

			<div class="ctc-phone li d-inline-block mr-4"><i class="fa fa-phone" aria-hidden="true"></i><a href="mailto<?php echo $phone; ?>"><?php echo $phone; ?></a></div>

<?php } ?>

	</div> <!-- .ctc-details -->
	
<?php if( count( $urls ) > 0 ) { ?>	

	<div class="col-12 ctc-urls">
	
<?php 
	foreach( $urls as $url_item ): 
		$host = strtolower( parse_url( $url_item, PHP_URL_HOST ) );
		$fa = '';
		if( false !== stripos( $host, 'facebook.com' ) )
			$fa = 'facebook-square';
		if( false !== stripos( $host, 'twitter.com' ) )
			$fa = 'twitter-square';
		if( false !== stripos( $host, 'instagram.com' ) )
			$fa = 'intagram';
		if( empty( $fa ) ) {
			$link = $url_item;
		} else {
			$link = '<i class="fa fa-2x fa-' . $fa .'" aria-hidden="true"></i>';
		}
?>
		
		<div class="ctc-url d-inline-block mr-2"><a href="<?php echo esc_url( $url_item ); ?>"><?php echo $link; ?></a></div>
		
<?php endforeach; ?>		
		
	</div> <!-- .ctc-urls -->
		
<?php } ?> 

		</div> <!-- .ctc-details -->
	</div>
	
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
			$has_image = ! empty( $ctc_data[ 'img' ] );
			$has_map = $has_image ? stripos( $ctc_data[ 'img' ], 'maps.google' ) != false : false;
			if( $has_map ){
				$img_url = add_query_arg( array(
					'size' => '540x400',
					'scale' => 1,
					'zoom' => 16,
					), $ctc_data[ 'img' ] );
				$img_src = '<img src="'. $img_url . '" class="ctc-image card-img-top img-fluid" />';
			} else {
				$id = empty( $ctc_data[ 'img_id' ] ) ? harvest_tk_get_attachment_id( $ctc_data[ 'img' ] ) : $ctc_data[ 'img_id' ];
				$img_src = wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] );
			}

		?>

	<div class="d-flex col-sm-6 col-md-4">
		<div class="card text-center ctc-card">

			<?php echo $img_src; ?>

			<div class="card-block p-0 m-2">

				<h3 class="card-title"><?php the_title(); ?></h3>

				<div class="ctc_capability">

					<div class="card-subtitle text-muted ctc_date"><?php echo $address; ?></div>

					<p><?php echo $times; ?></p>

					<?php if( $ctc_data[ 'map_url'] ): ?>
					<div class="mt-4">
						<a href="<?php echo $ctc_data[ 'map_url' ]; ?>" target="_blank" alt="<?php _e( 'Map and Directions', 'harvest_tk' ); ?>" class="btn btn-secondary font-weight-bold text-uppercase">
							<?php _e( 'Directions', 'harvest_tk' ); ?>
						</a>
					</div>
					<?php endif; ?>

				</div>

			</div>

		</div>
	</div>

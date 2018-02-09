<?php
/**
 * Template part for displaying groups in card format
 *
 * @package harvest_tk
 */
	if( ! get_the_ID() ) return; // Bail if not in the Loop
?>
		<?php
			$ctc_data = harvest_tk_get_group_data( get_the_ID() );
			
			$id = empty( $ctc_data[ 'img_id' ] ) ? harvest_tk_get_attachment_id( $ctc_data[ 'img' ] ) : $ctc_data[ 'img_id' ];
			
			$day = $ctc_data[ 'day' ] ? date_i18n( 'l', strtotime( 'next ' . $ctc_data[ 'day' ] ) ): '';
			$time = $ctc_data[ 'time' ] && $day ? date_i18n( 'g:iA', strtotime( $ctc_data[ 'time' ] ) ) : '';
			if( empty( $ctc_data[ 'demographic_sl' ] ) ){
				$ctc_data[ 'demographic_sl' ] = 'anyone' ;
				$ctc_data[ 'demographic' ] = __( 'Anyone', 'harvest_tk' ) ;
			} 
			$demo_sl = explode( ", ", $ctc_data[ 'demographic_sl' ] );
			$demos = explode( ", ", $ctc_data[ 'demographic' ] );
			$leader_em = $ctc_data[ 'leader_em' ];
			$leader = $ctc_data[ 'leader' ];
			$leader = $leader_em ? "<a href='mailto:$leader_em'>$leader</a>" : $leader;
			$has_childcare = $ctc_data[ 'has_childcare' ];
			$zip = "z" . $ctc_data[ 'zip' ];
			
			$classes = array();
			$classes[] = $ctc_data[ 'day' ];
			$classes[] = 'z' . $ctc_data[ 'zip' ];
			if( $has_childcare ) $classes[] = 'haschildcare';
			$classes = array_merge( $classes, $demo_sl );
		?>

	<div class="d-flex col-sm-6 col-md-4  mix ctcex_group <?php echo join( ' ', $classes ); ?>">
		<div class="card text-center ctc-card">

			<a href="<?php echo the_permalink(); ?>">

				<?php echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] ); ?>

				<div class="card-block p-0 m-2">

					<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

					<div class="ctc_capability">

						<?php if( $day ): ?><div class="card-subtitle text-muted ctc_date_time"><?php _ex( "{$day}s at {$time}", 'day of the week and time (as in "Sundays at 7:00pm"); $day and $time are i18n-ized', 'harvest_tk' ); ?></div><?php endif; ?>
						
						<?php if( $leader ): ?><div class="card-subtitle text-muted ctc_leader"><b><?php _e( 'Led by:', 'harvest_tk' ); ?></b> <?php echo $leader; ?></div><?php endif; ?>
						
						<?php if( $demos ): ?><div class="card-subtitle text-muted ctc_demo"><b><?php _e( 'For:', 'harvest_tk' ); ?></b> <?php echo join( ', ', $demos ); ?></div><?php endif; ?>
						
						<?php if( $has_childcare ): ?><i class="fa fa-child" title="<?php _e('Has Childcare', 'harvest_tk'); ?>"></i><?php endif; ?>
						

					</div>

				</div>

			</a>

		</div>
	</div>

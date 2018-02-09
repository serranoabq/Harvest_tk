<?php
/**
 * Template part for displaying people in card format
 *
 * @package harvest_tk
 */
	if( ! get_the_ID() ) return; // Bail if not in the Loop
?>
		<?php
			$ctc_data = harvest_tk_get_person_data( get_the_ID() );
			$id = empty( $ctc_data[ 'img_id' ] ) ? harvest_tk_get_attachment_id( $ctc_data[ 'img' ] ) : $ctc_data[ 'img_id' ];
			$position = empty ( $ctc_data[ 'position' ] ) ? '' : $ctc_data[ 'position' ];
			$email = empty( $ctc_data[ 'email' ] ) ? '' : 'mailto:' . $ctc_data[ 'email' ];
			$ctc_data[ 'url' ] .=  "\r\n" . $email;
			$urls = explode( "\r\n", $ctc_data[ 'url' ] );
			
		?>

	<div class="d-flex col-sm-6 col-md-4">
		<div class="card text-center ctc-card">

			<a href="<?php echo the_permalink(); ?>">

				<?php echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] ); ?>

				<div class="card-block p-0 m-2">

					<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

					<div class="ctc_capability">

						<?php if( $position ): ?><div class="card-subtitle text-muted ctc_position"><?php echo $position; ?></div><?php endif; ?>
						
						<div class="card-subtitle">
						
							<?php 
								foreach( $urls as $url_item ): 
									$host = strtolower( parse_url( $url_item, PHP_URL_HOST ) );
									$fa = ''; $link = '';
									if( false !== stripos( $host, 'facebook.com' ) )
										$fa = 'facebook-square';
									if( false !== stripos( $host, 'twitter.com' ) )
										$fa = 'twitter-square';
									if( false !== stripos( $host, 'instagram.com' ) )
										$fa = 'instagram';
									if( false !== stripos( $url_item, 'mailto:' ) )
										$fa = 'envelope';
									if( ! empty( $fa ) ) 
										$link = '<i class="fa fa-' . $fa .'" aria-hidden="true"></i>';
							?>
									
							<div class="ctc-url d-inline-block mr-2"><a href="<?php echo esc_url( $url_item ); ?>" class="text-muted"><?php echo $link; ?></a></div>
									
							<?php endforeach; ?>	

						</div>

					</div>

				</div>

			</a>

		</div>
	</div>

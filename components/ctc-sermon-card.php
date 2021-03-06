<?php
/**
 * Template part for displaying sermons in card format
 *
 * @package harvest_tk
 */
	if( ! get_the_ID() ) return; // Bail if not in the Loop 
?>
		<?php
			$ctc_data = harvest_tk_get_sermon_data( get_the_ID() );
			$has_audio = ! empty( $ctc_data[ 'audio' ] );
			$has_video = ! empty( $ctc_data[ 'video' ] );
			$id = empty( $ctc_data[ 'img_id' ] ) ? harvest_tk_get_attachment_id( $ctc_data[ 'img' ] ) : $ctc_data[ 'img_id' ];
		?>
		
	<div class="d-flex col-sm-6 col-md-4">
		<div class="card text-center ctc-card">
		
			<a href="<?php echo the_permalink(); ?>">
			
				<?php echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] ); ?>
				
				<div class="card-block p-0 m-2">
				
					<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					
					<div class="ctc_capability">
					
						<div class="card-subtitle text-muted ctc_speaker"><?php echo $ctc_data[ 'speakers' ]; ?></div>
						<div class="card-subtitle text-muted ctc_date"><?php the_date(); ?></div>
						
						<?php if ( $has_audio ): ?><i class="fa fa-volume-up" title="<?php _e('Audio Available', 'harvest_tk'); ?>"></i><?php endif; ?> 
						<?php if ( $has_video ): ?><i class="fa fa-film" title="<?php _e('Video Available', 'harvest_tk'); ?>"></i><?php endif; ?> 
						
					</div>
					
				</div>
				
			</a>
			
		</div>
	</div>
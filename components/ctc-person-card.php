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
			$position = $ctc_data[ 'position' ];
			$id = $ctc_data[ 'img_id' ] ? $ctc_data[ 'img_id' ] :harvest_tk_get_attachment_id( $ctc_data[ 'img' ] );
		?>
	
	<div class="d-flex col-sm-6 col-md-4">
		<div class="card text-center ctc-card">
		
			<a href="<?php echo the_permalink(); ?>">
			
				<?php echo wp_get_attachment_image( $id, 'harvest_tk-person', '', ['class'=>'ctc-image card-img-top img-fluid'] ); ?>
				
				<div class="card-block p-0 m-2">
				
					<h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					
					<div class="ctc_capability">
					
						<div class="card-subtitle text-muted ctc_position"><?php echo $position; ?></div>
							
					</div>
					
				</div>
				
			</a>
			
		</div>
	</div>
<?php
/**
 * Template Name: Sermon Series 
 *
 * The template for displaying all sermon series.
 *
 * @package harvest_tk
 */	
get_header(); 
?>
		
	<?php while ( have_posts() ) : the_post(); ?>

		<div class="row">
		
			<div class="text-center col-12 p-3">
				<h1><?php the_title(); ?></h1>
			</div>
		
			<div class="col-12">
				<p><?php the_content(); ?></p>
			</div>
			
		</div>


	<?php endwhile; // End of the loop. ?>

	<div class="row d-flex align-items-stretch justify-content-center">
	
	<?php
		$all_series = get_terms( 'ctc_sermon_series', array( 'order_by' => 'id', 'order' => 'DESC') );
		foreach( $all_series as $single_series ) :
			$img = '';
			$id = 0;
			$term_id = $single_series -> term_id ; 
			$term_link = get_term_link( intval( $single_series->term_id ), 'ctc_sermon_series' );
			$term_name = $single_series -> name;
			if( get_option( 'ctc_tax_img_' . $term_id ) ) {
				$img = get_option( 'ctc_tax_img_' . $term_id );
				$id = harvest_tk_get_attachment_id( $img );
			}
	?>
		<div class="d-flex col-sm-6 col-md-4">
			<div class="card card-inverse text-center ctc-card">
			
				<a href="<?php echo $term_link; ?>">
				
					<?php if( $id ): 
						
						echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] ); 
						
					endif; ?>
					
					<div class="card-block p-0 m-2">
					
						<h4 class="card-title"><a href="<?php echo $term_link; ?>"><?php echo $term_name; ?></a></h4>
						
					</div>
					
					
				</a>
				
			</div>
		</div>
<?php endforeach; ?>	

	</div><!-- .card-columns -->
	
	<?php harvest_tk_pagination(); ?>

<?php get_footer(); ?>
	

		

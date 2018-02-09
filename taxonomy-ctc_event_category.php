<?php
/**
 * Archive page for a single event category
 *
 * @package harvest_tk
 */

$term = get_queried_object();
get_header(); 
?>

	<div class="row">

		<div class="text-center col-12 p-3">
			<h1><?php echo $term->name; ?></h1>
		</div>
		
	</div>

<?php if( $term->description ): ?>
		
		<div class="ctc_sermon_series_description col-12">
			<p><?php echo do_shortcode( $term->description ); ?></p>
		</div>

<?php endif; ?>

	<div class="row d-flex align-items-stretch justify-content-center">
	
	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php get_template_part( 'components/ctc-event', 'card' ); ?>

	<?php endwhile; // End of the loop. ?>

	</div><!-- .card-columns -->
	
	<?php harvest_tk_pagination(); ?>
	
<?php get_footer(); ?>

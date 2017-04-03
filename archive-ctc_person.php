<?php
/**
 * Archive page for all events
 *
 * @package harvest_tk
 */

get_header(); 
?>
	<div class="row">

		<div class="text-center col-12 p-3">
			<h1><?php echo harvest_tk_get_ctc_name( 'ctc_person' ); ?></h1>
		</div>
		
	</div>

	<div class="row d-flex align-items-stretch justify-content-center">
	
	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php get_template_part( 'components/ctc-person', 'card' ); ?>

	<?php endwhile; // End of the loop. ?>

	</div> 
	
	<?php harvest_tk_pagination(); ?>
	
<?php get_footer(); ?>

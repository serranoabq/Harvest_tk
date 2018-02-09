<?php
/**
 * Archive page for all groups
 *
 * @package harvest_tk
 */

get_header(); 
?>
	<div class="row">

		<div class="text-center col-12 p-3">
			<h1><?php echo harvest_tk_get_ctc_name( 'ctcex_group' ); ?></h1>
		</div>
		
	</div>
	
	<?php get_template_part( 'components/ctc-group', 'selector' ); ?>
	
	<div class="row d-flex align-items-stretch justify-content-center ctcex_groups_container">
	
	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php get_template_part( 'components/ctc-group', 'card' ); ?>

	<?php endwhile; // End of the loop. ?>

	</div> 
	
	<?php harvest_tk_pagination(); ?>
	
<?php get_footer(); ?>

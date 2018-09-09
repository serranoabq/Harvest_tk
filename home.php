<?php
/**
 * The main template file.
 *
 * @package harvest_tk
 */

get_header(); ?>

	<div class="row">
	
		<div class="text-center col-12 p-3">
	
			<h1><?php _e( 'Blog', 'harvest_tk' ); ?></h1>
		
		</div>
	
	</div>
	
	<?php if ( have_posts() ) : ?>

	<div class="row">
	
		<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'components/post', 'card' ); ?>

		<?php endwhile; ?>

	</div>
	
		<?php harvest_tk_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'index' ); ?>

	<?php endif; ?>

<?php get_footer(); ?>
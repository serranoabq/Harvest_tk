<?php
/**
 * The Template for displaying all single posts.
 *
 * @package harvest_tk
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'components/content', 'single' ); ?>

		<?php // harvest_tk_content_nav( 'nav-below' ); ?>
		<?php harvest_tk_pagination(); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		?>

	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
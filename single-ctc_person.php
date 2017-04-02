<?php
/**
 * The template for displaying a single sermon
 *
 * @package harvest_tk
 */

get_header(); 
?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'components/ctc-person', 'single' ); ?>
		
	<?php endwhile; // End of the loop. ?>

<?php get_footer(); ?>

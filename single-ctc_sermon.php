<?php
/**
 * The template for displaying all single sermon posts.
 *
 * @package harvest_tk
 */

get_header(); 
?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'components/content', 'single-sermon' ); ?>

		<?php 
			$meta_args = array(
				'order' 		=> 'DESC',
				'orderby' 	=> 'date',
			);
			harvest_tk_link_pages_by_meta( array(
				'prev_text' => '<span>' . esc_html__( 'Previous', 'harvest_tk' ) . '</span> %title',
				'next_text' => '<span>' . esc_html__( 'Next', 'harvest_tk' ) . '</span> %title',
			), $meta_args );

		?>

		<?php //get_template_part( 'components/content','related-sermons' ); ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

	<?php endwhile; // End of the loop. ?>

<?php get_footer(); ?>

<?php
/**
 * The template for displaying a single group
 *
 * @package harvest_tk
 */

get_header(); 
?>

	<?php while ( have_posts() ) : the_post(); ?>
	
		<?php get_template_part( 'components/ctc-group', 'single' ); ?>

		<?php 
			/* Not functional yet
			$meta_args = array(
				'order' 		=> 'ASC',
				'orderby' 	=> 'meta_value',
				'meta_key' 	=> '_ctcex_group_day',
				'meta_type' => 'DATETIME',
				'meta_query' => array(
					array(
						'key' 	=> '_ctcex_group_day',
						'value' => date_i18n( 'Y-m-d' ), // today localized
						'compare' => '>=', // later than today
						'type' => 'DATE',
					),
				)
			);
			
			harvest_tk_link_pages_by_meta( array(
				'prev_text' => '<i class="fa fa-chevron-left"></i> &nbsp; %title',
				'next_text' => '%title &nbsp; <i class="fa fa-chevron-right"></i>',
			), $meta_args );
			*/ 
		?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

	<?php endwhile; // End of the loop. ?>

<?php get_footer(); ?>

<?php
/**
 * Template Name: Group Archive 
 *
 * The template for displaying all groups, but while 
 * allowing content in the header.
 *
 * @package harvest_tk
 */	
get_header(); 
?>

	<?php while ( have_posts() ) : the_post(); ?>

	<div class="row">

		<div class="text-center col-12 p-3">
			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
		</div><!-- .entry-header -->
	
	</div>
	
	<div class="row">
		
		<div class="col-12">
			<p><?php the_content(); ?></p>
		</div>

	</div>
	
	<?php endwhile; // End of the loop. ?>
	
	<?php get_template_part( 'components/ctc-group', 'selector' ); ?>
	
	<?php 
		$args = array( 
			'post_type' 			=> 'ctcex_group',  
			'order' 					=> 'ASC', 
			'order_by'        => 'meta_value_date',
			'meta_key'        => '_ctcex_group_day',
			'posts_per_page'  => -1, // show all
			//'paged'           => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,

		);
		$m_posts = new WP_Query ( $args );
		
		// Pagination fix
		// $temp_query = $wp_query;
		// $wp_query   = NULL;
		// $wp_query   = $m_posts;

	?>
	
	<?php if( $m_posts->have_posts() ): ?>
	
	<div class="row d-flex align-items-stretch justify-content-center ctcex_groups_container">

		<?php while ( $m_posts->have_posts() ) : $m_posts->the_post(); 
		
			get_template_part( 'components/ctc-group', 'card' );

		endwhile; // End second loop. ?>

	</div> 
	
	<?php 
		endif; // have_posts 
		
		wp_reset_postdata();

	?>
	
	<?php harvest_tk_pagination(); ?>
	
	<?php 
		// $wp_query = NULL;
		// $wp_query = $temp_query;
	?>
	
<?php get_footer(); ?>

	

		

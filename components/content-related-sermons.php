<?php
/**
 * Template part for displaying related sermons
 *
 * @package harvest_tk
 */
?>

<?php
	global $ctc_data;
	if ( empty( $ctc_data ) )
		$ctc_data = harvest_tk_get_sermon_data( get_the_ID() );
	
	if( $ctc_data[ 'series' ] ):
		$tax_query[] = array(
				'taxonomy'	=> 'ctc_sermon_series',
				'field'			=> 'slug',
				'terms'			=> $ctc_data[ 'series_slug' ],
		);
		
		
		$args = array( 
			'post_type' 			=> 'ctc_sermon',  
			'tax_query'				=> $tax_query,
			'order' 					=> 'DESC', 
			'posts_per_page'   => 3,
			'no_found_rows'   => true,
			'post__not_in'		=> array( $post->ID ),
		);
		$related_pages = new WP_Query ( $args );

		
?>

<?php if ( $related_pages->have_posts() ) : ?>

<div class="ctc-related-sermons pt-5">
	<h2><?php echo  __( 'More in this series', 'harvest_tk')  ?></h2>

	<ul>
		
		<?php while ( $related_pages->have_posts() ) : $related_pages->the_post(); ?>
		
		<li>
			<a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a> 
			<small class="ml-5 text-muted"><?php the_date(); ?></small>
		</li>
		
		<?php endwhile; ?>

	</ul>
</div><!-- .ctc-related-sermons -->

<?php
endif; // if $ctc_data[ 'series' ]

wp_reset_postdata();

endif; // if have_posts()

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
<div class="ctc-related-sermons">
	<h2><?php echo  __( 'Other messages from this series', 'harvest_tk')  ?></h2>

	<div class="row">
		
		<?php while ( $related_pages->have_posts() ) : $related_pages->the_post(); 
			
			$mdata = harvest_tk_get_sermon_data( get_the_ID() );
			$img = $mdata[ 'img' ];
			$has_video = ! empty( $mdata[ 'video' ] );
			$has_audio = ! empty( $mdata[ 'audio' ] );
			$id = harvest_tk_get_attachment_id( $img );
			$img_src = wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top'] );
			$permalink = $mdata[ 'permalink' ];

		?>
		<div class="col-sm-6">
			<div <?php post_class( 'card' ); ?>>
				<?php //if ( $img ) :  echo $img_src; endif; ?>
				<div class="card-block">
					<a href="<?php echo $permalink; ?>"><?php the_title( '<h5 class="card-title">' , '</h5>' ); ?></a>
					<h6 class="card-subtitle mb-2 text-muted"><?php the_date(); ?></h6>
					<div class="ctc_capability">
						<?php if ( $has_audio ): ?><i class="fa fa-volume-up" title="<?php _e('Audio Available', 'harvest_tk'); ?>"></i><?php endif; ?> 
						<?php if ( $has_video ): ?><i class="fa fa-film" title="<?php _e('Video Available', 'harvest_tk'); ?>"></i><?php endif; ?> 
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>

	</div>
</div><!-- .ctc-related-sermons -->
<?php
endif;
wp_reset_postdata();
endif;

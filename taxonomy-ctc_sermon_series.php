<?php
/**
 * The template for displaying sermon series archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package harvest_tk
 */

$term = get_queried_object();


get_header(); 
?>

	<div class="row">
		<div class="ctc_sermon_series_name text-center col-12 p-3">
			<h1><?php echo $term->name; ?></h1>
		</div>
		
		<?php if( $term->description ): ?>
		<div class="ctc_sermon_series_description col-12">
			<p><?php echo do_shortcode( $term->description ); ?></p>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="card-columns" >
	
	<?php while ( have_posts() ) : the_post(); ?>
		
		<div class="card card-inverse text-center ctc-card">
			<?php 
				$ctc_data = harvest_tk_get_sermon_data( get_the_ID() );
				$has_audio = ! empty( $ctc_data[ 'audio' ] );
				$has_video = ! empty( $ctc_data[ 'video' ] );
				$id = harvest_tk_get_attachment_id( $ctc_data[ 'img' ] );
				echo wp_get_attachment_image( $id, 'harvest_tk-hero', '', ['class'=>'ctc-image card-img-top img-fluid'] ); 
			?>
			<div class="card-block p-0 m-2">
				<h4 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<div class="ctc_capability">
					<div class="ctc_date"><?php the_date(); ?></div>
					<?php if ( $has_audio ): ?><i class="fa fa-volume-up" title="<?php _e('Audio Available', 'harvest_tk'); ?>"></i><?php endif; ?> 
					<?php if ( $has_video ): ?><i class="fa fa-film" title="<?php _e('Video Available', 'harvest_tk'); ?>"></i><?php endif; ?> 
				</div>
			</div>
		</div>
	<?php endwhile; // End of the loop. ?>
	</div><!-- .row -->
	<?php harvest_tk_pagination(); ?>
	
<?php get_footer(); ?>

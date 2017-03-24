<?php
/**
 * Template Name: Sermon Series 
 *
 * The template for displaying all single sermon posts.
 *
 * @package harvest_tk
 */	
get_header(); 
?>
		<div class="row">

<?php
	$all_series = get_terms( 'ctc_sermon_series', array( 'order_by' => 'id', 'order' => 'DESC') );
	foreach( $all_series as $single_series ) :
		$img = '';
		$term_id = $single_series -> term_id ; 
		$term_link = get_term_link( intval( $single_series->term_id ), 'ctc_sermon_series' );
		$term_name = $single_series -> name;
		if( get_option( 'ctc_tax_img_' . $term_id ) )
			$img = get_option( 'ctc_tax_img_' . $term_id );
?>

				<div class="grid-33 mobile-grid-50 ctc-sermon-grid">
					<a href="<?php echo $term_link; ?>">
						<div class="ctc-sermon">
<?php if( $img ): ?>
							<!-- div class="ctc-grid-details">
								<h3><?php echo $term_name; ?></h3>
							</div -->
							<img src="<?php echo $img; ?>" class="ctc-sermon-img" alt="<?php echo $term_name; ?>" title="<?php echo $term_name; ?>"/>
<?php	else: ?>
							<div class="ctc-grid-full accent-background">
								<h1 class="ctc-sermon-name"><?php echo $term_name; ?></h1>
							</div>
<?php	endif; ?>

						</div> <!-- ctc-sermon -->
					</a>
				</div>
				
<?php endforeach; ?>	

	

<?php get_footer(); ?>
	

		

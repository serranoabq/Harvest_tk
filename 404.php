<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package harvest_tk
 */

get_header(); ?>

	<section class="content-padder error-404 not-found">

		<header>
			<h2 class="page-title"><?php _e( 'Oops! Something went wrong here.', 'harvest_tk' ); ?></h2>
		</header><!-- .page-header -->

		<div class="page-content">

			<p><?php _e( 'We\'re sorry, but the page you requested could not be found.', 'harvest_tk' ); ?></p>

		</div><!-- .page-content -->

	</section><!-- .content-padder -->

<?php get_footer(); ?>
<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package harvest_tk
 */

get_header(); ?>

	<article class="row content-padder error-404 not-found">

		<header class="col-12">
			<h1 class="page-title"><?php _e( 'Oops! Something went wrong here.', 'harvest_tk' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content col-12">

			<p><?php _e( 'We\'re sorry, but the page you requested could not be found.', 'harvest_tk' ); ?></p>

		</div><!-- .entry-content -->

	</article><!-- .error-404 -->

<?php get_footer(); ?>
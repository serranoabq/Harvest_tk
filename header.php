<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package harvest_tk
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>
		
	<header id="masthead" class="site-header" role="banner">
	
		<?php get_template_part( 'includes/components/site', 'header' ); ?>
	
	</header><!-- #masthead -->

	<nav class="site-navigation">

		<?php get_template_part( 'includes/components/site', 'navigation' ); ?>
	
	</nav><!-- .site-navigation -->

	<div class="main-content">
		<div class="container">
			<div class="row">
				<div id="content" class="main-content-inner col-sm-12 col-md-8">


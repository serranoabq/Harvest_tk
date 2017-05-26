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
	<meta name="theme-color" content="<?php echo get_theme_mod('harvest_tk_header_bgcolor'); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>
		
	<header id="masthead" class="site-header" role="banner" style="background-color: <?php echo get_theme_mod('harvest_tk_header_bgcolor'); ?>">
	
		<?php get_template_part( 'components/site', 'header' ); ?>
	
	</header><!-- #masthead -->
	
	<div class="main-content">
	
		<div class="pre-content">
		
			<div class="pre-content-bg" style="background-color:<?php echo get_theme_mod('harvest_tk_header_bgcolor'); ?>"></div>
			
			<?php harvest_tk_precontent(); ?>
			
		</div> <!-- .pre-content -->
		
		<div class="container<?php echo is_front_page() ? '-fluid p-0' : '' ; ?>">

<?php if( ! is_front_page() ): ?>
		
			<div class="row justify-content-center">
			
				<div id="content" class="main-content-inner col-lg-10">

<?php endif; ?>
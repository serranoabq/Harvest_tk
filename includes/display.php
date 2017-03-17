<?php
/**
 * Some display helpers.
 *
 * @package harvest_tk
 */
 
// Allow shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');

// Make previous/next links based on some special meta argument
function harvest_tk_link_pages_by_meta( $args, $meta_args ){
	$post_id = get_the_id();
	$post_type = get_post_type();
	
	// Templates
	$nav_template = '
		<nav class="navigation post-navigation" role="navigation">
			<h2 class="screen-reader-text">%1$s</h2>
			<div class="nav-links">%2$s</div>
		</nav>';
	$navlink_template = '<div class="nav-%direction">%link</div>';
	$link_template = '<a href="%url" title="%title">%link_text</a>';
	
	// Parse display arguments
	$defaults = array(
		'prev_text'        => '%title',
		'next_text'        => '%title',
		'screen_reader_text' => __( 'Post navigation' ),
		'echo'             => 1
	);
	$r = wp_parse_args( $args, $defaults );
	
	// Parse meta arguments
	$default_meta_args = array(
		'post_type' 	=> $post_type,
		'posts_per_page' => -1,
		'order' 			=> 'DESC',
		'orderby' 		=> 'meta_value', // Use 'meta_value', 'meta_value_num', 'meta_type'
		'meta_key' 		=> '',
		'meta_type'		=> '',
		'meta_query'	=> '',
	);
	$m = wp_parse_args( $meta_args, $default_meta_args );
	
	// Get the next/previous posts
	$pages = array();
	$nav_posts = get_posts( $m );
	foreach($nav_posts as $nav_post) {
		$pages[] += $nav_post->ID;
	}
	$current = array_search($post_id, $pages);
	$prev = $current - 1;
	$next = $current + 1;
	
	// Prepare the navigation
	$prevlink = '';
	$nextlink = '';
	if( $prev > 0 ) {
		$prevID = $pages[ $prev ];
		$prevlink = str_replace( '%url', get_permalink( $prevID ), $link_template );
		$prevlink = str_replace( '%link_text', $r[ 'prev_text' ], $prevlink );
		$prevlink = str_replace( '%title', get_the_title( $prevID ), $prevlink );
		$prevlink = str_replace( '%link', $prevlink, $navlink_template );
		$prevlink = str_replace( '%direction', 'previous', $prevlink );
	}
	if( $next < count( $pages ) ) {
		$nextID = $pages[ $next ];
		$nextlink = str_replace( '%url', get_permalink( $nextID ), $link_template );
		$nextlink = str_replace( '%link_text', $r[ 'next_text' ], $nextlink );
		$nextlink = str_replace( '%title', get_the_title( $nextID ), $nextlink );
		$nextlink = str_replace( '%link', $nextlink, $navlink_template );
		$nextlink = str_replace( '%direction', 'next', $nextlink );
	}
	$nav_link = sprintf( $nav_template, $r[ 'screen_reader_text' ], $prevlink . $nextlink );

	if( $r[ 'echo' ] ){
		echo $nav_link;
	}
	return $nav_link;
	
}

// Get image attachment id to allow use of wp_get_attachment_image
function harvest_tk_get_attachment_id( $url ) {
	$attachment_id = 0;
	$dir = wp_upload_dir();

	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
		$file = basename( $url );

		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			)
		);

		$query = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				$meta = wp_get_attachment_metadata( $post_id );
				$original_file       = basename( $meta['file'] );
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );

				if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
					$attachment_id = $post_id;
					break;
				}

			}
		}
	}
	return $attachment_id;
}

// Adds custom classes to the array of body classes.
function harvest_tk_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'harvest_tk_body_classes' );

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
function harvest_tk_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'harvest_tk_page_menu_args' );

// Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
function harvest_tk_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'harvest_tk_enhanced_image_navigation', 10, 2 );

// Filters wp_title to print a neat <title> tag based on what is being viewed.
function harvest_tk_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'harvest_tk' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'harvest_tk_wp_title', 10, 2 );

function harvest_tk_precontent(){
	if ( is_singular( array( 'ctc_sermon', 'ctc_event', 'ctc_location', 'ctc_person' ) ) ) {
		get_template_part( 'components/ctc','image' ); 
	}
}
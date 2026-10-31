<?php
/**
 * Starvion theme setup.
 *
 * @package Starvion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STARVION_VERSION', '0.2.0' );

require get_template_directory() . '/inc/contact-form.php';

/**
 * Theme supports and editor styles.
 */
function starvion_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'starvion_setup' );

/**
 * Front-end stylesheet.
 */
function starvion_enqueue_assets() {
	wp_enqueue_style( 'starvion', get_stylesheet_uri(), array(), STARVION_VERSION );
}
add_action( 'wp_enqueue_scripts', 'starvion_enqueue_assets' );

/**
 * Templates are not run through the_content, so expand shortcodes placed in
 * Shortcode blocks there (the contact form lives in the Contact template).
 *
 * @param string $content Rendered block content.
 * @return string
 */
function starvion_render_shortcode_block( $content ) {
	return do_shortcode( $content );
}
add_filter( 'render_block_core/shortcode', 'starvion_render_shortcode_block' );

/**
 * Browser tab and home-screen icons, used until a Site Icon is set in the Customizer.
 */
function starvion_default_icons() {
	if ( has_site_icon() ) {
		return;
	}
	printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n", esc_url( get_theme_file_uri( 'assets/images/favicon-32.png' ) ) );
	printf( '<link rel="icon" type="image/png" sizes="512x512" href="%s">' . "\n", esc_url( get_theme_file_uri( 'assets/images/site-icon.png' ) ) );
	printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( get_theme_file_uri( 'assets/images/apple-touch-icon.png' ) ) );
}
add_action( 'wp_head', 'starvion_default_icons' );

/**
 * Pattern category so Starvion sections are easy to find in the inserter.
 */
function starvion_register_pattern_category() {
	register_block_pattern_category(
		'starvion',
		array( 'label' => __( 'Starvion', 'starvion' ) )
	);
}
add_action( 'init', 'starvion_register_pattern_category' );

/**
 * On activation, create the four core pages and set Home as the front page,
 * so a fresh install matches the site structure straight away.
 */
function starvion_create_default_pages() {
	$pages = array(
		'home'     => __( 'Home', 'starvion' ),
		'services' => __( 'Services', 'starvion' ),
		'about'    => __( 'About', 'starvion' ),
		'contact'  => __( 'Contact', 'starvion' ),
	);

	foreach ( $pages as $slug => $title ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$page_id = $existing->ID;
		} else {
			$page_id = wp_insert_post(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'post_title'  => $title,
					'post_name'   => $slug,
				)
			);
		}

		if ( 'home' === $slug && $page_id && ! is_wp_error( $page_id ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $page_id );
		}
	}

	update_option( 'permalink_structure', '/%postname%/' );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'starvion_create_default_pages' );

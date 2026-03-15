<?php
/**
 * PASF-Abong Noga College Theme Functions
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PASFANC_THEME_VERSION', '1.0.0' );
define( 'PASFANC_THEME_DIR', get_template_directory() );
define( 'PASFANC_THEME_URI', get_template_directory_uri() );

/**
 * Theme setup
 */
function pasfanc_theme_setup() {
	load_theme_textdomain( 'pasfanc-theme', PASFANC_THEME_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 250,
		'flex-width'  => true,
		'flex-height' => true,
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus( array(
		'primary'           => __( 'Primary Menu', 'pasfanc-theme' ),
		'footer'            => __( 'Footer Menu', 'pasfanc-theme' ),
		'footer_home'       => __( 'Footer HOME', 'pasfanc-theme' ),
		'footer_quick'      => __( 'Footer QUICK LINKS', 'pasfanc-theme' ),
		'footer_students'   => __( 'Footer STUDENTS', 'pasfanc-theme' ),
	) );
}
add_action( 'after_setup_theme', 'pasfanc_theme_setup' );

/**
 * Enqueue scripts and styles
 */
function pasfanc_theme_scripts() {
	$version = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : PASFANC_THEME_VERSION;

	wp_enqueue_style( 'pasfanc-theme-style', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'pasfanc-fonts', PASFANC_THEME_URI . '/assets/css/fonts.css', array( 'pasfanc-theme-style' ), $version );
	wp_enqueue_style( 'pasfanc-theme-main', PASFANC_THEME_URI . '/assets/css/main.css', array( 'pasfanc-theme-style', 'pasfanc-fonts' ), $version );
	wp_enqueue_style( 'pasfanc-theme-responsive', PASFANC_THEME_URI . '/assets/css/responsive.css', array( 'pasfanc-theme-main' ), $version );
	wp_enqueue_style( 'pasfanc-futuristic', PASFANC_THEME_URI . '/assets/css/futuristic.css', array( 'pasfanc-theme-responsive' ), $version );

	wp_enqueue_script( 'pasfanc-theme-main', PASFANC_THEME_URI . '/assets/js/main.js', array( 'jquery' ), $version, true );
	if ( is_front_page() ) {
		wp_enqueue_script( 'pasfanc-flash-news', PASFANC_THEME_URI . '/assets/js/flash-news.js', array( 'jquery' ), $version, true );
	}
	// GLightbox for gallery lightbox (homepage + gallery archive)
	if ( is_front_page() || is_post_type_archive( 'pasf_gallery' ) ) {
		wp_enqueue_style( 'glightbox', 'https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css', array(), '3.2.0' );
		wp_enqueue_script( 'glightbox', 'https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js', array(), '3.2.0', true );
		wp_enqueue_script( 'pasfanc-gallery-lightbox', PASFANC_THEME_URI . '/assets/js/gallery-lightbox.js', array( 'glightbox' ), $version, true );
	}
}
add_action( 'wp_enqueue_scripts', 'pasfanc_theme_scripts' );

/**
 * Remove version query string from scripts (security)
 */
function pasfanc_remove_script_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'script_loader_src', 'pasfanc_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'pasfanc_remove_script_version', 15, 1 );

/**
 * Events archive: only show upcoming events (date >= today)
 */
function pasfanc_events_archive_upcoming_only( $query ) {
	if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'pasf_event' ) ) {
		$today = gmdate( 'Y-m-d' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', '_pasf_event_date' );
		$query->set( 'order', 'ASC' );
		$query->set( 'meta_query', array(
			'relation' => 'AND',
			array(
				'key'     => '_pasf_event_date',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => '_pasf_event_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE',
			),
		) );
	}
}
add_action( 'pre_get_posts', 'pasfanc_events_archive_upcoming_only' );

/**
 * Increment site visitor count on each page view (front-end only)
 */
function pasfanc_increment_visitor_count() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	$count = (int) get_option( 'pasfanc_visitor_count', 0 );
	update_option( 'pasfanc_visitor_count', $count + 1 );
}
add_action( 'template_redirect', 'pasfanc_increment_visitor_count', 1 );

/**
 * Append enhanced pagination to content on singular pages when using <!--nextpage-->.
 * Makes pagination dynamic and consistent across all pages/posts.
 */
function pasfanc_content_append_pagination( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$extra_class = is_page_template( 'page-principal-message.php' ) ? 'pagination-principal' : '';
	$pagination  = pasfanc_page_pagination( $extra_class, false );
	return $content . $pagination;
}
add_filter( 'the_content', 'pasfanc_content_append_pagination', 20 );

/**
 * Include required files
 */
require_once PASFANC_THEME_DIR . '/inc/template-tags.php';
require_once PASFANC_THEME_DIR . '/inc/customizer.php';
require_once PASFANC_THEME_DIR . '/inc/security.php';
require_once PASFANC_THEME_DIR . '/inc/admin-customize.php';

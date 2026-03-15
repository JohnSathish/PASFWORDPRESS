<?php
/**
 * Plugin Name: PASF Hero Slider
 * Plugin URI: https://pasfanc.ac.in/
 * Description: Hero slider with image upload, optional title and read more URL per slide.
 * Version: 1.0.0
 * Author: PASF College
 * Author URI: https://pasfanc.ac.in/
 * Text Domain: pasfanc-hero-slider
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package pasfanc-hero-slider
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PASF_HERO_SLIDER_VERSION', '1.0.0' );
define( 'PASF_HERO_SLIDER_DIR', plugin_dir_path( __FILE__ ) );
define( 'PASF_HERO_SLIDER_URI', plugin_dir_url( __FILE__ ) );

require_once PASF_HERO_SLIDER_DIR . 'includes/class-hero-slider-cpt.php';
require_once PASF_HERO_SLIDER_DIR . 'includes/class-hero-slider-meta.php';
require_once PASF_HERO_SLIDER_DIR . 'includes/class-hero-slider-display.php';

/**
 * Activation: flush rewrite rules
 */
function pasf_hero_slider_activate() {
	Pasf_Hero_Slider_CPT::register_post_type();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'pasf_hero_slider_activate' );

/**
 * Init
 */
function pasf_hero_slider_init() {
	Pasf_Hero_Slider_CPT::register_post_type();
	Pasf_Hero_Slider_Meta::init();
	Pasf_Hero_Slider_Display::init();
}
add_action( 'init', 'pasf_hero_slider_init' );

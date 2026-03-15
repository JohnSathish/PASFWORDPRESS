<?php
/**
 * Hero Slide custom post type
 *
 * @package pasfanc-hero-slider
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasf_Hero_Slider_CPT {

	public static function register_post_type() {
		$labels = array(
			'name'               => _x( 'Hero Slides', 'post type general name', 'pasfanc-hero-slider' ),
			'singular_name'      => _x( 'Hero Slide', 'post type singular name', 'pasfanc-hero-slider' ),
			'menu_name'          => _x( 'Hero Slider', 'admin menu', 'pasfanc-hero-slider' ),
			'add_new'            => _x( 'Add New', 'hero slide', 'pasfanc-hero-slider' ),
			'add_new_item'       => __( 'Add New Hero Slide', 'pasfanc-hero-slider' ),
			'edit_item'          => __( 'Edit Hero Slide', 'pasfanc-hero-slider' ),
			'new_item'           => __( 'New Hero Slide', 'pasfanc-hero-slider' ),
			'view_item'          => __( 'View Hero Slide', 'pasfanc-hero-slider' ),
			'search_items'       => __( 'Search Hero Slides', 'pasfanc-hero-slider' ),
			'not_found'          => __( 'No hero slides found.', 'pasfanc-hero-slider' ),
			'not_found_in_trash' => __( 'No hero slides found in Trash.', 'pasfanc-hero-slider' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable'  => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'       => false,
			'hierarchical'       => false,
			'menu_position'     => 25,
			'menu_icon'         => 'dashicons-format-gallery',
			'supports'          => array( 'title', 'page-attributes' ),
		);

		register_post_type( 'pasf_hero_slide', $args );
	}
}

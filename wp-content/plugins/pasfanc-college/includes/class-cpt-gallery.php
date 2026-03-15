<?php
/**
 * Gallery CPT and Taxonomy
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Gallery {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_gallery', array(
			'labels'       => array(
				'name'               => __( 'Gallery', 'pasfanc-college' ),
				'singular_name'      => __( 'Gallery Item', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Gallery Item', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Gallery Item', 'pasfanc-college' ),
				'new_item'           => __( 'New Gallery Item', 'pasfanc-college' ),
				'view_item'          => __( 'View Gallery Item', 'pasfanc-college' ),
				'search_items'       => __( 'Search Gallery', 'pasfanc-college' ),
				'not_found'          => __( 'No gallery items found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No gallery items in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'gallery' ),
			'supports'     => array( 'title', 'thumbnail' ),
			'menu_icon'    => 'dashicons-format-gallery',
			'show_in_rest' => true,
		) );
	}

	public static function register_taxonomy() {
		register_taxonomy( 'pasf_gallery_category', 'pasf_gallery', array(
			'labels'       => array(
				'name'          => __( 'Gallery Categories', 'pasfanc-college' ),
				'singular_name' => __( 'Gallery Category', 'pasfanc-college' ),
				'search_items'  => __( 'Search Categories', 'pasfanc-college' ),
				'all_items'     => __( 'All Categories', 'pasfanc-college' ),
			),
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'gallery-category' ),
			'show_in_rest' => true,
		) );
	}
}
Pasfanc_CPT_Gallery::init();

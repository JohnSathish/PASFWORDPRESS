<?php
/**
 * Testimonials CPT
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Testimonials {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_testimonial', array(
			'labels'       => array(
				'name'               => __( 'Testimonials', 'pasfanc-college' ),
				'singular_name'      => __( 'Testimonial', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Testimonial', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Testimonial', 'pasfanc-college' ),
				'new_item'           => __( 'New Testimonial', 'pasfanc-college' ),
				'view_item'          => __( 'View Testimonial', 'pasfanc-college' ),
				'search_items'       => __( 'Search Testimonials', 'pasfanc-college' ),
				'not_found'          => __( 'No testimonials found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No testimonials in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'publicly_queryable' => false,
			'has_archive'  => false,
			'rewrite'      => false,
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'menu_icon'    => 'dashicons-format-quote',
			'show_in_rest' => true,
		) );
	}
}
Pasfanc_CPT_Testimonials::init();

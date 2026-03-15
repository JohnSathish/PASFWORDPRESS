<?php
/**
 * Flash News CPT (ticker announcements)
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Flash_News {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_flash', array(
			'labels'       => array(
				'name'               => __( 'Flash News', 'pasfanc-college' ),
				'singular_name'      => __( 'Flash News Item', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Flash News', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Flash News', 'pasfanc-college' ),
				'new_item'           => __( 'New Flash News', 'pasfanc-college' ),
				'view_item'          => __( 'View Flash News', 'pasfanc-college' ),
				'search_items'       => __( 'Search Flash News', 'pasfanc-college' ),
				'not_found'          => __( 'No flash news found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No flash news in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'publicly_queryable' => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'flash-news' ),
			'supports'     => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
			'menu_icon'    => 'dashicons-megaphone',
			'menu_position' => 5,
			'show_in_rest' => true,
		) );
	}
}
Pasfanc_CPT_Flash_News::init();

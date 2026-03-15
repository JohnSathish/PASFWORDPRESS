<?php
/**
 * News CPT
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_News {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ), 5 );
		add_action( 'init', array( __CLASS__, 'register_category_support' ), 15 );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_news', array(
			'labels'       => array(
				'name'               => __( 'News', 'pasfanc-college' ),
				'singular_name'      => __( 'News Item', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New News', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit News', 'pasfanc-college' ),
				'new_item'           => __( 'New News', 'pasfanc-college' ),
				'view_item'          => __( 'View News', 'pasfanc-college' ),
				'search_items'       => __( 'Search News', 'pasfanc-college' ),
				'not_found'          => __( 'No news found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No news in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'news' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon'    => 'dashicons-media-text',
			'show_in_rest' => true,
		) );
	}

	/**
	 * Register category taxonomy for News so items can be assigned to "news-highlights" category.
	 * Posts in "news-highlights" appear in the News & Events Highlights section on the homepage.
	 */
	public static function register_category_support() {
		register_taxonomy_for_object_type( 'category', 'pasf_news' );
	}
}
Pasfanc_CPT_News::init();

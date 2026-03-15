<?php
/**
 * Downloads CPT for Prospectus and other documents
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Downloads {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_download', array(
			'labels'       => array(
				'name'               => __( 'Downloads', 'pasfanc-college' ),
				'singular_name'      => __( 'Download', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Download', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Download', 'pasfanc-college' ),
				'new_item'           => __( 'New Download', 'pasfanc-college' ),
				'view_item'          => __( 'View Download', 'pasfanc-college' ),
				'search_items'       => __( 'Search Downloads', 'pasfanc-college' ),
				'not_found'          => __( 'No downloads found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No downloads in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'downloads' ),
			'supports'     => array( 'title' ),
			'menu_icon'    => 'dashicons-download',
			'show_in_rest' => true,
		) );
	}
}
Pasfanc_CPT_Downloads::init();

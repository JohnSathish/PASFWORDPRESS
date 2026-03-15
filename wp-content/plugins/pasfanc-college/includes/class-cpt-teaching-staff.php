<?php
/**
 * Teaching Staff CPT and Department Taxonomy
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Teaching_Staff {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_staff', array(
			'labels'       => array(
				'name'               => __( 'Teaching Staff', 'pasfanc-college' ),
				'singular_name'      => __( 'Staff Member', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Staff', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Staff', 'pasfanc-college' ),
				'new_item'           => __( 'New Staff', 'pasfanc-college' ),
				'view_item'          => __( 'View Staff', 'pasfanc-college' ),
				'search_items'       => __( 'Search Staff', 'pasfanc-college' ),
				'not_found'          => __( 'No staff found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No staff in trash', 'pasfanc-college' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'supports'     => array( 'title', 'thumbnail' ),
			'menu_icon'    => 'dashicons-groups',
			'show_in_rest' => true,
		) );
	}

	public static function register_taxonomy() {
		register_taxonomy( 'pasf_staff_department', 'pasf_staff', array(
			'labels'       => array(
				'name'          => __( 'Departments', 'pasfanc-college' ),
				'singular_name' => __( 'Department', 'pasfanc-college' ),
				'search_items'  => __( 'Search Departments', 'pasfanc-college' ),
				'all_items'     => __( 'All Departments', 'pasfanc-college' ),
			),
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'staff-department' ),
			'show_in_rest' => true,
		) );
	}
}
Pasfanc_CPT_Teaching_Staff::init();

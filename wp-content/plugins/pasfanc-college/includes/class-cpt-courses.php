<?php
/**
 * Courses CPT and Taxonomy
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Courses {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_course', array(
			'labels'       => array(
				'name'               => __( 'Courses', 'pasfanc-college' ),
				'singular_name'      => __( 'Course', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Course', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Course', 'pasfanc-college' ),
				'new_item'           => __( 'New Course', 'pasfanc-college' ),
				'view_item'          => __( 'View Course', 'pasfanc-college' ),
				'search_items'       => __( 'Search Courses', 'pasfanc-college' ),
				'not_found'          => __( 'No courses found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No courses in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'academics/courses' ),
			'supports'     => array( 'title', 'editor' ),
			'menu_icon'    => 'dashicons-welcome-learn-more',
			'show_in_rest' => true,
		) );
	}

	public static function register_taxonomy() {
		register_taxonomy( 'pasf_course_category', 'pasf_course', array(
			'labels'       => array(
				'name'          => __( 'Course Categories', 'pasfanc-college' ),
				'singular_name' => __( 'Course Category', 'pasfanc-college' ),
				'search_items'  => __( 'Search Categories', 'pasfanc-college' ),
				'all_items'     => __( 'All Categories', 'pasfanc-college' ),
			),
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'course-category' ),
			'show_in_rest' => true,
		) );
	}
}
Pasfanc_CPT_Courses::init();

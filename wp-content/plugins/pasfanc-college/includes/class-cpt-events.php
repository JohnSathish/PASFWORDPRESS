<?php
/**
 * Events CPT
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Events {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_event', array(
			'labels'       => array(
				'name'               => __( 'Events', 'pasfanc-college' ),
				'singular_name'      => __( 'Event', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Event', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Event', 'pasfanc-college' ),
				'new_item'           => __( 'New Event', 'pasfanc-college' ),
				'view_item'          => __( 'View Event', 'pasfanc-college' ),
				'search_items'       => __( 'Search Events', 'pasfanc-college' ),
				'not_found'          => __( 'No events found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No events in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'events' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon'    => 'dashicons-calendar-alt',
			'show_in_rest' => true,
		) );
	}
}
Pasfanc_CPT_Events::init();

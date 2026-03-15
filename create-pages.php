<?php
/**
 * One-time script to create default pages.
 * Visit: http://localhost/pasfanc.ac.in/create-pages.php
 * DELETE THIS FILE after use for security.
 */

// Load WordPress
require_once __DIR__ . '/wp-load.php';

// Require admin
if ( ! current_user_can( 'manage_options' ) ) {
	wp_redirect( wp_login_url( add_query_arg( 'create_pages', '1', home_url( '/create-pages.php' ) ) ) );
	exit;
}

$pages = array(
	array( 'title' => 'Home', 'slug' => 'home' ),
	array( 'title' => 'About Us', 'slug' => 'about' ),
	array( 'title' => 'Administration', 'slug' => 'administration' ),
	array( 'title' => 'Academics', 'slug' => 'academics' ),
	array( 'title' => 'Student Services', 'slug' => 'student-services' ),
	array( 'title' => 'Gallery', 'slug' => 'gallery' ),
	array( 'title' => 'Downloads', 'slug' => 'downloads' ),
	array( 'title' => 'Contact Us', 'slug' => 'contact' ),
);

$created = 0;
foreach ( $pages as $p ) {
	if ( get_page_by_path( $p['slug'], OBJECT, 'page' ) ) {
		continue;
	}
	$id = wp_insert_post( array(
		'post_title'  => $p['title'],
		'post_name'   => $p['slug'],
		'post_status' => 'publish',
		'post_type'   => 'page',
		'post_author' => 1,
	) );
	if ( $id && ! is_wp_error( $id ) ) {
		$created++;
	}
}

// Redirect to Pages list with success message
wp_redirect( add_query_arg( 'pasfanc_created', $created, admin_url( 'edit.php?post_type=page' ) ) );
exit;

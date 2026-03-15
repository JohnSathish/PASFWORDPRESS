<?php
/**
 * Create default pages for PASF College site
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_Page_Setup {

	/**
	 * Default pages to create
	 *
	 * @return array
	 */
	public static function get_default_pages() {
		return array(
			array(
				'title'   => 'Home',
				'slug'    => 'home',
				'content' => '',
			),
			array(
				'title'   => 'About Us',
				'slug'    => 'about',
				'content' => '',
			),
			array(
				'title'   => 'Administration',
				'slug'    => 'administration',
				'content' => '',
			),
			array(
				'title'   => 'Academics',
				'slug'    => 'academics',
				'content' => '',
			),
			array(
				'title'   => 'Student Services',
				'slug'    => 'student-services',
				'content' => '',
			),
			array(
				'title'   => 'Gallery',
				'slug'    => 'gallery',
				'content' => '',
			),
			array(
				'title'   => 'Downloads',
				'slug'    => 'downloads',
				'content' => '',
			),
			array(
				'title'   => 'Contact Us',
				'slug'    => 'contact',
				'content' => '',
			),
		);
	}

	/**
	 * Create default pages if they don't exist
	 *
	 * @return int Number of pages created
	 */
	public static function create_default_pages() {
		$created = 0;

		foreach ( self::get_default_pages() as $page_data ) {
			$existing = get_page_by_path( $page_data['slug'], OBJECT, 'page' );
			if ( $existing ) {
				continue;
			}

			$page_id = wp_insert_post( array(
				'post_title'   => $page_data['title'],
				'post_name'    => $page_data['slug'],
				'post_content' => $page_data['content'],
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => 1,
				'menu_order'   => 0,
			) );

			if ( $page_id && ! is_wp_error( $page_id ) ) {
				$created++;
			}
		}

		return $created;
	}

	/**
	 * Create Primary Menu and assign it to the primary theme location.
	 * Adds all default pages in order: Home, About Us, Administration, Academics, Student Services, Gallery, Downloads, Contact Us.
	 *
	 * @return bool|WP_Error True on success, WP_Error on failure.
	 */
	public static function setup_primary_menu() {
		$menu_name = __( 'Primary Menu', 'pasfanc-college' );
		$menu = wp_get_nav_menu_object( $menu_name );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $menu_name );
			if ( is_wp_error( $menu_id ) ) {
				return $menu_id;
			}
		} else {
			$menu_id = (int) $menu->term_id;
			// Clear existing items to avoid duplicates when re-running setup
			$items = wp_get_nav_menu_items( $menu_id );
			if ( is_array( $items ) ) {
				foreach ( $items as $item ) {
					wp_delete_post( $item->ID, true );
				}
			}
		}

		$slugs = array( 'home', 'about', 'administration', 'academics', 'student-services', 'gallery', 'downloads', 'contact' );
		$position = 1;

		foreach ( $slugs as $slug ) {
			$page = get_page_by_path( $slug, OBJECT, 'page' );
			if ( ! $page ) {
				continue;
			}

			$menu_item_data = array(
				'menu-item-type'        => 'post_type',
				'menu-item-object'      => 'page',
				'menu-item-object-id'   => $page->ID,
				'menu-item-status'      => 'publish',
				'menu-item-position'    => $position,
			);

			wp_update_nav_menu_item( $menu_id, 0, $menu_item_data );
			$position++;
		}

		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );

		return true;
	}
}

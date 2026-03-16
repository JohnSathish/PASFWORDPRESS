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

		// Create Fee Structure page (child of Student Services or top-level) with template
		$fee_created = self::create_fee_structure_page();
		if ( $fee_created ) {
			$created++;
		}

		// Ensure Gallery page uses page-gallery.php template (matches live pasfanc.ac.in/gallery)
		self::ensure_gallery_page_template();

		// Ensure Downloads page uses page-downloads.php template
		self::ensure_downloads_page_template();

		// Create President Message page (child of Administration) with template
		$pres_created = self::create_president_message_page();
		if ( $pres_created ) {
			$created++;
		}

		// Create Question Papers page (child of Student Services) with template
		$qp_created = self::create_question_papers_page();
		if ( $qp_created ) {
			$created++;
		}

		return $created;
	}

	/**
	 * Create Fee Structure page if it doesn't exist. Uses page-fee-structure.php template.
	 * Content synced from https://pasfanc.ac.in/student-services/fee-structure
	 *
	 * @return int|false Page ID if created, false otherwise
	 */
	public static function create_fee_structure_page() {
		$existing = get_page_by_path( 'fee-structure', OBJECT, 'page' );
		if ( ! $existing ) {
			$existing = get_page_by_path( 'student-services/fee-structure', OBJECT, 'page' );
		}
		if ( $existing ) {
			// Ensure template is assigned
			update_post_meta( $existing->ID, '_wp_page_template', 'page-fee-structure.php' );
			return false;
		}

		$page_id = wp_insert_post( array(
			'post_title'   => __( 'Fee Structure', 'pasfanc-college' ),
			'post_name'    => 'fee-structure',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => 1,
			'post_parent'  => 0,
			'menu_order'   => 0,
		) );

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-fee-structure.php' );
			return $page_id;
		}

		return false;
	}

	/**
	 * Create President Message page if it doesn't exist. Uses page-president-message.php template.
	 * Child of Administration.
	 *
	 * @return int|false Page ID if created, false otherwise
	 */
	public static function create_president_message_page() {
		$existing = get_page_by_path( 'president-message', OBJECT, 'page' );
		if ( ! $existing ) {
			$existing = get_page_by_path( 'administration/president-message', OBJECT, 'page' );
		}
		if ( $existing ) {
			update_post_meta( $existing->ID, '_wp_page_template', 'page-president-message.php' );
			return false;
		}

		$parent = get_page_by_path( 'administration', OBJECT, 'page' );
		$parent_id = ( $parent && ! is_wp_error( $parent ) ) ? (int) $parent->ID : 0;

		$president_message = "Dear students,\n\nIt is heartening to see PASF Abong Noga College embark on yet another journey of second academic year of its BA Degree Course. The previous years have seen many milestones of which we can be proud of. The Affiliation from NEHU and the successful establishment of an Exam Centre are a few of them besides the routine classes and activities which are carried out for the academic enrichment and to develop the character and intellect of the students. One of the most significant is the process of leading to the adoption of the PASF Abong Noga College as People's College by the Government of Meghalaya which will provide financial help and a promise to enhance the educational standards of Meghalaya as a whole.\n\nThe adoption of NEP 2009 by NEHU which is the affiliating body of the college, has mandated enormous challenges for Higher Education but it is a hope and promise that with such aspirations and vision the college is ever enthusiastic to strive and endeavour to fulfil the goals by NEP 2009.\n\nPASF Abong Noga College will continue its discourse with grit and determination in preparing its students and empowering its faculty that will enable them to prosper. We believe that in the coming days it will continue to educate students not merely to acquire degrees but to produce members of society who can contribute and be part of civil, political, economic and artistic revolution for positive change.\n\nIt is my strongest wish that the ones who carry the mantle of this great mission of guiding and facilitating the students will fulfil the aspirations of the College earnestly and honestly.";

		$page_id = wp_insert_post( array(
			'post_title'   => __( 'Message from the President', 'pasfanc-college' ),
			'post_name'    => 'president-message',
			'post_content' => wp_kses_post( wpautop( $president_message ) ),
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => 1,
			'post_parent'  => $parent_id,
			'menu_order'   => 0,
		) );

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-president-message.php' );
			return $page_id;
		}

		return false;
	}

	/**
	 * Create Question Papers page if it doesn't exist. Uses page-question-papers.php template.
	 * Child of Student Services.
	 *
	 * @return int|false Page ID if created, false otherwise
	 */
	public static function create_question_papers_page() {
		$existing = get_page_by_path( 'question-papers', OBJECT, 'page' );
		if ( ! $existing ) {
			$existing = get_page_by_path( 'student-services/question-papers', OBJECT, 'page' );
		}
		if ( $existing ) {
			update_post_meta( $existing->ID, '_wp_page_template', 'page-question-papers.php' );
			return false;
		}

		$parent = get_page_by_path( 'student-services', OBJECT, 'page' );
		$parent_id = ( $parent && ! is_wp_error( $parent ) ) ? (int) $parent->ID : 0;

		$page_id = wp_insert_post( array(
			'post_title'   => __( 'Question Papers', 'pasfanc-college' ),
			'post_name'    => 'question-papers',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => 1,
			'post_parent'  => $parent_id,
			'menu_order'   => 0,
		) );

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-question-papers.php' );
			return $page_id;
		}

		return false;
	}

	/**
	 * Ensure Downloads page uses page-downloads.php template.
	 */
	public static function ensure_downloads_page_template() {
		$page = get_page_by_path( 'downloads', OBJECT, 'page' );
		if ( $page && ! is_wp_error( $page ) ) {
			update_post_meta( $page->ID, '_wp_page_template', 'page-downloads.php' );
		}
	}

	/**
	 * Ensure Gallery page uses page-gallery.php template (matches https://pasfanc.ac.in/gallery).
	 */
	public static function ensure_gallery_page_template() {
		$page = get_page_by_path( 'gallery', OBJECT, 'page' );
		if ( $page && ! is_wp_error( $page ) ) {
			update_post_meta( $page->ID, '_wp_page_template', 'page-gallery.php' );
		}
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

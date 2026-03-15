<?php
/**
 * Plugin Name: PASF College
 * Plugin URI: https://pasfanc.ac.in/
 * Description: Custom post types, taxonomies, and functionality for PASF-Abong Noga College website.
 * Version: 1.0.0
 * Author: PASF College
 * Author URI: https://pasfanc.ac.in/
 * Text Domain: pasfanc-college
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PASFANC_COLLEGE_VERSION', '1.0.0' );
define( 'PASFANC_COLLEGE_DIR', plugin_dir_path( __FILE__ ) );
define( 'PASFANC_COLLEGE_URI', plugin_dir_url( __FILE__ ) );

require_once PASFANC_COLLEGE_DIR . 'includes/class-page-setup.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-news.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-events.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-gallery.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-testimonials.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-courses.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-flash-news.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-downloads.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-cpt-teaching-staff.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-meta-boxes.php';
require_once PASFANC_COLLEGE_DIR . 'includes/class-security.php';
require_once PASFANC_COLLEGE_DIR . 'public/shortcodes.php';

/**
 * Insert default taxonomy terms
 */
function pasfanc_college_insert_default_terms() {
	$gallery_cats = array( 'Alumni & Community', 'Campus Life', 'Cultural Programs', 'Events', 'Sports & Activities' );
	foreach ( $gallery_cats as $name ) {
		if ( ! term_exists( $name, 'pasf_gallery_category' ) ) {
			wp_insert_term( $name, 'pasf_gallery_category', array( 'slug' => sanitize_title( $name ) ) );
		}
	}
	$course_cats = array( 'Class XI & XII Arts', 'Class XI & XII Commerce', 'B.A. Degree Course' );
	foreach ( $course_cats as $name ) {
		if ( ! term_exists( $name, 'pasf_course_category' ) ) {
			wp_insert_term( $name, 'pasf_course_category', array( 'slug' => sanitize_title( $name ) ) );
		}
	}
	// Category for News items that appear in News & Events Highlights section.
	if ( ! term_exists( 'news-highlights', 'category' ) ) {
		wp_insert_term( 'News Highlights', 'category', array( 'slug' => 'news-highlights', 'description' => __( 'News in this category appear in the News & Events Highlights section on the homepage.', 'pasfanc-college' ) ) );
	}
}

/**
 * Insert Teaching Staff department taxonomy terms
 */
function pasfanc_college_insert_staff_departments() {
	$depts = array( 'Principal', 'English', 'Garo', 'Economics', 'Political Science', 'History', 'Philosophy', 'Environmental Studies', 'Education' );
	foreach ( $depts as $name ) {
		if ( ! term_exists( $name, 'pasf_staff_department' ) ) {
			wp_insert_term( $name, 'pasf_staff_department', array( 'slug' => sanitize_title( $name ) ) );
		}
	}
}

/**
 * Create Teaching Staff page as child of Academics
 */
function pasfanc_college_create_teaching_staff_page() {
	$existing = get_page_by_path( 'teaching-staff', OBJECT, 'page' );
	if ( $existing ) {
		return $existing->ID;
	}
	$academics = get_page_by_path( 'academics', OBJECT, 'page' );
	$parent_id = $academics ? (int) $academics->ID : 0;
	$page_id = wp_insert_post( array(
		'post_title'   => __( 'Teaching Staff', 'pasfanc-college' ),
		'post_name'    => 'teaching-staff',
		'post_content' => '',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_author'  => 1,
		'post_parent'  => $parent_id,
		'menu_order'   => 0,
	) );
	return $page_id && ! is_wp_error( $page_id ) ? $page_id : 0;
}

/**
 * Seed Flash News with sample items
 *
 * @param bool $force If true, add samples even when items exist.
 */
function pasfanc_college_seed_flash_news( $force = false ) {
	if ( ! post_type_exists( 'pasf_flash' ) ) {
		return;
	}
	$count = wp_count_posts( 'pasf_flash' );
	if ( ! $force && $count->publish > 0 ) {
		return;
	}
	$items = array(
		array( 'title' => __( 'Welcome to PASF College', 'pasfanc-college' ), 'excerpt' => __( 'We welcome all students and visitors to our campus.', 'pasfanc-college' ), 'order' => 0 ),
		array( 'title' => __( 'Prospectus 2026 Now Available', 'pasfanc-college' ), 'excerpt' => __( 'Download our latest prospectus from the Downloads page.', 'pasfanc-college' ), 'order' => 1 ),
		array( 'title' => __( 'Admissions Open for New Session', 'pasfanc-college' ), 'excerpt' => __( 'Contact the admission office for details.', 'pasfanc-college' ), 'order' => 2 ),
	);
	foreach ( $items as $item ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $item['title'],
			'post_name'    => sanitize_title( $item['title'] ),
			'post_content' => ! empty( $item['excerpt'] ) ? '<p>' . $item['excerpt'] . '</p>' : '',
			'post_excerpt' => $item['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'pasf_flash',
			'post_author'  => 1,
			'menu_order'   => $item['order'],
		) );
		// Post created; menu_order is already set in wp_insert_post
	}
}

/**
 * Seed Teaching Staff data from pasfanc.ac.in (runs only when no staff exist)
 */
function pasfanc_college_seed_teaching_staff() {
	if ( ! post_type_exists( 'pasf_staff' ) || ! taxonomy_exists( 'pasf_staff_department' ) ) {
		return;
	}
	$count = wp_count_posts( 'pasf_staff' );
	if ( $count->publish > 0 ) {
		return;
	}
	$staff_data = array(
		array( 'name' => 'Smt. Tiana Tarin D. Arengh', 'initials' => 'TT', 'designation' => 'Principal', 'qualifications' => 'MA (English), MA (Hist & Arch), M.Phil, Ph.D. (pursuing from NEHU)', 'dept' => 'Principal', 'order' => 0 ),
		array( 'name' => 'Smt. Nuri R. Marak', 'initials' => 'NR', 'designation' => 'Lecturer | English', 'qualifications' => 'MA (English), B.Ed, MA (Hist & Arch)', 'dept' => 'English', 'order' => 1 ),
		array( 'name' => 'Smt. Deepika R. Marak', 'initials' => 'DR', 'designation' => 'Lecturer | English', 'qualifications' => 'MA (English)', 'dept' => 'English', 'order' => 2 ),
		array( 'name' => 'Smt. Yanpolumi M Sangma', 'initials' => 'YM', 'designation' => 'Lecturer | English', 'qualifications' => 'MA (Eng), M.Phil, NET, Ph.D. (pursuing from Anamalai University)', 'dept' => 'English', 'order' => 3 ),
		array( 'name' => 'Smt. Marjorie Ch. Marak', 'initials' => 'MC', 'designation' => 'Lecturer | English', 'qualifications' => 'MA (English), B.Ed', 'dept' => 'English', 'order' => 4 ),
		array( 'name' => 'Smt. Nochon Dokatichi K. Marak', 'initials' => 'ND', 'designation' => 'Lecturer | Garo', 'qualifications' => 'MA (Garo)', 'dept' => 'Garo', 'order' => 10 ),
		array( 'name' => 'Smt. Manshana R. Marak', 'initials' => 'MR', 'designation' => 'Lecturer | Garo', 'qualifications' => 'MA (Garo), B.Ed', 'dept' => 'Garo', 'order' => 11 ),
		array( 'name' => 'Smt. Sengsime A. Sangma', 'initials' => 'SA', 'designation' => 'Lecturer | Garo', 'qualifications' => 'MA (Garo), NET (JRF), Ph.D. (pursuing from NEHU)', 'dept' => 'Garo', 'order' => 12 ),
		array( 'name' => 'Smt. Christina D Sangma', 'initials' => 'CD', 'designation' => 'Lecturer | Garo', 'qualifications' => 'MA (Garo), B.Ed, M.Phil, Ph.D. (pursuing from NEHU)', 'dept' => 'Garo', 'order' => 13 ),
		array( 'name' => 'Shri Sengra Ch. Momin', 'initials' => 'SC', 'designation' => 'Lecturer | Economics', 'qualifications' => 'MA (Economics), B.Ed', 'dept' => 'Economics', 'order' => 20 ),
		array( 'name' => 'Shri Anonbel G. Momin', 'initials' => 'AG', 'designation' => 'Lecturer | Economics', 'qualifications' => 'MA (Economics), B.Ed', 'dept' => 'Economics', 'order' => 21 ),
		array( 'name' => 'Smt. Koyel Roy', 'initials' => 'KR', 'designation' => 'Lecturer | Economics', 'qualifications' => 'MA (Eco), NET, B.Ed, Ph.D. (pursuing from NEHU)', 'dept' => 'Economics', 'order' => 22 ),
		array( 'name' => 'Smt. Koborie D. Sangma', 'initials' => 'KD', 'designation' => 'Lecturer | Political Science', 'qualifications' => 'MA (Political Science), B.Ed', 'dept' => 'Political Science', 'order' => 30 ),
		array( 'name' => 'Dr. Saint Seterfill A. Sangma', 'initials' => 'SS', 'designation' => 'Lecturer | Political Science', 'qualifications' => 'MA (Pol Sc), MA (Hist), Ph.D', 'dept' => 'Political Science', 'order' => 31 ),
		array( 'name' => 'Smt. Timsera R. Marak', 'initials' => 'TR', 'designation' => 'Lecturer | Political Science', 'qualifications' => 'MA (Pol.Sc)', 'dept' => 'Political Science', 'order' => 32 ),
		array( 'name' => 'Shri Prosanto Hajong', 'initials' => 'PH', 'designation' => 'Lecturer | History', 'qualifications' => 'MA (Hist & Arch), B.Ed', 'dept' => 'History', 'order' => 40 ),
		array( 'name' => 'Shri Sheangampou Thaimei', 'initials' => 'ST', 'designation' => 'Lecturer | History', 'qualifications' => 'MA (History), Ph.D (pursuing from NEHU)', 'dept' => 'History', 'order' => 41 ),
		array( 'name' => 'Shri Ayan Dingdo M Marak', 'initials' => 'AD', 'designation' => 'Lecturer | History', 'qualifications' => 'MA (Hist & Arch), Ph.D (pursuing from MGU)', 'dept' => 'History', 'order' => 42 ),
		array( 'name' => 'Shri Walseng B. Marak', 'initials' => 'WB', 'designation' => 'Lecturer | Philosophy', 'qualifications' => 'MA (Philosophy), B.Ed', 'dept' => 'Philosophy', 'order' => 50 ),
		array( 'name' => 'Shri Joshua R. Marak', 'initials' => 'JR', 'designation' => 'Lecturer | Philosophy', 'qualifications' => 'MA (Philosophy)', 'dept' => 'Philosophy', 'order' => 51 ),
		array( 'name' => 'Smt. Amika N Arengh', 'initials' => 'AN', 'designation' => 'Lecturer | Philosophy', 'qualifications' => 'MA (Philosophy)', 'dept' => 'Philosophy', 'order' => 52 ),
		array( 'name' => 'Shri Dilsang M. Sangma', 'initials' => 'DM', 'designation' => 'Lecturer | Environmental Studies', 'qualifications' => 'MA (Environment & Social Development), B.Ed', 'dept' => 'Environmental Studies', 'order' => 60 ),
		array( 'name' => 'Smt. Sarah G. Momin', 'initials' => 'SG', 'designation' => 'Lecturer | Environmental Studies', 'qualifications' => 'M.Sc (Environmental Science), Ph.D (pursuing from USTM)', 'dept' => 'Environmental Studies', 'order' => 61 ),
		array( 'name' => 'Smt. Flabina P. Marak', 'initials' => 'FP', 'designation' => 'Lecturer | Education', 'qualifications' => 'MA (Education)', 'dept' => 'Education', 'order' => 70 ),
	);
	foreach ( $staff_data as $s ) {
		$term = get_term_by( 'name', $s['dept'], 'pasf_staff_department' );
		$term_ids = $term ? array( (int) $term->term_id ) : array();
		$post_id = wp_insert_post( array(
			'post_title'   => $s['name'],
			'post_name'    => sanitize_title( $s['name'] ),
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'pasf_staff',
			'post_author'  => 1,
			'menu_order'   => $s['order'],
		) );
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_pasf_staff_initials', $s['initials'] );
			update_post_meta( $post_id, '_pasf_staff_designation', $s['designation'] );
			update_post_meta( $post_id, '_pasf_staff_qualifications', $s['qualifications'] );
			update_post_meta( $post_id, '_pasf_staff_order', $s['order'] );
			if ( ! empty( $term_ids ) ) {
				wp_set_object_terms( $post_id, $term_ids, 'pasf_staff_department' );
			}
		}
	}
}

/**
 * Activation: flush rewrite rules and insert default terms
 */
function pasfanc_college_activate() {
	Pasfanc_CPT_News::register_post_type();
	Pasfanc_CPT_Events::register_post_type();
	Pasfanc_CPT_Gallery::register_post_type();
	Pasfanc_CPT_Testimonials::register_post_type();
	Pasfanc_CPT_Courses::register_post_type();
	Pasfanc_CPT_Flash_News::register_post_type();
	Pasfanc_CPT_Downloads::register_post_type();
	Pasfanc_CPT_Teaching_Staff::register_post_type();
	Pasfanc_CPT_Teaching_Staff::register_taxonomy();
	Pasfanc_CPT_Gallery::register_taxonomy();
	Pasfanc_CPT_Courses::register_taxonomy();
	pasfanc_college_insert_default_terms();
	pasfanc_college_insert_staff_departments();
	Pasfanc_Page_Setup::create_default_pages();
	pasfanc_college_create_teaching_staff_page();
	pasfanc_college_seed_flash_news();
	pasfanc_college_seed_teaching_staff();
	Pasfanc_Page_Setup::setup_primary_menu();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'pasfanc_college_activate' );

/**
 * Admin: Add "Create Pages" to run page setup manually
 */
function pasfanc_college_admin_menu() {
	add_options_page(
		__( 'PASF College', 'pasfanc-college' ),
		__( 'PASF College', 'pasfanc-college' ),
		'manage_options',
		'pasfanc-college',
		'pasfanc_college_settings_page'
	);
}
add_action( 'admin_menu', 'pasfanc_college_admin_menu' );

function pasfanc_college_settings_page() {
	if ( isset( $_POST['pasfanc_create_pages'] ) && current_user_can( 'manage_options' ) ) {
		check_admin_referer( 'pasfanc_create_pages' );
		$created = Pasfanc_Page_Setup::create_default_pages();
		$menu_ok = Pasfanc_Page_Setup::setup_primary_menu();
		echo '<div class="notice notice-success"><p>' . sprintf(
			/* translators: %d: number of pages created */
			esc_html__( '%d page(s) created.', 'pasfanc-college' ),
			$created
		) . '</p></div>';
		if ( $menu_ok === true ) {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Primary Menu created and assigned.', 'pasfanc-college' ) . '</p></div>';
		}
	}
	if ( isset( $_POST['pasfanc_setup_menu'] ) && current_user_can( 'manage_options' ) ) {
		check_admin_referer( 'pasfanc_setup_menu' );
		$menu_ok = Pasfanc_Page_Setup::setup_primary_menu();
		if ( $menu_ok === true ) {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Primary Menu created/updated and assigned to navigation.', 'pasfanc-college' ) . '</p></div>';
		} else {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Menu setup failed.', 'pasfanc-college' ) . '</p></div>';
		}
	}
	if ( isset( $_POST['pasfanc_seed_staff'] ) && current_user_can( 'manage_options' ) ) {
		check_admin_referer( 'pasfanc_seed_staff' );
		pasfanc_college_insert_staff_departments();
		pasfanc_college_seed_teaching_staff();
		$count = wp_count_posts( 'pasf_staff' );
		echo '<div class="notice notice-success"><p>' . sprintf(
			/* translators: %d: number of staff */
			esc_html__( 'Teaching Staff: %d members seeded (or already present).', 'pasfanc-college' ),
			(int) $count->publish
		) . '</p></div>';
	}
	if ( isset( $_POST['pasfanc_seed_flash'] ) && current_user_can( 'manage_options' ) ) {
		check_admin_referer( 'pasfanc_seed_flash' );
		$force = isset( $_POST['pasfanc_seed_flash_force'] );
		pasfanc_college_seed_flash_news( $force );
		$count = wp_count_posts( 'pasf_flash' );
		echo '<div class="notice notice-success"><p>' . sprintf(
			/* translators: %d: number of items */
			esc_html__( 'Flash News: %d items now in database.', 'pasfanc-college' ),
			(int) $count->publish
		) . '</p></div>';
		if ( (int) $count->publish > 0 ) {
			echo '<div class="notice notice-info"><p>' . esc_html__( 'Tip: Flash News appears on the homepage only. Ensure items are Published and that Settings → Reading uses a static front page.', 'pasfanc-college' ) . '</p></div>';
		}
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'PASF College', 'pasfanc-college' ); ?></h1>
		<form method="post" style="margin-bottom: 1.5em;">
			<?php wp_nonce_field( 'pasfanc_create_pages' ); ?>
			<p><?php esc_html_e( 'Create default pages: Home, About Us, Administration, Academics, Student Services, Gallery, Downloads, Contact Us.', 'pasfanc-college' ); ?></p>
			<p><?php submit_button( __( 'Create Pages', 'pasfanc-college' ), 'primary', 'pasfanc_create_pages', false ); ?></p>
		</form>
		<form method="post" style="margin-bottom: 1.5em;">
			<?php wp_nonce_field( 'pasfanc_setup_menu' ); ?>
			<p><?php esc_html_e( 'Create or update Primary Menu and assign it to the site navigation (requires pages to exist).', 'pasfanc-college' ); ?></p>
			<p><?php submit_button( __( 'Setup Menu', 'pasfanc-college' ), 'secondary', 'pasfanc_setup_menu', false ); ?></p>
		</form>
		<form method="post" style="margin-bottom: 1.5em;">
			<?php wp_nonce_field( 'pasfanc_seed_flash' ); ?>
			<p><?php esc_html_e( 'Seed Flash News with sample items. Add 3 sample items when none exist, or check "Force" to add even if items already exist.', 'pasfanc-college' ); ?></p>
			<p>
				<label><input type="checkbox" name="pasfanc_seed_flash_force" value="1"> <?php esc_html_e( 'Force (add samples even if items exist)', 'pasfanc-college' ); ?></label>
			</p>
			<p><?php submit_button( __( 'Seed Flash News', 'pasfanc-college' ), 'secondary', 'pasfanc_seed_flash', false ); ?></p>
		</form>
		<form method="post">
			<?php wp_nonce_field( 'pasfanc_seed_staff' ); ?>
			<p><?php esc_html_e( 'Seed Teaching Staff with default data from pasfanc.ac.in (only runs when no staff exist).', 'pasfanc-college' ); ?></p>
			<p><?php submit_button( __( 'Seed Teaching Staff', 'pasfanc-college' ), 'secondary', 'pasfanc_seed_staff', false ); ?></p>
		</form>
	</div>
	<?php
}

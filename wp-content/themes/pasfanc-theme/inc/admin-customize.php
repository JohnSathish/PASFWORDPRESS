<?php
/**
 * Admin Dashboard & Login Page Customization
 * Brands WordPress admin and login with PASF College colours.
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue admin dashboard & sidebar styles
 */
function pasfanc_admin_styles() {
	$version = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : PASFANC_THEME_VERSION;
	wp_enqueue_style(
		'pasfanc-admin',
		PASFANC_THEME_URI . '/assets/css/admin.css',
		array( 'wp-admin' ),
		$version
	);
}
add_action( 'admin_enqueue_scripts', 'pasfanc_admin_styles' );

/**
 * Customize login page: enqueue styles
 */
function pasfanc_login_styles() {
	$version = defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : PASFANC_THEME_VERSION;
	wp_enqueue_style(
		'pasfanc-login',
		PASFANC_THEME_URI . '/assets/css/login.css',
		array( 'login' ),
		$version
	);
}
add_action( 'login_enqueue_scripts', 'pasfanc_login_styles' );

/**
 * Change login logo link to site URL
 */
function pasfanc_login_logo_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'pasfanc_login_logo_url' );

/**
 * Change login logo title
 */
function pasfanc_login_logo_title() {
	return get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' );
}
add_filter( 'login_headertext', 'pasfanc_login_logo_title' );

/**
 * Add custom logo to login page (replaces WordPress logo)
 */
function pasfanc_login_logo_html() {
	$logo = get_theme_mod( 'custom_logo', 0 );
	$logo_url = $logo ? wp_get_attachment_image_url( $logo, 'medium' ) : '';
	if ( ! $logo_url ) {
		$logo_url = PASFANC_THEME_URI . '/assets/images/pasf-logo.png';
	}
	if ( ! $logo_url ) {
		return;
	}
	?>
	<style type="text/css">
		body.login h1 a {
			background-image: url('<?php echo esc_url( $logo_url ); ?>') !important;
			background-size: contain !important;
			width: 220px !important;
			height: 100px !important;
		}
	</style>
	<?php
}
add_action( 'login_head', 'pasfanc_login_logo_html', 20 );

/**
 * Remove unnecessary WordPress dashboard content
 */
function pasfanc_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );       /* WordPress Events and News */
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  /* Quick Draft */
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   /* Other WordPress News */
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'pasfanc_remove_dashboard_widgets', 999 );

/**
 * Hide Welcome to WordPress panel for all users
 */
function pasfanc_hide_welcome_panel() {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	$user_id = get_current_user_id();
	if ( $user_id ) {
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
	}
}
add_action( 'load-index.php', 'pasfanc_hide_welcome_panel' );

/**
 * Add custom PASF College dashboard widget
 */
function pasfanc_add_dashboard_widget() {
	wp_add_dashboard_widget(
		'pasfanc_quick_links',
		__( 'PASF-Abong Noga College – Quick Links', 'pasfanc-theme' ),
		'pasfanc_dashboard_widget_content',
		null,
		null,
		'normal',
		'high'
	);
}
add_action( 'wp_dashboard_setup', 'pasfanc_add_dashboard_widget', 10 );

/**
 * Custom dashboard widget content
 */
function pasfanc_dashboard_widget_content() {
	$links = array(
		array( 'url' => home_url(), 'label' => __( 'View Site', 'pasfanc-theme' ), 'icon' => 'dashicons-visibility' ),
		array( 'url' => admin_url( 'post-new.php?post_type=pasf_flash' ), 'label' => __( 'Add Flash News', 'pasfanc-theme' ), 'icon' => 'dashicons-megaphone' ),
		array( 'url' => admin_url( 'post-new.php?post_type=pasf_news' ), 'label' => __( 'Add News', 'pasfanc-theme' ), 'icon' => 'dashicons-media-text' ),
		array( 'url' => admin_url( 'post-new.php?post_type=pasf_event' ), 'label' => __( 'Add Event', 'pasfanc-theme' ), 'icon' => 'dashicons-calendar-alt' ),
		array( 'url' => admin_url( 'edit.php?post_type=page' ), 'label' => __( 'Edit Pages', 'pasfanc-theme' ), 'icon' => 'dashicons-admin-page' ),
		array( 'url' => admin_url( 'customize.php' ), 'label' => __( 'Customize Site', 'pasfanc-theme' ), 'icon' => 'dashicons-admin-appearance' ),
	);
	echo '<div class="pasfanc-dash-links">';
	foreach ( $links as $link ) {
		echo '<a href="' . esc_url( $link['url'] ) . '" class="pasfanc-dash-link"><span class="dashicons ' . esc_attr( $link['icon'] ) . '"></span> ' . esc_html( $link['label'] ) . '</a>';
	}
	echo '</div>';
}

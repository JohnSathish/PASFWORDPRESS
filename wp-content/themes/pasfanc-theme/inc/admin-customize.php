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
 * Add login page tagline and extra branding
 */
function pasfanc_login_tagline() {
	$motto = get_theme_mod( 'pasfanc_motto', 'To Educate, To Change, To Grow & To Live' );
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var h1 = document.querySelector('body.login h1');
		if (h1 && !document.querySelector('.pasf-login-tagline')) {
			var tagline = document.createElement('p');
			tagline.className = 'pasf-login-tagline';
			tagline.textContent = '<?php echo esc_js( $motto ); ?>';
			h1.parentNode.insertBefore(tagline, h1.nextSibling);
		}
	});
	</script>
	<?php
}
add_action( 'login_footer', 'pasfanc_login_tagline', 5 );

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
 *
 * Enqueue Google Font for login page
 */
function pasfanc_login_fonts() {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action( 'login_head', 'pasfanc_login_fonts', 5 );

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
 * Custom welcome banner at top of dashboard
 */
function pasfanc_welcome_banner() {
	$screen = get_current_screen();
	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}
	?>
	<div class="pasfanc-welcome-banner">
		<h1><?php esc_html_e( 'Welcome to PASF College Admin', 'pasfanc-theme' ); ?></h1>
	</div>
	<?php
}
add_action( 'admin_notices', 'pasfanc_welcome_banner', 1 );

/**
 * Add custom PASF College dashboard widget
 */
function pasfanc_add_dashboard_widget() {
	// College Stats widget (high priority, top)
	wp_add_dashboard_widget(
		'pasfanc_college_stats',
		__( 'PASF College – Content Overview', 'pasfanc-theme' ),
		'pasfanc_college_stats_content',
		null,
		null,
		'normal',
		'high'
	);
	// Quick Links widget
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
 * College stats widget content (Flash News, Events, News, Gallery counts)
 */
function pasfanc_college_stats_content() {
	$post_types = array(
		'pasf_flash'  => array( 'label' => __( 'Flash News', 'pasfanc-theme' ), 'icon' => 'dashicons-megaphone' ),
		'pasf_event'  => array( 'label' => __( 'Events', 'pasfanc-theme' ), 'icon' => 'dashicons-calendar-alt' ),
		'pasf_news'   => array( 'label' => __( 'News', 'pasfanc-theme' ), 'icon' => 'dashicons-media-text' ),
		'pasf_gallery'=> array( 'label' => __( 'Gallery', 'pasfanc-theme' ), 'icon' => 'dashicons-format-gallery' ),
	);
	echo '<div class="pasfanc-college-stats">';
	foreach ( $post_types as $post_type => $info ) {
		$count = post_type_exists( $post_type ) ? wp_count_posts( $post_type )->publish : 0;
		$url   = admin_url( 'edit.php?post_type=' . $post_type );
		printf(
			'<a href="%s" class="pasfanc-stat-item"><span class="dashicons %s"></span><span class="pasfanc-stat-count">%d</span><span class="pasfanc-stat-label">%s</span></a>',
			esc_url( $url ),
			esc_attr( $info['icon'] ),
			(int) $count,
			esc_html( $info['label'] )
		);
	}
	echo '</div>';
}

/**
 * Custom dashboard widget content with expanded Quick Links
 */
function pasfanc_dashboard_widget_content() {
	$links = array(
		array( 'url' => home_url(), 'label' => __( 'View Site', 'pasfanc-theme' ), 'icon' => 'dashicons-visibility' ),
		array( 'url' => admin_url( 'post-new.php?post_type=pasf_flash' ), 'label' => __( 'Add Flash News', 'pasfanc-theme' ), 'icon' => 'dashicons-megaphone' ),
		array( 'url' => admin_url( 'post-new.php?post_type=pasf_news' ), 'label' => __( 'Add News', 'pasfanc-theme' ), 'icon' => 'dashicons-media-text' ),
		array( 'url' => admin_url( 'post-new.php?post_type=pasf_event' ), 'label' => __( 'Add Event', 'pasfanc-theme' ), 'icon' => 'dashicons-calendar-alt' ),
		array( 'url' => admin_url( 'edit.php?post_type=pasf_hero_slide' ), 'label' => __( 'Hero Slider', 'pasfanc-theme' ), 'icon' => 'dashicons-slides' ),
		array( 'url' => admin_url( 'edit.php?post_type=pasf_staff' ), 'label' => __( 'Teaching Staff', 'pasfanc-theme' ), 'icon' => 'dashicons-groups' ),
		array( 'url' => admin_url( 'edit.php?post_type=pasf_course' ), 'label' => __( 'Courses', 'pasfanc-theme' ), 'icon' => 'dashicons-welcome-learn-more' ),
		array( 'url' => admin_url( 'edit.php?post_type=pasf_gallery' ), 'label' => __( 'Gallery', 'pasfanc-theme' ), 'icon' => 'dashicons-format-gallery' ),
		array( 'url' => admin_url( 'edit.php?post_type=pasf_download' ), 'label' => __( 'Downloads', 'pasfanc-theme' ), 'icon' => 'dashicons-download' ),
		array( 'url' => admin_url( 'edit.php?post_type=page' ), 'label' => __( 'Edit Pages', 'pasfanc-theme' ), 'icon' => 'dashicons-admin-page' ),
		array( 'url' => admin_url( 'customize.php' ), 'label' => __( 'Customize Site', 'pasfanc-theme' ), 'icon' => 'dashicons-admin-appearance' ),
	);
	echo '<div class="pasfanc-dash-links">';
	foreach ( $links as $link ) {
		echo '<a href="' . esc_url( $link['url'] ) . '" class="pasfanc-dash-link"><span class="dashicons ' . esc_attr( $link['icon'] ) . '"></span> ' . esc_html( $link['label'] ) . '</a>';
	}
	echo '</div>';
}

/**
 * Replace admin footer text
 */
function pasfanc_admin_footer_text( $text ) {
	return 'PASF-Abong Noga College';
}
add_filter( 'admin_footer_text', 'pasfanc_admin_footer_text' );

/**
 * Add admin favicon (site icon or theme logo)
 */
function pasfanc_admin_favicon() {
	$icon_url = get_site_icon_url( 32 );
	if ( ! $icon_url ) {
		$logo = get_theme_mod( 'custom_logo', 0 );
		$icon_url = $logo ? wp_get_attachment_image_url( $logo, array( 32, 32 ) ) : '';
	}
	if ( ! $icon_url ) {
		$icon_url = PASFANC_THEME_URI . '/assets/images/favicon.png';
	}
	if ( $icon_url ) {
		echo '<link rel="icon" href="' . esc_url( $icon_url ) . '" sizes="32x32" />' . "\n";
	}
}
add_action( 'admin_head', 'pasfanc_admin_favicon', 1 );

/**
 * Option to hide PHP update notice (via theme mod)
 */
function pasfanc_maybe_hide_php_notice() {
	if ( ! get_theme_mod( 'pasfanc_hide_php_notice', false ) ) {
		return;
	}
	?>
	<style id="pasfanc-hide-php-notice">
	/* Hide PHP update recommended notice when option enabled */
	#wp-php-notice,
	.notice[data-dismissible="php-version"] { display: none !important; }
	</style>
	<?php
}
add_action( 'admin_head', 'pasfanc_maybe_hide_php_notice', 999 );

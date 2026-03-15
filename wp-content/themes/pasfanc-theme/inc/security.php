<?php
/**
 * Theme-level security measures
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add security headers (via wp_headers or template)
 */
function pasfanc_security_headers() {
	if ( is_admin() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
}
add_action( 'send_headers', 'pasfanc_security_headers' );

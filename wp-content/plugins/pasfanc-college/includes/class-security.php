<?php
/**
 * Plugin security measures
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_Plugin_Security {

	public static function init() {
		add_filter( 'script_loader_src', array( __CLASS__, 'remove_version' ), 15, 1 );
		add_filter( 'style_loader_src', array( __CLASS__, 'remove_version' ), 15, 1 );
		add_action( 'init', array( __CLASS__, 'disable_xml_rpc' ), 1 );
	}

	/**
	 * Remove version query string from assets
	 */
	public static function remove_version( $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}

	/**
	 * Disable XML-RPC if not needed (reduces attack surface)
	 */
	public static function disable_xml_rpc() {
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}
}
Pasfanc_Plugin_Security::init();

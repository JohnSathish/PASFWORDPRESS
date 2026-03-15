<?php
/**
 * Admissions CTA section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta_heading  = get_theme_mod( 'pasfanc_cta_heading', 'Admissions Open ' . date( 'Y' ) );
$cta_text     = get_theme_mod( 'pasfanc_cta_text', 'Take the first step towards your future. Join PASF-Abong Noga College today.' );
$apply_url    = get_theme_mod( 'pasfanc_apply_url', home_url( '/admissions/' ) );
$contact_url  = get_theme_mod( 'pasfanc_cta_contact_url', '' );
$contact_url  = $contact_url ? $contact_url : home_url( '/contact/' );
?>
<section class="cta-section cta-section-admissions">
	<div class="cta-inner">
		<div class="cta-accent-line"></div>
		<h2 class="cta-title"><?php echo esc_html( $cta_heading ); ?></h2>
		<p class="cta-tagline"><?php echo esc_html( $cta_text ); ?></p>
		<div class="cta-buttons">
			<a href="<?php echo esc_url( $apply_url ); ?>" class="btn btn-apply"><?php esc_html_e( 'Apply Now', 'pasfanc-theme' ); ?></a>
			<a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-contact"><?php esc_html_e( 'Contact Admission Office', 'pasfanc-theme' ); ?></a>
		</div>
	</div>
</section>

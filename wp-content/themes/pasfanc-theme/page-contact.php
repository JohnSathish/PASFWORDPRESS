<?php
/**
 * Contact page template
 *
 * @package pasfanc-theme
 */

get_header();

$address_raw = get_theme_mod( 'pasfanc_footer_address', "PASF-ABONG NOGA COLLEGE\nUnder People's College Grant-in-Aid\n(Affiliated to the North-Eastern Hills University)\nTura, West Garo Hills, Meghalaya-794101" );
$address_lines = explode( "\n", $address_raw );
$college_name = ! empty( $address_lines[0] ) ? trim( $address_lines[0] ) : 'PASF-ABONG NOGA COLLEGE';
$address_rest = array_slice( $address_lines, 1 );
$address = $college_name . ( ! empty( $address_rest ) ? "\n" . implode( "\n", $address_rest ) : '' );
$phone    = get_theme_mod( 'pasfanc_top_phone', '+91 97741 09207' );
$email    = get_theme_mod( 'pasfanc_top_email', 'pasfabongnogacollege@gmail.com' );
$maps_url = get_theme_mod( 'pasfanc_maps_url', 'https://www.google.com/maps/place/PASF-+Abong+Noga+College,+Tura./@25.502221,90.180934,15z' );
?>

<main id="main" class="site-main contact-page-main">
	<section class="contact-hero">
		<div class="contact-hero-overlay"></div>
		<div class="container contact-hero-inner">
			<h1 class="contact-hero-title"><?php esc_html_e( 'Contact Us', 'pasfanc-theme' ); ?></h1>
			<p class="contact-hero-tagline"><?php esc_html_e( 'Get in touch with PASF-Abong Noga College. We are here to help.', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container contact-content-wrap">
		<div class="contact-page-grid">
			<div class="contact-info-card">
				<h2 class="contact-section-title"><?php esc_html_e( 'Get in Touch', 'pasfanc-theme' ); ?></h2>
				<div class="contact-info-block contact-info-address">
					<span class="contact-info-icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
					</span>
					<address class="contact-address">
						<strong class="contact-college-name"><?php echo esc_html( $college_name ); ?></strong>
						<?php if ( ! empty( $address_rest ) ) : ?>
							<br>
							<?php echo wp_kses_post( nl2br( esc_html( implode( "\n", $address_rest ) ) ) ); ?>
						<?php endif; ?>
					</address>
				</div>
				<div class="contact-info-block contact-info-phone">
					<span class="contact-info-icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
					</span>
					<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
				</div>
				<div class="contact-info-block contact-info-email">
					<span class="contact-info-icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
					</span>
					<p><a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>"><?php echo esc_html( $email ); ?></a></p>
				</div>
				<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn contact-maps-btn"><?php esc_html_e( 'Open in Google Maps', 'pasfanc-theme' ); ?> &rarr;</a>
			</div>
			<div class="contact-form-card">
				<?php echo do_shortcode( '[pasf_contact_form]' ); ?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();

<?php
/**
 * Contact page template
 *
 * @package pasfanc-theme
 */

get_header();

$address = get_theme_mod( 'pasfanc_footer_address', "PASF-ABONG NOGA COLLEGE\nUnder People's College Grant-in-Aid\n(Affiliated to the North-Eastern Hills University)\nTura, West Garo Hills, Meghalaya-794101" );
$phone   = get_theme_mod( 'pasfanc_top_phone', '+91 97741 09207' );
$email   = get_theme_mod( 'pasfanc_top_email', 'pasfabongnogacollege@gmail.com' );
$maps_url = get_theme_mod( 'pasfanc_maps_url', 'https://www.google.com/maps/place/PASF-+Abong+Noga+College,+Tura./@25.502221,90.180934,15z' );
?>

<main id="main" class="site-main">
	<div class="container" style="padding: 3rem 0;">
		<h1 class="page-title"><?php esc_html_e( 'Contact Us', 'pasfanc-theme' ); ?></h1>

		<div class="contact-page-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-top: 2rem;">
			<div>
				<h2><?php esc_html_e( 'Get in Touch', 'pasfanc-theme' ); ?></h2>
				<address style="font-style: normal; margin: 1rem 0;">
					<p><?php echo wp_kses_post( nl2br( esc_html( $address ) ) ); ?></p>
				</address>
				<p><strong><?php esc_html_e( 'Phone', 'pasfanc-theme' ); ?>:</strong> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
				<p><strong><?php esc_html_e( 'Email', 'pasfanc-theme' ); ?>:</strong> <a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>"><?php echo esc_html( $email ); ?></a></p>
				<p><a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn"><?php esc_html_e( 'Open in Google Maps', 'pasfanc-theme' ); ?> &rarr;</a></p>
			</div>
			<div>
				<?php echo do_shortcode( '[pasf_contact_form]' ); ?>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();

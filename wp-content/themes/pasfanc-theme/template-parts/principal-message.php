<?php
/**
 * Principal message section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$name    = get_theme_mod( 'pasfanc_principal_name', 'Tiana Tarin D. Arengh' );
$image_id = get_theme_mod( 'pasfanc_principal_image', 0 );
$message = get_theme_mod( 'pasfanc_principal_message', '' );
$img_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
if ( empty( $img_url ) ) {
	$img_url = get_template_directory_uri() . '/assets/images/principal-default.png';
}

if ( empty( $message ) ) {
	$message = __( 'I am pleased to extend my heartiest welcome to PASF–Abong Noga College. This institution is filled with positivity and optimism. Every individual is treated with equal dignity, and opportunities of all kinds are open to everyone.', 'pasfanc-theme' );
}
?>
<section class="principal-section section section-animate">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php esc_html_e( 'Message from the Principal', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'A warm note and guidance for students, parents, and the community.', 'pasfanc-theme' ); ?></p>
		</div>
		<div class="principal-inner">
			<div class="principal-image">
				<div class="principal-image-frame">
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>">
				</div>
			</div>
			<div class="principal-content">
				<p class="principal-desk"><?php esc_html_e( 'Principal\'s Desk', 'pasfanc-theme' ); ?></p>
				<h3><?php echo esc_html( $name ); ?>, <?php esc_html_e( 'Principal', 'pasfanc-theme' ); ?></h3>
				<blockquote><?php echo wp_kses_post( wpautop( $message ) ); ?></blockquote>
				<p><a href="<?php echo esc_url( home_url( '/about/#principal' ) ); ?>" class="btn"><?php esc_html_e( 'Read more→', 'pasfanc-theme' ); ?></a></p>
			</div>
		</div>
	</div>
</section>

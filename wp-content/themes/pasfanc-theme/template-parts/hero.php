<?php
/**
 * Hero section - uses Hero Slider plugin when available, else theme Customizer hero + Flash News
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_slider_output = '';
if ( function_exists( 'do_shortcode' ) && class_exists( 'Pasf_Hero_Slider_Display' ) ) {
	$hero_slider_output = do_shortcode( '[pasf_hero_slider]' );
}

if ( $hero_slider_output ) {
	echo $hero_slider_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output
	// Flash News bar below hero slider (same as when using theme hero)
	if ( function_exists( 'do_shortcode' ) ) {
		$flash_out = do_shortcode( '[pasf_flash_news limit="10"]' );
		if ( $flash_out ) {
			echo '<div class="flash-news-wrapper">' . $flash_out . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
} else {
	$hero_image_id   = get_theme_mod( 'pasfanc_hero_image', 0 );
	$hero_text       = get_theme_mod( 'pasfanc_hero_text', 'Welcome to PASF Academy' );
	$hero_subtitle   = get_theme_mod( 'pasfanc_hero_subtitle', '' );
	$hero_bg         = '';
	if ( $hero_image_id ) {
		$hero_bg = wp_get_attachment_image_url( $hero_image_id, 'full' );
	}
	?>
	<section class="hero-section">
		<?php if ( $hero_bg ) : ?>
			<div class="hero-bg" style="background-image: url('<?php echo esc_url( $hero_bg ); ?>');"></div>
		<?php endif; ?>
		<div class="hero-overlay">
			<h1><?php echo esc_html( $hero_text ); ?></h1>
			<?php if ( $hero_subtitle ) : ?>
				<p class="hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
			<?php endif; ?>
			<?php if ( function_exists( 'do_shortcode' ) ) : ?>
				<div class="flash-news-wrapper">
					<?php echo do_shortcode( '[pasf_flash_news limit="10"]' ); ?>
				</div>
			<?php endif; ?>
		</div>
		<a href="#about" class="hero-scroll-indicator" aria-label="<?php esc_attr_e( 'Scroll to content', 'pasfanc-theme' ); ?>">
			<span class="hero-scroll-chevron"></span>
		</a>
	</section>
	<?php
}

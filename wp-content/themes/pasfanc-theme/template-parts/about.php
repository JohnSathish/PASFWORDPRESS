<?php
/**
 * About section - Flash News bar + About the College content
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about_page  = get_page_by_path( 'about' );
$content     = $about_page ? apply_filters( 'the_content', $about_page->post_content ) : '';
$excerpt     = $about_page ? wp_trim_words( $content, 150 ) : '';
$founder_id  = get_theme_mod( 'pasfanc_founder_image', 0 );
$founder_url = $founder_id ? wp_get_attachment_image_url( $founder_id, 'large' ) : '';
?>
<section class="about-section section section-animate" id="about">
	<div class="container">
		<div class="about-grid">
			<div class="about-image-wrap">
				<div class="about-image-frame">
					<?php if ( $founder_url ) : ?>
						<img src="<?php echo esc_url( $founder_url ); ?>" alt="<?php esc_attr_e( 'Founder', 'pasfanc-theme' ); ?>">
						<span class="about-image-caption"><?php esc_html_e( 'Founder', 'pasfanc-theme' ); ?></span>
					<?php else : ?>
						<div class="about-image-placeholder">
							<span class="about-image-placeholder-text"><?php esc_html_e( 'Founder', 'pasfanc-theme' ); ?></span>
							<p class="about-image-placeholder-hint"><?php esc_html_e( 'Add image in Customizer', 'pasfanc-theme' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
				<?php if ( $founder_url ) : ?>
					<p class="about-image-caption"><?php esc_html_e( 'Founder', 'pasfanc-theme' ); ?></p>
				<?php endif; ?>
			</div>
			<div class="about-content">
				<div class="about-content-inner">
					<h3 class="about-title"><?php esc_html_e( 'About PASF–Abong Noga College', 'pasfanc-theme' ); ?></h3>
				<?php
				$about_default_excerpt = "Rooted in the rich heritage of the A·chik community and inspired by visionary leadership, PASF–Abong Noga College stands as a centre of learning, culture, and social commitment.\n\nThe college is named in honour of two important and influential legendary figures of the A·chik community. Late Shri Purno Agitok Sangma (1947–2016) remains a cherished name in every nook and corner of Garo Hills and holds a special place in the hearts of many Indians even today.";
				$about_excerpt = get_theme_mod( 'pasfanc_about_excerpt', $about_default_excerpt );
				if ( $about_excerpt ) {
					echo '<div class="about-excerpt">' . wp_kses_post( wpautop( $about_excerpt ) ) . '</div>';
				} elseif ( $about_page ) {
					echo wp_kses_post( $excerpt );
				} else {
					echo '<p>' . esc_html__( 'Rooted in the rich heritage of the A·chik community and inspired by visionary leadership, PASF–Abong Noga College stands as a centre of learning, culture, and social commitment.', 'pasfanc-theme' ) . '</p>';
				}
				$about_link = $about_page ? get_permalink( $about_page ) : home_url( '/about/' );
				?>
				<p><a href="<?php echo esc_url( $about_link ); ?>" class="btn btn-read-more"><span><?php esc_html_e( 'Read More', 'pasfanc-theme' ); ?></span> <span class="btn-arrow" aria-hidden="true">→</span></a></p>
				</div>
			</div>
		</div>
	</div>
</section>

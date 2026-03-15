<?php
/**
 * Why Choose section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$defaults = array(
	1 => array(
		'title' => __( 'Experienced Faculty', 'pasfanc-theme' ),
		'text'  => __( 'Our dedicated teachers bring years of experience and passion for student success.', 'pasfanc-theme' ),
	),
	2 => array(
		'title' => __( 'Strong Academic Results', 'pasfanc-theme' ),
		'text'  => __( 'Consistent track record of excellent results and university placements.', 'pasfanc-theme' ),
	),
	3 => array(
		'title' => __( 'Modern Learning Environment', 'pasfanc-theme' ),
		'text'  => __( 'Well-equipped classrooms and facilities for an enriching learning experience.', 'pasfanc-theme' ),
	),
	4 => array(
		'title' => __( 'Career Focused Programs', 'pasfanc-theme' ),
		'text'  => __( 'Programs designed to build skills and prepare students for future careers.', 'pasfanc-theme' ),
	),
);
?>
<section class="why-choose-section section section-alt section-animate">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php esc_html_e( 'Why Choose PASF-Abong Noga College', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Excellence in education and character building', 'pasfanc-theme' ); ?></p>
		</div>
		<div class="why-choose-grid why-choose-animate">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<?php
				$title = get_theme_mod( 'pasfanc_why_title_' . $i, $defaults[ $i ]['title'] );
				$text  = get_theme_mod( 'pasfanc_why_text_' . $i, $defaults[ $i ]['text'] );
				?>
				<div class="why-card why-card-<?php echo esc_attr( $i ); ?>">
					<div class="why-card-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></div>
					<h3><?php echo esc_html( $title ); ?></h3>
					<p><?php echo esc_html( $text ); ?></p>
				</div>
			<?php endfor; ?>
		</div>
		<?php
		$about_link = get_permalink( get_page_by_path( 'about', OBJECT, 'page' ) );
		$about_link = $about_link ? $about_link : home_url( '/about/' );
		?>
		<?php if ( $about_link ) : ?>
			<p class="why-choose-cta">
				<a href="<?php echo esc_url( $about_link ); ?>" class="btn btn-view-all-why"><?php esc_html_e( 'Learn More About Us', 'pasfanc-theme' ); ?> &rarr;</a>
			</p>
		<?php endif; ?>
	</div>
</section>

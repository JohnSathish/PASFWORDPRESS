<?php
/**
 * Template Name: Vision & Mission
 * Template for page with slug: vision-mission
 *
 * Enhanced layout with hero banner, card-style content, and optional
 * Customizer Vision/Mission integration.
 *
 * @package pasfanc-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	$has_content     = ! empty( trim( get_the_content() ) );
	$vision_custom   = get_theme_mod( 'pasfanc_vision', '' );
	$mission_custom  = get_theme_mod( 'pasfanc_mission', '' );
	$hero_image_id   = get_post_thumbnail_id();
	$hero_image_url  = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'large' ) : '';
	?>
<main id="main" class="site-main vision-mission-page-main">
	<!-- Hero banner -->
	<section class="vision-mission-hero"<?php echo $hero_image_url ? ' style="background-image: url(' . esc_url( $hero_image_url ) . ');"' : ''; ?>>
		<div class="vision-mission-hero-overlay"></div>
		<div class="container vision-mission-hero-inner">
			<h1 class="vision-mission-title"><?php the_title(); ?></h1>
			<p class="vision-mission-tagline"><?php esc_html_e( 'Our guiding principles for education, growth, and community development.', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container vision-mission-content-wrap">
		<?php if ( $has_content ) : ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'vision-mission-article' ); ?>>
				<div class="vision-mission-entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endif; ?>

		<?php
		// Show Customizer Vision & Mission in card layout when page content is empty
		if ( ! $has_content && ( $vision_custom || $mission_custom ) ) :
			?>
			<div class="vision-mission-cards">
				<?php if ( $vision_custom ) : ?>
					<div class="vision-mission-card vision-mission-card-vision">
						<div class="vision-mission-card-icon" aria-hidden="true">◉</div>
						<h2 class="vision-mission-card-title"><?php esc_html_e( 'Our Vision', 'pasfanc-theme' ); ?></h2>
						<p class="vision-mission-card-text"><?php echo esc_html( $vision_custom ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( $mission_custom ) : ?>
					<div class="vision-mission-card vision-mission-card-mission">
						<div class="vision-mission-card-icon" aria-hidden="true">⚡</div>
						<h2 class="vision-mission-card-title"><?php esc_html_e( 'Our Mission', 'pasfanc-theme' ); ?></h2>
						<p class="vision-mission-card-text"><?php echo esc_html( $mission_custom ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</main>
	<?php
endwhile;

get_footer();

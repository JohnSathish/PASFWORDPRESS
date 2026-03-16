<?php
/**
 * Homepage template
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main">
	<?php get_template_part( 'template-parts/hero' ); ?>
	<?php get_template_part( 'template-parts/quick-facts' ); ?>
	<?php get_template_part( 'template-parts/about' ); ?>
	<?php get_template_part( 'template-parts/guiding-principles' ); ?>
	<?php get_template_part( 'template-parts/principal-message' ); ?>
	<?php get_template_part( 'template-parts/president-message' ); ?>
	<?php get_template_part( 'template-parts/courses-preview' ); ?>
	<?php get_template_part( 'template-parts/why-choose' ); ?>
	<?php get_template_part( 'template-parts/news-events' ); ?>
	<?php get_template_part( 'template-parts/gallery' ); ?>
	<?php get_template_part( 'template-parts/testimonials' ); ?>
	<?php if ( get_theme_mod( 'pasfanc_cta_enabled', true ) ) : ?>
		<?php get_template_part( 'template-parts/cta' ); ?>
	<?php endif; ?>
</main>

<?php
get_footer();

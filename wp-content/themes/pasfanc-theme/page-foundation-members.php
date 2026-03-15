<?php
/**
 * Template Name: Foundation Members
 * Template for page with slug: foundation-members
 *
 * Enhanced layout with hero banner and polished table styling
 * for the foundation members roster.
 *
 * @package pasfanc-theme
 */

get_header();

while ( have_posts() ) :
	the_post();
	$hero_image_id  = get_post_thumbnail_id();
	$hero_image_url = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'large' ) : '';
	?>
<main id="main" class="site-main foundation-members-page-main">
	<!-- Hero banner -->
	<section class="foundation-members-hero"<?php echo $hero_image_url ? ' style="background-image: url(' . esc_url( $hero_image_url ) . ');"' : ''; ?>>
		<div class="foundation-members-hero-overlay"></div>
		<div class="container foundation-members-hero-inner">
			<h1 class="foundation-members-title"><?php the_title(); ?></h1>
			<p class="foundation-members-tagline"><?php esc_html_e( 'Meet the distinguished members of our foundation governing body.', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container foundation-members-content-wrap">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'foundation-members-article' ); ?>>
			<div class="foundation-members-entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	</div>
</main>
	<?php
endwhile;

get_footer();

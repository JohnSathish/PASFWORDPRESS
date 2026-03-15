<?php
/**
 * Admissions page template
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container" style="padding: 3rem 0;">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; endif; ?>

		<div class="admissions-cta" style="text-align: center; margin-top: 2rem; padding: 2rem; background: var(--pasf-bg-alt); border-radius: var(--pasf-radius);">
			<h2><?php esc_html_e( 'Apply Now', 'pasfanc-theme' ); ?></h2>
			<p><?php esc_html_e( 'Take the first step towards your future. Join PASF-Abong Noga College today.', 'pasfanc-theme' ); ?></p>
			<a href="<?php echo esc_url( get_theme_mod( 'pasfanc_apply_url', home_url( '/contact/' ) ) ); ?>" class="btn"><?php esc_html_e( 'Apply Now', 'pasfanc-theme' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-outline"><?php esc_html_e( 'Contact Admission Office', 'pasfanc-theme' ); ?></a>
		</div>
	</div>
</main>

<?php
get_footer();

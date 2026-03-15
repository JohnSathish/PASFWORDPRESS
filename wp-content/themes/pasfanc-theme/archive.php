<?php
/**
 * Archive template
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container" style="padding: 3rem 0;">
		<header class="page-header">
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="archive-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
						<?php endif; ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="entry-meta"><?php echo esc_html( get_the_date() ); ?></p>
						<?php the_excerpt(); ?>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts found.', 'pasfanc-theme' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();

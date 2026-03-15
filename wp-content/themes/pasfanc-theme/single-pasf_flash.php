<?php
/**
 * Single Flash News template
 *
 * Displays full Flash News content when user clicks a news item from the ticker.
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container" style="padding: 3rem 0;">
		<?php
		while ( have_posts() ) :
			the_post();
			$link   = get_post_meta( get_the_ID(), '_pasf_flash_link', true );
			$pdf_id = absint( get_post_meta( get_the_ID(), '_pasf_flash_pdf', true ) );
			$pdf_url = $pdf_id ? wp_get_attachment_url( $pdf_id ) : '';
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'flash-news-single-article' ); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-meta"><?php echo esc_html( get_the_date() ); ?></div>
				</header>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
				<?php if ( $link || $pdf_url ) : ?>
					<div class="flash-news-single-links" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--pasf-border, #e0e0e0);">
						<?php if ( $link ) : ?>
							<p><a href="<?php echo esc_url( $link ); ?>" class="btn" target="_blank" rel="noopener"><?php esc_html_e( 'Visit Link', 'pasfanc-theme' ); ?> &rarr;</a></p>
						<?php endif; ?>
						<?php if ( $pdf_url ) : ?>
							<p><a href="<?php echo esc_url( $pdf_url ); ?>" class="btn btn-outline" target="_blank" rel="noopener"><?php esc_html_e( 'View PDF', 'pasfanc-theme' ); ?> &rarr;</a></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</article>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();

<?php
/**
 * Archive template for Downloads (pasf_download)
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main downloads-archive-main">
	<section class="downloads-hero">
		<div class="downloads-hero-overlay"></div>
		<div class="container downloads-hero-inner">
			<h1 class="downloads-hero-title"><?php esc_html_e( 'Downloads', 'pasfanc-theme' ); ?></h1>
			<p class="downloads-hero-tagline"><?php esc_html_e( 'Prospectus, application forms, and other documents.', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container downloads-content-wrap">
		<?php if ( have_posts() ) : ?>
			<div class="downloads-list">
				<?php
				while ( have_posts() ) :
					the_post();
					$file_id  = get_post_meta( get_the_ID(), '_pasf_download_file', true );
					$file_url = get_post_meta( get_the_ID(), '_pasf_download_url', true );
					if ( $file_id ) {
						$file_url = wp_get_attachment_url( (int) $file_id );
					}
					$file_url = $file_url ? $file_url : get_permalink();
					$ext      = '';
					if ( $file_id ) {
						$path = get_attached_file( (int) $file_id );
						$ext  = $path ? strtoupper( pathinfo( $path, PATHINFO_EXTENSION ) ) : 'PDF';
					} elseif ( $file_url ) {
						$ext = 'PDF';
					}
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'download-item' ); ?>>
						<span class="download-item-icon" aria-hidden="true">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2 5 5h-5V4zM8 13h2v5H8v-5zm4 0h2v5h-2v-5zm-2 3h2v2h-2v-2zm4 0h2v2h-2v-2z"/></svg>
						</span>
						<div class="download-item-body">
							<h2 class="download-item-title"><?php the_title(); ?></h2>
							<p class="download-item-meta"><?php echo esc_html( get_the_date() ); ?><?php echo $ext ? ' · ' . esc_html( $ext ) : ''; ?></p>
							<a href="<?php echo esc_url( $file_url ); ?>" class="btn download-item-btn"<?php echo ( strpos( $file_url, home_url( '/' ) ) === 0 ) ? ' download' : ' target="_blank" rel="noopener noreferrer"'; ?>>
								<?php esc_html_e( 'Download', 'pasfanc-theme' ); ?> &rarr;
							</a>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '&larr;', 'next_text' => '&rarr;' ) ); ?>
		<?php else : ?>
			<div class="downloads-empty">
				<p><?php esc_html_e( 'No downloads available at the moment. Check back later.', 'pasfanc-theme' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();

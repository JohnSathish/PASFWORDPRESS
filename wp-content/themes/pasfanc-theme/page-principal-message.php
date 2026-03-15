<?php
/**
 * Template Name: Principal Message
 *
 * Gives the Principal Message page a distinct layout with card-style content
 * and enhanced pagination when content is split with <!--nextpage-->.
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main principal-message-page-main">
	<div class="container principal-message-page-container">
		<?php
		while ( have_posts() ) :
			the_post();
			$principal_name  = get_theme_mod( 'pasfanc_principal_name', 'Tiana Tarin D. Arengh' );
			$principal_image = get_theme_mod( 'pasfanc_principal_image', 0 );
			$img_url         = $principal_image ? wp_get_attachment_image_url( $principal_image, 'medium' ) : '';
			if ( empty( $img_url ) ) {
				$img_url = get_template_directory_uri() . '/assets/images/principal-default.png';
			}
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'principal-message-article' ); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="principal-message-content-wrap">
					<?php if ( $img_url ) : ?>
						<div class="principal-message-image">
							<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $principal_name ); ?>">
							<p class="principal-message-caption"><?php echo esc_html( $principal_name ); ?>, <?php esc_html_e( 'Principal', 'pasfanc-theme' ); ?></p>
						</div>
					<?php endif; ?>
					<div class="entry-content principal-message-entry">
						<?php the_content(); ?>
					</div>
				</div>
			</article>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();

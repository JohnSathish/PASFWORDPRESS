<?php
/**
 * Template Name: President Message
 *
 * Full message from the President of the Governing Body.
 * Matches Principal Message page layout.
 *
 * @package pasfanc-theme
 */

get_header();

$president_name    = get_theme_mod( 'pasfanc_president_name', 'Dr. Mrs. Jasmine B A Sangma' );
$president_title  = get_theme_mod( 'pasfanc_president_title', 'President, Governing Body' );
$president_image  = get_theme_mod( 'pasfanc_president_image', 0 );
$img_url          = $president_image ? wp_get_attachment_image_url( $president_image, 'medium' ) : '';
if ( empty( $img_url ) ) {
	$img_url = get_template_directory_uri() . '/assets/images/president-default.png';
}
$president_qual   = get_theme_mod( 'pasfanc_president_qualification', 'PhD' );
?>

<main id="main" class="site-main president-message-page-main">
	<div class="container president-message-page-container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'president-message-article' ); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="president-message-content-wrap">
					<?php if ( $img_url ) : ?>
						<div class="president-message-image">
							<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $president_name ); ?>">
							<p class="president-message-caption"><?php echo esc_html( $president_name ); ?><?php echo $president_qual ? ', ' . esc_html( $president_qual ) : ''; ?></p>
							<p class="president-message-designation"><?php echo esc_html( $president_title ); ?></p>
						</div>
					<?php endif; ?>
					<div class="entry-content president-message-entry">
						<?php the_content(); ?>
						<p class="president-signature">
							<strong><?php echo esc_html( $president_name ); ?><?php echo $president_qual ? ', ' . esc_html( $president_qual ) : ''; ?></strong><br>
							<?php echo esc_html( $president_title ); ?>
						</p>
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

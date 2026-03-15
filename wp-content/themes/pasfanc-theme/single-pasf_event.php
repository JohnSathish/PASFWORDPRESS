<?php
/**
 * Single Event template
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main">
	<div class="container" style="padding: 3rem 0;">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$event_date = get_post_meta( get_the_ID(), '_pasf_event_date', true );
			$display_date = $event_date ? date_i18n( get_option( 'date_format' ), strtotime( $event_date ) ) : get_the_date();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-meta"><?php echo esc_html( $display_date ); ?></div>
				</header>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumbnail"><?php the_post_thumbnail( 'large' ); ?></div>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	</div>
</main>

<?php
get_footer();

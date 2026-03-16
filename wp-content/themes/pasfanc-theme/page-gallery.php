<?php
/**
 * Template Name: Gallery
 * Gallery page - matches https://pasfanc.ac.in/gallery structure exactly
 *
 * Layout: H1 Gallery, subtitle, H2 Campus Gallery, description, category filters, grid, Back to Home
 *
 * @package pasfanc-theme
 */

get_header();

$filter_slug = isset( $_GET['filter'] ) ? sanitize_text_field( wp_unslash( $_GET['filter'] ) ) : '';
$paged      = isset( $_GET['paged'] ) ? max( 1, absint( $_GET['paged'] ) ) : 1;
$gallery_url = home_url( '/gallery/' );

$args = array(
	'post_type'      => 'pasf_gallery',
	'posts_per_page' => 24,
	'paged'          => $paged,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
);
if ( $filter_slug ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'pasf_gallery_category',
			'field'    => 'slug',
			'terms'    => $filter_slug,
		),
	);
}

$gallery_query = new WP_Query( $args );
$terms         = get_terms( array( 'taxonomy' => 'pasf_gallery_category', 'hide_empty' => true ) );
?>

<main id="main" class="site-main gallery-page-main">
	<div class="container" style="padding: 3rem 0;">
		<h1 class="gallery-page-title"><?php esc_html_e( 'Gallery', 'pasfanc-theme' ); ?></h1>
		<p class="gallery-page-subtitle"><?php esc_html_e( 'Photo gallery. Edit from Admin → Pages.', 'pasfanc-theme' ); ?></p>

		<h2 class="gallery-section-title"><?php esc_html_e( 'Campus Gallery', 'pasfanc-theme' ); ?></h2>
		<p class="gallery-section-desc"><?php esc_html_e( 'A glimpse of our campus life and activities.', 'pasfanc-theme' ); ?></p>

		<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
			<div class="gallery-filters" style="margin-bottom: 2rem;">
				<a href="<?php echo esc_url( $gallery_url ); ?>" class="<?php echo empty( $filter_slug ) ? 'active' : ''; ?>"><?php esc_html_e( 'All', 'pasfanc-theme' ); ?></a>
				<?php foreach ( $terms as $term ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'filter', $term->slug, $gallery_url ) ); ?>" class="<?php echo $filter_slug === $term->slug ? 'active' : ''; ?>"><?php echo esc_html( $term->name ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="gallery-grid">
			<?php
			if ( $gallery_query->have_posts() ) :
				while ( $gallery_query->have_posts() ) :
					$gallery_query->the_post();
					$item       = get_post();
					$item_terms = get_the_terms( $item->ID, 'pasf_gallery_category' );
					$slugs      = array();
					if ( $item_terms && ! is_wp_error( $item_terms ) ) {
						$slugs = array_map( function ( $t ) { return $t->slug; }, $item_terms );
					}
					$cats_attr = esc_attr( implode( ' ', $slugs ) );
					$title    = get_the_title();

					$all_img_ids = array();
					if ( has_post_thumbnail( $item ) ) {
						$all_img_ids[] = get_post_thumbnail_id( $item );
					}
					$extra = get_post_meta( $item->ID, '_pasf_gallery_images', true );
					if ( is_array( $extra ) ) {
						$all_img_ids = array_merge( $all_img_ids, array_filter( array_map( 'absint', $extra ) ) );
					} elseif ( is_string( $extra ) && $extra !== '' ) {
						$all_img_ids = array_merge( $all_img_ids, array_filter( array_map( 'absint', explode( ',', $extra ) ) ) );
					}

					foreach ( $all_img_ids as $img_id ) :
						$full_img = wp_get_attachment_image_src( $img_id, 'large' );
						$full_url = $full_img ? $full_img[0] : '';
						?>
						<div class="gallery-item" data-categories="<?php echo $cats_attr; ?>">
							<?php if ( $full_url ) : ?>
								<a href="<?php echo esc_url( $full_url ); ?>" class="gallery-item-link" title="<?php echo esc_attr( $title ); ?>" data-glightbox="gallery:campus-gallery" data-title="<?php echo esc_attr( $title ); ?>">
									<?php echo wp_get_attachment_image( $img_id, 'medium', false, array( 'alt' => esc_attr( $title ) ) ); ?>
									<span class="gallery-item-overlay"><span class="gallery-item-icon" aria-hidden="true"></span></span>
								</a>
							<?php else : ?>
								<div class="gallery-item-placeholder"><?php echo esc_html( $title ); ?></div>
							<?php endif; ?>
						</div>
						<?php
					endforeach;
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p><?php esc_html_e( 'No gallery items found.', 'pasfanc-theme' ); ?></p>
			<?php endif; ?>
		</div>

		<?php
		$total = $gallery_query->found_posts;
		if ( $total > 24 ) :
			$pages = ceil( $total / 24 );
			$base  = add_query_arg( 'paged', '%#%', $filter_slug ? add_query_arg( 'filter', $filter_slug, $gallery_url ) : $gallery_url );
			?>
			<nav class="gallery-pagination" style="margin-top: 2rem;"><?php
				echo wp_kses_post( paginate_links( array(
					'total'   => $pages,
					'current' => $paged,
					'base'    => preg_replace( '~\#.*~', '', $base ) . '%_%',
					'format'  => '?paged=%#%',
				) ) );
			?></nav>
		<?php endif; ?>

		<p class="gallery-back-home" style="margin-top: 2.5rem; text-align: center;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'pasfanc-theme' ); ?> &larr;</a>
		</p>
	</div>
</main>

<?php
get_footer();

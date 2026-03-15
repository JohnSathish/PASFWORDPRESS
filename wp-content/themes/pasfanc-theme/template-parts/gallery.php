<?php
/**
 * Gallery section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$gallery_items = get_posts( array(
	'post_type'      => 'pasf_gallery',
	'posts_per_page' => 48,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
) );

$terms = get_terms( array(
	'taxonomy'   => 'pasf_gallery_category',
	'hide_empty' => true,
) );

$gallery_link = get_post_type_archive_link( 'pasf_gallery' );
?>
<section class="gallery-section section section-alt section-animate" id="gallery">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php esc_html_e( 'Campus Gallery', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'A glimpse of our campus life and activities.', 'pasfanc-theme' ); ?></p>
		</div>

		<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
			<div class="gallery-filters" role="tablist" aria-label="<?php esc_attr_e( 'Filter gallery by category', 'pasfanc-theme' ); ?>">
				<button type="button" class="gallery-filter-btn active" data-filter="all" aria-pressed="true"><?php esc_html_e( 'All', 'pasfanc-theme' ); ?></button>
				<?php foreach ( $terms as $term ) : ?>
					<button type="button" class="gallery-filter-btn" data-filter="<?php echo esc_attr( $term->slug ); ?>" aria-pressed="false"><?php echo esc_html( $term->name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="gallery-grid gallery-grid-animate">
			<?php
			$tile_idx = 0;
			foreach ( $gallery_items as $item ) :
				$item_terms = get_the_terms( $item->ID, 'pasf_gallery_category' );
				$slugs     = array();
				if ( $item_terms && ! is_wp_error( $item_terms ) ) {
					$slugs = array_map( function ( $t ) { return $t->slug; }, $item_terms );
				}
				$cats_attr = esc_attr( implode( ' ', $slugs ) );
				$title    = get_the_title( $item );

				// Collect all images: featured first, then gallery images
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
					$tile_idx++;
					$full_img = wp_get_attachment_image_src( $img_id, 'large' );
					$full_url = $full_img ? $full_img[0] : '';
					$classes  = 'gallery-item gallery-item-' . $tile_idx;
					?>
					<div class="<?php echo esc_attr( $classes ); ?>" data-categories="<?php echo $cats_attr; ?>">
						<?php if ( $full_url ) : ?>
							<a href="<?php echo esc_url( $full_url ); ?>" class="gallery-item-link" title="<?php echo esc_attr( $title ); ?>" data-glightbox="gallery:campus-gallery" data-title="<?php echo esc_attr( $title ); ?>">
								<?php echo wp_get_attachment_image( $img_id, 'medium', false, array( 'alt' => esc_attr( $title ) ) ); ?>
								<span class="gallery-item-overlay"><span class="gallery-item-icon" aria-hidden="true"></span></span>
							</a>
						<?php else : ?>
							<div class="gallery-item-placeholder"><?php echo esc_html( $title ); ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</div>

		<?php if ( $gallery_link ) : ?>
			<p class="gallery-cta">
				<a href="<?php echo esc_url( $gallery_link ); ?>" class="btn btn-view-all-gallery"><?php esc_html_e( 'View All Galleries', 'pasfanc-theme' ); ?> &rarr;</a>
			</p>
		<?php endif; ?>
	</div>
</section>

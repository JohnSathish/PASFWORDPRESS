<?php
/**
 * Gallery archive template with taxonomy filter
 *
 * @package pasfanc-theme
 */

get_header();

$filter_slug = isset( $_GET['filter'] ) ? sanitize_text_field( wp_unslash( $_GET['filter'] ) ) : '';
$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
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
$terms = get_terms( array( 'taxonomy' => 'pasf_gallery_category', 'hide_empty' => true ) );
?>

<main id="main" class="site-main">
	<div class="container" style="padding: 3rem 0;">
		<h1 class="page-title"><?php esc_html_e( 'Campus Gallery', 'pasfanc-theme' ); ?></h1>
		<p class="section-subtitle" style="text-align: center; margin-bottom: 2rem;"><?php esc_html_e( 'A glimpse of our campus life and activities.', 'pasfanc-theme' ); ?></p>

		<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
			<div class="gallery-filters" style="margin-bottom: 2rem;">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'pasf_gallery' ) ); ?>" class="<?php echo empty( $filter_slug ) ? 'active' : ''; ?>"><?php esc_html_e( 'All', 'pasfanc-theme' ); ?></a>
				<?php foreach ( $terms as $term ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'filter', $term->slug, get_post_type_archive_link( 'pasf_gallery' ) ) ); ?>" class="<?php echo $filter_slug === $term->slug ? 'active' : ''; ?>"><?php echo esc_html( $term->name ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="gallery-grid">
			<?php
			if ( $gallery_query->have_posts() ) :
				while ( $gallery_query->have_posts() ) :
					$gallery_query->the_post();
					$item = get_post();
					$item_terms = get_the_terms( $item->ID, 'pasf_gallery_category' );
					$slugs = array();
					if ( $item_terms && ! is_wp_error( $item_terms ) ) {
						$slugs = array_map( function ( $t ) { return $t->slug; }, $item_terms );
					}
					$cats_attr = esc_attr( implode( ' ', $slugs ) );
					$title = get_the_title();

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
			?>
			<nav class="gallery-pagination"><?php echo wp_kses_post( paginate_links( array( 'total' => $pages ) ) ); ?></nav>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();

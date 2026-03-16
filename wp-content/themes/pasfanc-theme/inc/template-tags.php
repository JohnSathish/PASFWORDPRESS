<?php
/**
 * Custom template tags for PASF theme
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default menu when no menu is assigned
 */
function pasfanc_default_menu() {
	?>
	<ul id="primary-menu" class="nav-menu">
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pasfanc-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'pasfanc-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/administration/' ) ); ?>"><?php esc_html_e( 'Administration', 'pasfanc-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/academics/' ) ); ?>"><?php esc_html_e( 'Academics', 'pasfanc-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/student-services/' ) ); ?>"><?php esc_html_e( 'Student Services', 'pasfanc-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>"><?php esc_html_e( 'Gallery', 'pasfanc-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/downloads/' ) ); ?>"><?php esc_html_e( 'Downloads', 'pasfanc-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'pasfanc-theme' ); ?></a></li>
	</ul>
	<?php
}

/**
 * Fallback for footer Quick Links menu
 */
function pasfanc_footer_quick_fallback() {
	$links = array(
		array( 'Home', '/' ),
		array( 'About Us', '/about/' ),
		array( 'Academics', '/academics/' ),
		array( 'Gallery', '/gallery/' ),
		array( 'Downloads', '/downloads/' ),
		array( 'Contact Us', '/contact/' ),
	);
	echo '<ul class="footer-menu">';
	foreach ( $links as $item ) {
		echo '<li><a href="' . esc_url( home_url( $item[1] ) ) . '">' . esc_html( $item[0] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Output enhanced page pagination for multi-page content (<!--nextpage-->).
 * Displays only when the post has 2+ pages. Applies to all pages and singles.
 *
 * @param string $extra_class Optional. Extra CSS class(es) for the nav wrapper.
 * @param bool   $echo       Optional. Whether to echo (true) or return (false). Default true.
 * @return string Empty string if no pagination, or HTML when $echo is false.
 */
function pasfanc_page_pagination( $extra_class = '', $echo = true ) {
	global $page, $numpages, $multipage;
	if ( ! isset( $numpages ) || $numpages < 2 || ! isset( $multipage ) || ! $multipage ) {
		return '';
	}
	$nav_class = 'page-links pagination-links pasfanc-page-pagination';
	if ( $extra_class ) {
		$nav_class .= ' ' . esc_attr( $extra_class );
	}
	$page_indicator = ( isset( $page ) ) ? '<span class="pagination-page-indicator">' . sprintf(
		/* translators: 1: current page, 2: total pages */
		esc_html__( 'Page %1$d of %2$d', 'pasfanc-theme' ),
		(int) $page,
		(int) $numpages
	) . '</span>' : '';
	if ( $echo ) {
		wp_link_pages( array(
			'before'         => '<nav class="' . $nav_class . '" aria-label="' . esc_attr__( 'Page navigation', 'pasfanc-theme' ) . '">' . $page_indicator . '<span class="page-links-title">' . esc_html__( 'Pages:', 'pasfanc-theme' ) . '</span>',
			'after'          => '</nav>',
			'link_before'    => '<span class="page-number">',
			'link_after'     => '</span>',
			'next_or_number' => 'both',
			'prev_text'      => '&laquo; ' . esc_html__( 'Previous', 'pasfanc-theme' ),
			'next_text'      => esc_html__( 'Next', 'pasfanc-theme' ) . ' &raquo;',
		) );
		return '';
	}
	ob_start();
	wp_link_pages( array(
		'before'         => '<nav class="' . $nav_class . '" aria-label="' . esc_attr__( 'Page navigation', 'pasfanc-theme' ) . '">' . $page_indicator . '<span class="page-links-title">' . esc_html__( 'Pages:', 'pasfanc-theme' ) . '</span>',
		'after'          => '</nav>',
		'link_before'    => '<span class="page-number">',
		'link_after'     => '</span>',
		'next_or_number' => 'both',
		'prev_text'      => '&laquo; ' . esc_html__( 'Previous', 'pasfanc-theme' ),
		'next_text'      => esc_html__( 'Next', 'pasfanc-theme' ) . ' &raquo;',
	) );
	return ob_get_clean();
}

/**
 * Get breadcrumb trail items for current page.
 *
 * @return array Array of items with 'url' and 'label'.
 */
function pasfanc_get_breadcrumbs() {
	$items   = array();
	$items[] = array( 'url' => home_url( '/' ), 'label' => __( 'Home', 'pasfanc-theme' ) );

	if ( is_front_page() ) {
		return $items;
	}

	if ( is_page() ) {
		$post      = get_queried_object();
		$ancestors = array_reverse( get_post_ancestors( $post ) );
		foreach ( $ancestors as $anc_id ) {
			$anc = get_post( $anc_id );
			if ( $anc ) {
				$items[] = array( 'url' => get_permalink( $anc ), 'label' => get_the_title( $anc ) );
			}
		}
		$items[] = array( 'url' => '', 'label' => get_the_title( $post ) );
	} elseif ( is_single() ) {
		$post_type = get_post_type();
		$pt_obj    = get_post_type_object( $post_type );
		if ( $pt_obj && $pt_obj->has_archive ) {
			$items[] = array( 'url' => get_post_type_archive_link( $post_type ), 'label' => $pt_obj->labels->name );
		} elseif ( 'post' === $post_type ) {
			$cats = get_the_category();
			if ( ! empty( $cats ) ) {
				$items[] = array( 'url' => get_category_link( $cats[0] ), 'label' => $cats[0]->name );
			}
		}
		$items[] = array( 'url' => '', 'label' => get_the_title() );
	} elseif ( is_post_type_archive() ) {
		$pt_obj   = get_queried_object();
		$items[]  = array( 'url' => '', 'label' => $pt_obj->labels->name );
	} elseif ( is_category() ) {
		$cat      = get_queried_object();
		$items[]  = array( 'url' => '', 'label' => $cat->name );
	} elseif ( is_tag() ) {
		$tag      = get_queried_object();
		$items[]  = array( 'url' => '', 'label' => $tag->name );
	} elseif ( is_search() ) {
		$items[]  = array( 'url' => '', 'label' => sprintf( __( 'Search results for: %s', 'pasfanc-theme' ), get_search_query() ) );
	} elseif ( is_404() ) {
		$items[]  = array( 'url' => '', 'label' => __( 'Page not found', 'pasfanc-theme' ) );
	}

	return $items;
}

/**
 * Output breadcrumb markup.
 */
function pasfanc_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}
	$items = pasfanc_get_breadcrumbs();
	if ( count( $items ) < 2 ) {
		return;
	}
	?>
	<nav class="pasfanc-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'pasfanc-theme' ); ?>">
		<div class="container">
			<ul class="pasfanc-breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
				<?php foreach ( $items as $i => $item ) : ?>
					<li class="pasfanc-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<?php if ( ! empty( $item['url'] ) ) : ?>
							<a itemprop="item" href="<?php echo esc_url( $item['url'] ); ?>">
								<span itemprop="name"><?php echo esc_html( $item['label'] ); ?></span>
							</a>
							<span class="pasfanc-breadcrumb-sep" aria-hidden="true">»</span>
						<?php else : ?>
							<span itemprop="name" class="pasfanc-breadcrumb-current"><?php echo esc_html( $item['label'] ); ?></span>
						<?php endif; ?>
						<meta itemprop="position" content="<?php echo (int) ( $i + 1 ); ?>" />
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</nav>
	<?php
}

/**
 * Fallback for footer Students menu
 */
function pasfanc_footer_students_fallback() {
	$links = array(
		array( 'Contact Us', '/contact/' ),
		array( 'Gallery', '/gallery/' ),
		array( 'Student Services', '/student-services/' ),
		array( 'Admissions', '/admissions/' ),
	);
	echo '<ul class="footer-menu">';
	foreach ( $links as $item ) {
		echo '<li><a href="' . esc_url( home_url( $item[1] ) ) . '">' . esc_html( $item[0] ) . '</a></li>';
	}
	echo '</ul>';
}

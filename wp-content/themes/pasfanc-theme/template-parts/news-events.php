<?php
/**
 * News & Events section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$news_items  = get_posts( array(
	'post_type'      => 'pasf_news',
	'posts_per_page' => 6,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
) );
$today = gmdate( 'Y-m-d' );
$event_items = get_posts( array(
	'post_type'      => 'pasf_event',
	'posts_per_page' => 6,
	'orderby'        => 'meta_value',
	'meta_key'       => '_pasf_event_date',
	'order'          => 'ASC',
	'post_status'    => 'publish',
	'meta_query'     => array(
		'relation' => 'AND',
		array(
			'key'     => '_pasf_event_date',
			'compare' => 'EXISTS',
		),
		array(
			'key'     => '_pasf_event_date',
			'value'   => $today,
			'compare' => '>=',
			'type'    => 'DATE',
		),
	),
) );

$news_link   = get_post_type_archive_link( 'pasf_news' );
$events_link = get_post_type_archive_link( 'pasf_event' );
?>
<section class="news-events-section section section-alt section-animate">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php esc_html_e( 'Latest News & Events', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Stay up-to-date with our latest happenings.', 'pasfanc-theme' ); ?></p>
		</div>
		<div class="news-events-grid">
			<div class="news-events-col">
				<h3><?php esc_html_e( 'Notice Board', 'pasfanc-theme' ); ?></h3>
				<div class="news-scroll-wrap">
					<div class="news-scroll-inner">
						<ul class="notice-list">
							<?php foreach ( $news_items as $item ) : ?>
								<?php
								$link = get_post_meta( $item->ID, '_pasf_news_link', true );
								$url  = $link ? $link : get_permalink( $item );
								?>
								<li>
									<span class="notice-date"><?php echo esc_html( get_the_date( 'd M Y', $item ) ); ?></span>
									<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_title( $item ) ); ?></a>
									<?php if ( has_excerpt( $item ) ) : ?>
										<br><small><?php echo esc_html( wp_trim_words( get_the_excerpt( $item ), 15 ) ); ?></small>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php if ( ! empty( $news_items ) ) : ?>
							<ul class="notice-list notice-list-dupe" aria-hidden="true">
								<?php foreach ( $news_items as $item ) : ?>
									<?php
									$link = get_post_meta( $item->ID, '_pasf_news_link', true );
									$url  = $link ? $link : get_permalink( $item );
									?>
									<li>
										<span class="notice-date"><?php echo esc_html( get_the_date( 'd M Y', $item ) ); ?></span>
										<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_title( $item ) ); ?></a>
										<?php if ( has_excerpt( $item ) ) : ?>
											<br><small><?php echo esc_html( wp_trim_words( get_the_excerpt( $item ), 15 ) ); ?></small>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
				<?php if ( $news_link ) : ?>
					<p class="news-col-cta"><a href="<?php echo esc_url( $news_link ); ?>" class="btn btn-show-more"><?php esc_html_e( 'Show more', 'pasfanc-theme' ); ?> &rarr;</a></p>
				<?php endif; ?>
			</div>
			<div class="news-events-col news-events-col-events">
				<h3 class="events-title-with-icon"><span class="events-calendar-icon" aria-hidden="true"></span><?php esc_html_e( 'Upcoming Events', 'pasfanc-theme' ); ?></h3>
				<div class="news-scroll-wrap">
					<div class="news-scroll-inner">
						<?php if ( empty( $event_items ) ) : ?>
							<p class="events-empty-msg"><?php esc_html_e( 'No upcoming events at the moment. Check back soon!', 'pasfanc-theme' ); ?></p>
						<?php else : ?>
						<ul class="events-list">
							<?php foreach ( $event_items as $item ) : ?>
								<?php
								$link   = get_post_meta( $item->ID, '_pasf_event_link', true );
								$url    = $link ? $link : get_permalink( $item );
								$edate  = get_post_meta( $item->ID, '_pasf_event_date', true );
								$display_date = $edate ? date_i18n( 'd M Y', strtotime( $edate ) ) : get_the_date( 'd M Y', $item );
								?>
								<li>
									<span class="event-date"><?php echo esc_html( $display_date ); ?></span>
									<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_title( $item ) ); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php if ( ! empty( $event_items ) ) : ?>
							<ul class="events-list events-list-dupe" aria-hidden="true">
								<?php foreach ( $event_items as $item ) : ?>
									<?php
									$link   = get_post_meta( $item->ID, '_pasf_event_link', true );
									$url    = $link ? $link : get_permalink( $item );
									$edate  = get_post_meta( $item->ID, '_pasf_event_date', true );
									$display_date = $edate ? date_i18n( 'd M Y', strtotime( $edate ) ) : get_the_date( 'd M Y', $item );
									?>
									<li>
										<span class="event-date"><?php echo esc_html( $display_date ); ?></span>
										<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( get_the_title( $item ) ); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php if ( $events_link ) : ?>
					<p class="news-col-cta"><a href="<?php echo esc_url( $events_link ); ?>" class="btn btn-show-more"><?php esc_html_e( 'Show more', 'pasfanc-theme' ); ?> &rarr;</a></p>
				<?php endif; ?>
			</div>
		</div>

		<?php
		$today = gmdate( 'Y-m-d' );

		// News in "news-highlights" category (assign category when adding News to show in Highlights)
		$news_highlights_term = get_term_by( 'slug', 'news-highlights', 'category' );
		$featured_news = array();
		if ( $news_highlights_term ) {
			$featured_news = get_posts( array(
				'post_type'      => 'pasf_news',
				'posts_per_page' => 4,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'post_status'    => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $news_highlights_term->term_id,
					),
				),
			) );
		}

		// Featured upcoming events (from admin "Show in News & Events Highlights")
		$featured_events = get_posts( array(
			'post_type'      => 'pasf_event',
			'posts_per_page' => 4,
			'meta_key'       => '_pasf_event_date',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'meta_query'     => array(
				'relation' => 'AND',
				array( 'key' => '_pasf_event_highlight', 'value' => '1', 'compare' => '=' ),
				array( 'key' => '_pasf_event_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
			),
		) );

		// Merge: add type and sort date for unified display
		$highlight_items = array();
		foreach ( $featured_news as $p ) {
			$highlight_items[] = array(
				'post'  => $p,
				'type'  => 'news',
				'url'   => get_post_meta( $p->ID, '_pasf_news_link', true ) ?: get_permalink( $p->ID ),
				'date'  => get_the_date( 'Y-m-d', $p ),
				'order' => strtotime( get_the_date( 'Y-m-d', $p ) ),
			);
		}
		foreach ( $featured_events as $p ) {
			$edate = get_post_meta( $p->ID, '_pasf_event_date', true );
			$highlight_items[] = array(
				'post'  => $p,
				'type'  => 'event',
				'url'   => get_post_meta( $p->ID, '_pasf_event_link', true ) ?: get_permalink( $p->ID ),
				'date'  => $edate ?: get_the_date( 'Y-m-d', $p ),
				'order' => $edate ? strtotime( $edate ) : strtotime( get_the_date( 'Y-m-d', $p ) ),
			);
		}

		// Sort by date (most recent first), limit 4
		usort( $highlight_items, function ( $a, $b ) {
			return $b['order'] - $a['order'];
		} );
		$highlight_items = array_slice( $highlight_items, 0, 4 );

		// Fallback: if no featured items, use latest news
		if ( empty( $highlight_items ) ) {
			$fallback = array_slice( $news_items, 0, 4 );
			foreach ( $fallback as $p ) {
				$highlight_items[] = array(
					'post'  => $p,
					'type'  => 'news',
					'url'   => get_post_meta( $p->ID, '_pasf_news_link', true ) ?: get_permalink( $p->ID ),
					'date'  => get_the_date( 'Y-m-d', $p ),
					'order' => strtotime( get_the_date( 'Y-m-d', $p ) ),
				);
			}
		}

		if ( ! empty( $highlight_items ) ) :
			?>
			<div class="news-highlights-wrapper">
				<div class="section-header">
					<h3 class="section-title"><?php esc_html_e( 'News & Events Highlights', 'pasfanc-theme' ); ?></h3>
				</div>
				<div class="news-highlights-grid news-highlights-grid-animate">
					<?php foreach ( $highlight_items as $idx => $entry ) : ?>
						<?php
						$item = $entry['post'];
						$card_class = 'news-highlight-card news-highlight-card-' . ( $idx + 1 );
						if ( 'event' === $entry['type'] ) {
							$card_class .= ' news-highlight-card-event';
						}
						$display_date = $entry['date'] ? date_i18n( 'd M Y', strtotime( $entry['date'] ) ) : '';
						?>
						<a href="<?php echo esc_url( $entry['url'] ); ?>" class="<?php echo esc_attr( $card_class ); ?>">
							<?php if ( 'event' === $entry['type'] && $display_date ) : ?>
								<span class="news-highlight-badge news-highlight-badge-event" aria-hidden="true">
									<span class="news-highlight-calendar-icon" aria-hidden="true"></span>
									<?php echo esc_html( $display_date ); ?>
								</span>
							<?php endif; ?>
							<?php if ( has_post_thumbnail( $item ) ) : ?>
								<?php echo get_the_post_thumbnail( $item, 'medium', array( 'alt' => esc_attr( get_the_title( $item ) ) ) ); ?>
							<?php else : ?>
								<div class="news-highlight-placeholder"></div>
							<?php endif; ?>
							<h4><?php echo esc_html( get_the_title( $item ) ); ?></h4>
							<span class="news-highlight-cta"><?php esc_html_e( 'Read More', 'pasfanc-theme' ); ?> &rarr;</span>
						</a>
					<?php endforeach; ?>
				</div>
				<?php if ( $news_link ) : ?>
					<p class="news-highlights-cta"><a href="<?php echo esc_url( $news_link ); ?>" class="btn btn-view-all-news"><?php esc_html_e( 'View All News', 'pasfanc-theme' ); ?> &rarr;</a></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

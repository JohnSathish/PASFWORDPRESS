<?php
/**
 * Testimonials section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$testimonials = get_posts( array(
	'post_type'      => 'pasf_testimonial',
	'posts_per_page' => 6,
	'orderby'        => 'rand',
	'post_status'    => 'publish',
) );
if ( empty( $testimonials ) ) {
	$testimonials = array(
		(object) array(
			'ID'           => 0,
			'post_content' => __( 'PASF Academy helped me build a strong academic foundation and the confidence to pursue higher studies.', 'pasfanc-theme' ),
			'pasf_student' => __( 'Riya Momin', 'pasfanc-theme' ),
			'pasf_class'   => __( 'Class of 2024', 'pasfanc-theme' ),
			'pasf_photo'   => '',
		),
		(object) array(
			'ID'           => 0,
			'post_content' => __( 'The supportive teachers and excellent facilities at PASF College made my learning experience truly enriching. I am grateful for the opportunities.', 'pasfanc-theme' ),
			'pasf_student' => __( 'Arun Sangma', 'pasfanc-theme' ),
			'pasf_class'   => __( 'B.A. 2023', 'pasfanc-theme' ),
			'pasf_photo'   => '',
		),
		(object) array(
			'ID'           => 0,
			'post_content' => __( 'From day one, I felt welcomed and encouraged to aim higher. The college community and academic excellence prepared me well for my career.', 'pasfanc-theme' ),
			'pasf_student' => __( 'Megha Choudhury', 'pasfanc-theme' ),
			'pasf_class'   => __( 'Class of 2025', 'pasfanc-theme' ),
			'pasf_photo'   => '',
		),
		(object) array(
			'ID'           => 0,
			'post_content' => __( 'The diverse courses and practical learning approach gave me the skills I needed. PASF College truly shaped my future.', 'pasfanc-theme' ),
			'pasf_student' => __( 'David Marak', 'pasfanc-theme' ),
			'pasf_class'   => __( 'B.Sc. 2024', 'pasfanc-theme' ),
			'pasf_photo'   => '',
		),
	);
}
?>
<section class="testimonial-section section section-alt section-animate">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php esc_html_e( 'What Our Students Say', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Hear from our alumni and current students about their experience at PASF College.', 'pasfanc-theme' ); ?></p>
		</div>
		<div class="testimonial-scroll-wrap">
			<div class="testimonial-track" aria-label="<?php esc_attr_e( 'Scrolling testimonials', 'pasfanc-theme' ); ?>">
				<?php
				$items = array_merge( $testimonials, $testimonials );
				foreach ( $items as $idx => $t ) :
					$student = isset( $t->ID ) && $t->ID ? ( get_post_meta( $t->ID, '_pasf_student_name', true ) ?: get_the_title( $t ) ) : $t->pasf_student;
					$class_year = isset( $t->ID ) && $t->ID ? get_post_meta( $t->ID, '_pasf_class_year', true ) : $t->pasf_class;
					$content = isset( $t->post_content ) ? apply_filters( 'the_content', $t->post_content ) : '';
					$card_class = 'testimonial-card testimonial-card-' . ( ( $idx % count( $testimonials ) ) + 1 );
					$photo_url = '';
					$photo_alt = '';
					if ( isset( $t->ID ) && $t->ID && has_post_thumbnail( $t ) ) {
						$photo_url = get_the_post_thumbnail_url( $t, 'thumbnail' );
						$photo_alt = get_the_title( $t );
					}
					if ( ! $photo_url ) {
						$photo_url = 'https://ui-avatars.com/api/?name=' . rawurlencode( $student ) . '&size=120&background=48cfad&color=fff';
						$photo_alt = $student;
					}
					?>
					<div class="<?php echo esc_attr( $card_class ); ?>">
						<div class="testimonial-photo-wrap">
							<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $photo_alt ); ?>" class="testimonial-photo" width="96" height="96" loading="lazy">
						</div>
						<span class="testimonial-quote-icon" aria-hidden="true">"</span>
						<div class="testimonial-content">
							<blockquote><?php echo wp_kses_post( $content ); ?></blockquote>
						</div>
						<p class="testimonial-author"><?php echo esc_html( $student ); ?></p>
						<p class="testimonial-class"><?php echo esc_html( $class_year ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

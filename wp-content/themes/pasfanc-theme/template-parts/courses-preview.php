<?php
/**
 * Courses preview section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$courses = get_posts( array(
	'post_type'      => 'pasf_course',
	'posts_per_page' => 3,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'post_status'    => 'publish',
) );

if ( empty( $courses ) ) {
	$courses = array();
	$default_courses = array(
		'Class XI & XII Arts' => array( 'English', 'Garo (MIL)', 'Alternative English', 'Education', 'Economics', 'History', 'Garo (GSL)', 'Political Science', 'Philosophy' ),
		'Class XI & XII Commerce' => array( 'English', 'Garo (MIL)', 'Alternative English', 'Accountancy', 'Business Studies', 'Entrepreneurship' ),
		'Four Years Under Graduate Courses' => array( 'English', 'Garo', 'Economics', 'History', 'Political Science', 'Philosophy' ),
	);
	foreach ( $default_courses as $title => $subjects ) {
		$obj = new stdClass();
		$obj->post_title = $title;
		$obj->subjects = $subjects;
		$courses[] = $obj;
	}
}
?>
<section class="courses-preview section section-alt section-animate">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php esc_html_e( 'Courses & Subjects Offered', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Explore our programmes at higher secondary and degree level.', 'pasfanc-theme' ); ?></p>
		</div>
		<div class="courses-grid courses-grid-animate">
			<?php foreach ( $courses as $idx => $course ) : ?>
				<?php
				$subjects = array();
				if ( isset( $course->ID ) ) {
					$subjects = get_post_meta( $course->ID, '_pasf_course_subjects', true );
					if ( ! is_array( $subjects ) ) {
						$subjects = array();
					}
				} elseif ( isset( $course->subjects ) ) {
					$subjects = $course->subjects;
				}
				$title = isset( $course->post_title ) ? $course->post_title : '';
				?>
				<div class="course-card course-card-<?php echo esc_attr( $idx + 1 ); ?>">
					<span class="course-card-icon" aria-hidden="true"></span>
					<h3><?php echo esc_html( $title ); ?></h3>
					<?php if ( ! empty( $subjects ) ) : ?>
						<ul>
							<?php foreach ( $subjects as $subj ) : ?>
								<li><?php echo esc_html( $subj ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
		$courses_link = get_post_type_archive_link( 'pasf_course' );
		$courses_link = $courses_link ? $courses_link : home_url( '/academics/' );
		?>
		<?php if ( $courses_link ) : ?>
			<p class="courses-cta">
				<a href="<?php echo esc_url( $courses_link ); ?>" class="btn btn-view-all-courses"><?php esc_html_e( 'View All Courses', 'pasfanc-theme' ); ?> &rarr;</a>
			</p>
		<?php endif; ?>
	</div>
</section>

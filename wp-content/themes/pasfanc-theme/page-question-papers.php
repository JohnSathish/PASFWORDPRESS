<?php
/**
 * Template Name: Question Papers
 * Template for page with slug: question-papers
 *
 * Displays question papers filterable by Course and Year.
 *
 * @package pasfanc-theme
 */

get_header();

$courses = class_exists( 'Pasfanc_Meta_Boxes' ) && method_exists( 'Pasfanc_Meta_Boxes', 'get_question_paper_courses' )
	? Pasfanc_Meta_Boxes::get_question_paper_courses()
	: ( class_exists( 'Pasfanc_CPT_Question_Papers' ) && method_exists( 'Pasfanc_CPT_Question_Papers', 'get_courses' ) ? Pasfanc_CPT_Question_Papers::get_courses() : array() );
$years   = range( (int) date( 'Y' ), (int) date( 'Y' ) - 10 );

$filter_course = isset( $_GET['course'] ) ? sanitize_text_field( wp_unslash( $_GET['course'] ) ) : '';
$filter_year   = isset( $_GET['year'] ) ? sanitize_text_field( wp_unslash( $_GET['year'] ) ) : '';

$args = array(
	'post_type'      => 'pasf_question_paper',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish',
);

$meta_query = array();
if ( $filter_course ) {
	$meta_query[] = array(
		'key'   => '_pasf_question_paper_course',
		'value' => $filter_course,
		'compare' => '=',
	);
}
if ( $filter_year ) {
	$meta_query[] = array(
		'key'   => '_pasf_question_paper_year',
		'value' => $filter_year,
		'compare' => '=',
	);
}
if ( ! empty( $meta_query ) ) {
	$meta_query['relation'] = 'AND';
	$args['meta_query']     = $meta_query;
}

$query   = new WP_Query( $args );
$papers  = $query->posts;

// Group by Course -> Year
$grouped = array();
foreach ( $papers as $paper ) {
	$course = get_post_meta( $paper->ID, '_pasf_question_paper_course', true );
	$year   = get_post_meta( $paper->ID, '_pasf_question_paper_year', true );
	$course = $course ? $course : __( 'Uncategorized', 'pasfanc-theme' );
	$year   = $year ? $year : __( '—', 'pasfanc-theme' );
	if ( ! isset( $grouped[ $course ] ) ) {
		$grouped[ $course ] = array();
	}
	if ( ! isset( $grouped[ $course ][ $year ] ) ) {
		$grouped[ $course ][ $year ] = array();
	}
	$grouped[ $course ][ $year ][] = $paper;
}

// Sort years descending within each course
foreach ( array_keys( $grouped ) as $c ) {
	krsort( $grouped[ $c ], SORT_NUMERIC );
}
?>

<main id="main" class="site-main question-papers-page-main">
	<section class="question-papers-hero">
		<div class="question-papers-hero-overlay"></div>
		<div class="container question-papers-hero-inner">
			<h1 class="question-papers-title"><?php esc_html_e( 'Question Papers', 'pasfanc-theme' ); ?></h1>
			<p class="question-papers-tagline"><?php esc_html_e( 'Download past exam question papers by course and year.', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container question-papers-content-wrap">
		<form class="question-papers-filters" method="get" action="<?php echo esc_url( get_permalink() ); ?>">
			<div class="question-papers-filter-row">
				<div class="question-papers-filter-group">
					<label for="qp-course"><?php esc_html_e( 'Course', 'pasfanc-theme' ); ?></label>
					<select id="qp-course" name="course" class="question-papers-select">
						<option value=""><?php esc_html_e( 'All Courses', 'pasfanc-theme' ); ?></option>
						<?php foreach ( $courses as $val => $label ) : ?>
							<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $filter_course, $val ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="question-papers-filter-group">
					<label for="qp-year"><?php esc_html_e( 'Year', 'pasfanc-theme' ); ?></label>
					<select id="qp-year" name="year" class="question-papers-select">
						<option value=""><?php esc_html_e( 'All Years', 'pasfanc-theme' ); ?></option>
						<?php foreach ( $years as $y ) : ?>
							<option value="<?php echo esc_attr( $y ); ?>" <?php selected( $filter_year, (string) $y ); ?>><?php echo esc_html( (string) $y ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="question-papers-filter-actions">
					<button type="submit" class="btn"><?php esc_html_e( 'Apply Filters', 'pasfanc-theme' ); ?></button>
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-outline"><?php esc_html_e( 'Reset', 'pasfanc-theme' ); ?></a>
				</div>
			</div>
		</form>

		<div class="question-papers-results">
			<?php if ( empty( $grouped ) ) : ?>
				<p class="question-papers-empty"><?php esc_html_e( 'No question papers found. Try adjusting your filters or check back later.', 'pasfanc-theme' ); ?></p>
			<?php else : ?>
				<?php foreach ( $grouped as $course_name => $years_data ) : ?>
					<div class="question-papers-course-block">
						<h2 class="question-papers-course-title"><?php echo esc_html( $course_name ); ?></h2>
						<?php foreach ( $years_data as $year_val => $year_papers ) : ?>
							<div class="question-papers-year-block">
								<h3 class="question-papers-year-title"><?php echo esc_html( $year_val ); ?></h3>
								<ul class="question-papers-list">
									<?php foreach ( $year_papers as $paper ) : ?>
										<?php
										$file_id = get_post_meta( $paper->ID, '_pasf_question_paper_file', true );
										$file_url = $file_id ? wp_get_attachment_url( (int) $file_id ) : '';
										$subj    = $paper->post_title;
										?>
										<li class="question-papers-item">
											<span class="question-papers-item-subject"><?php echo esc_html( $subj ); ?></span>
											<span class="question-papers-item-meta"><?php echo esc_html( $course_name ); ?> · <?php echo esc_html( $year_val ); ?></span>
											<?php if ( $file_url ) : ?>
												<a href="<?php echo esc_url( $file_url ); ?>" class="btn btn-sm question-papers-download" download>
													<svg class="question-papers-pdf-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 2 5 5h-5V4zM8 13h2v5H8v-5zm4 0h2v5h-2v-5zm-2 3h2v2h-2v-2zm4 0h2v2h-2v-2z"/></svg>
													<?php esc_html_e( 'Download', 'pasfanc-theme' ); ?>
												</a>
											<?php else : ?>
												<span class="question-papers-no-file"><?php esc_html_e( 'No file', 'pasfanc-theme' ); ?></span>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php
get_footer();

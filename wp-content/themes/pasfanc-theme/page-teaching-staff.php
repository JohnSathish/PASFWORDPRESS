<?php
/**
 * Template Name: Teaching Staff
 * Template for page with slug: teaching-staff
 *
 * Displays teaching staff from pasf_staff CPT, grouped by department.
 * Matches the principal profile style (circular photo, name, designation, qualifications).
 *
 * @package pasfanc-theme
 */

get_header();

$departments = array(
	'Principal'           => 0,
	'English'             => 1,
	'Garo'                => 2,
	'Economics'           => 3,
	'Political Science'   => 4,
	'History'             => 5,
	'Philosophy'          => 6,
	'Environmental Studies' => 7,
	'Education'           => 8,
);

// Build department order for sorting (Principal first, then by list)
$dept_order = array();
foreach ( $departments as $name => $order ) {
	$term = get_term_by( 'name', $name, 'pasf_staff_department' );
	if ( $term ) {
		$dept_order[ $term->term_id ] = $order;
	}
}

$all_staff = get_posts( array(
	'post_type'      => 'pasf_staff',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order title',
	'order'          => 'ASC',
) );

// Group by department
$grouped = array();
foreach ( $all_staff as $staff ) {
	$terms = get_the_terms( $staff->ID, 'pasf_staff_department' );
	$dept_name = isset( $terms[0] ) ? $terms[0]->name : __( 'Other', 'pasfanc-theme' );
	if ( ! isset( $grouped[ $dept_name ] ) ) {
		$grouped[ $dept_name ] = array();
	}
	$grouped[ $dept_name ][] = $staff;
}

// Sort departments: Principal first, then by defined order
uksort( $grouped, function ( $a, $b ) use ( $departments ) {
	$order_a = isset( $departments[ $a ] ) ? $departments[ $a ] : 999;
	$order_b = isset( $departments[ $b ] ) ? $departments[ $b ] : 999;
	return $order_a - $order_b;
} );

?>

<main id="main" class="site-main teaching-staff-page-main">
	<section class="teaching-staff-hero">
		<div class="teaching-staff-hero-overlay"></div>
		<div class="container teaching-staff-hero-inner">
			<h1 class="teaching-staff-title"><?php esc_html_e( 'Teaching Staff', 'pasfanc-theme' ); ?></h1>
			<p class="teaching-staff-tagline"><?php esc_html_e( 'Meet our distinguished faculty members who guide and inspire our students.', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container teaching-staff-content-wrap">
		<?php
		foreach ( $grouped as $dept_name => $staff_list ) :
			?>
			<section class="teaching-staff-department">
				<h2 class="teaching-staff-department-title"><?php echo esc_html( $dept_name ); ?></h2>
				<div class="teaching-staff-grid">
					<?php
					foreach ( $staff_list as $staff ) :
						$name          = get_the_title( $staff->ID );
						$initials      = get_post_meta( $staff->ID, '_pasf_staff_initials', true );
						$designation   = get_post_meta( $staff->ID, '_pasf_staff_designation', true );
						$qualifications = get_post_meta( $staff->ID, '_pasf_staff_qualifications', true );
						$thumb_id      = get_post_thumbnail_id( $staff->ID );
						$img_url       = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';
						if ( empty( $initials ) && $name ) {
							$parts = preg_split( '/\s+/', trim( $name ), 3 );
							$initials = '';
							foreach ( $parts as $p ) {
								if ( $p ) {
									$initials .= mb_substr( $p, 0, 1, 'UTF-8' );
								}
								if ( mb_strlen( $initials ) >= 2 ) {
									break;
								}
							}
							$initials = $initials ? strtoupper( $initials ) : '—';
						}
						?>
						<div class="teaching-staff-card">
							<div class="teaching-staff-card-image-wrap<?php echo $thumb_id ? '' : ' teaching-staff-card-initials-only'; ?>">
								<?php if ( $img_url ) : ?>
									<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="teaching-staff-card-image">
								<?php else : ?>
									<span class="teaching-staff-card-initials" aria-hidden="true"><?php echo esc_html( $initials ); ?></span>
								<?php endif; ?>
							</div>
							<div class="teaching-staff-card-content">
								<h3 class="teaching-staff-card-name"><?php echo esc_html( $name ); ?></h3>
								<?php if ( $designation ) : ?>
									<p class="teaching-staff-card-designation"><?php echo esc_html( $designation ); ?></p>
								<?php endif; ?>
								<?php if ( $qualifications ) : ?>
									<p class="teaching-staff-card-qualifications"><?php echo esc_html( $qualifications ); ?></p>
								<?php endif; ?>
							</div>
						</div>
						<?php
					endforeach;
					?>
				</div>
			</section>
			<?php
		endforeach;

		if ( empty( $grouped ) ) :
			?>
			<p class="teaching-staff-empty"><?php esc_html_e( 'Teaching staff details will be added here. Add staff from Admin → Teaching Staff.', 'pasfanc-theme' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();

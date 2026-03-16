<?php
/**
 * President message section - mirrors Principal Message layout
 * Placed after Principal Message on homepage.
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$name    = get_theme_mod( 'pasfanc_president_name', 'Dr. Mrs. Jasmine B A Sangma' );
$image_id = get_theme_mod( 'pasfanc_president_image', 0 );
$message = get_theme_mod( 'pasfanc_president_message', '' );
$img_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
if ( empty( $img_url ) ) {
	$img_url = get_template_directory_uri() . '/assets/images/president-default.png';
}

if ( empty( $message ) ) {
	$message = __( 'Dear students, It is heartening to see PASF Abong Noga College embark on yet another journey of second academic year of its BA Degree Course. The previous years have seen many milestones of which we can be proud of. The Affiliation from NEHU and the successful establishment of an Exam Centre are a few of them besides the routine classes and activities which are carried out for the academic enrichment and to develop the character and intellect of the students. One of the most significant is the process of leading to the adoption of the PASF Abong Noga College as People\'s College by the Government of Meghalaya which will provide financial help and a promise to enhance the educational standards of Meghalaya as a whole.', 'pasfanc-theme' );
}

$president_page = get_page_by_path( 'president-message', OBJECT, 'page' );
$read_more_url  = $president_page ? get_permalink( $president_page ) : home_url( '/administration/' );
?>
<section class="president-section section section-animate section-alt">
	<div class="container">
		<div class="section-header president-section-header">
			<h2 class="section-title"><?php esc_html_e( 'Message from the President', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'A note from the President of the Governing Body.', 'pasfanc-theme' ); ?></p>
		</div>
		<div class="president-card">
			<div class="principal-inner president-inner">
				<?php if ( $img_url ) : ?>
				<div class="principal-image president-image">
					<div class="president-image-frame">
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>">
					</div>
					<p class="president-desk"><?php esc_html_e( 'President\'s Desk', 'pasfanc-theme' ); ?></p>
				</div>
				<?php endif; ?>
				<div class="principal-content president-content">
					<?php if ( ! $img_url ) : ?>
					<p class="president-desk president-desk-text"><?php esc_html_e( 'President\'s Desk', 'pasfanc-theme' ); ?></p>
					<?php endif; ?>
					<h3 class="president-name"><?php echo esc_html( $name ); ?>, <?php echo esc_html( get_theme_mod( 'pasfanc_president_title', 'President, Governing Body' ) ); ?></h3>
					<blockquote class="president-message-excerpt"><?php echo wp_kses_post( wpautop( $message ) ); ?></blockquote>
					<a href="<?php echo esc_url( $read_more_url ); ?>" class="btn btn-president-read"><?php esc_html_e( 'Read more', 'pasfanc-theme' ); ?> &rarr;</a>
				</div>
			</div>
		</div>
	</div>
</section>

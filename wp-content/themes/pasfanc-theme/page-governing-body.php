<?php
/**
 * Template Name: Governing Body
 * Template for page with slug: governing-body
 *
 * Displays the PASF-Abong Noga College Governing Body members with an enhanced table layout.
 *
 * @package pasfanc-theme
 */

get_header();

$members = array(
	array( 'name' => 'Smt. Agatha K. Sangma', 'qualification' => 'Former MP (Lok Sabha)', 'designation' => 'Adviser' ),
	array( 'name' => 'Dr. Jasmine A. Sangma', 'qualification' => 'Ph.D.', 'designation' => 'President of PASF-Abong Noga College' ),
	array( 'name' => 'Shri Mathias N. Marak', 'qualification' => '', 'designation' => 'Vice-President' ),
	array( 'name' => 'Shri J.D. Sangma', 'qualification' => 'M.Sc, M. Div. Th.D.', 'designation' => 'General Secretary' ),
	array( 'name' => 'Shri Raymond A. Sangma', 'qualification' => '', 'designation' => 'Secretary' ),
	array( 'name' => 'Shri Brilliant D. Sangma', 'qualification' => '', 'designation' => 'Joint Secretary' ),
	array( 'name' => 'Shri Eisen H.K. Sangma', 'qualification' => '', 'designation' => 'Treasurer' ),
	array( 'name' => 'Dr. Patrick S.R. Marak', 'qualification' => '', 'designation' => 'Executive Member' ),
	array( 'name' => 'Shri Danny Ch. Marak', 'qualification' => '', 'designation' => 'Executive Member' ),
	array( 'name' => 'Smt. Illa G. Momin', 'qualification' => '', 'designation' => 'Executive Member' ),
	array( 'name' => 'Shri Lonarson Marak', 'qualification' => '', 'designation' => 'Executive Member' ),
	array( 'name' => 'Shri Dabo M. Marak', 'qualification' => '', 'designation' => 'Executive Member' ),
	array( 'name' => 'Smt. Tiana Train D. Arengh', 'qualification' => '', 'designation' => 'Ex-Officio Member' ),
	array( 'name' => 'Smt. Nuri R. Marak', 'qualification' => '', 'designation' => 'Teacher Representative' ),
	array( 'name' => 'Smt. Koyel Roy', 'qualification' => '', 'designation' => 'Teacher Representative' ),
);

?>

<main id="main" class="site-main governing-body-page-main">
	<section class="governing-body-hero">
		<div class="governing-body-hero-overlay"></div>
		<div class="container governing-body-hero-inner">
			<h1 class="governing-body-title"><?php esc_html_e( 'Governing Body', 'pasfanc-theme' ); ?></h1>
			<p class="governing-body-tagline"><?php esc_html_e( 'List of Governing Body Members of PASF-Abong Noga College', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container governing-body-content-wrap">
		<article class="governing-body-article">
			<div class="governing-body-table-wrap">
				<table class="governing-body-table">
					<thead>
						<tr>
							<th scope="col"><?php esc_html_e( 'Sl. No.', 'pasfanc-theme' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Name', 'pasfanc-theme' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Designation', 'pasfanc-theme' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $members as $i => $member ) : ?>
							<tr>
								<td class="gov-serial"><?php echo esc_html( (string) ( $i + 1 ) ); ?></td>
								<td class="gov-name">
									<?php
									echo esc_html( $member['name'] );
									if ( ! empty( $member['qualification'] ) ) {
										echo ' <span class="gov-qualification">(' . esc_html( $member['qualification'] ) . ')</span>';
									}
									?>
								</td>
								<td class="gov-designation"><?php echo esc_html( $member['designation'] ); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</article>
	</div>
</main>

<?php
get_footer();

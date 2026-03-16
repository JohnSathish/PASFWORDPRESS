<?php
/**
 * Template Name: Fee Structure
 * Template for page with slug: fee-structure
 *
 * Displays fee structure for Class XI & XII (Arts & Commerce) and Four Years Under Graduate Courses
 * as per https://pasfanc.ac.in/student-services/fee-structure
 *
 * @package pasfanc-theme
 */

get_header();
?>

<main id="main" class="site-main fee-structure-page-main">
	<!-- Hero banner -->
	<section class="fee-structure-hero">
		<div class="fee-structure-hero-overlay"></div>
		<div class="container fee-structure-hero-inner">
			<h1 class="fee-structure-title"><?php esc_html_e( 'Fee Structure', 'pasfanc-theme' ); ?></h1>
			<p class="fee-structure-tagline"><?php esc_html_e( 'Fee details for Class XI & XII and Four Years Under Graduate Courses', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container fee-structure-content-wrap">
		<article class="fee-structure-article">
			<div class="fee-structure-entry-content">

				<h2><?php esc_html_e( 'Class XI & XII | Arts & Commerce', 'pasfanc-theme' ); ?></h2>
				<div class="fee-structure-table-wrap">
					<table class="fee-structure-table">
						<tbody>
							<tr>
								<td>1. <?php esc_html_e( 'Monthly Tuition Fee', 'pasfanc-theme' ); ?></td>
								<td>&#8377; 700/-</td>
							</tr>
							<tr>
								<td colspan="2">
									<strong>2. <?php esc_html_e( 'Admission Fees', 'pasfanc-theme' ); ?>: &#8377; 2,700/-</strong>
									<ul>
										<li>(i) <?php esc_html_e( 'Internal Examination Fee', 'pasfanc-theme' ); ?> &#8377; 1,000/-</li>
										<li>(j) <?php esc_html_e( 'Co-curriculum Activities', 'pasfanc-theme' ); ?> &#8377; 1,000/-</li>
										<li>(k) <?php esc_html_e( 'Identity Card', 'pasfanc-theme' ); ?> &#8377; 300/-</li>
										<li>(l) <?php esc_html_e( 'College Development Fund', 'pasfanc-theme' ); ?> &#8377; 2,000/-</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td><strong><?php esc_html_e( 'Total Annual Session Fees', 'pasfanc-theme' ); ?></strong></td>
								<td><strong>&#8377; 7,000/-</strong></td>
							</tr>
						</tbody>
					</table>
				</div>

				<h3><?php esc_html_e( 'Payment Schedule', 'pasfanc-theme' ); ?></h3>
				<ol>
					<li><?php esc_html_e( 'Session Fees + Admission Fee + Tuition Fee for one month = &#8377; 7000/- Payable on admission.', 'pasfanc-theme' ); ?></li>
					<li><?php esc_html_e( 'Monthly Tuition Fee of &#8377; 700/- to be paid within the 10th of every month.', 'pasfanc-theme' ); ?></li>
				</ol>

				<h2><?php esc_html_e( 'Four Years Under Graduate Courses', 'pasfanc-theme' ); ?></h2>
				<div class="fee-structure-table-wrap">
					<table class="fee-structure-table">
						<tbody>
							<tr>
								<td>1. <?php esc_html_e( 'Monthly Tuition Fee', 'pasfanc-theme' ); ?></td>
								<td>&#8377; 700/-</td>
							</tr>
							<tr>
								<td colspan="2">
									<strong>2. <?php esc_html_e( 'Admission Fees', 'pasfanc-theme' ); ?>: &#8377; 2,500/-</strong>
									<ul>
										<li>(i) <?php esc_html_e( 'Internal Examination Fee', 'pasfanc-theme' ); ?> &#8377; 1,000/-</li>
										<li>(j) <?php esc_html_e( 'Maintenance Fee', 'pasfanc-theme' ); ?> &#8377; 800/-</li>
										<li>(k) <?php esc_html_e( 'Annual Library Fee', 'pasfanc-theme' ); ?> &#8377; 600/-</li>
										<li>(l) <?php esc_html_e( 'Test & Examination Fees', 'pasfanc-theme' ); ?> &#8377; 800/-</li>
										<li>(m) <?php esc_html_e( 'Identity Card', 'pasfanc-theme' ); ?> &#8377; 350/-</li>
										<li>(n) <?php esc_html_e( 'NEHU Registration Fee', 'pasfanc-theme' ); ?> &#8377; 350/-</li>
										<li>(o) <?php esc_html_e( 'College Development Fund', 'pasfanc-theme' ); ?> &#8377; 2,000/-</li>
										<li>(p) <?php esc_html_e( 'Co-curricular Activities', 'pasfanc-theme' ); ?> &#8377; 600/-</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td><strong><?php esc_html_e( 'Total Annual Session Fees', 'pasfanc-theme' ); ?></strong></td>
								<td><strong>&#8377; 8,000/-</strong></td>
							</tr>
						</tbody>
					</table>
				</div>

				<h3><?php esc_html_e( 'Payment Schedule', 'pasfanc-theme' ); ?></h3>
				<ol>
					<li><?php esc_html_e( 'Session Fees + Admission Fee + Tuition Fee for one month = &#8377; 8000/- Payable on admission.', 'pasfanc-theme' ); ?></li>
					<li><?php esc_html_e( 'Monthly Tuition Fee of &#8377; 700/- to be paid within the 10th of every month.', 'pasfanc-theme' ); ?></li>
				</ol>
			</div>
		</article>

		<div class="fee-structure-cta" style="text-align: center; margin-top: 2rem; padding: 2rem; background: var(--pasf-bg-alt); border-radius: var(--pasf-radius);">
			<h2><?php esc_html_e( 'Apply Now', 'pasfanc-theme' ); ?></h2>
			<p><?php esc_html_e( 'Take the first step towards your future. Join PASF-Abong Noga College today.', 'pasfanc-theme' ); ?></p>
			<a href="<?php echo esc_url( get_theme_mod( 'pasfanc_apply_url', home_url( '/contact/' ) ) ); ?>" class="btn"><?php esc_html_e( 'Apply Now', 'pasfanc-theme' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/downloads/' ) ); ?>" class="btn btn-outline"><?php esc_html_e( 'Prospectus 2026', 'pasfanc-theme' ); ?></a>
		</div>
	</div>
</main>

<?php
get_footer();

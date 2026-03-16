<?php
/**
 * Template Name: Foundation Members
 * Template for page with slug: foundation-members
 *
 * Enhanced layout with hero banner and polished table styling
 * for the foundation members roster.
 *
 * @package pasfanc-theme
 */

get_header();

$foundation_members = array(
	array( 'name' => 'SMTI. SORADINI K. SANGMA', 'occupation' => 'WALBAKGRE, TURA - 794101, MEGHALAYA', 'address' => 'ARAIMILE', 'designation' => 'PRESIDENT', 'mobile' => '9612161712' ),
	array( 'name' => 'DR. CHARLES REUBEN LYNGDOH', 'occupation' => 'POHKSEH, SHILLONG - 793006, MEGHALAYA', 'address' => 'RYNJAH', 'designation' => 'SECRETARY', 'mobile' => '9856334168' ),
	array( 'name' => 'SHRI. SAIDUL ISLAM KHAN', 'occupation' => 'FORESTILLA, TURA - 794001, MEGHALAYA', 'address' => 'CHANDMARY', 'designation' => 'JOINT SECRETARY', 'mobile' => '9101465337' ),
	array( 'name' => 'SMTI. AGATHA K. SANGMA', 'occupation' => 'WALBAKGRE, TURA - 794101, MEGHALAYA', 'address' => 'ARAIMILE', 'designation' => 'TREASURER', 'mobile' => '9958190054' ),
	array( 'name' => 'DR. CHRISTI K. SANGMA', 'occupation' => 'WALBAKGRE, TURA - 794101, MEGHALAYA', 'address' => 'ARAIMILE', 'designation' => 'EXECUTIVE MEMBER', 'mobile' => '9089960908' ),
	array( 'name' => 'DR. METHAB CHANDI A. SANGMA', 'occupation' => 'SS CHAMBERS, DHANKETI, SHILLONG - 793003, MEGHALAYA', 'address' => 'LAITUMKHRAH', 'designation' => 'EXECUTIVE MEMBER', 'mobile' => '7042100003' ),
	array( 'name' => 'SHRI. BRILLIANT D. SANGMA', 'occupation' => 'DAKOPGRE, TURA - 794101, MEGHALAYA', 'address' => 'ARAIMILE', 'designation' => 'EXECUTIVE MEMBER', 'mobile' => '9089603235' ),
	array( 'name' => 'DR. JASMINE B. A. SANGMA', 'occupation' => 'FORESTILLA, TURA - 794001, MEGHALAYA', 'address' => 'CHANDMARY', 'designation' => 'EXECUTIVE MEMBER', 'mobile' => '9436114675' ),
	array( 'name' => 'SHRI. KERLANG MALNGIANG', 'occupation' => 'HM HOUSE, NONGRIM ROAD, LAITUMKHRAH BEAT HOUSE, SHILLONG - 793003, MEGHALAYA', 'address' => 'LAITUMKHRAH', 'designation' => 'EXECUTIVE MEMBER', 'mobile' => '9953432234' ),
);

while ( have_posts() ) :
	the_post();
	$hero_image_id  = get_post_thumbnail_id();
	$hero_image_url = $hero_image_id ? wp_get_attachment_image_url( $hero_image_id, 'large' ) : '';
	?>
<main id="main" class="site-main foundation-members-page-main">
	<!-- Hero banner -->
	<section class="foundation-members-hero"<?php echo $hero_image_url ? ' style="background-image: url(' . esc_url( $hero_image_url ) . ');"' : ''; ?>>
		<div class="foundation-members-hero-overlay"></div>
		<div class="container foundation-members-hero-inner">
			<h1 class="foundation-members-title"><?php the_title(); ?></h1>
			<p class="foundation-members-tagline"><?php esc_html_e( 'Meet the distinguished members of our foundation governing body.', 'pasfanc-theme' ); ?></p>
		</div>
	</section>

	<div class="container foundation-members-content-wrap">
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'foundation-members-article' ); ?>>
			<div class="foundation-members-entry-content">
				<h2><?php esc_html_e( 'MEMBER DETAILS', 'pasfanc-theme' ); ?></h2>
				<div class="foundation-members-table-wrap">
					<table class="foundation-members-table">
						<thead>
							<tr>
								<th scope="col"><?php esc_html_e( 'Sl. No.', 'pasfanc-theme' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Name', 'pasfanc-theme' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Occupation', 'pasfanc-theme' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Address', 'pasfanc-theme' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Designation', 'pasfanc-theme' ); ?></th>
								<th scope="col"><?php esc_html_e( 'Mobile No.', 'pasfanc-theme' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $foundation_members as $i => $member ) : ?>
								<tr>
									<td><?php echo esc_html( (string) ( $i + 1 ) ); ?></td>
									<td><?php echo esc_html( $member['name'] ); ?></td>
									<td><?php echo esc_html( $member['occupation'] ); ?></td>
									<td><?php echo esc_html( $member['address'] ); ?></td>
									<td><?php echo esc_html( $member['designation'] ); ?></td>
									<td><?php echo esc_html( $member['mobile'] ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</article>
	</div>
</main>
	<?php
endwhile;

get_footer();

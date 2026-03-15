<?php
/**
 * Footer template
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_address = get_theme_mod( 'pasfanc_footer_address', "PASF-ABONG NOGA COLLEGE\nUnder People's College Grant-in-Aid\n(Affiliated to the North-Eastern Hills University)\nTura, West Garo Hills, Meghalaya-794101" );
$footer_copyright = get_theme_mod( 'pasfanc_footer_copyright', '© ' . date( 'Y' ) . ' PASF-ABONG NOGA COLLEGE. All Rights Reserved.' );
$maps_url = get_theme_mod( 'pasfanc_maps_url', 'https://maps.app.goo.gl/bV9zFy1t1Jn5q8Du5' );
$maps_embed = get_theme_mod( 'pasfanc_maps_embed', 'https://www.google.com/maps?q=25.502221,90.180934&z=15&output=embed' );
$site_visitors = get_theme_mod( 'pasfanc_show_visitors', true );
$powered_by = get_theme_mod( 'pasfanc_powered_by', 'BaseCode Labs Pvt.Ltd' );
$powered_by_url = get_theme_mod( 'pasfanc_powered_by_url', 'https://basecodelabs.com/' );
$addr_lines = array_filter( array_map( 'trim', explode( "\n", $footer_address ) ) );
$footer_heading = ! empty( $addr_lines ) ? array_shift( $addr_lines ) : get_bloginfo( 'name' );
$footer_details = implode( "\n", $addr_lines );
?>
	<footer id="colophon" class="site-footer">
		<div class="footer-main">
			<div class="container">
				<div class="footer-grid footer-grid-full">
					<div class="footer-col footer-about">
						<div class="footer-about-inner">
							<div class="footer-logo-col">
								<?php
								$footer_logo = get_theme_mod( 'pasfanc_footer_logo', 0 );
								$logo_url = home_url( '/' );
								$logo_alt = esc_attr( get_bloginfo( 'name' ) );
								if ( $footer_logo ) {
									echo '<a href="' . esc_url( $logo_url ) . '" class="footer-logo-link" aria-label="' . esc_attr__( 'Home', 'pasfanc-theme' ) . '">';
									echo wp_get_attachment_image( (int) $footer_logo, 'medium', false, array( 'class' => 'footer-logo', 'alt' => $logo_alt ) );
									echo '</a>';
								} elseif ( has_custom_logo() ) {
									echo '<div class="footer-logo-wrap">';
									the_custom_logo();
									echo '</div>';
								} elseif ( file_exists( get_theme_file_path( 'assets/images/logo.png' ) ) ) {
									$default_logo = get_theme_file_uri( 'assets/images/logo.png' );
									echo '<a href="' . esc_url( $logo_url ) . '" class="footer-logo-link" aria-label="' . esc_attr__( 'Home', 'pasfanc-theme' ) . '">';
									echo '<img src="' . esc_url( $default_logo ) . '" alt="' . $logo_alt . '" class="footer-logo" width="140" height="140" loading="lazy">';
									echo '</a>';
								}
								?>
							</div>
							<div class="footer-info-col">
								<h2 class="footer-brand"><?php echo esc_html( $footer_heading ); ?></h2>
								<address class="footer-address"><?php echo wp_kses_post( nl2br( esc_html( $footer_details ) ) ); ?></address>
							</div>
						</div>
					</div>
					<div class="footer-col footer-links-col">
						<h4 class="footer-links-title"><?php esc_html_e( 'QUICK LINKS', 'pasfanc-theme' ); ?></h4>
						<?php
						if ( has_nav_menu( 'footer_quick' ) ) {
							wp_nav_menu( array( 'theme_location' => 'footer_quick', 'container' => false ) );
						} else {
							echo '<ul class="footer-menu">';
							echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'pasfanc-theme' ) . '</a></li>';
							echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">' . esc_html__( 'About Us', 'pasfanc-theme' ) . '</a></li>';
							echo '<li><a href="' . esc_url( home_url( '/academics/' ) ) . '">' . esc_html__( 'Academics', 'pasfanc-theme' ) . '</a></li>';
							echo '<li><a href="' . esc_url( home_url( '/gallery/' ) ) . '">' . esc_html__( 'Gallery', 'pasfanc-theme' ) . '</a></li>';
							echo '<li><a href="' . esc_url( home_url( '/downloads/' ) ) . '">' . esc_html__( 'Downloads', 'pasfanc-theme' ) . '</a></li>';
							echo '</ul>';
						}
						?>
					</div>
					<div class="footer-col footer-links-col">
						<h4 class="footer-links-title"><?php esc_html_e( 'STUDENTS', 'pasfanc-theme' ); ?></h4>
						<?php
						if ( has_nav_menu( 'footer_students' ) ) {
							wp_nav_menu( array( 'theme_location' => 'footer_students', 'container' => false ) );
						} else {
							echo '<ul class="footer-menu">';
							echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact Us', 'pasfanc-theme' ) . '</a></li>';
							echo '<li><a href="' . esc_url( home_url( '/gallery/' ) ) . '">' . esc_html__( 'Gallery', 'pasfanc-theme' ) . '</a></li>';
							echo '<li><a href="' . esc_url( home_url( '/student-services/' ) ) . '">' . esc_html__( 'Student Services', 'pasfanc-theme' ) . '</a></li>';
							echo '</ul>';
						}
						?>
					</div>
					<div class="footer-col footer-find">
						<h4 class="footer-links-title"><?php esc_html_e( 'FIND US', 'pasfanc-theme' ); ?></h4>
						<?php if ( $maps_embed ) : ?>
							<div class="footer-map-wrap">
								<iframe src="<?php echo esc_url( $maps_embed ); ?>" width="100%" height="200" style="border:0;border-radius:8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php esc_attr_e( 'College location on map', 'pasfanc-theme' ); ?>"></iframe>
							</div>
							<p class="footer-map-link"><a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Open in Google Maps', 'pasfanc-theme' ); ?></a></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="container">
				<p class="copyright"><?php echo wp_kses_post( $footer_copyright ); ?></p>
				<div class="footer-bottom-extra">
					<?php if ( $site_visitors ) : ?>
						<p class="site-visitors"><?php esc_html_e( 'Site Visitors:', 'pasfanc-theme' ); ?> <?php echo absint( get_option( 'pasfanc_visitor_count', 0 ) ); ?></p>
					<?php endif; ?>
					<?php if ( $powered_by ) : ?>
						<p class="powered-by"><?php esc_html_e( 'Powered by:', 'pasfanc-theme' ); ?>
							<?php if ( $powered_by_url ) : ?>
								<a href="<?php echo esc_url( $powered_by_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $powered_by ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $powered_by ); ?>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</footer>

	<!-- Back to top button -->
	<button type="button" id="back-to-top" class="back-to-top-btn" aria-label="<?php esc_attr_e( 'Scroll to top', 'pasfanc-theme' ); ?>" title="<?php esc_attr_e( 'Back to top', 'pasfanc-theme' ); ?>">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
	</button>

</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>

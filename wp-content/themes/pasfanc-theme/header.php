<?php
/**
 * Header template
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<?php
	$top_email   = get_theme_mod( 'pasfanc_top_email', 'pasfabongnogacollege@gmail.com' );
	$top_phone   = get_theme_mod( 'pasfanc_top_phone', '+91 97741 09207' );
	$aqar_url    = get_theme_mod( 'pasfanc_aqar_url', home_url( '/aqar/' ) );
	$iqac_url    = get_theme_mod( 'pasfanc_iqac_url', home_url( '/iqac/' ) );
	$naac_url    = get_theme_mod( 'pasfanc_naac_url', home_url( '/naac/' ) );
	$nirf_url    = get_theme_mod( 'pasfanc_nirf_url', home_url( '/administration/nirf/' ) );
	?>
	<!-- Top Bar -->
	<div class="top-bar">
		<div class="container top-bar-inner">
			<div class="top-bar-left">
				<?php if ( $top_email ) : ?>
					<a href="mailto:<?php echo esc_attr( sanitize_email( $top_email ) ); ?>" class="top-bar-contact">
						<svg class="top-bar-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						<span><?php echo esc_html( $top_email ); ?></span>
					</a>
				<?php endif; ?>
				<?php if ( $top_phone ) : ?>
					<?php if ( $top_email ) : ?><span class="top-bar-sep">|</span><?php endif; ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $top_phone ) ); ?>" class="top-bar-contact">
						<svg class="top-bar-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
						<span><?php echo esc_html( $top_phone ); ?></span>
					</a>
				<?php endif; ?>
			</div>
			<div class="top-bar-right">
				<a href="<?php echo esc_url( $aqar_url ); ?>">AQAR</a>
				<span class="top-bar-sep">|</span>
				<a href="<?php echo esc_url( $iqac_url ); ?>">IQAC</a>
				<span class="top-bar-sep">|</span>
				<a href="<?php echo esc_url( $naac_url ); ?>">NAAC</a>
				<span class="top-bar-sep">|</span>
				<a href="<?php echo esc_url( $nirf_url ); ?>">NIRF</a>
			</div>
		</div>
	</div>

	<!-- Branding Banner: Logo + Address (dark green) -->
	<div class="branding-banner">
		<div class="container branding-inner">
			<div class="branding-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pasf-logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="college-logo">
					<?php endif; ?>
				</a>
			</div>
			<div class="branding-info">
				<?php
				$college_name   = get_bloginfo( 'name' );
				$college_grant  = get_theme_mod( 'pasfanc_college_grant', "Under People's College Grant-in-Aid" );
				$college_affil  = get_theme_mod( 'pasfanc_college_affiliation', '(Affiliated to the North-Eastern Hills University)' );
				$college_addr   = get_theme_mod( 'pasfanc_college_address', 'Tura, West Garo Hills, Meghalaya-794101' );
				?>
				<h1 class="college-name"><?php echo esc_html( $college_name ); ?></h1>
				<p class="college-grant"><?php echo esc_html( $college_grant ); ?></p>
				<p class="college-affiliation"><?php echo esc_html( $college_affil ); ?></p>
				<p class="college-address"><span class="location-icon">&#128205;</span> <?php echo esc_html( $college_addr ); ?></p>
			</div>
			<?php
			$motto = get_theme_mod( 'pasfanc_motto', 'To Educate, To Change, To Grow & To Live' );
			if ( $motto ) :
				?>
			<div class="branding-motto">
				<p class="motto-label"><?php esc_html_e( 'Motto', 'pasfanc-theme' ); ?></p>
				<p class="motto-text"><?php echo esc_html( $motto ); ?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<header id="masthead" class="site-header">
		<div class="container header-inner">
			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'pasfanc-theme' ); ?>">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'pasfanc-theme' ); ?>">
					<span class="menu-toggle-icon"></span>
				</button>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'nav-menu',
					'container'      => false,
					'fallback_cb'    => 'pasfanc_default_menu',
				) );
				?>
			</nav>
		</div>
	</header>

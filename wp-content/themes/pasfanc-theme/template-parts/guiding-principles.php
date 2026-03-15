<?php
/**
 * Guiding Principles section
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$motto   = get_theme_mod( 'pasfanc_motto', 'To Educate, To Change, To Grow & To Live' );
$vision  = get_theme_mod( 'pasfanc_vision', 'To be "an agent of change" to empower the people socially, economically, through education, training and awareness programs, to create awareness of the intrinsic value of their culture, tradition so as to strengthen the consciousness and preserve the same.' );
$mission = get_theme_mod( 'pasfanc_mission', 'The College will work towards providing opportunities through education and training by setting up such institution and also by deputing to such other institutions, conduct research and study of the best practices prevalent among the indigenous tribe of the region and to share the same with the world.' );
$aims    = array();
for ( $i = 1; $i <= 6; $i++ ) {
	$aim = get_theme_mod( 'pasfanc_aim_' . $i, '' );
	if ( $aim ) {
		$aims[] = $aim;
	}
}
if ( empty( $aims ) ) {
	$aims = array(
		__( 'To prepare students to become independent and life-long learners.', 'pasfanc-theme' ),
		__( 'To promote creativity, confidence and determination.', 'pasfanc-theme' ),
		__( 'To encourage students to realise the value of time.', 'pasfanc-theme' ),
		__( 'To develop self-esteem and mutual respect.', 'pasfanc-theme' ),
		__( 'To promote the idea of tolerance and acceptability.', 'pasfanc-theme' ),
		__( 'Advice will be given to promote value education.', 'pasfanc-theme' ),
	);
}
?>
<section class="guiding-section section section-alt section-animate">
	<div class="container">
		<div class="section-header">
			<h2 class="section-title"><?php esc_html_e( 'Our Guiding Principles', 'pasfanc-theme' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Vision, Mission and core values that guide our academic and student development journey.', 'pasfanc-theme' ); ?></p>
		</div>
		<div class="guiding-grid guiding-grid-animate">
			<div class="guiding-card guiding-card-motto-aim guiding-card-1">
				<div class="motto-aim-inner">
					<div class="motto-block">
						<span class="guiding-icon guiding-icon-motto" aria-hidden="true"></span>
						<h3><?php esc_html_e( 'Our Motto', 'pasfanc-theme' ); ?></h3>
						<p class="motto-text"><?php echo esc_html( $motto ); ?></p>
					</div>
					<div class="aim-block">
						<span class="guiding-icon guiding-icon-aim" aria-hidden="true"></span>
						<h3><?php esc_html_e( 'Our Aim', 'pasfanc-theme' ); ?></h3>
						<ul class="aim-list">
							<?php foreach ( $aims as $idx => $aim ) : ?>
								<li data-num="<?php echo esc_attr( ( $idx + 1 ) . '. ' ); ?>"><?php echo esc_html( $aim ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="guiding-card guiding-card-vision guiding-card-2">
				<span class="guiding-icon guiding-icon-vision" aria-hidden="true"></span>
				<h3><?php esc_html_e( 'Vision', 'pasfanc-theme' ); ?></h3>
				<p class="guiding-sub"><?php esc_html_e( 'Our Future Focus', 'pasfanc-theme' ); ?></p>
				<p><?php echo esc_html( $vision ); ?></p>
			</div>
			<div class="guiding-card guiding-card-mission guiding-card-3">
				<span class="guiding-icon guiding-icon-mission" aria-hidden="true"></span>
				<h3><?php esc_html_e( 'Mission', 'pasfanc-theme' ); ?></h3>
				<p class="guiding-sub"><?php esc_html_e( 'What We Do Daily', 'pasfanc-theme' ); ?></p>
				<p><?php echo esc_html( $mission ); ?></p>
			</div>
		</div>
	</div>
</section>

<?php
/**
 * Quick Facts stats bar - shown between hero and about on front page
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! get_theme_mod( 'pasfanc_stats_enabled', true ) ) {
	return;
}

$stats = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$label = get_theme_mod( 'pasfanc_stat_label_' . $i, '' );
	$value = get_theme_mod( 'pasfanc_stat_value_' . $i, '' );
	if ( $value || $label ) {
		$stats[] = array(
			'label' => $label ?: sprintf( __( 'Stat %d', 'pasfanc-theme' ), $i ),
			'value' => $value ?: '—',
		);
	}
}

if ( empty( $stats ) ) {
	$stats = array(
		array( 'label' => __( 'Years of Excellence', 'pasfanc-theme' ), 'value' => '10+' ),
		array( 'label' => __( 'Students', 'pasfanc-theme' ), 'value' => '500+' ),
		array( 'label' => __( 'Courses', 'pasfanc-theme' ), 'value' => '15+' ),
		array( 'label' => __( 'Faculty', 'pasfanc-theme' ), 'value' => '30+' ),
	);
}
$welcome = get_theme_mod( 'pasfanc_stats_welcome', 'Welcome to P.A.S.F Abong Noga College' );
?>
<section class="quick-facts-section" aria-label="<?php esc_attr_e( 'College at a glance', 'pasfanc-theme' ); ?>">
	<div class="container">
		<div class="quick-facts-grid">
			<?php foreach ( $stats as $stat ) :
				$raw = preg_replace( '/[^0-9]/', '', $stat['value'] );
				$suffix = preg_replace( '/^[0-9]+/', '', $stat['value'] );
				$data_target = ( $raw !== '' ) ? $stat['value'] : '';
				?>
				<div class="quick-fact-item">
					<span class="quick-fact-value"<?php echo $data_target ? ' data-target="' . esc_attr( $stat['value'] ) . '"' : ''; ?>><?php echo esc_html( $stat['value'] ); ?></span>
					<span class="quick-fact-label"><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ( $welcome ) : ?>
			<div class="quick-facts-welcome">
				<p class="quick-facts-welcome-text"><?php echo esc_html( $welcome ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

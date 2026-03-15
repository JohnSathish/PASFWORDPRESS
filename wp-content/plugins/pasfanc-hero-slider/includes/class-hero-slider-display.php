<?php
/**
 * Hero Slider shortcode and front-end display
 *
 * @package pasfanc-hero-slider
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasf_Hero_Slider_Display {

	public static function init() {
		add_shortcode( 'pasf_hero_slider', array( __CLASS__, 'shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	public static function enqueue_assets() {
		/* Enqueue when shortcode is in post content or on front page (theme hero template) */
		if ( self::has_shortcode() || is_front_page() ) {
			self::do_enqueue();
		}
	}

	public static function do_enqueue() {
		wp_enqueue_style(
			'pasf-hero-slider',
			PASF_HERO_SLIDER_URI . 'assets/css/hero-slider.css',
			array(),
			PASF_HERO_SLIDER_VERSION
		);
		wp_enqueue_script(
			'pasf-hero-slider',
			PASF_HERO_SLIDER_URI . 'assets/js/hero-slider.js',
			array(),
			PASF_HERO_SLIDER_VERSION,
			true
		);
	}

	private static function has_shortcode() {
		global $post;
		return $post && has_shortcode( $post->post_content, 'pasf_hero_slider' );
	}

	public static function shortcode( $atts = array() ) {
		$atts = shortcode_atts( array(
			'autoplay' => 'true',
			'delay'    => '5000',
			'height'   => '680',
		), $atts, 'pasf_hero_slider' );

		$slides = get_posts( array(
			'post_type'      => 'pasf_hero_slide',
			'posts_per_page' => 20,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		) );

		$valid_slides = array();
		foreach ( $slides as $slide ) {
			$image_id = get_post_meta( $slide->ID, '_pasf_hero_image_id', true );
			if ( $image_id ) {
				$valid_slides[] = $slide;
			}
		}

		if ( empty( $valid_slides ) ) {
			return '';
		}

		ob_start();
		?>
		<section class="pasf-hero-slider" data-autoplay="<?php echo esc_attr( $atts['autoplay'] ); ?>" data-delay="<?php echo esc_attr( $atts['delay'] ); ?>" style="height: <?php echo absint( $atts['height'] ); ?>px;">
			<div class="pasf-hero-slider-track">
				<?php foreach ( $valid_slides as $index => $slide ) : ?>
					<?php
					$image_id  = get_post_meta( $slide->ID, '_pasf_hero_image_id', true );
					$title     = get_post_meta( $slide->ID, '_pasf_hero_title', true );
					$read_more = get_post_meta( $slide->ID, '_pasf_hero_read_more_url', true );
					$img_url   = wp_get_attachment_image_url( $image_id, 'full' );
					if ( ! $img_url ) {
						continue;
					}
					$active = 0 === $index ? ' active' : '';
					?>
					<div class="pasf-hero-slide<?php echo esc_attr( $active ); ?>" data-index="<?php echo (int) $index; ?>">
						<div class="pasf-hero-slide-bg" style="background-image: url('<?php echo esc_url( $img_url ); ?>');"></div>
						<div class="pasf-hero-slide-overlay">
							<?php if ( $title ) : ?>
								<h2 class="pasf-hero-slide-title"><?php echo esc_html( $title ); ?></h2>
							<?php endif; ?>
							<?php if ( $read_more ) : ?>
								<a href="<?php echo esc_url( $read_more ); ?>" class="pasf-hero-slide-btn"><?php esc_html_e( 'Read More', 'pasfanc-hero-slider' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if ( count( $valid_slides ) > 1 ) : ?>
				<button type="button" class="pasf-hero-slider-nav pasf-hero-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'pasfanc-hero-slider' ); ?>">‹</button>
				<button type="button" class="pasf-hero-slider-nav pasf-hero-next" aria-label="<?php esc_attr_e( 'Next slide', 'pasfanc-hero-slider' ); ?>">›</button>
				<div class="pasf-hero-slider-dots">
					<?php foreach ( $valid_slides as $i => $slide ) : ?>
						<button type="button" class="pasf-hero-dot<?php echo 0 === $i ? ' active' : ''; ?>" data-index="<?php echo (int) $i; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'pasfanc-hero-slider' ), $i + 1 ) ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>
		<?php
		return ob_get_clean();
	}

	/**
	 * Template tag for themes
	 */
	public static function render() {
		echo do_shortcode( '[pasf_hero_slider]' );
	}
}

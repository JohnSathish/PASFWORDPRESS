<?php
/**
 * Meta boxes for Hero Slide - Image, Title (optional), Read More URL (optional)
 *
 * @package pasfanc-hero-slider
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasf_Hero_Slider_Meta {

	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post_pasf_hero_slide', array( __CLASS__, 'save_meta' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
	}

	public static function add_meta_boxes() {
		add_meta_box(
			'pasf_hero_slide_details',
			__( 'Slide Details', 'pasfanc-hero-slider' ),
			array( __CLASS__, 'render_meta_box' ),
			'pasf_hero_slide',
			'normal'
		);
	}

	public static function admin_scripts( $hook ) {
		if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
			return;
		}
		global $post_type;
		if ( 'pasf_hero_slide' !== $post_type ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script(
			'pasf-hero-slider-admin',
			PASF_HERO_SLIDER_URI . 'assets/js/admin.js',
			array( 'jquery' ),
			PASF_HERO_SLIDER_VERSION,
			true
		);
	}

	public static function render_meta_box( $post ) {
		wp_nonce_field( 'pasf_hero_slide_meta', 'pasf_hero_slide_meta_nonce' );

		$image_id  = get_post_meta( $post->ID, '_pasf_hero_image_id', true );
		$title     = get_post_meta( $post->ID, '_pasf_hero_title', true );
		$read_more = get_post_meta( $post->ID, '_pasf_hero_read_more_url', true );
		$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium_large' ) : '';
		?>
		<p>
			<strong><?php esc_html_e( 'Slide Image', 'pasfanc-hero-slider' ); ?></strong>
			<span class="description"><?php esc_html_e( '(Required for display)', 'pasfanc-hero-slider' ); ?></span>
		</p>
		<p>
			<input type="hidden" id="pasf_hero_image_id" name="pasf_hero_image_id" value="<?php echo esc_attr( $image_id ); ?>" />
			<button type="button" class="button pasf-hero-upload-image" id="pasf_hero_upload_btn">
				<?php esc_html_e( 'Upload Image', 'pasfanc-hero-slider' ); ?>
			</button>
			<button type="button" class="button pasf-hero-remove-image" id="pasf_hero_remove_btn" style="<?php echo $image_id ? '' : 'display:none;'; ?>">
				<?php esc_html_e( 'Remove Image', 'pasfanc-hero-slider' ); ?>
			</button>
		</p>
		<p id="pasf_hero_image_preview">
			<?php if ( $image_url ) : ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="" style="max-width: 100%; max-height: 300px; display: block;" />
			<?php endif; ?>
		</p>

		<p style="margin-top: 1.5em;">
			<label for="pasf_hero_title"><strong><?php esc_html_e( 'Title', 'pasfanc-hero-slider' ); ?></strong></label>
			<span class="description"><?php esc_html_e( '(Optional)', 'pasfanc-hero-slider' ); ?></span><br />
			<input type="text" id="pasf_hero_title" name="pasf_hero_title" value="<?php echo esc_attr( $title ); ?>" class="widefat" style="margin-top: 4px;" />
		</p>

		<p>
			<label for="pasf_hero_read_more_url"><strong><?php esc_html_e( 'Read More URL', 'pasfanc-hero-slider' ); ?></strong></label>
			<span class="description"><?php esc_html_e( '(Optional)', 'pasfanc-hero-slider' ); ?></span><br />
			<input type="url" id="pasf_hero_read_more_url" name="pasf_hero_read_more_url" value="<?php echo esc_url( $read_more ); ?>" class="widefat" style="margin-top: 4px;" placeholder="https://" />
		</p>

		<p class="description">
			<?php esc_html_e( 'Use "Order" (Page Attributes) to control slide order. Lower numbers appear first.', 'pasfanc-hero-slider' ); ?>
		</p>
		<?php
	}

	public static function save_meta( $post_id, $post ) {
		if ( ! isset( $_POST['pasf_hero_slide_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_hero_slide_meta_nonce'] ) ), 'pasf_hero_slide_meta' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$image_id = isset( $_POST['pasf_hero_image_id'] ) ? absint( $_POST['pasf_hero_image_id'] ) : 0;
		$title    = isset( $_POST['pasf_hero_title'] ) ? sanitize_text_field( wp_unslash( $_POST['pasf_hero_title'] ) ) : '';
		$read_more = isset( $_POST['pasf_hero_read_more_url'] ) ? esc_url_raw( wp_unslash( $_POST['pasf_hero_read_more_url'] ) ) : '';

		update_post_meta( $post_id, '_pasf_hero_image_id', $image_id );
		update_post_meta( $post_id, '_pasf_hero_title', $title );
		update_post_meta( $post_id, '_pasf_hero_read_more_url', $read_more );
	}
}

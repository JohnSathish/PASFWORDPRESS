<?php
/**
 * Shortcodes for PASF College
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'pasf_contact_form', array( 'Pasfanc_Shortcodes', 'contact_form' ) );
add_shortcode( 'pasf_flash_news', array( 'Pasfanc_Shortcodes', 'flash_news' ) );

class Pasfanc_Shortcodes {

	/**
	 * Contact form shortcode
	 */
	public static function contact_form( $atts ) {
		$atts   = shortcode_atts( array(
			'title' => __( 'Send a Message', 'pasfanc-college' ),
		), $atts, 'pasf_contact_form' );
		$result = null;
		if ( isset( $_POST['pasf_contact_submit'] ) ) {
			$result = Pasfanc_Shortcodes::handle_contact_form();
			if ( $result['success'] ) {
				return '<div class="pasf-contact-success">' . esc_html( $result['message'] ) . '</div>';
			}
		}

		ob_start();
		?>
		<div class="pasf-contact-form-wrap">
			<?php if ( $result && ! empty( $result['error'] ) && ! empty( $result['message'] ) ) : ?>
				<div class="pasf-contact-error"><?php echo esc_html( $result['message'] ); ?></div>
			<?php endif; ?>
			<h3><?php echo esc_html( $atts['title'] ); ?></h3>
			<form method="post" class="pasf-contact-form">
				<?php wp_nonce_field( 'pasf_contact_form', 'pasf_contact_nonce' ); ?>
				<p>
					<label for="pasf_contact_name"><?php esc_html_e( 'Your Name', 'pasfanc-college' ); ?> *</label><br>
					<input type="text" id="pasf_contact_name" name="pasf_contact_name" required value="<?php echo isset( $_POST['pasf_contact_name'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['pasf_contact_name'] ) ) ) : ''; ?>">
				</p>
				<p>
					<label for="pasf_contact_email"><?php esc_html_e( 'Email Address', 'pasfanc-college' ); ?> *</label><br>
					<input type="email" id="pasf_contact_email" name="pasf_contact_email" required value="<?php echo isset( $_POST['pasf_contact_email'] ) ? esc_attr( sanitize_email( wp_unslash( $_POST['pasf_contact_email'] ) ) ) : ''; ?>">
				</p>
				<p>
					<label for="pasf_contact_subject"><?php esc_html_e( 'Subject', 'pasfanc-college' ); ?> *</label><br>
					<input type="text" id="pasf_contact_subject" name="pasf_contact_subject" required value="<?php echo isset( $_POST['pasf_contact_subject'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['pasf_contact_subject'] ) ) ) : ''; ?>">
				</p>
				<p>
					<label for="pasf_contact_message"><?php esc_html_e( 'Message', 'pasfanc-college' ); ?> *</label><br>
					<textarea id="pasf_contact_message" name="pasf_contact_message" rows="5" required><?php echo isset( $_POST['pasf_contact_message'] ) ? esc_textarea( wp_unslash( $_POST['pasf_contact_message'] ) ) : ''; ?></textarea>
				</p>
				<p>
					<button type="submit" name="pasf_contact_submit" class="btn"><?php esc_html_e( 'Send Message', 'pasfanc-college' ); ?></button>
				</p>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}

	public static function handle_contact_form() {
		if ( ! isset( $_POST['pasf_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_contact_nonce'] ) ), 'pasf_contact_form' ) ) {
			return array( 'success' => false, 'error' => true, 'message' => __( 'Security check failed. Please try again.', 'pasfanc-college' ) );
		}

		$name    = isset( $_POST['pasf_contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['pasf_contact_name'] ) ) : '';
		$email   = isset( $_POST['pasf_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['pasf_contact_email'] ) ) : '';
		$subject = isset( $_POST['pasf_contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['pasf_contact_subject'] ) ) : '';
		$message = isset( $_POST['pasf_contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pasf_contact_message'] ) ) : '';

		if ( ! $name || ! $email || ! $subject || ! $message ) {
			return array( 'success' => false, 'error' => true, 'message' => __( 'All fields are required.', 'pasfanc-college' ) );
		}

		if ( ! is_email( $email ) ) {
			return array( 'success' => false, 'error' => true, 'message' => __( 'Please enter a valid email address.', 'pasfanc-college' ) );
		}

		$to      = get_option( 'admin_email' );
		$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>' );
		$body    = sprintf(
			"Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s",
			$name,
			$email,
			$subject,
			$message
		);

		$sent = wp_mail( $to, '[' . get_bloginfo( 'name' ) . '] ' . $subject, $body, $headers );

		if ( $sent ) {
			return array( 'success' => true, 'error' => false, 'message' => __( 'Thank you. Your message has been sent.', 'pasfanc-college' ) );
		}
		return array( 'success' => false, 'error' => true, 'message' => __( 'Sorry, we could not send your message. Please try again later.', 'pasfanc-college' ) );
	}

	/**
	 * Flash news ticker shortcode
	 */
	public static function flash_news( $atts ) {
		$atts = shortcode_atts( array(
			'limit' => 10,
		), $atts, 'pasf_flash_news' );

		$items = get_posts( array(
			'post_type'      => 'pasf_flash',
			'posts_per_page' => absint( $atts['limit'] ),
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		) );

		if ( empty( $items ) ) {
			return '';
		}

		ob_start();
		?>
		<div class="pasf-flash-news-ticker" role="marquee" aria-live="polite">
			<span class="pasf-flash-label"><?php esc_html_e( 'Flash News', 'pasfanc-college' ); ?></span>
			<div class="pasf-flash-track">
				<?php
					$new_badge_url  = apply_filters( 'pasf_flash_new_badge_url', get_template_directory_uri() . '/assets/images/new-badge.gif' );
					$new_badge_path = get_template_directory() . '/assets/images/new-badge.gif';
					$use_badge_img  = file_exists( $new_badge_path );
					foreach ( $items as $item ) :
						$link    = get_post_meta( $item->ID, '_pasf_flash_link', true );
						$pdf_id  = absint( get_post_meta( $item->ID, '_pasf_flash_pdf', true ) );
						$pdf_url = $pdf_id ? wp_get_attachment_url( $pdf_id ) : '';
						$thumb   = get_the_post_thumbnail( $item->ID, 'thumbnail' );
						$text    = ! empty( $item->post_excerpt ) ? $item->post_excerpt : wp_trim_words( wp_strip_all_tags( $item->post_content ), 15 );
						// Priority: custom link > PDF > Flash News detail page (permalink)
						$item_url = $link ? $link : ( $pdf_url ? $pdf_url : get_permalink( $item ) );
						$item_tag = 'a';
						?>
					<<?php echo esc_html( $item_tag ); ?> class="pasf-flash-item" <?php
						if ( $item_url ) {
							$is_external = ( 0 !== strpos( $item_url, home_url( '/' ) ) );
							echo 'href="' . esc_url( $item_url ) . '"';
							if ( $is_external ) {
								echo ' target="_blank" rel="noopener"';
							}
						}
						?>>
						<span class="pasf-flash-item-new-badge">
							<img src="<?php echo esc_url( $new_badge_url ); ?>" alt="NEW!" width="32" height="32">
						</span>
						<?php if ( $thumb ) : ?>
							<span class="pasf-flash-item-img"><?php echo wp_kses_post( $thumb ); ?></span>
						<?php endif; ?>
						<span class="pasf-flash-item-text">
							<?php echo esc_html( $item->post_title ); ?>
							<?php if ( $text ) : ?>
								<span class="pasf-flash-item-desc"><?php echo esc_html( $text ); ?></span>
							<?php endif; ?>
							<?php if ( $pdf_url && $link ) : ?>
								<span class="pasf-flash-item-pdf" role="button" tabindex="0" data-pdf="<?php echo esc_url( $pdf_url ); ?>" onclick="event.stopPropagation(); window.open(this.getAttribute('data-pdf'));"><?php esc_html_e( 'View PDF', 'pasfanc-college' ); ?></span>
							<?php elseif ( $pdf_url && ! $link ) : ?>
								<span class="pasf-flash-item-pdf-hint"><?php esc_html_e( 'View PDF', 'pasfanc-college' ); ?></span>
							<?php endif; ?>
						</span>
					</<?php echo esc_html( $item_tag ); ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

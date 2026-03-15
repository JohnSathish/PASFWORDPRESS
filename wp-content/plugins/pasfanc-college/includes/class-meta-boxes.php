<?php
/**
 * Meta boxes for custom post types
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_Meta_Boxes {

	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post', array( __CLASS__, 'save_meta_boxes' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_gallery_admin_scripts' ) );
	}

	public static function add_meta_boxes() {
		add_meta_box(
			'pasf_news_details',
			__( 'News Details', 'pasfanc-college' ),
			array( __CLASS__, 'render_news_meta' ),
			'pasf_news',
			'normal'
		);
		add_meta_box(
			'pasf_event_details',
			__( 'Event Details', 'pasfanc-college' ),
			array( __CLASS__, 'render_event_meta' ),
			'pasf_event',
			'side',
			'high'
		);
		add_meta_box(
			'pasf_testimonial_details',
			__( 'Testimonial Details', 'pasfanc-college' ),
			array( __CLASS__, 'render_testimonial_meta' ),
			'pasf_testimonial',
			'normal'
		);
		add_meta_box(
			'pasf_course_details',
			__( 'Course Details', 'pasfanc-college' ),
			array( __CLASS__, 'render_course_meta' ),
			'pasf_course',
			'normal'
		);
		add_meta_box(
			'pasf_flash_details',
			__( 'Flash News Details', 'pasfanc-college' ),
			array( __CLASS__, 'render_flash_meta' ),
			'pasf_flash',
			'normal'
		);
		add_meta_box(
			'pasf_download_details',
			__( 'Download Details', 'pasfanc-college' ),
			array( __CLASS__, 'render_download_meta' ),
			'pasf_download',
			'normal'
		);
		add_meta_box(
			'pasf_gallery_images',
			__( 'Gallery Photos', 'pasfanc-college' ),
			array( __CLASS__, 'render_gallery_images' ),
			'pasf_gallery',
			'normal',
			'high'
		);
		add_meta_box(
			'pasf_gallery_help',
			__( 'How to Add Gallery Photos', 'pasfanc-college' ),
			array( __CLASS__, 'render_gallery_help' ),
			'pasf_gallery',
			'side',
			'default'
		);
		add_meta_box(
			'pasf_staff_details',
			__( 'Staff Details', 'pasfanc-college' ),
			array( __CLASS__, 'render_staff_meta' ),
			'pasf_staff',
			'normal'
		);
	}

	/**
	 * Enqueue admin scripts for gallery, flash news, and downloads.
	 */
	public static function enqueue_gallery_admin_scripts( $hook ) {
		$screen = get_current_screen();
		if ( ! $screen || 'post' !== $screen->base ) {
			return;
		}
		$load_gallery = ( 'pasf_gallery' === $screen->post_type );
		$load_media = ( 'pasf_flash' === $screen->post_type || 'pasf_download' === $screen->post_type || 'pasf_staff' === $screen->post_type );

		if ( $load_gallery ) {
			wp_enqueue_media();
			wp_enqueue_script(
				'pasf-gallery-admin',
				PASFANC_COLLEGE_URI . 'assets/js/gallery-admin.js',
				array( 'jquery' ),
				PASFANC_COLLEGE_VERSION,
				true
			);
		}
		if ( $load_media ) {
			wp_enqueue_media();
			wp_enqueue_script(
				'pasf-admin-media',
				PASFANC_COLLEGE_URI . 'assets/js/admin-media.js',
				array( 'jquery' ),
				PASFANC_COLLEGE_VERSION,
				true
			);
		}
	}

	public static function render_gallery_images( $post ) {
		wp_nonce_field( 'pasf_gallery_images', 'pasf_gallery_images_nonce' );
		$images = get_post_meta( $post->ID, '_pasf_gallery_images', true );
		if ( ! is_array( $images ) ) {
			$images = array();
		}
		$images = array_filter( array_map( 'absint', $images ) );
		?>
		<p class="description"><?php esc_html_e( 'Add multiple photos to this gallery item. The Featured Image (sidebar) is the main/cover photo. Use the button below to add more photos.', 'pasfanc-college' ); ?></p>
		<p>
			<button type="button" id="pasf-gallery-add-images" class="button button-primary"><?php esc_html_e( 'Add Photos', 'pasfanc-college' ); ?></button>
			<span id="pasf-gallery-add-images-spinner" class="spinner" style="float: none; margin: 0 0 0 8px; display: none;"></span>
		</p>
		<input type="hidden" id="pasf_gallery_images" name="pasf_gallery_images" value="<?php echo esc_attr( implode( ',', $images ) ); ?>">
		<div id="pasf-gallery-images-preview" class="pasf-gallery-images-preview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px;">
			<?php foreach ( $images as $img_id ) : ?>
				<?php
				$img = wp_get_attachment_image_src( $img_id, 'thumbnail' );
				if ( $img ) :
					?>
					<div class="pasf-gallery-preview-item" data-id="<?php echo esc_attr( $img_id ); ?>" style="position: relative;">
						<img src="<?php echo esc_url( $img[0] ); ?>" alt="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; display: block;">
						<button type="button" class="pasf-gallery-remove-image" data-id="<?php echo esc_attr( $img_id ); ?>" style="position: absolute; top: 2px; right: 2px; width: 20px; height: 20px; padding: 0; border: none; background: #dc3545; color: #fff; border-radius: 50%; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>
					</div>
					<?php
				endif;
			endforeach;
			?>
		</div>
		<?php
	}

	public static function render_news_meta( $post ) {
		wp_nonce_field( 'pasf_news_meta', 'pasf_news_meta_nonce' );
		$link_url = get_post_meta( $post->ID, '_pasf_news_link', true );
		?>
		<p>
			<label for="pasf_news_link"><?php esc_html_e( 'Link URL (optional)', 'pasfanc-college' ); ?></label><br>
			<input type="url" id="pasf_news_link" name="pasf_news_link" value="<?php echo esc_url( $link_url ); ?>" class="widefat">
		</p>
		<p class="description"><?php esc_html_e( 'To show this News in the News & Events Highlights section, assign it to the "News Highlights" category (in the Categories box on the right).', 'pasfanc-college' ); ?></p>
		<?php
	}

	public static function render_event_meta( $post ) {
		wp_nonce_field( 'pasf_event_meta', 'pasf_event_meta_nonce' );
		$event_date = get_post_meta( $post->ID, '_pasf_event_date', true );
		$link_url = get_post_meta( $post->ID, '_pasf_event_link', true );
		$highlight = get_post_meta( $post->ID, '_pasf_event_highlight', true );
		?>
		<p>
			<label for="pasf_event_date"><?php esc_html_e( 'Event Date', 'pasfanc-college' ); ?></label><br>
			<input type="date" id="pasf_event_date" name="pasf_event_date" value="<?php echo esc_attr( $event_date ); ?>" class="widefat">
		</p>
		<p>
			<label for="pasf_event_link"><?php esc_html_e( 'Link URL (optional)', 'pasfanc-college' ); ?></label><br>
			<input type="url" id="pasf_event_link" name="pasf_event_link" value="<?php echo esc_url( $link_url ); ?>" class="widefat">
		</p>
		<p>
			<label><input type="checkbox" name="pasf_event_highlight" value="1" <?php checked( $highlight, '1' ); ?>>
				<?php esc_html_e( 'Show in News & Events Highlights', 'pasfanc-college' ); ?></label>
		</p>
		<?php
	}

	public static function render_testimonial_meta( $post ) {
		wp_nonce_field( 'pasf_testimonial_meta', 'pasf_testimonial_meta_nonce' );
		$student_name = get_post_meta( $post->ID, '_pasf_student_name', true );
		$class_year = get_post_meta( $post->ID, '_pasf_class_year', true );
		if ( ! $student_name && $post->post_title ) {
			$student_name = $post->post_title;
		}
		?>
		<p>
			<label for="pasf_student_name"><?php esc_html_e( 'Student Name', 'pasfanc-college' ); ?></label><br>
			<input type="text" id="pasf_student_name" name="pasf_student_name" value="<?php echo esc_attr( $student_name ); ?>" class="widefat">
		</p>
		<p>
			<label for="pasf_class_year"><?php esc_html_e( 'Class / Year (e.g., Class of 2024)', 'pasfanc-college' ); ?></label><br>
			<input type="text" id="pasf_class_year" name="pasf_class_year" value="<?php echo esc_attr( $class_year ); ?>" class="widefat">
		</p>
		<?php
	}

	public static function render_course_meta( $post ) {
		wp_nonce_field( 'pasf_course_meta', 'pasf_course_meta_nonce' );
		$subjects = get_post_meta( $post->ID, '_pasf_course_subjects', true );
		if ( ! is_array( $subjects ) ) {
			$subjects = array();
		}
		?>
		<p>
			<label><?php esc_html_e( 'Subjects (one per line)', 'pasfanc-college' ); ?></label><br>
			<textarea id="pasf_course_subjects" name="pasf_course_subjects" class="widefat" rows="10"><?php echo esc_textarea( implode( "\n", $subjects ) ); ?></textarea>
		</p>
		<?php
	}

	public static function render_gallery_help( $post ) {
		?>
		<p><?php esc_html_e( 'To add photos to the Campus Gallery:', 'pasfanc-college' ); ?></p>
		<ol style="margin: 0.5rem 0 0 1rem; padding-left: 0.5rem;">
			<li><?php esc_html_e( 'Enter a title (e.g., "Sports Day 2025")', 'pasfanc-college' ); ?></li>
			<li><?php esc_html_e( 'Set the Featured Image (this is the photo that will appear in the gallery)', 'pasfanc-college' ); ?></li>
			<li><?php esc_html_e( 'Assign a Gallery Category (e.g., Sports & Activities, Events, Campus Life) in the box below', 'pasfanc-college' ); ?></li>
			<li><?php esc_html_e( 'Click Publish', 'pasfanc-college' ); ?></li>
		</ol>
		<p style="margin-top: 0.75rem; font-size: 12px; color: #646970;"><?php esc_html_e( 'You can add multiple photos in the "Gallery Photos" box on this page. Each photo will appear in the gallery grid.', 'pasfanc-college' ); ?></p>
		<?php
	}

	public static function render_flash_meta( $post ) {
		wp_nonce_field( 'pasf_flash_meta', 'pasf_flash_meta_nonce' );
		$link_url = get_post_meta( $post->ID, '_pasf_flash_link', true );
		$pdf_id  = get_post_meta( $post->ID, '_pasf_flash_pdf', true );
		$pdf_name = '';
		if ( $pdf_id ) {
			$file = get_attached_file( (int) $pdf_id );
			if ( $file ) {
				$pdf_name = basename( $file );
			}
		}
		?>
		<p>
			<label for="pasf_flash_link"><?php esc_html_e( 'Link URL (optional)', 'pasfanc-college' ); ?></label><br>
			<input type="url" id="pasf_flash_link" name="pasf_flash_link" value="<?php echo esc_url( $link_url ); ?>" class="widefat">
		</p>
		<p>
			<label for="pasf_flash_pdf"><?php esc_html_e( 'PDF File (optional)', 'pasfanc-college' ); ?></label><br>
			<input type="hidden" id="pasf_flash_pdf" name="pasf_flash_pdf" value="<?php echo esc_attr( $pdf_id ); ?>">
			<button type="button" class="button pasf-upload-file" data-target="pasf_flash_pdf"><?php esc_html_e( 'Select PDF', 'pasfanc-college' ); ?></button>
			<span class="pasf-file-name"><?php echo esc_html( $pdf_name ); ?></span>
		</p>
		<p class="description"><?php esc_html_e( 'Set Featured Image (right sidebar) for the GIF/image. Add content in the editor for full text. Use the Order field to control display order.', 'pasfanc-college' ); ?></p>
		<?php
	}

	public static function render_staff_meta( $post ) {
		wp_nonce_field( 'pasf_staff_meta', 'pasf_staff_meta_nonce' );
		$initials      = get_post_meta( $post->ID, '_pasf_staff_initials', true );
		$designation   = get_post_meta( $post->ID, '_pasf_staff_designation', true );
		$qualifications = get_post_meta( $post->ID, '_pasf_staff_qualifications', true );
		$order_num     = get_post_meta( $post->ID, '_pasf_staff_order', true );
		if ( '' === $order_num ) {
			$order_num = 0;
		}
		?>
		<p>
			<label for="pasf_staff_initials"><?php esc_html_e( 'Initials (e.g., TT, NR)', 'pasfanc-college' ); ?></label><br>
			<input type="text" id="pasf_staff_initials" name="pasf_staff_initials" value="<?php echo esc_attr( $initials ); ?>" class="widefat" maxlength="6" placeholder="TT">
		</p>
		<p>
			<label for="pasf_staff_designation"><?php esc_html_e( 'Designation (e.g., Principal, Lecturer | English)', 'pasfanc-college' ); ?></label><br>
			<input type="text" id="pasf_staff_designation" name="pasf_staff_designation" value="<?php echo esc_attr( $designation ); ?>" class="widefat" placeholder="Lecturer | English">
		</p>
		<p>
			<label for="pasf_staff_qualifications"><?php esc_html_e( 'Qualifications (e.g., MA (English), B.Ed)', 'pasfanc-college' ); ?></label><br>
			<textarea id="pasf_staff_qualifications" name="pasf_staff_qualifications" class="widefat" rows="3"><?php echo esc_textarea( $qualifications ); ?></textarea>
		</p>
		<p>
			<label for="pasf_staff_order"><?php esc_html_e( 'Display Order (lower = first)', 'pasfanc-college' ); ?></label><br>
			<input type="number" id="pasf_staff_order" name="pasf_staff_order" value="<?php echo esc_attr( $order_num ); ?>" class="small-text" min="0" step="1">
		</p>
		<p class="description"><?php esc_html_e( 'Set Featured Image (right sidebar) for the staff photo. Assign Department (e.g., English, Garo) in the box below. Title = full name.', 'pasfanc-college' ); ?></p>
		<?php
	}

	public static function render_download_meta( $post ) {
		wp_nonce_field( 'pasf_download_meta', 'pasf_download_meta_nonce' );
		$file_id = get_post_meta( $post->ID, '_pasf_download_file', true );
		$file_url = get_post_meta( $post->ID, '_pasf_download_url', true );
		?>
		<p>
			<label for="pasf_download_file"><?php esc_html_e( 'Media File (PDF)', 'pasfanc-college' ); ?></label><br>
			<?php
			$file_input = sprintf(
				'<input type="hidden" id="pasf_download_file" name="pasf_download_file" value="%s">',
				esc_attr( $file_id )
			);
			echo $file_input; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
			<button type="button" class="button pasf-upload-file" data-target="pasf_download_file"><?php esc_html_e( 'Select File', 'pasfanc-college' ); ?></button>
			<span class="pasf-file-name"><?php echo $file_id ? esc_html( basename( get_attached_file( $file_id ) ) ) : ''; ?></span>
		</p>
		<p>
			<label for="pasf_download_url"><?php esc_html_e( 'Or External URL', 'pasfanc-college' ); ?></label><br>
			<input type="url" id="pasf_download_url" name="pasf_download_url" value="<?php echo esc_url( $file_url ); ?>" class="widefat">
		</p>
		<?php
	}

	public static function save_meta_boxes( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( 'pasf_news' === $post->post_type ) {
			if ( isset( $_POST['pasf_news_meta_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_news_meta_nonce'] ) ), 'pasf_news_meta' ) ) {
				if ( isset( $_POST['pasf_news_link'] ) ) {
					update_post_meta( $post_id, '_pasf_news_link', esc_url_raw( wp_unslash( $_POST['pasf_news_link'] ) ) );
				}
			}
		}

		if ( 'pasf_event' === $post->post_type ) {
			if ( isset( $_POST['pasf_event_meta_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_event_meta_nonce'] ) ), 'pasf_event_meta' ) ) {
				if ( isset( $_POST['pasf_event_date'] ) ) {
					update_post_meta( $post_id, '_pasf_event_date', sanitize_text_field( wp_unslash( $_POST['pasf_event_date'] ) ) );
				}
				if ( isset( $_POST['pasf_event_link'] ) ) {
					update_post_meta( $post_id, '_pasf_event_link', esc_url_raw( wp_unslash( $_POST['pasf_event_link'] ) ) );
				}
				update_post_meta( $post_id, '_pasf_event_highlight', isset( $_POST['pasf_event_highlight'] ) ? '1' : '' );
			}
		}

		if ( 'pasf_testimonial' === $post->post_type ) {
			if ( isset( $_POST['pasf_testimonial_meta_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_testimonial_meta_nonce'] ) ), 'pasf_testimonial_meta' ) ) {
				if ( isset( $_POST['pasf_student_name'] ) ) {
					update_post_meta( $post_id, '_pasf_student_name', sanitize_text_field( wp_unslash( $_POST['pasf_student_name'] ) ) );
				}
				if ( isset( $_POST['pasf_class_year'] ) ) {
					update_post_meta( $post_id, '_pasf_class_year', sanitize_text_field( wp_unslash( $_POST['pasf_class_year'] ) ) );
				}
			}
		}

		if ( 'pasf_course' === $post->post_type ) {
			if ( isset( $_POST['pasf_course_meta_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_course_meta_nonce'] ) ), 'pasf_course_meta' ) ) {
				if ( isset( $_POST['pasf_course_subjects'] ) ) {
					$subjects = array_filter( array_map( 'sanitize_text_field', explode( "\n", wp_unslash( $_POST['pasf_course_subjects'] ) ) ) );
					update_post_meta( $post_id, '_pasf_course_subjects', $subjects );
				}
			}
		}

		if ( 'pasf_flash' === $post->post_type ) {
			if ( isset( $_POST['pasf_flash_meta_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_flash_meta_nonce'] ) ), 'pasf_flash_meta' ) ) {
				if ( isset( $_POST['pasf_flash_link'] ) ) {
					update_post_meta( $post_id, '_pasf_flash_link', esc_url_raw( wp_unslash( $_POST['pasf_flash_link'] ) ) );
				}
				if ( isset( $_POST['pasf_flash_pdf'] ) ) {
					update_post_meta( $post_id, '_pasf_flash_pdf', absint( $_POST['pasf_flash_pdf'] ) );
				}
			}
		}

		if ( 'pasf_download' === $post->post_type ) {
			if ( isset( $_POST['pasf_download_meta_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_download_meta_nonce'] ) ), 'pasf_download_meta' ) ) {
				if ( isset( $_POST['pasf_download_file'] ) ) {
					update_post_meta( $post_id, '_pasf_download_file', absint( $_POST['pasf_download_file'] ) );
				}
				if ( isset( $_POST['pasf_download_url'] ) ) {
					update_post_meta( $post_id, '_pasf_download_url', esc_url_raw( wp_unslash( $_POST['pasf_download_url'] ) ) );
				}
			}
		}

		if ( 'pasf_gallery' === $post->post_type ) {
			if ( isset( $_POST['pasf_gallery_images_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_gallery_images_nonce'] ) ), 'pasf_gallery_images' ) ) {
				if ( isset( $_POST['pasf_gallery_images'] ) && is_string( $_POST['pasf_gallery_images'] ) ) {
					$ids = array_filter( array_map( 'absint', explode( ',', wp_unslash( $_POST['pasf_gallery_images'] ) ) ) );
					update_post_meta( $post_id, '_pasf_gallery_images', $ids );
				}
			}
		}

		if ( 'pasf_staff' === $post->post_type ) {
			if ( isset( $_POST['pasf_staff_meta_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pasf_staff_meta_nonce'] ) ), 'pasf_staff_meta' ) ) {
				if ( isset( $_POST['pasf_staff_initials'] ) ) {
					update_post_meta( $post_id, '_pasf_staff_initials', sanitize_text_field( wp_unslash( $_POST['pasf_staff_initials'] ) ) );
				}
				if ( isset( $_POST['pasf_staff_designation'] ) ) {
					update_post_meta( $post_id, '_pasf_staff_designation', sanitize_text_field( wp_unslash( $_POST['pasf_staff_designation'] ) ) );
				}
				if ( isset( $_POST['pasf_staff_qualifications'] ) ) {
					update_post_meta( $post_id, '_pasf_staff_qualifications', sanitize_textarea_field( wp_unslash( $_POST['pasf_staff_qualifications'] ) ) );
				}
				if ( isset( $_POST['pasf_staff_order'] ) ) {
					update_post_meta( $post_id, '_pasf_staff_order', absint( $_POST['pasf_staff_order'] ) );
				}
			}
		}
	}
}
Pasfanc_Meta_Boxes::init();

<?php
/**
 * Theme Customizer for PASF College
 *
 * @package pasfanc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Customizer settings
 */
function pasfanc_customize_register( $wp_customize ) {

	/* === BRANDING BANNER (Logo + Address) === */
	$wp_customize->add_section( 'pasfanc_branding', array(
		'title'    => __( 'Branding Banner', 'pasfanc-theme' ),
		'priority' => 15,
		'description' => __( 'Logo and college info in the header. Upload logo via Site Identity.', 'pasfanc-theme' ),
	) );
	$wp_customize->add_setting( 'pasfanc_college_grant', array(
		'default'           => "Under People's College Grant-in-Aid",
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_college_grant', array(
		'label'   => __( 'Grant-in-Aid Text', 'pasfanc-theme' ),
		'section' => 'pasfanc_branding',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_college_affiliation', array(
		'default'           => '(Affiliated to the North-Eastern Hills University)',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_college_affiliation', array(
		'label'   => __( 'Affiliation Text', 'pasfanc-theme' ),
		'section' => 'pasfanc_branding',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_college_address', array(
		'default'           => 'Tura, West Garo Hills, Meghalaya-794101',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_college_address', array(
		'label'   => __( 'Address', 'pasfanc-theme' ),
		'section' => 'pasfanc_branding',
		'type'    => 'text',
	) );

	/* === TOP BAR === */
	$wp_customize->add_section( 'pasfanc_topbar', array(
		'title'    => __( 'Top Bar', 'pasfanc-theme' ),
		'priority' => 20,
	) );
	$wp_customize->add_setting( 'pasfanc_top_email', array(
		'default'           => 'pasfabongnogacollege@gmail.com',
		'sanitize_callback'  => 'sanitize_email',
	) );
	$wp_customize->add_control( 'pasfanc_top_email', array(
		'label'   => __( 'Email', 'pasfanc-theme' ),
		'section' => 'pasfanc_topbar',
		'type'    => 'email',
	) );
	$wp_customize->add_setting( 'pasfanc_top_phone', array(
		'default'           => '+91 97741 09207',
		'sanitize_callback'  => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_top_phone', array(
		'label'   => __( 'Phone', 'pasfanc-theme' ),
		'section' => 'pasfanc_topbar',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_prospectus_label', array(
		'default'           => 'Prospectus 2026',
		'sanitize_callback'  => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_prospectus_label', array(
		'label'   => __( 'Prospectus Label', 'pasfanc-theme' ),
		'section' => 'pasfanc_topbar',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_prospectus_url', array(
		'default'           => '',
		'sanitize_callback'  => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'pasfanc_prospectus_url', array(
		'label'   => __( 'Prospectus URL', 'pasfanc-theme' ),
		'section' => 'pasfanc_topbar',
		'type'    => 'url',
	) );
	$accr_urls = array(
		'aqar' => home_url( '/aqar/' ),
		'iqac' => home_url( '/iqac/' ),
		'naac' => home_url( '/naac/' ),
		'nirf' => home_url( '/administration/nirf/' ),
	);
	foreach ( $accr_urls as $key => $url ) {
		$wp_customize->add_setting( 'pasfanc_' . $key . '_url', array(
			'default'           => $url,
			'sanitize_callback'  => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'pasfanc_' . $key . '_url', array(
			'label'   => strtoupper( $key ) . ' URL',
			'section' => 'pasfanc_topbar',
			'type'    => 'url',
		) );
	}

	/* === HERO === */
	$wp_customize->add_section( 'pasfanc_hero', array(
		'title'    => __( 'Hero Section', 'pasfanc-theme' ),
		'priority' => 25,
	) );
	$wp_customize->add_setting( 'pasfanc_hero_image', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'pasfanc_hero_image', array(
		'label'     => __( 'Hero Image', 'pasfanc-theme' ),
		'section'   => 'pasfanc_hero',
		'mime_type' => 'image',
	) ) );
	$wp_customize->add_setting( 'pasfanc_hero_text', array(
		'default'           => 'Welcome to PASF Academy',
		'sanitize_callback'  => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_hero_text', array(
		'label'   => __( 'Hero Overlay Text', 'pasfanc-theme' ),
		'section' => 'pasfanc_hero',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_hero_subtitle', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_hero_subtitle', array(
		'label'       => __( 'Hero Subtitle (optional)', 'pasfanc-theme' ),
		'description' => __( 'Shown below the main hero text.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_hero',
		'type'        => 'text',
	) );

	/* === FRONT PAGE STATS === */
	$wp_customize->add_section( 'pasfanc_front_stats', array(
		'title'    => __( 'Front Page Quick Facts', 'pasfanc-theme' ),
		'priority' => 26,
	) );
	$wp_customize->add_setting( 'pasfanc_stats_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'pasfanc_stats_enabled', array(
		'label'   => __( 'Show Quick Facts bar', 'pasfanc-theme' ),
		'section' => 'pasfanc_front_stats',
		'type'    => 'checkbox',
	) );
	$stats_defaults = array(
		1 => array( 'label' => __( 'Years of Excellence', 'pasfanc-theme' ), 'value' => '10+' ),
		2 => array( 'label' => __( 'Students', 'pasfanc-theme' ), 'value' => '500+' ),
		3 => array( 'label' => __( 'Courses', 'pasfanc-theme' ), 'value' => '15+' ),
		4 => array( 'label' => __( 'Faculty', 'pasfanc-theme' ), 'value' => '30+' ),
	);
	for ( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting( 'pasfanc_stat_value_' . $i, array(
			'default'           => $stats_defaults[ $i ]['value'],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'pasfanc_stat_value_' . $i, array(
			'label'   => sprintf( __( 'Stat %d Value', 'pasfanc-theme' ), $i ),
			'section' => 'pasfanc_front_stats',
			'type'    => 'text',
		) );
		$wp_customize->add_setting( 'pasfanc_stat_label_' . $i, array(
			'default'           => $stats_defaults[ $i ]['label'],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'pasfanc_stat_label_' . $i, array(
			'label'   => sprintf( __( 'Stat %d Label', 'pasfanc-theme' ), $i ),
			'section' => 'pasfanc_front_stats',
			'type'    => 'text',
		) );
	}
	$wp_customize->add_setting( 'pasfanc_stats_welcome', array(
		'default'           => 'Welcome to P.A.S.F Abong Noga College',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'pasfanc_stats_welcome', array(
		'label'       => __( 'Welcome Message', 'pasfanc-theme' ),
		'description' => __( 'Shown below the statistics. Leave empty to hide.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_front_stats',
		'type'        => 'text',
	) );

	/* === GUIDING PRINCIPLES === */
	$wp_customize->add_section( 'pasfanc_guiding', array(
		'title'    => __( 'Guiding Principles', 'pasfanc-theme' ),
		'priority' => 30,
	) );
	$wp_customize->add_setting( 'pasfanc_motto', array(
		'default'           => 'To Educate, To Change, To Grow & To Live',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_motto', array(
		'label'   => __( 'Motto', 'pasfanc-theme' ),
		'section' => 'pasfanc_guiding',
		'type'    => 'text',
	) );
	for ( $i = 1; $i <= 6; $i++ ) {
		$wp_customize->add_setting( 'pasfanc_aim_' . $i, array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'pasfanc_aim_' . $i, array(
			'label'   => sprintf( __( 'Our Aim %d', 'pasfanc-theme' ), $i ),
			'section' => 'pasfanc_guiding',
			'type'    => 'text',
		) );
	}
	$wp_customize->add_setting( 'pasfanc_vision', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'pasfanc_vision', array(
		'label'   => __( 'Vision', 'pasfanc-theme' ),
		'section' => 'pasfanc_guiding',
		'type'    => 'textarea',
	) );
	$wp_customize->add_setting( 'pasfanc_mission', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'pasfanc_mission', array(
		'label'   => __( 'Mission', 'pasfanc-theme' ),
		'section' => 'pasfanc_guiding',
		'type'    => 'textarea',
	) );

	/* === ABOUT / FOUNDER === */
	$wp_customize->add_section( 'pasfanc_about', array(
		'title'    => __( 'About Section', 'pasfanc-theme' ),
		'priority' => 35,
	) );
	$wp_customize->add_setting( 'pasfanc_founder_image', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'pasfanc_founder_image', array(
		'label'       => __( 'Founder Image', 'pasfanc-theme' ),
		'description' => __( 'Upload founder portrait. Shown on the left of the About section.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_about',
		'mime_type'   => 'image',
	) ) );
	$about_default = "Rooted in the rich heritage of the A·chik community and inspired by visionary leadership, PASF–Abong Noga College stands as a centre of learning, culture, and social commitment.\n\nThe college is named in honour of two important and influential legendary figures of the A·chik community. Late Shri Purno Agitok Sangma (1947–2016) remains a cherished name in every nook and corner of Garo Hills and holds a special place in the hearts of many Indians even today.";
	$wp_customize->add_setting( 'pasfanc_about_excerpt', array(
		'default'           => $about_default,
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'pasfanc_about_excerpt', array(
		'label'       => __( 'About Excerpt', 'pasfanc-theme' ),
		'description' => __( 'Short text shown on homepage. Full content on About page.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_about',
		'type'        => 'textarea',
	) );

	/* === PRINCIPAL === */
	$wp_customize->add_section( 'pasfanc_principal', array(
		'title'    => __( 'Principal Message', 'pasfanc-theme' ),
		'priority' => 40,
	) );
	$wp_customize->add_setting( 'pasfanc_principal_name', array(
		'default'           => 'Tiana Tarin D. Arengh',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_principal_name', array(
		'label'   => __( 'Principal Name', 'pasfanc-theme' ),
		'section' => 'pasfanc_principal',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_principal_image', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'pasfanc_principal_image', array(
		'label'     => __( 'Principal Image', 'pasfanc-theme' ),
		'section'   => 'pasfanc_principal',
		'mime_type' => 'image',
	) ) );
	$wp_customize->add_setting( 'pasfanc_principal_message', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'pasfanc_principal_message', array(
		'label'   => __( 'Principal Message', 'pasfanc-theme' ),
		'section' => 'pasfanc_principal',
		'type'    => 'textarea',
	) );

	/* === PRESIDENT MESSAGE === */
	$wp_customize->add_section( 'pasfanc_president', array(
		'title'    => __( 'President Message', 'pasfanc-theme' ),
		'priority' => 41,
	) );
	$wp_customize->add_setting( 'pasfanc_president_name', array(
		'default'           => 'Dr. Mrs. Jasmine B A Sangma',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_president_name', array(
		'label'   => __( 'President Name', 'pasfanc-theme' ),
		'section' => 'pasfanc_president',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_president_image', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'pasfanc_president_image', array(
		'label'       => __( 'President Image', 'pasfanc-theme' ),
		'description' => __( 'Upload President photo (headshot). Shown in the President Message section.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_president',
		'mime_type'   => 'image',
	) ) );
	$president_default = "Dear students,\n\nIt is heartening to see PASF Abong Noga College embark on yet another journey of second academic year of its BA Degree Course. The previous years have seen many milestones of which we can be proud of. The Affiliation from NEHU and the successful establishment of an Exam Centre are a few of them besides the routine classes and activities which are carried out for the academic enrichment and to develop the character and intellect of the students. One of the most significant is the process of leading to the adoption of the PASF Abong Noga College as People's College by the Government of Meghalaya which will provide financial help and a promise to enhance the educational standards of Meghalaya as a whole.";
	$wp_customize->add_setting( 'pasfanc_president_message', array(
		'default'           => $president_default,
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'pasfanc_president_message', array(
		'label'       => __( 'President Message (excerpt)', 'pasfanc-theme' ),
		'description' => __( 'Short excerpt shown on homepage. Full message on President Message page.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_president',
		'type'        => 'textarea',
	) );
	$wp_customize->add_setting( 'pasfanc_president_title', array(
		'default'           => 'President, Governing Body',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_president_title', array(
		'label'   => __( 'President Title/Designation', 'pasfanc-theme' ),
		'section' => 'pasfanc_president',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_president_qualification', array(
		'default'           => 'PhD',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_president_qualification', array(
		'label'   => __( 'President Qualification (e.g. PhD)', 'pasfanc-theme' ),
		'section' => 'pasfanc_president',
		'type'    => 'text',
	) );

	/* === WHY CHOOSE (4 cards) === */
	$wp_customize->add_section( 'pasfanc_why_choose', array(
		'title'    => __( 'Why Choose Us', 'pasfanc-theme' ),
		'priority' => 45,
	) );
	for ( $i = 1; $i <= 4; $i++ ) {
		$wp_customize->add_setting( 'pasfanc_why_title_' . $i, array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'pasfanc_why_title_' . $i, array(
			'label'   => sprintf( __( 'Card %d Title', 'pasfanc-theme' ), $i ),
			'section' => 'pasfanc_why_choose',
			'type'    => 'text',
		) );
		$wp_customize->add_setting( 'pasfanc_why_text_' . $i, array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( 'pasfanc_why_text_' . $i, array(
			'label'   => sprintf( __( 'Card %d Description', 'pasfanc-theme' ), $i ),
			'section' => 'pasfanc_why_choose',
			'type'    => 'textarea',
		) );
	}

	/* === ADMISSIONS CTA === */
	$wp_customize->add_section( 'pasfanc_cta', array(
		'title'    => __( 'Admissions CTA', 'pasfanc-theme' ),
		'priority' => 50,
	) );
	$wp_customize->add_setting( 'pasfanc_cta_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'pasfanc_cta_enabled', array(
		'label'   => __( 'Show Admissions Open Section', 'pasfanc-theme' ),
		'section' => 'pasfanc_cta',
		'type'    => 'checkbox',
	) );
	$wp_customize->add_setting( 'pasfanc_cta_heading', array(
		'default'           => 'Admissions Open ' . date( 'Y' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_cta_heading', array(
		'label'   => __( 'CTA Heading', 'pasfanc-theme' ),
		'section' => 'pasfanc_cta',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_cta_text', array(
		'default'           => 'Take the first step towards your future. Join PASF-Abong Noga College today.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'pasfanc_cta_text', array(
		'label'   => __( 'CTA Text', 'pasfanc-theme' ),
		'section' => 'pasfanc_cta',
		'type'    => 'textarea',
	) );
	$wp_customize->add_setting( 'pasfanc_apply_url', array(
		'default'           => home_url( '/admissions/' ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'pasfanc_apply_url', array(
		'label'   => __( 'Apply Now URL', 'pasfanc-theme' ),
		'section' => 'pasfanc_cta',
		'type'    => 'url',
	) );
	$wp_customize->add_setting( 'pasfanc_cta_contact_url', array(
		'default'           => home_url( '/contact/' ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'pasfanc_cta_contact_url', array(
		'label'   => __( 'Contact Admission Office URL', 'pasfanc-theme' ),
		'section' => 'pasfanc_cta',
		'type'    => 'url',
	) );

	/* === FOOTER === */
	$wp_customize->add_section( 'pasfanc_footer', array(
		'title'    => __( 'Footer', 'pasfanc-theme' ),
		'priority' => 55,
	) );
	$wp_customize->add_setting( 'pasfanc_footer_logo', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'pasfanc_footer_logo', array(
		'label'       => __( 'Footer Logo', 'pasfanc-theme' ),
		'description' => __( 'College logo shown in the footer. Uses Site Logo if not set.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_footer',
		'mime_type'   => 'image',
	) ) );
	$wp_customize->add_setting( 'pasfanc_footer_address', array(
		'default'           => "PASF-ABONG NOGA COLLEGE\nUnder People's College Grant-in-Aid\n(Affiliated to the North-Eastern Hills University)\nTura, West Garo Hills, Meghalaya-794101",
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'pasfanc_footer_address', array(
		'label'   => __( 'Footer Address', 'pasfanc-theme' ),
		'section' => 'pasfanc_footer',
		'type'    => 'textarea',
	) );
	$wp_customize->add_setting( 'pasfanc_footer_copyright', array(
		'default'           => '© ' . date( 'Y' ) . ' PASF-ABONG NOGA COLLEGE. All Rights Reserved.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_footer_copyright', array(
		'label'   => __( 'Copyright Text', 'pasfanc-theme' ),
		'section' => 'pasfanc_footer',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_maps_url', array(
		'default'           => 'https://maps.app.goo.gl/bV9zFy1t1Jn5q8Du5',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'pasfanc_maps_url', array(
		'label'       => __( 'Google Maps URL (link)', 'pasfanc-theme' ),
		'description' => __( 'URL for the "Open in Google Maps" button.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_footer',
		'type'        => 'url',
	) );
	$wp_customize->add_setting( 'pasfanc_maps_embed', array(
		'default'           => 'https://www.google.com/maps?q=25.502221,90.180934&z=15&output=embed',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'pasfanc_maps_embed', array(
		'label'       => __( 'Maps Embed URL', 'pasfanc-theme' ),
		'description' => __( 'iframe src for embedded map. Get from Google Maps → Share → Embed.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_footer',
		'type'        => 'url',
	) );
	$wp_customize->add_setting( 'pasfanc_show_visitors', array(
		'default'           => true,
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'pasfanc_show_visitors', array(
		'label'   => __( 'Show Site Visitors', 'pasfanc-theme' ),
		'section' => 'pasfanc_footer',
		'type'    => 'checkbox',
	) );
	$wp_customize->add_setting( 'pasfanc_powered_by', array(
		'default'           => 'BaseCode Labs Pvt.Ltd',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'pasfanc_powered_by', array(
		'label'   => __( 'Powered by', 'pasfanc-theme' ),
		'section' => 'pasfanc_footer',
		'type'    => 'text',
	) );
	$wp_customize->add_setting( 'pasfanc_powered_by_url', array(
		'default'           => 'https://basecodelabs.com/',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'pasfanc_powered_by_url', array(
		'label'   => __( 'Powered by URL', 'pasfanc-theme' ),
		'section' => 'pasfanc_footer',
		'type'    => 'url',
	) );

	/* === ADMIN (Dashboard) === */
	$wp_customize->add_section( 'pasfanc_admin', array(
		'title'       => __( 'Admin Dashboard', 'pasfanc-theme' ),
		'priority'    => 160,
		'description' => __( 'Options for the WordPress admin area.', 'pasfanc-theme' ),
	) );
	$wp_customize->add_setting( 'pasfanc_hide_php_notice', array(
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	) );
	$wp_customize->add_control( 'pasfanc_hide_php_notice', array(
		'label'       => __( 'Hide PHP Update notice', 'pasfanc-theme' ),
		'description' => __( 'When enabled, hides the PHP version update recommended notice in the admin area.', 'pasfanc-theme' ),
		'section'     => 'pasfanc_admin',
		'type'        => 'checkbox',
	) );
}
add_action( 'customize_register', 'pasfanc_customize_register' );

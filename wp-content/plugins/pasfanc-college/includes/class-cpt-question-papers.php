<?php
/**
 * Question Papers CPT for past exam papers
 *
 * @package pasfanc-college
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pasfanc_CPT_Question_Papers {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_filter( 'manage_pasf_question_paper_posts_columns', array( __CLASS__, 'admin_columns' ) );
		add_action( 'manage_pasf_question_paper_posts_custom_column', array( __CLASS__, 'admin_column_content' ), 10, 2 );
	}

	public static function register_post_type() {
		register_post_type( 'pasf_question_paper', array(
			'labels'       => array(
				'name'               => __( 'Question Papers', 'pasfanc-college' ),
				'singular_name'      => __( 'Question Paper', 'pasfanc-college' ),
				'add_new'            => __( 'Add New', 'pasfanc-college' ),
				'add_new_item'       => __( 'Add New Question Paper', 'pasfanc-college' ),
				'edit_item'          => __( 'Edit Question Paper', 'pasfanc-college' ),
				'new_item'           => __( 'New Question Paper', 'pasfanc-college' ),
				'view_item'          => __( 'View Question Paper', 'pasfanc-college' ),
				'search_items'       => __( 'Search Question Papers', 'pasfanc-college' ),
				'not_found'          => __( 'No question papers found', 'pasfanc-college' ),
				'not_found_in_trash' => __( 'No question papers in trash', 'pasfanc-college' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'question-paper' ),
			'supports'     => array( 'title' ),
			'menu_icon'    => 'dashicons-media-document',
			'menu_position' => 25,
			'show_in_rest' => true,
		) );
	}

	/**
	 * Get available courses for dropdown
	 *
	 * @return array
	 */
	public static function get_courses() {
		return array(
			'Class XI & XII Arts'         => __( 'Class XI & XII Arts', 'pasfanc-college' ),
			'Class XI & XII Commerce'     => __( 'Class XI & XII Commerce', 'pasfanc-college' ),
			'BA Degree Course'            => __( 'BA Degree Course', 'pasfanc-college' ),
			'English'                     => __( 'English', 'pasfanc-college' ),
			'Garo'                        => __( 'Garo', 'pasfanc-college' ),
			'Economics'                   => __( 'Economics', 'pasfanc-college' ),
			'History'                     => __( 'History', 'pasfanc-college' ),
			'Political Science'          => __( 'Political Science', 'pasfanc-college' ),
			'Philosophy'                  => __( 'Philosophy', 'pasfanc-college' ),
			'BCA'                         => __( 'BCA', 'pasfanc-college' ),
			'Other'                       => __( 'Other', 'pasfanc-college' ),
		);
	}

	/**
	 * Get years for dropdown (current year down to 10 years back)
	 *
	 * @return array
	 */
	public static function get_years() {
		$current = (int) date( 'Y' );
		$years   = array();
		for ( $y = $current; $y >= $current - 10; $y-- ) {
			$years[ $y ] = (string) $y;
		}
		return $years;
	}

	/**
	 * Add Course and Year columns to admin list.
	 *
	 * @param array $columns Existing columns.
	 * @return array
	 */
	public static function admin_columns( $columns ) {
		$new = array();
		foreach ( $columns as $key => $value ) {
			$new[ $key ] = $value;
			if ( 'title' === $key ) {
				$new['pasf_qp_course'] = __( 'Course', 'pasfanc-college' );
				$new['pasf_qp_year']  = __( 'Year', 'pasfanc-college' );
			}
		}
		return $new;
	}

	/**
	 * Output column content for Course and Year.
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 */
	public static function admin_column_content( $column, $post_id ) {
		if ( 'pasf_qp_course' === $column ) {
			$course = get_post_meta( $post_id, '_pasf_question_paper_course', true );
			echo $course ? esc_html( $course ) : '—';
		}
		if ( 'pasf_qp_year' === $column ) {
			$year = get_post_meta( $post_id, '_pasf_question_paper_year', true );
			echo $year ? esc_html( $year ) : '—';
		}
	}
}
Pasfanc_CPT_Question_Papers::init();

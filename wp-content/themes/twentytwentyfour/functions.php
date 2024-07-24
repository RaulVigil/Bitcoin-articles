<?php

/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/**
 * Register block styles.
 */

if (!function_exists('twentytwentyfour_block_styles')) :
	/**
	 * Register custom block styles
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_styles()
	{

		register_block_style(
			'core/details',
			array(
				'name'         => 'arrow-icon-details',
				'label'        => __('Arrow icon', 'twentytwentyfour'),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-arrow-icon-details {
					padding-top: var(--wp--preset--spacing--10);
					padding-bottom: var(--wp--preset--spacing--10);
				}

				.is-style-arrow-icon-details summary {
					list-style-type: "\2193\00a0\00a0\00a0";
				}

				.is-style-arrow-icon-details[open]>summary {
					list-style-type: "\2192\00a0\00a0\00a0";
				}',
			)
		);
		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill',
				'label'        => __('Pill', 'twentytwentyfour'),
				/*
				 * Styles variation for post terms
				 * https://github.com/WordPress/gutenberg/issues/24956
				 */
				'inline_style' => '
				.is-style-pill a,
				.is-style-pill span:not([class], [data-rich-text-placeholder]) {
					display: inline-block;
					background-color: var(--wp--preset--color--base-2);
					padding: 0.375rem 0.875rem;
					border-radius: var(--wp--preset--spacing--20);
				}

				.is-style-pill a:hover {
					background-color: var(--wp--preset--color--contrast-3);
				}',
			)
		);
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __('Checkmark', 'twentytwentyfour'),
				/*
				 * Styles for the custom checkmark list block style
				 * https://github.com/WordPress/gutenberg/issues/51480
				 */
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
		register_block_style(
			'core/navigation-link',
			array(
				'name'         => 'arrow-link',
				'label'        => __('With arrow', 'twentytwentyfour'),
				/*
				 * Styles for the custom arrow nav link block style
				 */
				'inline_style' => '
				.is-style-arrow-link .wp-block-navigation-item__label:after {
					content: "\2197";
					padding-inline-start: 0.25rem;
					vertical-align: middle;
					text-decoration: none;
					display: inline-block;
				}',
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'         => 'asterisk',
				'label'        => __('With asterisk', 'twentytwentyfour'),
				'inline_style' => "
				.is-style-asterisk:before {
					content: '';
					width: 1.5rem;
					height: 3rem;
					background: var(--wp--preset--color--contrast-2, currentColor);
					clip-path: path('M11.93.684v8.039l5.633-5.633 1.216 1.23-5.66 5.66h8.04v1.737H13.2l5.701 5.701-1.23 1.23-5.742-5.742V21h-1.737v-8.094l-5.77 5.77-1.23-1.217 5.743-5.742H.842V9.98h8.162l-5.701-5.7 1.23-1.231 5.66 5.66V.684h1.737Z');
					display: block;
				}

				/* Hide the asterisk if the heading has no content, to avoid using empty headings to display the asterisk only, which is an A11Y issue */
				.is-style-asterisk:empty:before {
					content: none;
				}

				.is-style-asterisk:-moz-only-whitespace:before {
					content: none;
				}

				.is-style-asterisk.has-text-align-center:before {
					margin: 0 auto;
				}

				.is-style-asterisk.has-text-align-right:before {
					margin-left: auto;
				}

				.rtl .is-style-asterisk.has-text-align-left:before {
					margin-right: auto;
				}",
			)
		);
	}
endif;

add_action('init', 'twentytwentyfour_block_styles');

/**
 * Enqueue block stylesheets.
 */

if (!function_exists('twentytwentyfour_block_stylesheets')) :
	/**
	 * Enqueue custom block stylesheets
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_stylesheets()
	{
		/**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'twentytwentyfour-button-style-outline',
				'src'    => get_parent_theme_file_uri('assets/css/button-outline.css'),
				'ver'    => wp_get_theme(get_template())->get('Version'),
				'path'   => get_parent_theme_file_path('assets/css/button-outline.css'),
			)
		);
	}
endif;

add_action('init', 'twentytwentyfour_block_stylesheets');

/**
 * Register pattern categories.
 */

if (!function_exists('twentytwentyfour_pattern_categories')) :
	/**
	 * Register pattern categories
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_pattern_categories()
	{

		register_block_pattern_category(
			'twentytwentyfour_page',
			array(
				'label'       => _x('Pages', 'Block pattern category', 'twentytwentyfour'),
				'description' => __('A collection of full page layouts.', 'twentytwentyfour'),
			)
		);
	}
endif;

add_action('init', 'twentytwentyfour_pattern_categories');

/*Crear el custom post type 'Books'*/
function create_books_post_type()
{
	$labels = array(
		'name' => __('Books'),
		'singular_name' => __('Book'),
		'add_new' => __('Add New Book'),
		'add_new_item' => __('Add New Book'),
		'edit_item' => __('Edit Book'),
		'new_item' => __('New Book'),
		'view_item' => __('View Book'),
		'search_items' => __('Search Books'),
		'not_found' => __('No Books found'),
		'not_found_in_trash' => __('No Books found in Trash'),
		'all_items' => __('All Books'),
		'archives' => __('Book Archives'),
		'insert_into_item' => __('Insert into book'),
		'uploaded_to_this_item' => __('Uploaded to this book'),
		'featured_image' => __('Featured Image'),
		'set_featured_image' => __('Set featured image'),
		'remove_featured_image' => __('Remove featured image'),
		'use_featured_image' => __('Use as featured image'),
		'menu_name' => __('Books'),
		'filter_items_list' => __('Filter books list'),
		'items_list_navigation' => __('Books list navigation'),
		'items_list' => __('Books list'),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'books'),
		'supports' => array('title', 'editor', 'thumbnail'),
		'show_in_rest' => true,
	);

	register_post_type('books', $args);
}

add_action('init', 'create_books_post_type');

/*mostrar libros'*/
function display_books_shortcode($atts)
{
	$args = array(
		'post_type' => 'books',
		'posts_per_page' => -1
	);

	$query = new WP_Query($args);
	$output = '<div class="books-container">';

	while ($query->have_posts()) {
		$query->the_post();
		$book_title = get_field('titulo');
		$book_description = get_field('descripcion_breve');
		$book_image = get_field('imagen');
		$book_year = get_field('ano_de_publicacion');

		$output .= '<div class="book">';
		if ($book_image) {
			$output .= '<img class="image-book" src="' . esc_url($book_image['url']) . '" alt="' . esc_attr($book_image['alt']) . '">';
		}
		$output .= '<div class="container-details">';
		$output .= '<div>';
		$output .= '<h2 class="title-book">' . esc_html($book_title) . '</h2>';
		$output .= '<p class="txt-book">' . limitarCaracteres(esc_html($book_description)) . '</p>';
		$output .= '</div>';
		$output .= '<div>';
		$output .= '<p class="txt-book-year"><span><strong>Year:</strong> ' . esc_html($book_year) . '</span></p>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	}

	wp_reset_postdata();
	$output .= '</div>';

	return $output;
}

add_shortcode('display_books', 'display_books_shortcode');

/*Funcion para agregar archivo de estilo*/
function enqueue_books_styles()
{
	wp_enqueue_style('books-style', get_template_directory_uri() . '/bookStyle.css');
}

add_action('wp_enqueue_scripts', 'enqueue_books_styles');

function limitarCaracteres($cadena, $limite = 100)
{
	if (strlen($cadena) > $limite) {
		return substr($cadena, 0, $limite) . "...";
	} else {
		return $cadena;
	}
}

function register_custom_sidebars()
{

	$args = array(
		'id'                    => 'custom-sidebar',
		'name'                  => 'Custom Sidebar',
	);
	register_sidebar($args);
}
add_action('widgets_init', 'register_custom_sidebars');


class Bitcoin_Price_Widget extends WP_Widget
{

	public function __construct()
	{
		parent::__construct(
			'custom_widget_id',
			__('Bitcoin price', 'text_domain'),
			array(
				'description' => __('This is a custom widget generated with WPCode', 'text_domain'),
				'classname' => 'bitcoin-widget-widget',
			)
		);
	}

	public function widget($args, $instance)
	{
		$instance = wp_parse_args((array) $instance, array());
		// Before widget tag
		echo $args['before_widget'];

		echo '<pre>';
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://mempool.space/api/v1/prices',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);
		print json_encode($response, JSON_PRETTY_PRINT);
		echo '</pre>';

		// After widget tag
		echo $args['after_widget'];
	}

	public function form($instance)
	{
		// Set default values
		$instance = wp_parse_args((array) $instance, array());
	}
}


function bitcoin_price_register_widgets()
{
	register_widget('Bitcoin_Price_Widget');
}
add_action('widgets_init', 'bitcoin_price_register_widgets');

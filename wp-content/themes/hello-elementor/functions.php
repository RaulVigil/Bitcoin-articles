<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.1.0' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Admin notice
if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}


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


/*Funcion para limitar el número de caracteres*/
function limitarCaracteres($cadena, $limite = 100)
{
	if (strlen($cadena) > $limite) {
		return substr($cadena, 0, $limite) . "...";
	} else {
		return $cadena;
	}
}


/*Funcion para registrar el sidebar*/
function register_custom_sidebars()
{

	$args = array(
		'id'                    => 'custom-sidebar',
		'name'                  => 'Custom Sidebar',
	);
	register_sidebar($args);
}
add_action('widgets_init', 'register_custom_sidebars');

/*Crar widget*/
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


	/*Funcion para mostar el html y css del widget*/
	public function widget($args, $instance)
	{
		$instance = wp_parse_args((array) $instance, array());
		// Before widget tag
		echo $args['before_widget'];

		?>
		<div id="progress-container">
			<div id="progress-bar"></div>
		</div>
		<style>
			#progress-container {
				width: 100%;
				background-color: #e0e0e0;
				border: 1px solid #ccc;
				border-radius: 5px;
				height: 10px;
				overflow: hidden;
				position: relative;
			}

			#progress-bar {
				width: 100%;
				height: 100%;
				background-color: #4caf50;
				transition: width 0.1s linear;
			}
		</style>
		<div id="bitcoin-price"></div>
		<script>
			jQuery(document).ready(($) => {
				const $progressBar = $('#progress-bar');
				const duration = 10; // Duración de un ciclo en segundos
				let elapsedTime = 0; // Tiempo transcurrido

				function updateProgressBar() {
					// Calcular el porcentaje del tiempo transcurrido
					const percentage = (elapsedTime / duration) * 100;
					// Actualizar el ancho de la barra de progreso
					$progressBar.css('width', (100 - percentage) + '%');

					// Incrementar el tiempo transcurrido
					elapsedTime++;

					// Si el tiempo transcurrido alcanza la duración, reiniciar
					if (elapsedTime > duration) {
						elapsedTime = 0;
						// Volver a consultar la API
						$.get('<?= get_site_url() ?>' + '/wp-json/miapi/v1/precio-bitcoin', (data) => {
							$('#bitcoin-price').empty();
							$.each(data, (key, value) => {
								if (key === 'time') {
									const date = new Date(value * 1000);
									const formattedDate = date.toLocaleDateString();
									const formattedTime = date.toLocaleTimeString();
									$('#bitcoin-price').append('<p>Fecha y hora: ' + formattedDate + ' ' + formattedTime + '</p>');
								} else {
									$('#bitcoin-price').append('<p>El precio del Bitcoin en <b>' + key + '</b> es de: <b>$' + value + '</b></p>');
								}
							});
						});
					}
				}

				// Iniciar el intervalo para actualizar la barra cada segundo
				setInterval(updateProgressBar, 1000);
				$.get('<?= get_site_url() ?>' + '/wp-json/miapi/v1/precio-bitcoin', (data) => {
					$.each(data, (key, value) => {
						if (key === 'time') {
							const date = new Date(value * 1000);
							const formattedDate = date.toLocaleDateString();
							const formattedTime = date.toLocaleTimeString();
							$('#bitcoin-price').append('<p>Fecha y hora: ' + formattedDate + ' ' + formattedTime + '</p>');
						} else {
							$('#bitcoin-price').append('<p>El precio del Bitcoin en <b>' + key + '</b> es de: <b>$' + value + '</b></p>');
						}
					});
				});
			});
		</script>
		<?php

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


/*Añadir una accion para registrar el endpoint REST*/
add_action('rest_api_init', function () {
	register_rest_route('miapi/v1', '/precio-bitcoin', array(
		'methods' => 'GET',
		'callback' => 'obtener_precio_bitcoin',
	));
});

// Función para obtener el precio actual del Bitcoin usando la API de CoinGecko
function obtener_precio_bitcoin()
{
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

	// Decodificar el JSON recibido
	$data = json_decode($response, true);

	// Comprobar si se obtuvo el precio correctamente
	if (isset($data)) {
		foreach ($data as $key => &$value) {
			if ($key != 'time') {
				$value = number_format($value, 2, '.', ',');
			}
		}
		// Retornar el precio formateado como respuesta de la API
		return new WP_REST_Response($data, 200);
	} else {
		// En caso de error, retornar un mensaje de error
		return new WP_Error('bitcoin_no_disponible', 'No se pudo obtener el precio del Bitcoin', array('status' => 500));
	}
}
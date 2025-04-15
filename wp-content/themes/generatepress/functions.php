<?php
/**
 * GeneratePress.
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Set our theme version.
define( 'GENERATE_VERSION', '3.5.1' );

if ( ! function_exists( 'generate_setup' ) ) {
	add_action( 'after_setup_theme', 'generate_setup' );
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 0.1
	 */
	function generate_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'generatepress' );

		// Add theme support for various features.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );

		$color_palette = generate_get_editor_color_palette();

		if ( ! empty( $color_palette ) ) {
			add_theme_support( 'editor-color-palette', $color_palette );
		}

		add_theme_support(
			'custom-logo',
			array(
				'height' => 70,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			)
		);

		// Register primary menu.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'generatepress' ),
			)
		);

		/**
		 * Set the content width to something large
		 * We set a more accurate width in generate_smart_content_width()
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1200; /* pixels */
		}

		// Add editor styles to the block editor.
		add_theme_support( 'editor-styles' );

		$editor_styles = apply_filters(
			'generate_editor_styles',
			array(
				'assets/css/admin/block-editor.css',
			)
		);

		add_editor_style( $editor_styles );
	}
}

/**
 * Get all necessary theme files
 */
$theme_dir = get_template_directory();

require $theme_dir . '/inc/theme-functions.php';
require $theme_dir . '/inc/defaults.php';
require $theme_dir . '/inc/class-css.php';
require $theme_dir . '/inc/css-output.php';
require $theme_dir . '/inc/general.php';
require $theme_dir . '/inc/customizer.php';
require $theme_dir . '/inc/markup.php';
require $theme_dir . '/inc/typography.php';
require $theme_dir . '/inc/plugin-compat.php';
require $theme_dir . '/inc/block-editor.php';
require $theme_dir . '/inc/class-typography.php';
require $theme_dir . '/inc/class-typography-migration.php';
require $theme_dir . '/inc/class-html-attributes.php';
require $theme_dir . '/inc/class-theme-update.php';
require $theme_dir . '/inc/class-rest.php';
require $theme_dir . '/inc/deprecated.php';

if ( is_admin() ) {
	require $theme_dir . '/inc/meta-box.php';
	require $theme_dir . '/inc/class-dashboard.php';
}

/**
 * Load our theme structure
 */
require $theme_dir . '/inc/structure/archives.php';
require $theme_dir . '/inc/structure/comments.php';
require $theme_dir . '/inc/structure/featured-images.php';
require $theme_dir . '/inc/structure/footer.php';
require $theme_dir . '/inc/structure/header.php';
require $theme_dir . '/inc/structure/navigation.php';
require $theme_dir . '/inc/structure/post-meta.php';
require $theme_dir . '/inc/structure/sidebars.php';
require $theme_dir . '/inc/structure/search-modal.php';

function acfpet_register_pet_post_type() {
	$labels = [
		'name' => 'Pets',
		'singular_name' => 'Pet',
		'menu_name' => 'Pets',
		'name_admin_bar' => 'Pet',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Pet',
		'new_item' => 'New Pet',
		'edit_item' => 'Edit Pet',
		'view_item' => 'View Pet',
		'all_items' => 'All Pets',
		'search_items' => 'Search Pets',
		'not_found' => 'No pets found',
		'not_found_in_trash' => 'No pets found in trash',
	];

	$args = [
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => ['slug' => 'pets'],
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true, //Gutenberg support
		'menu_icon' => 'dashicons-pets', //WordPress pet icon
	];

	register_post_type('pet', $args);
}
add_action('init', 'acfpet_register_pet_post_type');

function acfpet_register_pet_taxonomies() {
	//Species
	register_taxonomy('species', 'pet', [
		'label' => 'Species',
		'hierachical' => true,
		'public' => true,
		'rewrite' => ['slug' => 'species'],
		'show_in_rest' => true,
	]);

	//Breed
	register_taxonomy('breed', 'pet', [
		'label' => 'Breed',
		'hierachical' => true,
		'public' => true,
		'rewrite' => ['slug' => 'breed'],
		'show_in_rest' => true,
	]);

	//Location
	register_taxonomy('location', 'pet', [
		'label' => 'Location',
		'hierachical' => 'true',
		'public' => 'true',
		'rewrite' => ['slug' => 'location'],
		'show_in_rest' => true,
	]);
}
add_action('init', 'acfpet_register_pet_taxonomies');
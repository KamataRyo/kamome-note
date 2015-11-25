<?php
/**
 * kamome-note functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kamome-note
 */

if ( ! function_exists( 'kamome_note_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kamome_note_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on kamome-note, use a find and replace
	 * to change 'kamome-note' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'kamome-note', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'kamome-note' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'kamome_note_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}
endif; // kamome_note_setup
add_action( 'after_setup_theme', 'kamome_note_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kamome_note_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kamome_note_content_width', 640 );
}
add_action( 'after_setup_theme', 'kamome_note_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kamome_note_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kamome-note' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'kamome_note_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function kamome_note_scripts() {
	$lib_uri = get_template_directory_uri() . '/js/lib' ;

	//defaults
	wp_enqueue_style( 'kamome-note-style', get_stylesheet_uri(), array( 'bootstrap' ) );
	#wp_enqueue_style( 'kamome-note-style', get_template_directory_uri() . '/style-rtl.css', 'bootstrap' );

	wp_enqueue_script( 'kamome-note-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'kamome-note-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	// additional
	wp_enqueue_style( 'bootstrap', $lib_uri . '/bootstrap/dist/css/bootstrap.min.css', array()  );
	#wp_enqueue_style( 'bootstrap-rtl', $lib_uri . '/bootstrap/dist/css/bootstrap-rtl.min.css', array( 'jquery', 'bootstrap')  );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kamome_note_scripts' );


/**
 * Control Bootstrap Grids.
 */
// define( 'KAMOME_NOTE_BOOTSTRAP_GRID_OF_MAIN_COL', 'col-xs-12 col-sm-8 col-md-9 col-lg-10 pull-right' );
// define( 'KAMOME_NOTE_BOOTSTRAP_GRID_OF_SIDEBAR_COL', 'col-xs-12 col-sm-4 col-md-3 col-lg-2' );
define( 'KAMOME_NOTE_BOOTSTRAP_GRID_OF_MAIN_COL', 'col-xs-12' );
define( 'KAMOME_NOTE_BOOTSTRAP_GRID_OF_SIDEBAR_COL', 'col-xs-12' );
function kamome_note_open_grid_loop( $count ) {
	if ( $count % 3 === 1 ) {
		echo '<div class="row"><div class="post-grid_wrapper col-xs-12 col-sm-6 col-md-4">';
	} else {
		echo '<div class="post-grid_wrapper col-xs-12 col-sm-6 col-md-4">';
		}
}
function kamome_note_close_grid_loop ( $count ) {
	if ( $count % 3 === 1 || $count % 3 === 2 ) {
		echo '</div>';
	} else {
		echo '</div></div>';
	}
}
function kamome_note_close_grid_loop_terminator ($count) {
	if ( $count % 3 === 1  || $count % 3 === 2  ) {
		echo '</div>';
	}
}







/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

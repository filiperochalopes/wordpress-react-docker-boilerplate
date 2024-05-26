<?php
/**
 * wp_api theme functions and definitions
 */

//  Adicionando CSS para páginas do tema
function wpdocs_theme_style() {
    wp_enqueue_style( "style", get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_style' );

//  Adicionando CSS global para páginas do dashboard
function wpdocs_admin_theme_style() {
    wp_enqueue_style( "style_admin", get_template_directory_uri().'/style_admin.css' );
}
add_action('admin_enqueue_scripts', 'wpdocs_admin_theme_style');

//  Adicionando JS para páginas do dashboard
function wpdocs_admin_theme_script() {
    wp_enqueue_script('script_admin', get_template_directory_uri().'/js/main.js' , array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'wpdocs_admin_theme_script');

function remove_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Designando sistema de upload padrão para wordpress
function wpb_image_editor_default_to_gd( $editors ) {
    $gd_editor = 'WP_Image_Editor_GD';
    $editors = array_diff( $editors, array( $gd_editor ) );
    array_unshift( $editors, $gd_editor );
    return $editors;
}
add_filter( 'wp_image_editors', 'wpb_image_editor_default_to_gd' );

// Filter except length to 15 words.
// tn custom excerpt length
function tn_custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'tn_custom_excerpt_length', 999 );

// Adicionar imagem destacada
add_theme_support( 'post-thumbnails' );

// Adicionando tipos de postagem personalizados
include_once("cpt_banners.php");

// Adicionando REST API
include_once("api_smtp.php");

//Adicionar tag e categorias à páginas
function add_category_tags_to_pages_settings() {  
    // Add tag metabox to page
	register_taxonomy_for_object_type('post_tag', 'page'); 
	register_taxonomy_for_object_type('category', 'page');
}
 // Add to the admin_init hook of your theme functions.php file 
add_action( 'init', 'add_category_tags_to_pages_settings' );

// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}

add_action('admin_init', 'df_disable_comments_post_types_support');
// Close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url()); exit;
	}
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action('init', 'df_disable_comments_admin_bar');


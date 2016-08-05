<?php 
// Deshabilitar la ejecución directa de archivos PHP
if ( ! defined( 'WPINC' ) ) {
    die;
}


//textdomain: equipo
if ( ! function_exists( 'equipo_textdomain' ) ) :
add_action( 'equipo_init', 'equipo_textdomain' );

function equipo_textdomain() {
	load_plugin_textdomain( 'equipo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
endif;

//custom post type
if ( ! function_exists( 'equipo_init_includes' ) ) :
add_action( 'equipo_init', 'equipo_init_includes' );

function equipo_init_includes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/ctp.php';
}
endif;

// metaboxes
if ( ! function_exists( 'equipo_plugin_init_admin' ) && is_admin() ) :
add_action( 'equipo_init', 'equipo_plugin_init_admin' );

function equipo_plugin_init_admin() {
	require_once plugin_dir_path( __FILE__ ) . 'admin/equipo_mb.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings.php';
}
endif;

//init public
if ( ! function_exists( 'equipo_plugin_init_public' ) && ! is_admin() ) :
add_action( 'equipo_init', 'equipo_plugin_init_public' );

function equipo_plugin_init_public() {
	require_once plugin_dir_path( __FILE__ ) . 'public/equipo-functions.php';
}
endif;


//Loading Styles and scripts	
if ( ! function_exists( 'add_style_admin' ) && is_admin() ) :
add_action( 'equipo_init', 'add_style_admin' );
function add_style_admin() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style1', $plugin_url . 'admin/assets/css/style.css' );
    wp_enqueue_style( 'style2', $plugin_url . 'includes/css/bootstrap.min.css' );
    wp_enqueue_style( 'font-awesome', $plugin_url . 'includes/css/font-awesome.min.css' );
}
endif;

if ( ! function_exists( 'add_scripts_admin' ) && is_admin() ) :
add_action( 'equipo_init', 'add_scripts_admin' );
function add_scripts_admin() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_script('bootstrap', $plugin_url . 'includes/js/bootstrap.min.js');
}
endif;

do_action( 'equipo_init' );


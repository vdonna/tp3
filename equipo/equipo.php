<?php  
/*
Plugin Name: Equipo de trabajo
Author: Donnadio Veronica
Description: Crear un plugin con las siguientes características: Custom Post Type. Meta Boxes (al menos una) para el nuevo Custom Post Type. Que los datos guardados con Meta Boxes se muestren en la página del post perteneciente al nuevo Custom Post Type. Crear un menú de administración, submenú de administración, o página de opciones para la configuración general del plugin. Mostrar y guardar la configuración usando la Settings API.
Domain Path: /languages
Text Domain: equipo
*/

// Deshabilitar la ejecución directa de archivos PHP
if ( ! defined( 'WPINC' ) ) {
    die;
}

// init.php
if ( ! function_exists( 'equipo_plugin_load' ) ) :
add_action( 'plugins_loaded', 'equipo_plugin_load' );

function equipo_plugin_load() {
	if ( apply_filters( 'equipo_init', true ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'init.php';
	}
}
endif;

<?php
// Deshabilitar la ejecución directa de archivos PHP
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! function_exists( 'equipo_details' ) ) :
add_filter( 'the_content', 'equipo_details' );

function equipo_details( $content ) {
	if ( 'equipo' === get_post_type() ) {
		$post_id = get_the_ID();
		if ( $name= esc_html( get_post_meta( $post_id, '_equipo_name', true ) ) ) {
			$content .= '<strong>' . esc_html__( '', 'equipo' ) . '</strong> ' . $name . '<br />';
		}
		if ( $title= esc_html( get_post_meta( $post_id, '_equipo_title', true ) ) ) {
			$content .= '<strong>' . esc_html__( '', 'equipo' ) . '</strong> ' . $title . '<br />';
		}
		if ( $email = esc_html( get_post_meta( $post_id, '_equipo_email', true ) ) ) {
			$content .= '<strong>' . esc_html__( 'Email:', 'equipo' ) . '</strong> ' . $email . '<br />';
		}

		if ( $website = esc_url( get_post_meta( $post_id, '_equipo_website', true ) ) ) {
			$content .= '<strong>' . esc_html__( 'Website:', 'equipo' ) . '</strong> ' . $website . '<br />';
		}
		if ( $facebook = esc_url( get_post_meta( $post_id, '_equipo_facebook', true ) ) ) {
			$content .= '<strong>' . esc_html__( 'Facebook:', 'equipo' ) . '</strong> ' . $facebook . '<br />';
		}
		if ( $twitter = esc_url( get_post_meta( $post_id, '_equipo_twitter', true ) ) ) {
			$content .= '<strong>' . esc_html__( 'Twitter:', 'equipo' ) . '</strong> ' . $twitter . '<br />';
		}
	}
	return $content;
}
endif;


if ( ! function_exists( 'equipo_project_show_logged_in_only' ) ) :
add_filter( 'the_content', 'equipo_project_show_logged_in_only', 999 );

function equipo_project_show_logged_in_only( $content ) {
	$settings = get_option( 'equipo_settings' );
	// Si se elige mostrar solo a usuarios registrados y el usuario actual no está logueado, reemplazamos el contenido por un mensaje.
	if ( ! empty( $settings['show_logged_only'] ) && ! is_user_logged_in() ) {
		$content = esc_html__( 'You don\'t have permissions to view this content.', 'equipo' );
	}
	return $content;
}
endif;

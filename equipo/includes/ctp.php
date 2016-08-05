<?php 
// Deshabilitar la ejecución directa de archivos PHP
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! function_exists( 'equipo_ctp' ) ) :
add_action( 'init', 'equipo_ctp' );

/* registro ctp -> register_post_type( $post_type, $args ); */
function equipo_ctp() {
    register_post_type( 'equipo', array(

            'labels' => array(
                'name' => __( 'Team Profiles', 'equipo' ),          // Nombre (en plural) para este tipo de contenido.
                'singular_name' => __( 'Team Profile' , 'equipo' ), // Nombre (en singular) para este tipo de contenido.
                'add_new' => _x("Add New", "Team Profile"),
                'add_new_item' => __("Add New Profile"),

            ),
            //Define características soportadas por el post type.
            'supports' => array(
                'title',     // Permite ingresar título
                /*'editor',    // Permite usar el editor de texto*/
                'author',    // Permite definir y modificar el autor
                /*'excerpt',   // Permite usar el campo de extracto de la entrada*/
                'thumbnail', // Permite ingresar imagen destacada
            ),
            'public' => true, // Hace accesibles las entradas desde el front-end.
            'has_archive' => true, // Hace accesible el sumario de entradas de este tipo.
            'menu_icon' => 'dashicons-businessman',
        )
    );
}

endif;


// taxonomy: category
if ( ! function_exists( 'equipo_register_category_taxonomy' ) ) :
add_action( 'init', 'equipo_register_category_taxonomy' );

function equipo_register_category_taxonomy() {
    // Taxonomía equivalente a categorías de posts.
    register_taxonomy( 'equipo-category', 'equipo', array(
            'labels'       => array(
                'name'          => __( 'Team Group', 'equipo' ),
                'singular_name' => __( 'Team Group', 'equipo' ),
            ),
            'hierarchical' => true,
            'public'       =>  true,
        )
    );
}
endif;

// taxonomy: tags
if ( ! function_exists( 'equipo_register_tag_taxonomy' ) ) :
add_action( 'init', 'equipo_register_tag_taxonomy' );

function equipo_register_tag_taxonomy() {
    // Taxonomía equivalente a etiquetas de posts.
    register_taxonomy( 'equipo-tag', 'equipo', array(
            'labels'       => array(
                'name'          => __( 'Tags', 'equipo' ),
                'singular_name' => __( 'Tag', 'equipo' ),
            ),
            'hierarchical' => false,
        )
    );
}
endif;

/**
 * Reseteamos las reglas de permalinks para asegurarnos de que
 * los links a nuestro post type funcionen.
 */
if ( ! function_exists( 'equipo_flush_rewrite_rules' ) ) :
add_action( 'init', 'equipo_flush_rewrite_rules', 90 );

function equipo_flush_rewrite_rules() {
    if ( ! get_option( 'equipo_flushed_rewrite_rules' ) ) {
        flush_rewrite_rules();
        add_option( 'equipo_flushed_rewrite_rules', true );
    }
}
endif;

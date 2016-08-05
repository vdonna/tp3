<?php
// Deshabilitar la ejecución directa de archivos PHP
if ( ! defined( 'WPINC' ) ) {
    die;
}

/*----------------------------------------------------
	Admin menu
----------------------------------------------------*/

if ( ! function_exists( 'equipo_add_submenu_page' ) ) :
add_action( 'admin_menu', 'equipo_add_submenu_page' );
function equipo_add_submenu_page() {
	add_submenu_page(
		'edit.php?post_type=equipo',                       	// Slug del menú principal.
		__( 'Profile Settings', 'equipoequipo' ), 		// Texto del título que aparece en la página de opciones.
		__( 'Settings', 'equipo' ),           				// Texto que aparece en el link principal del menú.
		'manage_options',                                   // Permiso que debe tener el usuario para ver el menú.
		'equipo-settings',                               // Slug, string que permite identificar internamente el menú.
		'equipo_settings_page_callback'                  // Nombre de la función que imprime el HTML de la página de opciones.
	);
}
endif;

if ( ! function_exists( 'equipo_settings_page_callback' ) ) :
function equipo_settings_page_callback() {
	?>
	<div class="wrap">
		<h1><?php _e( 'Profile Settings', 'equipo' ); ?></h1>

		<form action="options.php" method="POST">
			<?php settings_fields( 'equipo_settings_group' ); // Imprime el HTML necesario para las validaciones. ?>
			<?php do_settings_sections( 'equipo-settings' ); // Imprime nuestra sección y los campos asociados. ?>
			<?php submit_button(); // Imprime el botón de confirmación. ?>
		</form>
	</div>
	<?php
}
endif;

/*----------------------------------------------------
	Settings
----------------------------------------------------*/

if ( ! function_exists( 'equipo_register_settings' ) ) :
add_action( 'admin_init', 'equipo_register_settings' );

function equipo_register_settings() {
	// Registramos una sección para nuestro campo.
	add_settings_section(
		'equipo-general-settings-section',             // Texto del tag `id` de la sección.
		__( 'General Settings', 'equipo' ), 		   // Título de la sección.
		'equipo_general_settings_section_callback',    // Nombre de la función que imprime el HTML de la sección.
		'equipo-settings'                              // Slug del menú donde debe aparecer la sección.
	);
	// Registramos un campo asociado a la sección.
	add_settings_field(
		'equipo-settings-show-logged-only-setting',                         // Texto del tag `id` del campo.
		__( 'Only show projects to logged-in users', 'equipo' ), 			// Título del campo.
		'equipo_settings_show_logged_only_callback',                        // Nombre de la función que imprime el HTML del campo.
		'equipo-settings',                                                  // Slug del menú donde debe aparecer el campo.
		'equipo-general-settings-section'                                   // ID de la sección a la que pertenece el campo.
	);

	// Registramos una sección para nuestro campo.
	add_settings_section(
		'equipo-general-settings-section2',             // Texto del tag `id` de la sección.
		__( 'Visual Settings', 'equipo' ), 		   // Título de la sección.
		'equipo_visual_settings_section_callback',    // Nombre de la función que imprime el HTML de la sección.
		'equipo-settings'                              // Slug del menú donde debe aparecer la sección.
	);

	add_settings_field(
		'choose-color',                         // Texto del tag `id` del campo.
		__( 'Color Scheme', 'equipo' ), 			// Título del campo.
		'choose_color_callback',                        // Nombre de la función que imprime el HTML del campo.
		'equipo-settings',                                                  // Slug del menú donde debe aparecer el campo.
		'equipo-general-settings-section2'                                  // ID de la sección a la que pertenece el campo.
	);


	register_setting( 'equipo_settings_group', 'equipo_settings', 'equipo_sanitize_show_logged_only' );
}
endif;

/*----------------------------------------------------
	Settings Sections Callback
----------------------------------------------------*/

if ( ! function_exists( 'equipo_general_settings_section_callback' ) ) :
function equipo_general_settings_section_callback() {
	_e( 'Configure the general plugin settings here' );
}
endif;

if ( ! function_exists( 'equipo_visual_settings_section_callback' ) ) :
function equipo_visual_settings_section_callback() {
	_e( 'Configure the visual plugin settings here' );
}
endif;

/*----------------------------------------------------
	Settings Fields Callback
----------------------------------------------------*/

if ( ! function_exists( 'equipo_settings_show_logged_only_callback' ) ) :
function equipo_settings_show_logged_only_callback() {
	$settings = get_option( 'equipo_settings' );
	$checked  = isset( $settings['show_logged_only'] ) ? $settings['show_logged_only'] : false;
	?>
	<input id="equipo-settings-show-logged-only" name="equipo_settings[show_logged_only]" type="checkbox" value="true" <?php checked( $checked ); ?>/>
	<label for="equipo-settings-show-logged-only"><?php _e( 'Check to show projects only to logged-in users', 'equipo' ); ?></label>
	<?php
}
endif;


if ( ! function_exists( 'choose_color_callback' ) ) :
function choose_color_callback() {
	$settings = get_option( 'equipo_settings' );
    ?>
    <form method="POST" action="">
        <select name ="colour">
            <option value="red" <?php if ($settings=='red') { echo 'selected=1'; } ?> >Red</option>
            <option value="green" <?php if ($settings=='green') { echo "selected=1"; } ?>>Green</option>
            <option value="blue" <?php if ($settings=='blue') { echo "selected=1"; } ?>>Blue</option>
        </select>           
    </form>

    <?php
}
endif;


/*----------------------------------------------------
	Settings Sanitize
----------------------------------------------------*/

if ( ! function_exists( 'equipo_sanitize_show_logged_only' ) ) :
function equipo_sanitize_show_logged_only( $data ) {
	if ( isset( $data['show_logged_only'] ) ) {
		// Chequeamos si el valor ingresado está permitido. Si lo está, mostramos proyectos solo a usuarios registrados.
		$accepted_values          = array( true, 'true' );
		$data['show_logged_only'] = in_array( $data['show_logged_only'], $accepted_values );
	}
	return $data;
}
endif;


<?php
// Deshabilitar la ejecución directa de archivos PHP
if ( ! defined( 'WPINC' ) ) {
    die;
}


// add metabox
if ( ! function_exists( 'equipo_add_meta_box' ) ) :
add_action( 'add_meta_boxes', 'equipo_add_meta_box' );

function equipo_add_meta_box() {
	add_meta_box(
		'equipo-meta-box',
		__( 'Member Profile', 'equipo' ),
		'equipo_meta_box_callback',
		'equipo' 
	);
}
endif;

//callback - validacion
if ( ! function_exists( 'equipo_meta_box_callback' ) ) :

function equipo_meta_box_callback( WP_Post $post ) {
	wp_nonce_field( '_equipo_data', '_equipo_data_nonce' );
	$name     = get_post_meta( $post->ID, '_equipo_name', true );
	$title     = get_post_meta( $post->ID, '_equipo_title', true );
	$email     = get_post_meta( $post->ID, '_equipo_email', true );
	$website   = get_post_meta( $post->ID, '_equipo_website', true );
	$facebook  = get_post_meta( $post->ID, '_equipo_facebook', true );
	$twitter   = get_post_meta( $post->ID, '_equipo_twitter', true );
	$submit  = get_post_meta( $post->ID, '_equipo_submit', true );
	?>

	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
					<i class="more-less fa fa-angle-right" aria-hidden="true"></i>Member Information</a>
				</div>
			</div>

			<div id="collapse1" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="equipo-field">
						<label for="_equipo_name"><?php esc_html_e( 'Name', 'equipo' ); ?></label><br>
						<input type="text" name="_equipo_name" placeholder="Name" value="<?php echo esc_attr( $name ); ?>"/>
					</div>
					<div class="equipo-field">
						<label for="_equipo_title"><?php esc_html_e( 'Title', 'equipo' ); ?></label><br>
						<input type="text" name="_equipo_title" placeholder="Web Developer" value="<?php echo esc_attr( $title ); ?>"/>
					</div>

					<div class="equipo-field">
						<label for="_equipo_email"><?php esc_html_e( 'Email', 'equipo' ); ?></label><br>
						<input type="email" name="_equipo_email" placeholder="hello@gmail.com" value="<?php echo esc_attr( $email ); ?>"/>
					</div>

					<hr class="linea"/>

					<div class="equipo-field">
						<label for="_equipo_website"><?php esc_html_e( 'Website', 'equipo' ); ?></label><br>
						<input type="text" name="_equipo_website" placeholder="http://myweb.com.ar" value="<?php echo esc_attr( $website ); ?>"/>
					</div>

					<div class="equipo-field">
						<label for="_equipo_facebook"><?php esc_html_e( 'Facebook', 'equipo' ); ?></label><br>
						<input type="text" name="_equipo_facebook" placeholder="http://web.com/username" value="<?php echo esc_attr( $facebook ); ?>"/>
					</div>

					<div class="equipo-field">
						<label for="_equipo_twitter"><?php esc_html_e( 'Twitter', 'equipo' ); ?></label><br>
						<input type="text" name="_equipo_twitter" placeholder="http://web.com/username"  value="<?php echo esc_attr( $twitter ); ?>"/>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="equipo-boton">
		<a href="#" class="button button-large">Add Another Member Profile</a>
	</div>
	<?php
}
endif;

//save - update - sanitize
if ( ! function_exists( 'equipo_save_data' ) ) :
add_action( 'save_post', 'equipo_save_data', 10, 2 );

function equipo_save_data( $post_id, WP_Post $post ) {
	// Si no se reciben los datos esperados, salir de la función.
	if (    ! isset( $_POST['_equipo_name'] )
		 || ! isset( $_POST['_equipo_title'] )
	     || ! isset( $_POST['_equipo_email'] )
	     || ! isset( $_POST['_equipo_website'] )
	     || ! isset( $_POST['_equipo_facebook'] )
	     || ! isset( $_POST['_equipo_twitter'] )
	) {
		return;
	}
	// Si no se aprueba el chequeo de seguridad, salir de la función.
	if ( ! isset( $_POST['_equipo_data_nonce'] ) || ! wp_verify_nonce( $_POST['_equipo_data_nonce'], '_equipo_data' ) ) {
		return;
	}
	$post_type = get_post_type_object( $post->post_type );
	// Si el usuario actual no tiene permisos para modificar el post, salir de la función.
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return;
	}
	// Convertimos los datos ingresados a formatos válidos para nuestros campos.
	$name     = sanitize_text_field( $_POST['_equipo_name'] );
	$title     = sanitize_text_field( $_POST['_equipo_title'] );
	$email   = sanitize_text_field( $_POST['_equipo_email']  );
	$website       = esc_url_raw( $_POST['_equipo_website'] );
	$facebook       = esc_url_raw( $_POST['_equipo_facebook']  );
	$twitter        = esc_url_raw( $_POST['_equipo_twitter'] );

	// Guardamos datos
	update_post_meta( $post_id, '_equipo_name', $name);
	update_post_meta( $post_id, '_equipo_title', $title);
	update_post_meta( $post_id, '_equipo_email', $email );
	update_post_meta( $post_id, '_equipo_website', $website);
	update_post_meta( $post_id, '_equipo_facebook', $facebook );
	update_post_meta( $post_id, '_equipo_twitter', $twitter );
}
endif;
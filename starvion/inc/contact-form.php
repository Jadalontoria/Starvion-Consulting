<?php
/**
 * Contact form: [starvion_contact_form] shortcode and its handler.
 *
 * Sends enquiries to the site admin email by default. Change the recipient
 * with the `starvion_contact_recipient` filter, or in Settings > General.
 *
 * @package Starvion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Areas of interest shown in the form's dropdown.
 *
 * @return string[]
 */
function starvion_contact_interests() {
	return array(
		__( 'Business needs analysis', 'starvion' ),
		__( 'Product design', 'starvion' ),
		__( 'Data strategy', 'starvion' ),
		__( 'Cloud migration', 'starvion' ),
		__( 'Vendor oversight', 'starvion' ),
		__( 'Not sure yet', 'starvion' ),
	);
}

/**
 * Render the form.
 *
 * @return string
 */
function starvion_contact_form_shortcode() {
	$status = isset( $_GET['enquiry'] ) ? sanitize_key( wp_unslash( $_GET['enquiry'] ) ) : '';

	ob_start();

	if ( 'sent' === $status ) {
		echo '<div class="starvion-notice" role="status"><p>' . esc_html__( 'Thanks for getting in touch. We\'ll be in contact within one business day.', 'starvion' ) . '</p></div>';
		return ob_get_clean();
	}

	if ( 'invalid' === $status ) {
		echo '<div class="starvion-notice is-error" role="alert"><p>' . esc_html__( 'Please fill in your name, a valid email address and a message.', 'starvion' ) . '</p></div>';
	} elseif ( 'failed' === $status ) {
		echo '<div class="starvion-notice is-error" role="alert"><p>' . esc_html__( 'Sorry, your message could not be sent. Please email us directly.', 'starvion' ) . '</p></div>';
	}
	?>
	<form class="starvion-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="starvion_contact">
		<?php wp_nonce_field( 'starvion_contact', 'starvion_contact_nonce' ); ?>
		<div class="starvion-hp" aria-hidden="true">
			<label for="starvion-website">Website</label>
			<input type="text" id="starvion-website" name="website" tabindex="-1" autocomplete="off">
		</div>
		<div class="starvion-form-row">
			<p>
				<label for="starvion-name"><?php esc_html_e( 'Name', 'starvion' ); ?></label>
				<input type="text" id="starvion-name" name="name" required autocomplete="name">
			</p>
			<p>
				<label for="starvion-company"><?php esc_html_e( 'Company', 'starvion' ); ?></label>
				<input type="text" id="starvion-company" name="company" autocomplete="organization">
			</p>
		</div>
		<div class="starvion-form-row">
			<p>
				<label for="starvion-email"><?php esc_html_e( 'Email', 'starvion' ); ?></label>
				<input type="email" id="starvion-email" name="email" required autocomplete="email">
			</p>
			<p>
				<label for="starvion-phone"><?php esc_html_e( 'Phone (optional)', 'starvion' ); ?></label>
				<input type="tel" id="starvion-phone" name="phone" autocomplete="tel">
			</p>
		</div>
		<p>
			<label for="starvion-interest"><?php esc_html_e( 'Area of interest', 'starvion' ); ?></label>
			<select id="starvion-interest" name="interest">
				<?php foreach ( starvion_contact_interests() as $interest ) : ?>
					<option value="<?php echo esc_attr( $interest ); ?>"><?php echo esc_html( $interest ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="starvion-message"><?php esc_html_e( 'Message', 'starvion' ); ?></label>
			<textarea id="starvion-message" name="message" required></textarea>
		</p>
		<button type="submit"><?php esc_html_e( 'Send enquiry', 'starvion' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'starvion_contact_form', 'starvion_contact_form_shortcode' );

/**
 * Handle a submission and redirect back with a status.
 */
function starvion_handle_contact() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/contact/' );
	$back = remove_query_arg( 'enquiry', $back );

	if ( ! isset( $_POST['starvion_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['starvion_contact_nonce'] ) ), 'starvion_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'failed', $back ) );
		exit;
	}

	// Bots fill the hidden field; pretend it worked.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $back ) );
		exit;
	}

	$name     = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$company  = isset( $_POST['company'] ) ? sanitize_text_field( wp_unslash( $_POST['company'] ) ) : '';
	$email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone    = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$interest = isset( $_POST['interest'] ) ? sanitize_text_field( wp_unslash( $_POST['interest'] ) ) : '';
	$message  = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'invalid', $back ) );
		exit;
	}

	if ( ! in_array( $interest, starvion_contact_interests(), true ) ) {
		$interest = '';
	}

	$recipient = apply_filters( 'starvion_contact_recipient', get_option( 'admin_email' ) );
	/* translators: %s: sender name */
	$subject = sprintf( __( 'New website enquiry from %s', 'starvion' ), $name );
	$body    = implode(
		"\n",
		array(
			'Name: ' . $name,
			'Company: ' . $company,
			'Email: ' . $email,
			'Phone: ' . $phone,
			'Area of interest: ' . $interest,
			'',
			$message,
		)
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $recipient, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'enquiry', $sent ? 'sent' : 'failed', $back ) );
	exit;
}
add_action( 'admin_post_starvion_contact', 'starvion_handle_contact' );
add_action( 'admin_post_nopriv_starvion_contact', 'starvion_handle_contact' );

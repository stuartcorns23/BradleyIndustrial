<?php
/**
 * Built-in contact form (no plugin needed). Sends with wp_mail().
 *
 * Use it with the "Contact" page template, or anywhere with the [bi_contact_form] shortcode.
 *
 * @package Bradley_Industrial
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render the form.
 *
 * @return string
 */
function bi_contact_form() {
	$status = isset( $_GET['enquiry'] ) ? sanitize_key( wp_unslash( $_GET['enquiry'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	ob_start();

	if ( 'sent' === $status ) {
		echo '<div class="bi-notice bi-notice--ok" role="status">' . esc_html__( 'Thank you, your enquiry has been sent. We will be in touch shortly.', 'bradley-industrial' ) . '</div>';
	} elseif ( 'invalid' === $status ) {
		echo '<div class="bi-notice bi-notice--error" role="alert">' . esc_html__( 'Please fill in your name, a valid email address and your requirements.', 'bradley-industrial' ) . '</div>';
	} elseif ( 'failed' === $status ) {
		echo '<div class="bi-notice bi-notice--error" role="alert">' . esc_html__( 'Sorry, your enquiry could not be sent. Please call or email us instead.', 'bradley-industrial' ) . '</div>';
	}
	?>
	<form class="bi-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="bi_contact" />
		<input type="hidden" name="redirect" value="<?php echo esc_url( get_permalink() ); ?>" />
		<?php wp_nonce_field( 'bi_contact', 'bi_contact_nonce' ); ?>
		<div class="field">
			<label for="bi-name"><?php esc_html_e( 'Your name', 'bradley-industrial' ); ?> *</label>
			<input type="text" id="bi-name" name="bi_name" autocomplete="name" required />
		</div>
		<div class="field">
			<label for="bi-email"><?php esc_html_e( 'Your email', 'bradley-industrial' ); ?> *</label>
			<input type="email" id="bi-email" name="bi_email" autocomplete="email" required />
		</div>
		<div class="field">
			<label for="bi-phone"><?php esc_html_e( 'Your phone number', 'bradley-industrial' ); ?></label>
			<input type="tel" id="bi-phone" name="bi_phone" autocomplete="tel" />
		</div>
		<div class="field">
			<label for="bi-message"><?php esc_html_e( 'Overview of your requirements', 'bradley-industrial' ); ?> *</label>
			<textarea id="bi-message" name="bi_message" rows="6" placeholder="<?php esc_attr_e( 'Please use this space to tell us what you need', 'bradley-industrial' ); ?>" required></textarea>
		</div>
		<div class="hp" aria-hidden="true">
			<label for="bi-website"><?php esc_html_e( 'Leave this field empty', 'bradley-industrial' ); ?></label>
			<input type="text" id="bi-website" name="bi_website" tabindex="-1" autocomplete="off" />
		</div>
		<button type="submit" class="bi-button"><?php esc_html_e( 'Send enquiry', 'bradley-industrial' ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'bi_contact_form', 'bi_contact_form' );

/**
 * Handle a submission.
 */
function bi_handle_contact() {
	$redirect = isset( $_POST['redirect'] ) ? esc_url_raw( wp_unslash( $_POST['redirect'] ) ) : home_url( '/' );
	$redirect = wp_validate_redirect( $redirect, home_url( '/' ) );

	if ( ! isset( $_POST['bi_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bi_contact_nonce'] ) ), 'bi_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'failed', $redirect ) );
		exit;
	}

	// Honeypot: bots fill every field. Pretend it worked.
	if ( ! empty( $_POST['bi_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['bi_name'] ) ? sanitize_text_field( wp_unslash( $_POST['bi_name'] ) ) : '';
	$email   = isset( $_POST['bi_email'] ) ? sanitize_email( wp_unslash( $_POST['bi_email'] ) ) : '';
	$phone   = isset( $_POST['bi_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['bi_phone'] ) ) : '';
	$message = isset( $_POST['bi_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['bi_message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'invalid', $redirect ) );
		exit;
	}

	$to = bi_mod( 'bi_form_recipient' );
	if ( ! is_email( $to ) ) {
		$to = bi_mod( 'bi_email' );
	}
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	/* translators: %s: sender name. */
	$subject = sprintf( __( 'Website enquiry from %s', 'bradley-industrial' ), $name );
	$body    = sprintf(
		"Name: %s\nEmail: %s\nPhone: %s\n\n%s\n",
		$name,
		$email,
		$phone ? $phone : '-',
		$message
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'enquiry', $sent ? 'sent' : 'failed', $redirect ) . '#enquiry' );
	exit;
}
add_action( 'admin_post_nopriv_bi_contact', 'bi_handle_contact' );
add_action( 'admin_post_bi_contact', 'bi_handle_contact' );

<?php
/**
 * Simple, self-contained contact form for the Contact page template.
 *
 * Sends to the site admin email (Settings → General) with wp_mail, protected
 * by a nonce and a honeypot. If a dedicated form plugin is preferred, drop its
 * shortcode into the Contact page instead; this is only a sensible default.
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle a contact-form submission early, so we can redirect on success.
 */
function tebasuci_handle_contact_form() {
	if ( empty( $_POST['tebasuci_contact'] ) ) {
		return;
	}

	$referer = wp_get_referer();
	$back    = $referer ? $referer : home_url( '/' );

	// Nonce.
	if ( ! isset( $_POST['tebasuci_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tebasuci_contact_nonce'] ) ), 'tebasuci_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', remove_query_arg( 'contact', $back ) ) );
		exit;
	}

	// Honeypot: real people leave this hidden field empty.
	if ( ! empty( $_POST['tebasuci_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'sent', remove_query_arg( 'contact', $back ) ) );
		exit;
	}

	$name    = isset( $_POST['tebasuci_name'] ) ? sanitize_text_field( wp_unslash( $_POST['tebasuci_name'] ) ) : '';
	$email   = isset( $_POST['tebasuci_email'] ) ? sanitize_email( wp_unslash( $_POST['tebasuci_email'] ) ) : '';
	$message = isset( $_POST['tebasuci_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tebasuci_message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', remove_query_arg( 'contact', $back ) ) );
		exit;
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf(
		/* translators: %s: site name. */
		__( 'Website enquiry — %s', 'tebasuci' ),
		wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES )
	);
	$body    = sprintf(
		"%s\n\n%s: %s\n%s: %s\n\n%s:\n%s\n",
		__( 'New enquiry from the website contact form.', 'tebasuci' ),
		__( 'Name', 'tebasuci' ),
		$name,
		__( 'Email', 'tebasuci' ),
		$email,
		__( 'Message', 'tebasuci' ),
		$message
	);
	$headers = array(
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', $sent ? 'sent' : 'error', remove_query_arg( 'contact', $back ) ) );
	exit;
}
add_action( 'template_redirect', 'tebasuci_handle_contact_form' );

/**
 * Render the contact form (and any success/error notice).
 */
function tebasuci_contact_form() {
	$status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only status.

	if ( 'sent' === $status ) {
		echo '<p class="form-notice form-notice--ok">' . esc_html__( 'Thank you — your message has been sent. We’ll be in touch shortly.', 'tebasuci' ) . '</p>';
	} elseif ( 'error' === $status ) {
		echo '<p class="form-notice form-notice--error">' . esc_html__( 'Sorry, something went wrong. Please check your details and try again, or reach us on WhatsApp.', 'tebasuci' ) . '</p>';
	}
	?>
	<form class="contact-form" method="post" action="<?php echo esc_url( home_url( add_query_arg( array() ) ) ); ?>">
		<p>
			<label for="tebasuci_name"><?php esc_html_e( 'Your name', 'tebasuci' ); ?></label>
			<input type="text" id="tebasuci_name" name="tebasuci_name" required>
		</p>
		<p>
			<label for="tebasuci_email"><?php esc_html_e( 'Email', 'tebasuci' ); ?></label>
			<input type="email" id="tebasuci_email" name="tebasuci_email" required>
		</p>
		<p>
			<label for="tebasuci_message"><?php esc_html_e( 'Message', 'tebasuci' ); ?></label>
			<textarea id="tebasuci_message" name="tebasuci_message" rows="5" required></textarea>
		</p>
		<p class="contact-form-hp" aria-hidden="true">
			<label for="tebasuci_website"><?php esc_html_e( 'Leave this field empty', 'tebasuci' ); ?></label>
			<input type="text" id="tebasuci_website" name="tebasuci_website" tabindex="-1" autocomplete="off">
		</p>
		<?php wp_nonce_field( 'tebasuci_contact', 'tebasuci_contact_nonce' ); ?>
		<input type="hidden" name="tebasuci_contact" value="1">
		<button type="submit" class="button room-cta"><?php esc_html_e( 'Send message', 'tebasuci' ); ?> <?php echo tebasuci_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></button>
	</form>
	<?php
}

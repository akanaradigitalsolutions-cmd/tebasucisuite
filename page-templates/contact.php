<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * @package TebaSuci
 */

get_header();

$tebasuci_address = (string) tebasuci_get( 'address' );
$tebasuci_email   = (string) tebasuci_get( 'email' );
$tebasuci_phone   = (string) tebasuci_get( 'phone' );
$tebasuci_wa      = (string) tebasuci_get( 'whatsapp' );

tebasuci_render_page_hero(
	array(
		'eyebrow' => __( 'Get in touch', 'tebasuci' ),
		'title'   => get_the_title(),
		'intro'   => __( 'We’d love to hear from you. Reach out about a stay, a table at D’Gadon Cafe, an event or anything else — we’ll reply as soon as we can.', 'tebasuci' ),
	)
);
?>

<section class="contact-page">
	<div class="contact-details" data-reveal>
		<?php if ( '' !== $tebasuci_address ) : ?>
			<div class="contact-block">
				<span class="eyebrow"><?php esc_html_e( 'Our location', 'tebasuci' ); ?></span>
				<p><?php echo tebasuci_lines( 'address' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></p>
			</div>
		<?php endif; ?>

		<?php if ( '' !== $tebasuci_phone || '' !== $tebasuci_wa ) : ?>
			<div class="contact-block">
				<span class="eyebrow"><?php esc_html_e( 'Phone & WhatsApp', 'tebasuci' ); ?></span>
				<ul class="contact-lines">
					<?php if ( '' !== $tebasuci_phone ) : ?>
						<li><?php tebasuci_link( 'tel:' . preg_replace( '/[^0-9+]/', '', $tebasuci_phone ), $tebasuci_phone, '', '' ); ?> <small><?php esc_html_e( 'Reservations', 'tebasuci' ); ?></small></li>
					<?php endif; ?>
					<?php
					$tebasuci_contacts = tebasuci_contact_items();
					foreach ( $tebasuci_contacts as $tebasuci_item ) :
						if ( 0 === strpos( $tebasuci_item[0], 'https://wa.me' ) ) :
							?>
							<li><?php tebasuci_link( $tebasuci_item[0], $tebasuci_item[1], '', '' ); ?></li>
							<?php
						endif;
					endforeach;
					?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if ( '' !== $tebasuci_email && is_email( $tebasuci_email ) ) : ?>
			<div class="contact-block">
				<span class="eyebrow"><?php esc_html_e( 'Email', 'tebasuci' ); ?></span>
				<p><?php tebasuci_link( 'mailto:' . $tebasuci_email, $tebasuci_email, '', '' ); ?></p>
			</div>
		<?php endif; ?>

		<?php
		$tebasuci_social = array_filter(
			tebasuci_contact_items(),
			static function ( $item ) {
				return (bool) preg_match( '#instagram\.com|tripadvisor\.|facebook\.com#i', $item[0] );
			}
		);
		if ( $tebasuci_social ) :
			?>
			<div class="contact-block">
				<span class="eyebrow"><?php esc_html_e( 'Find us on', 'tebasuci' ); ?></span>
				<ul class="contact-lines">
					<?php foreach ( $tebasuci_social as $tebasuci_item ) : ?>
						<li><?php tebasuci_link( $tebasuci_item[0], $tebasuci_item[1], '', '' ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>

	<div class="contact-form-wrap" data-reveal>
		<span class="eyebrow"><?php esc_html_e( 'Send a message', 'tebasuci' ); ?></span>
		<?php tebasuci_contact_form(); ?>
	</div>
</section>

<div class="location-map location-map--contact" data-reveal>
	<iframe
		title="<?php esc_attr_e( 'Map to Teba Suci Suite', 'tebasuci' ); ?>"
		src="<?php echo esc_url( tebasuci_map_embed_src() ); ?>"
		width="600" height="450" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

<?php
get_footer();

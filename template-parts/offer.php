<?php
/**
 * Booking banner. Used on the homepage and, by default, at the bottom of
 * inner pages and posts.
 *
 * @package TebaSuci
 */

$tebasuci_context = ( isset( $args['context'] ) && 'inner' === $args['context'] ) ? 'inner' : 'front';

if ( 'front' === $tebasuci_context && ! tebasuci_show( 'offer' ) ) {
	return;
}

if ( '' === (string) tebasuci_get( 'offer_title' ) && '' === (string) tebasuci_get( 'offer_text' ) ) {
	return;
}
?>
<section class="offer-section offer-section--<?php echo esc_attr( $tebasuci_context ); ?>"<?php echo 'front' === $tebasuci_context ? ' id="offers"' : ''; ?> aria-labelledby="offer-title">
	<div class="offer-inner" data-reveal>
		<?php if ( tebasuci_get( 'offer_eyebrow' ) ) : ?>
			<span class="eyebrow"><?php echo tebasuci_text( 'offer_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
		<h2 id="offer-title"><?php echo tebasuci_lines( 'offer_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
		<?php if ( tebasuci_get( 'offer_text' ) ) : ?>
			<p><?php echo tebasuci_lines( 'offer_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
		<?php tebasuci_link( tebasuci_url_or( 'offer_button_url', 'booking_url' ), tebasuci_get( 'offer_button_label' ), 'button offer-button' ); ?>
	</div>
</section>

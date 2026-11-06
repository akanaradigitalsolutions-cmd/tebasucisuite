<?php
/**
 * Homepage: D’Gadon Cafe.
 *
 * @package TebaSuci
 */

if ( ! tebasuci_show( 'cafe' ) ) {
	return;
}

$tebasuci_image = tebasuci_image(
	'cafe_image',
	array( 'sizes' => '(max-width: 760px) calc(100vw - 2.5rem), 680px' )
);
?>
<section class="cafe-section<?php echo $tebasuci_image ? '' : ' cafe-section--no-image'; ?>" id="cafe">
	<div class="cafe-copy" data-reveal>
		<?php if ( tebasuci_get( 'cafe_eyebrow' ) ) : ?>
			<span class="eyebrow"><?php echo tebasuci_text( 'cafe_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'cafe_title' ) ) : ?>
			<h2><?php echo tebasuci_lines( 'cafe_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'cafe_text' ) ) : ?>
			<p><?php echo tebasuci_lines( 'cafe_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
		<?php tebasuci_link( tebasuci_get( 'cafe_link_url' ), tebasuci_get( 'cafe_link_label' ), 'text-link' ); ?>
	</div>

	<?php if ( $tebasuci_image ) : ?>
		<div class="cafe-image" data-reveal>
			<?php echo $tebasuci_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
		</div>
	<?php endif; ?>
</section>

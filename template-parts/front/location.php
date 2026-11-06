<?php
/**
 * Homepage: location.
 *
 * @package TebaSuci
 */

if ( ! tebasuci_show( 'location' ) ) {
	return;
}

$tebasuci_mark  = (string) tebasuci_get( 'location_mark' );
$tebasuci_aside = (string) tebasuci_get( 'location_aside_text' );

$tebasuci_classes = 'location-section';
if ( '' === $tebasuci_mark ) {
	$tebasuci_classes .= ' location-section--no-mark';
}
if ( '' === $tebasuci_aside ) {
	$tebasuci_classes .= ' location-section--no-aside';
}
?>
<section class="<?php echo esc_attr( $tebasuci_classes ); ?>" id="location">
	<?php if ( '' !== $tebasuci_mark ) : ?>
		<div class="location-mark" aria-hidden="true"><?php echo esc_html( $tebasuci_mark ); ?></div>
	<?php endif; ?>

	<div class="location-copy" data-reveal>
		<?php if ( tebasuci_get( 'location_eyebrow' ) ) : ?>
			<span class="eyebrow"><?php echo tebasuci_text( 'location_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'location_title' ) ) : ?>
			<h2><?php echo tebasuci_lines( 'location_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'location_text' ) ) : ?>
			<p><?php echo tebasuci_lines( 'location_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
		<?php tebasuci_link( tebasuci_url_or( 'location_link_url', 'maps_url' ), tebasuci_get( 'location_link_label' ), 'text-link' ); ?>
	</div>

	<?php if ( '' !== $tebasuci_aside ) : ?>
		<div class="location-aside" data-reveal>
			<?php if ( tebasuci_get( 'location_aside_eyebrow' ) ) : ?>
				<span class="eyebrow"><?php echo tebasuci_text( 'location_aside_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<?php endif; ?>
			<p><?php echo tebasuci_lines( 'location_aside_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		</div>
	<?php endif; ?>
</section>

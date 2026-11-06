<?php
/**
 * Homepage: welcome.
 *
 * @package TebaSuci
 */

if ( ! tebasuci_show( 'welcome' ) ) {
	return;
}

$tebasuci_image = tebasuci_image(
	'welcome_image',
	array( 'sizes' => '(max-width: 760px) calc(100vw - 2.5rem), 620px' )
);
?>
<section class="welcome-section<?php echo $tebasuci_image ? '' : ' welcome-section--no-image'; ?>" id="welcome">
	<div class="welcome-copy" data-reveal>
		<?php if ( tebasuci_get( 'welcome_eyebrow' ) ) : ?>
			<span class="eyebrow"><?php echo tebasuci_text( 'welcome_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'welcome_title' ) ) : ?>
			<h2><?php echo tebasuci_lines( 'welcome_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'welcome_text' ) ) : ?>
			<p><?php echo tebasuci_lines( 'welcome_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
		<?php tebasuci_link( tebasuci_get( 'welcome_link_url' ), tebasuci_get( 'welcome_link_label' ), 'text-link' ); ?>
	</div>

	<?php if ( $tebasuci_image ) : ?>
		<div class="welcome-image-wrap" data-reveal>
			<?php echo $tebasuci_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
			<?php if ( tebasuci_get( 'welcome_caption' ) ) : ?>
				<span class="image-caption"><?php echo tebasuci_text( 'welcome_caption' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</section>

<?php
/**
 * Homepage: experience (dark green split section).
 *
 * @package TebaSuci
 */

if ( ! tebasuci_show( 'experience' ) ) {
	return;
}

$tebasuci_image = tebasuci_image(
	'experience_image',
	array( 'sizes' => '(max-width: 760px) 100vw, 53vw' )
);
?>
<section class="experience-section<?php echo $tebasuci_image ? '' : ' experience-section--no-image'; ?>" id="experience" aria-labelledby="experience-title">
	<?php if ( $tebasuci_image ) : ?>
		<div class="experience-image" data-reveal>
			<?php echo $tebasuci_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
		</div>
	<?php endif; ?>

	<div class="experience-copy" data-reveal>
		<?php if ( tebasuci_get( 'experience_eyebrow' ) ) : ?>
			<span class="eyebrow"><?php echo tebasuci_text( 'experience_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
		<h2 id="experience-title"><?php echo tebasuci_lines( 'experience_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
		<?php if ( tebasuci_get( 'experience_text' ) ) : ?>
			<p><?php echo tebasuci_lines( 'experience_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
		<?php tebasuci_link( tebasuci_get( 'experience_link_url' ), tebasuci_get( 'experience_link_label' ), 'text-link' ); ?>
	</div>
</section>

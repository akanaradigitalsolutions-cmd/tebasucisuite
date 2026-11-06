<?php
/**
 * Homepage: photo gallery.
 *
 * The first photo is the large one. The grid adapts to the number of
 * photos (1–5) so it never leaves an empty cell.
 *
 * @package TebaSuci
 */

if ( ! tebasuci_show( 'gallery' ) ) {
	return;
}

$tebasuci_keys = array();
for ( $tebasuci_i = 1; $tebasuci_i <= tebasuci_gallery_slots(); $tebasuci_i++ ) {
	if ( tebasuci_image_sources( "gallery_image_{$tebasuci_i}" ) ) {
		$tebasuci_keys[] = "gallery_image_{$tebasuci_i}";
	}
}
$tebasuci_count = count( $tebasuci_keys );
?>
<section class="gallery-section" id="gallery">
	<div class="gallery-heading" data-reveal>
		<div>
			<?php if ( tebasuci_get( 'gallery_eyebrow' ) ) : ?>
				<span class="eyebrow"><?php echo tebasuci_text( 'gallery_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<?php endif; ?>
			<?php if ( tebasuci_get( 'gallery_title' ) ) : ?>
				<h2><?php echo tebasuci_lines( 'gallery_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
			<?php endif; ?>
		</div>
		<?php if ( tebasuci_get( 'gallery_note' ) ) : ?>
			<span class="gallery-side-note"><?php echo tebasuci_text( 'gallery_note' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
	</div>

	<?php if ( $tebasuci_count ) : ?>
		<div class="gallery-grid gallery-grid--<?php echo (int) $tebasuci_count; ?>">
			<?php
			foreach ( $tebasuci_keys as $tebasuci_index => $tebasuci_key ) :
				$tebasuci_large = 0 === $tebasuci_index;
				// The last photo of four spans two columns to complete the grid.
				$tebasuci_wide = 4 === $tebasuci_count && 3 === $tebasuci_index;
				if ( $tebasuci_large ) {
					$tebasuci_sizes = '(max-width: 760px) calc(100vw - 2.5rem), 480px';
				} elseif ( $tebasuci_wide ) {
					$tebasuci_sizes = '(max-width: 760px) calc(100vw - 2.5rem), 730px';
				} else {
					$tebasuci_sizes = '(max-width: 760px) 50vw, 400px';
				}
				?>
				<figure class="gallery-photo<?php echo $tebasuci_large ? ' gallery-photo-large' : ''; ?>" data-reveal>
					<?php echo tebasuci_image( $tebasuci_key, array( 'sizes' => $tebasuci_sizes ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</figure>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( tebasuci_get( 'gallery_link_label' ) && tebasuci_get( 'gallery_link_url' ) ) : ?>
		<div class="gallery-more">
			<?php tebasuci_link( tebasuci_get( 'gallery_link_url' ), tebasuci_get( 'gallery_link_label' ), 'text-link' ); ?>
		</div>
	<?php endif; ?>
</section>

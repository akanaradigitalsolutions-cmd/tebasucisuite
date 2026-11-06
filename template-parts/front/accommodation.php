<?php
/**
 * Homepage: accommodation list.
 *
 * @package TebaSuci
 */

if ( ! tebasuci_show( 'rooms' ) ) {
	return;
}

$tebasuci_booking = (string) tebasuci_get( 'booking_url' );
$tebasuci_rooms   = array();

for ( $tebasuci_i = 1; $tebasuci_i <= tebasuci_room_slots(); $tebasuci_i++ ) {
	$tebasuci_name = (string) tebasuci_get( "room_{$tebasuci_i}_name" );
	if ( '' === $tebasuci_name ) {
		continue;
	}
	$tebasuci_url     = (string) tebasuci_get( "room_{$tebasuci_i}_url" );
	$tebasuci_rooms[] = array(
		'name'   => $tebasuci_name,
		'detail' => (string) tebasuci_get( "room_{$tebasuci_i}_detail" ),
		'url'    => tebasuci_resolve_url( '' !== $tebasuci_url ? $tebasuci_url : $tebasuci_booking ),
	);
}

$tebasuci_image = tebasuci_image(
	'rooms_image',
	array( 'sizes' => '(max-width: 760px) calc(100vw - 2.5rem), 580px' )
);
?>
<section class="accommodation-section" id="accommodation">
	<div class="section-heading" data-reveal>
		<?php if ( tebasuci_get( 'rooms_eyebrow' ) ) : ?>
			<span class="eyebrow"><?php echo tebasuci_text( 'rooms_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'rooms_title' ) ) : ?>
			<h2><?php echo tebasuci_lines( 'rooms_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
		<?php endif; ?>
		<?php if ( tebasuci_get( 'rooms_text' ) ) : ?>
			<p><?php echo tebasuci_lines( 'rooms_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>
	</div>

	<div class="room-layout<?php echo $tebasuci_image ? '' : ' room-layout--no-image'; ?>">
		<?php if ( $tebasuci_image ) : ?>
			<div class="room-image" data-reveal>
				<?php echo $tebasuci_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				<?php if ( tebasuci_get( 'rooms_image_note' ) ) : ?>
					<span class="room-image-note"><?php echo tebasuci_text( 'rooms_image_note' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="room-list">
			<?php if ( $tebasuci_rooms ) : ?>
				<ul class="room-rows" aria-label="<?php esc_attr_e( 'Accommodation options', 'tebasuci' ); ?>">
					<?php
					foreach ( $tebasuci_rooms as $tebasuci_index => $tebasuci_room ) :
						$tebasuci_external = tebasuci_is_external( $tebasuci_room['url'] );
						?>
						<li>
							<a class="room-row" href="<?php echo esc_url( $tebasuci_room['url'] ); ?>"<?php echo $tebasuci_external ? ' target="_blank" rel="noopener"' : ''; ?>>
								<span class="room-number"><?php echo esc_html( sprintf( '%02d', $tebasuci_index + 1 ) ); ?></span>
								<span class="room-copy">
									<strong><?php echo esc_html( $tebasuci_room['name'] ); ?></strong>
									<?php if ( '' !== $tebasuci_room['detail'] ) : ?>
										<small><?php echo esc_html( $tebasuci_room['detail'] ); ?></small>
									<?php endif; ?>
								</span>
								<?php echo tebasuci_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
								<?php if ( $tebasuci_external ) : ?>
									<span class="screen-reader-text"><?php esc_html_e( '(opens in a new tab)', 'tebasuci' ); ?></span>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php tebasuci_link( tebasuci_url_or( 'rooms_button_url', 'booking_url' ), tebasuci_get( 'rooms_button_label' ), 'button room-cta' ); ?>
		</div>
	</div>
</section>

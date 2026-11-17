<?php
/**
 * Template Name: Accommodation
 * Template Post Type: page
 *
 * Lists every room with its photo, details and links. Rooms are edited under
 * Appearance → Customize → Teba Suci Suite → Accommodation.
 *
 * @package TebaSuci
 */

get_header();

$tebasuci_rooms   = tebasuci_rooms_list();
$tebasuci_booking = (string) tebasuci_get( 'booking_url' );

tebasuci_render_page_hero(
	array(
		'eyebrow' => tebasuci_get( 'rooms_eyebrow' ) ? tebasuci_get( 'rooms_eyebrow' ) : __( 'Stay with us', 'tebasuci' ),
		'title'   => get_the_title(),
		'intro'   => __( 'Eleven private spaces and twelve rooms, from rice-field suites to a private-pool villa and a two-bedroom family villa — each with the quiet landscapes of Ubud just beyond the door.', 'tebasuci' ),
	)
);
?>

<section class="rooms-page">
	<?php
	foreach ( $tebasuci_rooms as $tebasuci_index => $tebasuci_room ) :
		$tebasuci_i        = $tebasuci_room['index'];
		$tebasuci_specs    = $tebasuci_room['specs'];
		$tebasuci_external = tebasuci_is_external( $tebasuci_room['url'] );
		?>
		<article class="room-card" data-reveal>
			<div class="room-card-media">
				<?php echo tebasuci_image( "room_{$tebasuci_i}_photo", array( 'sizes' => '(max-width: 900px) calc(100vw - 2.5rem), 560px' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				<span class="room-card-index"><?php echo esc_html( sprintf( '%02d', $tebasuci_index + 1 ) ); ?></span>
			</div>

			<div class="room-card-body">
				<h2 class="room-card-name"><?php echo esc_html( $tebasuci_room['name'] ); ?></h2>
				<?php if ( '' !== $tebasuci_room['summary'] ) : ?>
					<p class="room-card-summary"><?php echo esc_html( $tebasuci_room['summary'] ); ?></p>
				<?php endif; ?>

				<?php if ( $tebasuci_specs ) : ?>
					<ul class="room-specs">
						<?php foreach ( $tebasuci_specs as $tebasuci_spec ) : ?>
							<li><?php echo esc_html( $tebasuci_spec ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="room-card-footer">
					<?php if ( '' !== $tebasuci_room['price'] ) : ?>
						<span class="room-card-price"><?php echo esc_html( $tebasuci_room['price'] ); ?></span>
					<?php endif; ?>
					<div class="room-card-actions">
						<?php
						if ( $tebasuci_room['has_page'] ) {
							tebasuci_link( $tebasuci_room['url'], __( 'View details', 'tebasuci' ), 'text-link' );
						}
						tebasuci_link( $tebasuci_booking, __( 'Book', 'tebasuci' ), 'button room-cta' );
						?>
					</div>
				</div>
			</div>
		</article>
	<?php endforeach; ?>

	<?php if ( ! $tebasuci_rooms ) : ?>
		<div class="entry-content"><?php the_post(); the_content(); ?></div>
	<?php endif; ?>
</section>

<?php
get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
get_footer();

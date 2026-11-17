<?php
/**
 * Template Name: Location
 * Template Post Type: page
 *
 * @package TebaSuci
 */

get_header();

$tebasuci_landmarks = tebasuci_location_landmarks();
$tebasuci_address   = (string) tebasuci_get( 'address' );
$tebasuci_maps      = (string) tebasuci_get( 'maps_url' );

tebasuci_render_page_hero(
	array(
		'eyebrow' => __( 'Your Ubud hideaway', 'tebasuci' ),
		'title'   => get_the_title(),
		'intro'   => __( 'Tucked into the green landscapes of Singakerta, around 15 minutes from the heart of Ubud — close to the sights, far from the noise.', 'tebasuci' ),
	)
);
?>

<section class="location-page">
	<div class="location-map" data-reveal>
		<iframe
			title="<?php esc_attr_e( 'Map to Teba Suci Suite', 'tebasuci' ); ?>"
			src="<?php echo esc_url( tebasuci_map_embed_src() ); ?>"
			width="600" height="450" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>

	<div class="location-details">
		<div class="location-address" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Find us', 'tebasuci' ); ?></span>
			<p class="location-address-text"><?php echo tebasuci_lines( 'address' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></p>
			<?php tebasuci_link( $tebasuci_maps, __( 'Open in Google Maps', 'tebasuci' ), 'text-link' ); ?>
		</div>

		<div class="location-landmarks" data-reveal>
			<span class="eyebrow"><?php esc_html_e( 'Nearby, by car', 'tebasuci' ); ?></span>
			<ul class="landmark-list">
				<?php foreach ( $tebasuci_landmarks as $tebasuci_place => $tebasuci_time ) : ?>
					<li>
						<span class="landmark-name"><?php echo esc_html( $tebasuci_place ); ?></span>
						<span class="landmark-time"><?php echo esc_html( $tebasuci_time ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
get_footer();

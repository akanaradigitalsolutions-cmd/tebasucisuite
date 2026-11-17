<?php
/**
 * Template Name: Room (single room)
 * Template Post Type: page
 *
 * A single room in an editorial, luxury layout: full-bleed hero, overview with
 * key details, description, amenities, a photo gallery and a booking band.
 * The room is matched to this page by its link in the Customizer; if no room
 * matches, the page's own content is shown.
 *
 * @package TebaSuci
 */

get_header();

$tebasuci_i    = tebasuci_room_index_for_page();
$tebasuci_data = tebasuci_rooms_data();

if ( $tebasuci_i && isset( $tebasuci_data[ $tebasuci_i ] ) ) :
	$tebasuci_room    = $tebasuci_data[ $tebasuci_i ];
	$tebasuci_name    = (string) tebasuci_get( "room_{$tebasuci_i}_name" );
	$tebasuci_detail  = (string) tebasuci_get( "room_{$tebasuci_i}_detail" );
	$tebasuci_booking = (string) tebasuci_get( 'booking_url' );
	$tebasuci_phone   = (string) tebasuci_get( 'phone' );
	$tebasuci_times   = tebasuci_stay_times();

	// Collect the room's gallery photos.
	$tebasuci_gallery = array();
	for ( $tebasuci_g = 2; $tebasuci_g <= 4; $tebasuci_g++ ) {
		$tebasuci_img = tebasuci_bundled_image( "room-{$tebasuci_i}-{$tebasuci_g}" );
		if ( $tebasuci_img ) {
			$tebasuci_gallery[] = $tebasuci_img;
		}
	}
	?>
	<article class="room-lux">
		<section class="room-hero">
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
			echo tebasuci_image(
				"room_{$tebasuci_i}_photo",
				array(
					'class'    => 'room-hero-img',
					'sizes'    => '100vw',
					'priority' => true,
				)
			);
			?>
			<div class="room-hero-shade" aria-hidden="true"></div>
			<div class="room-hero-inner" data-reveal>
				<span class="eyebrow"><?php echo esc_html( $tebasuci_detail ? $tebasuci_detail : __( 'Accommodation', 'tebasuci' ) ); ?></span>
				<h1><?php echo esc_html( $tebasuci_name ); ?></h1>
			</div>
		</section>

		<section class="room-overview">
			<?php if ( '' !== $tebasuci_room['summary'] ) : ?>
				<p class="room-lead" data-reveal><?php echo esc_html( $tebasuci_room['summary'] ); ?></p>
			<?php endif; ?>

			<?php if ( $tebasuci_room['specs'] ) : ?>
				<ul class="room-facts" data-reveal>
					<?php foreach ( $tebasuci_room['specs'] as $tebasuci_key => $tebasuci_val ) : ?>
						<li>
							<span class="room-fact-label"><?php echo esc_html( ucfirst( $tebasuci_key ) ); ?></span>
							<span class="room-fact-value"><?php echo esc_html( $tebasuci_val ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>

		<section class="room-detail">
			<div class="room-story" data-reveal>
				<span class="eyebrow"><?php esc_html_e( 'The room', 'tebasuci' ); ?></span>
				<?php foreach ( $tebasuci_room['description'] as $tebasuci_para ) : ?>
					<p><?php echo esc_html( $tebasuci_para ); ?></p>
				<?php endforeach; ?>
			</div>

			<?php if ( $tebasuci_room['amenities'] ) : ?>
				<div class="room-features" data-reveal>
					<span class="eyebrow"><?php esc_html_e( 'Features & amenities', 'tebasuci' ); ?></span>
					<ul>
						<?php foreach ( $tebasuci_room['amenities'] as $tebasuci_amenity ) : ?>
							<li><?php echo esc_html( $tebasuci_amenity ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</section>

		<?php if ( $tebasuci_gallery ) : ?>
			<section class="room-gallery" aria-label="<?php esc_attr_e( 'Room photos', 'tebasuci' ); ?>">
				<?php foreach ( $tebasuci_gallery as $tebasuci_img ) : ?>
					<figure data-reveal>
						<img src="<?php echo esc_url( $tebasuci_img['src'] ); ?>" srcset="<?php echo esc_attr( $tebasuci_img['srcset'] ); ?>" sizes="(max-width: 760px) calc(100vw - 2.5rem), 390px" width="<?php echo (int) $tebasuci_img['width']; ?>" height="<?php echo (int) $tebasuci_img['height']; ?>" alt="" loading="lazy" decoding="async">
					</figure>
				<?php endforeach; ?>
			</section>
		<?php endif; ?>

		<section class="room-stay">
			<div class="room-stay-inner" data-reveal>
				<div class="room-stay-times">
					<div>
						<span class="eyebrow"><?php esc_html_e( 'Check-in', 'tebasuci' ); ?></span>
						<p><?php echo esc_html( $tebasuci_times['checkin'] ); ?></p>
					</div>
					<div>
						<span class="eyebrow"><?php esc_html_e( 'Check-out', 'tebasuci' ); ?></span>
						<p><?php echo esc_html( $tebasuci_times['checkout'] ); ?></p>
					</div>
				</div>
				<div class="room-stay-cta">
					<?php tebasuci_link( $tebasuci_booking, __( 'Reserve your stay', 'tebasuci' ), 'button hero-button' ); ?>
					<?php if ( '' !== $tebasuci_phone ) : ?>
						<p class="room-stay-phone">
							<?php esc_html_e( 'For reservations', 'tebasuci' ); ?><br>
							<?php tebasuci_link( 'tel:' . preg_replace( '/[^0-9+]/', '', $tebasuci_phone ), $tebasuci_phone, '', '' ); ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<nav class="room-back">
			<?php tebasuci_link( '/accomodation/', __( 'All accommodation', 'tebasuci' ), 'text-link' ); ?>
		</nav>
	</article>
	<?php
else :
	// Not a recognised room page — show the page's own content.
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'entry' ); ?>>
			<header class="page-hero">
				<div class="page-hero-inner" data-reveal>
					<span class="eyebrow"><?php esc_html_e( 'Accommodation', 'tebasuci' ); ?></span>
					<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				</div>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="page-featured"><?php the_post_thumbnail( 'full' ); ?></figure>
			<?php endif; ?>
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
		<?php
	endwhile;

	get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
endif;

get_footer();

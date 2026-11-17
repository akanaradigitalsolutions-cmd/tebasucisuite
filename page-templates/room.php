<?php
/**
 * Template Name: Room (single room)
 * Template Post Type: page
 *
 * A single room: photo, description, amenities, details and a booking link.
 * The room is matched to this page by its link in the Customizer. If no room
 * matches, the page's own content is shown instead.
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
	$tebasuci_price   = (string) tebasuci_get( "room_{$tebasuci_i}_price" );
	$tebasuci_booking = (string) tebasuci_get( 'booking_url' );
	$tebasuci_times   = tebasuci_stay_times();
	?>
	<article class="room-single">
		<header class="page-hero page-hero--room">
			<div class="page-hero-inner" data-reveal>
				<span class="eyebrow"><?php echo esc_html( $tebasuci_detail ? $tebasuci_detail : __( 'Accommodation', 'tebasuci' ) ); ?></span>
				<h1 class="page-title"><?php echo esc_html( $tebasuci_name ); ?></h1>
				<?php if ( '' !== $tebasuci_room['summary'] ) : ?>
					<p class="page-intro"><?php echo esc_html( $tebasuci_room['summary'] ); ?></p>
				<?php endif; ?>
			</div>
		</header>

		<figure class="room-single-photo" data-reveal>
			<?php echo tebasuci_image( "room_{$tebasuci_i}_photo", array( 'sizes' => '(max-width: 1280px) calc(100vw - 3.5rem), 1220px' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
		</figure>

		<div class="room-single-body">
			<div class="room-single-main" data-reveal>
				<span class="eyebrow"><?php esc_html_e( 'Room description', 'tebasuci' ); ?></span>
				<?php foreach ( $tebasuci_room['description'] as $tebasuci_para ) : ?>
					<p><?php echo esc_html( $tebasuci_para ); ?></p>
				<?php endforeach; ?>

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
			</div>

			<aside class="room-single-aside" data-reveal>
				<div class="room-aside-card">
					<?php if ( $tebasuci_room['specs'] ) : ?>
						<ul class="room-detail-list">
							<?php foreach ( $tebasuci_room['specs'] as $tebasuci_key => $tebasuci_val ) : ?>
								<li><span><?php echo esc_html( ucfirst( $tebasuci_key ) ); ?></span><strong><?php echo esc_html( $tebasuci_val ); ?></strong></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( '' !== $tebasuci_price ) : ?>
						<p class="room-aside-price"><?php echo esc_html( $tebasuci_price ); ?></p>
					<?php endif; ?>

					<?php tebasuci_link( $tebasuci_booking, __( 'Book your stay', 'tebasuci' ), 'button room-cta room-aside-book' ); ?>

					<?php if ( tebasuci_get( 'phone' ) ) : ?>
						<p class="room-aside-info">
							<?php esc_html_e( 'For information', 'tebasuci' ); ?><br>
							<?php tebasuci_link( 'tel:' . preg_replace( '/[^0-9+]/', '', (string) tebasuci_get( 'phone' ) ), (string) tebasuci_get( 'phone' ), '', '' ); ?>
						</p>
					<?php endif; ?>
				</div>

				<?php if ( $tebasuci_room['amenities'] ) : ?>
					<div class="room-amenities">
						<span class="eyebrow"><?php esc_html_e( 'Features & amenities', 'tebasuci' ); ?></span>
						<ul>
							<?php foreach ( $tebasuci_room['amenities'] as $tebasuci_amenity ) : ?>
								<li><?php echo esc_html( $tebasuci_amenity ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</aside>
		</div>

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
endif;

get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
get_footer();

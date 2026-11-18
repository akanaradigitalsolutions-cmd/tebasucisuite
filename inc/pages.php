<?php
/**
 * Inner-page content and helpers (Accommodation, Room, Gallery, D’Gadon Cafe,
 * Location, Contact, Special Offer).
 *
 * The longer, rarely-changing copy (room descriptions, amenities, landmarks,
 * offer cards) is pre-filled here from the property’s own content. The things
 * owners change often — room names, photos, rates, booking and contact details —
 * stay in the Customizer (Appearance → Customize → Teba Suci Suite).
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared check-in / check-out times.
 *
 * @return array
 */
function tebasuci_stay_times() {
	return array(
		'checkin'  => __( 'From 2:00 PM to 10:00 PM', 'tebasuci' ),
		'checkout' => __( 'From 8:00 AM to 11:00 AM', 'tebasuci' ),
	);
}

/**
 * Amenities shared by every room.
 *
 * @return string[]
 */
function tebasuci_common_amenities() {
	return array(
		__( 'Tea & coffee making facilities', 'tebasuci' ),
		__( 'Welcome tropical fruit basket', 'tebasuci' ),
		__( 'Complimentary bottled mineral water', 'tebasuci' ),
		__( 'Stocked mini bar', 'tebasuci' ),
		__( 'Air conditioning', 'tebasuci' ),
		__( 'Bathrobes & slippers', 'tebasuci' ),
		__( 'Daily housekeeping and villa service', 'tebasuci' ),
		__( 'Free Wi-Fi', 'tebasuci' ),
		__( 'Hair dryer', 'tebasuci' ),
		__( 'In-room safe deposit box', 'tebasuci' ),
		__( 'Toothbrush & toothpaste', 'tebasuci' ),
	);
}

/**
 * Detailed content for each room, keyed to the room numbers in the Customizer
 * (Accommodation section). Names, photos, rates and links come from there.
 *
 * @return array
 */
function tebasuci_rooms_data() {
	$common = tebasuci_common_amenities();

	return array(
		1 => array(
			'summary'     => __( 'A 20 m² double room with a private entrance and a terrace looking into the serene jungle — air-conditioned, with a cosy patio, flat-screen TV, minibar and free Wi-Fi.', 'tebasuci' ),
			'description' => array(
				__( 'One bedroom with a king-size bed, featuring a private entrance and a terrace with serene garden views. This air-conditioned room offers a cosy patio, flat-screen TV, minibar and free Wi-Fi.', 'tebasuci' ),
				__( 'The private bathroom is equipped with a refreshing shower. Enjoy restful nights in comfortable beds — an ideal choice for a tranquil retreat.', 'tebasuci' ),
			),
			'specs'       => array(
				'guests' => __( '1–2 guests', 'tebasuci' ),
				'bed'    => __( 'King bed', 'tebasuci' ),
				'size'   => __( '4 m × 4 m', 'tebasuci' ),
				'units'  => __( '2 units', 'tebasuci' ),
			),
			'amenities'   => array_merge( $common, array( __( 'Laundry basket', 'tebasuci' ) ) ),
		),
		2 => array(
			'summary'     => __( 'A one-bedroom room with a serene rice-field view — immerse yourself in the beauty of nature from your own balcony or private terrace.', 'tebasuci' ),
			'description' => array(
				__( 'One bedroom with a double bed on the second floor, offering a beautiful view of the rice fields and the main pool. Enjoy the view from the balcony area or your private terrace, with all the modern facilities that make a stay comfortable and enjoyable.', 'tebasuci' ),
				__( 'The private bathroom has a rain shower and separate toilet, a wash basin, soap, shampoo, shower cap, toothbrush, toothpaste and a hairdryer.', 'tebasuci' ),
			),
			'specs'       => array(
				'guests' => __( '1–2 guests', 'tebasuci' ),
				'bed'    => __( 'Double bed', 'tebasuci' ),
				'size'   => __( '4 m × 4 m', 'tebasuci' ),
				'units'  => __( '2 units', 'tebasuci' ),
			),
			'amenities'   => $common,
		),
		3 => array(
			'summary'     => __( 'A one-bedroom villa with its own private kitchen and breathtaking rice-field views — the convenience of home-cooked meals amid nature’s beauty.', 'tebasuci' ),
			'description' => array(
				__( 'A Balinese carved door leads into a private kitchen with a sofa and television room — a true Balinese home feel. From your bed or private terrace you look straight out over the rice fields, with a large living room and a luxurious bedroom, and a private terrace for each villa.', 'tebasuci' ),
				__( 'Our three villas each have different architectural features and room sizes but share the same view — expansive rice fields where villagers tend their paddies. You can enjoy room-service lunch from D’Gadon Cafe at your private dining table while a cool tropical breeze completes the day on the terrace.', 'tebasuci' ),
			),
			'specs'       => array(
				'guests' => __( '1–2 guests', 'tebasuci' ),
				'bed'    => __( 'King bed', 'tebasuci' ),
				'size'   => __( '5.5 m × 5.5 m / 4 m × 4 m / 4.5 m × 5 m', 'tebasuci' ),
				'units'  => __( '3 units', 'tebasuci' ),
			),
			'amenities'   => array_merge( $common, array( __( 'Private kitchen & dining room', 'tebasuci' ) ) ),
		),
		4 => array(
			'summary'     => __( 'A one-bedroom villa with its own private pool — a honeymoon-worthy, private oasis with rice-field views and sunsets from the water.', 'tebasuci' ),
			'description' => array(
				__( 'This villa has a small swimming pool in front of a private terrace, with a sofa and television in the room. Its private style suits honeymooners — you can arrange flowers in the pool when you reserve, a lovely surprise for your partner.', 'tebasuci' ),
				__( 'Step outside to the beauty of the rice fields while you relax in your open pool, right in front of your room, and enjoy the afternoon sunset. For this category we have three villa units, and you can order a floating breakfast in your private pool from reception for a memorable romantic holiday.', 'tebasuci' ),
			),
			'specs'       => array(
				'guests' => __( '1–2 guests', 'tebasuci' ),
				'bed'    => __( 'King bed', 'tebasuci' ),
				'size'   => __( '4.5 m × 4.5 m', 'tebasuci' ),
				'units'  => __( '3 units', 'tebasuci' ),
			),
			'amenities'   => array_merge( $common, array( __( 'Private pool', 'tebasuci' ), __( 'Soap & shampoo', 'tebasuci' ) ) ),
		),
		5 => array(
			'summary'     => __( 'A two-bedroom villa with garden views, a private massage room and a spacious kitchen — made for family holidays in harmony with nature.', 'tebasuci' ),
			'description' => array(
				__( 'The two-bedroom villa has a private massage room and a very spacious kitchen with simple cooking utensils, a large dining table and a sofa. Each room has a private terrace with a beautiful view of the villa’s inner garden, and both bedrooms have private bathrooms with bathtubs.', 'tebasuci' ),
				__( 'In front of the villa a wide view of the rice fields awaits, with the shared swimming pool nearby. Complete with a private kitchen and the option to book an in-villa massage, it is a very comfortable place for a family holiday with children or relatives.', 'tebasuci' ),
			),
			'specs'       => array(
				'guests' => __( '2 bedrooms · ideal for families', 'tebasuci' ),
				'bed'    => __( 'King beds', 'tebasuci' ),
				'size'   => __( '5 m × 6 m / 5.5 m × 4.5 m', 'tebasuci' ),
				'units'  => __( '1 unit', 'tebasuci' ),
			),
			'amenities'   => array_merge(
				$common,
				array(
					__( 'Private kitchen', 'tebasuci' ),
					__( 'Large dining table', 'tebasuci' ),
					__( 'Private massage / spa room', 'tebasuci' ),
					__( 'Ceiling fan', 'tebasuci' ),
				)
			),
		),
	);
}

/**
 * Which room (Customizer number) the current page represents, by matching the
 * page URL to the room links. 0 if the page is not a room.
 *
 * @param int|null $post_id Page ID; defaults to the queried page.
 * @return int
 */
function tebasuci_room_index_for_page( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_queried_object_id();
	if ( ! $post_id ) {
		return 0;
	}

	$page_path = trim( (string) wp_parse_url( get_permalink( $post_id ), PHP_URL_PATH ), '/' );
	if ( '' === $page_path ) {
		return 0;
	}

	for ( $i = 1; $i <= tebasuci_room_slots(); $i++ ) {
		$url = (string) tebasuci_get( "room_{$i}_url" );
		if ( '' === $url ) {
			continue;
		}
		$room_path = trim( (string) wp_parse_url( tebasuci_resolve_url( $url ), PHP_URL_PATH ), '/' );
		if ( '' !== $room_path && $room_path === $page_path ) {
			return $i;
		}
	}

	return 0;
}

/**
 * Rooms that have a name set, with their Customizer values merged with the
 * detailed content. Used by the Accommodation page.
 *
 * @return array
 */
function tebasuci_rooms_list() {
	$data  = tebasuci_rooms_data();
	$rooms = array();

	for ( $i = 1; $i <= tebasuci_room_slots(); $i++ ) {
		$name = (string) tebasuci_get( "room_{$i}_name" );
		if ( '' === $name ) {
			continue;
		}
		$url     = (string) tebasuci_get( "room_{$i}_url" );
		$rooms[] = array(
			'index'   => $i,
			'name'    => $name,
			'detail'  => (string) tebasuci_get( "room_{$i}_detail" ),
			'price'   => (string) tebasuci_get( "room_{$i}_price" ),
			'url'     => tebasuci_resolve_url( '' !== $url ? $url : (string) tebasuci_get( 'booking_url' ) ),
			'has_page'=> '' !== $url,
			'summary' => isset( $data[ $i ]['summary'] ) ? $data[ $i ]['summary'] : '',
			'specs'   => isset( $data[ $i ]['specs'] ) ? $data[ $i ]['specs'] : array(),
		);
	}

	return $rooms;
}

/**
 * D’Gadon Cafe page content.
 *
 * @return array
 */
function tebasuci_cafe_data() {
	return array(
		'tagline'     => __( 'Where culinary passion meets flavourful indulgence', 'tebasuci' ),
		'description' => array(
			__( 'Teba Suci Suite is home to a restaurant we call D’Gadon Cafe. We keep the quality of our ingredients and the preparation of our food and drinks to the highest standards, overseen by a team of highly trained chefs and servers who greet every guest warmly.', 'tebasuci' ),
			__( 'Talk to our staff about any allergies and we will suggest alternatives to suit your needs. Our chef’s favourite dishes, enjoyed over a view of the rice fields, make a visit here one of the more unforgettable moments of your time in Bali.', 'tebasuci' ),
		),
		'gallery'     => array( 'cafe', 'cafe-2', 'gallery-05' ),
		'menu'        => array(
			'pdf'    => TEBASUCI_URI . '/assets/menu/cafe-menu.pdf',
			'labels' => array(
				__( 'Breakfast', 'tebasuci' ),
				__( 'Lunch & Dinner', 'tebasuci' ),
				__( 'Main course', 'tebasuci' ),
				__( 'Pizza & Dessert', 'tebasuci' ),
				__( 'Drinks', 'tebasuci' ),
				__( 'Cocktails & Mocktails', 'tebasuci' ),
			),
		),
	);
}

/**
 * Whether the cafe menu PDF is bundled with the theme.
 *
 * @return bool
 */
function tebasuci_has_cafe_menu() {
	return file_exists( TEBASUCI_DIR . '/assets/menu/cafe-menu.pdf' )
		&& file_exists( TEBASUCI_DIR . '/assets/images/cafe-menu-1.jpg' );
}

/**
 * The shortcode tag configured for the cafe menu flipbook (e.g. "dflip"),
 * or '' when none is set.
 *
 * @return string
 */
function tebasuci_cafe_menu_shortcode_tag() {
	$shortcode = (string) tebasuci_get( 'cafe_menu_shortcode' );
	if ( '' !== $shortcode && preg_match( '/\[([a-z0-9_-]+)/i', $shortcode, $m ) ) {
		return strtolower( $m[1] );
	}
	return '';
}

/**
 * DearFlip (dFlip) loads its scripts only when it finds its shortcode in a
 * page's content. The cafe template calls the shortcode from PHP, so enqueue
 * the plugin's registered assets directly on that page.
 */
function tebasuci_enqueue_cafe_flipbook() {
	if ( ! is_page_template( 'page-templates/cafe.php' ) ) {
		return;
	}

	$tag = tebasuci_cafe_menu_shortcode_tag();
	if ( '' === $tag || ! shortcode_exists( $tag ) ) {
		return;
	}

	foreach ( array( 'three', 'mockup', 'dflip', 'dearflip', 'dflip-min' ) as $handle ) {
		if ( wp_script_is( $handle, 'registered' ) && ! wp_script_is( $handle, 'enqueued' ) ) {
			wp_enqueue_script( $handle );
		}
	}
	foreach ( array( 'dflip', 'dflip-fontawesome', 'dearflip' ) as $handle ) {
		if ( wp_style_is( $handle, 'registered' ) && ! wp_style_is( $handle, 'enqueued' ) ) {
			wp_enqueue_style( $handle );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'tebasuci_enqueue_cafe_flipbook', 20 );

/**
 * Nearby landmarks for the Location page: name => drive time.
 *
 * @return array
 */
function tebasuci_location_landmarks() {
	return array(
		__( 'Monkey Forest Sanctuary', 'tebasuci' ) => __( '9 min', 'tebasuci' ),
		__( 'Bebek Tepi Sawah', 'tebasuci' )        => __( '9 min', 'tebasuci' ),
		__( 'Paradiso Ubud', 'tebasuci' )           => __( '9 min', 'tebasuci' ),
		__( 'Bali Zoo', 'tebasuci' )                => __( '9 min', 'tebasuci' ),
		__( 'Bali Bird Park', 'tebasuci' )          => __( '11 min', 'tebasuci' ),
		__( 'Sukawati Art Market', 'tebasuci' )     => __( '14 min', 'tebasuci' ),
		__( 'The Blanco Museum', 'tebasuci' )       => __( '14 min', 'tebasuci' ),
		__( 'Bukit Campuhan', 'tebasuci' )          => __( '16 min', 'tebasuci' ),
		__( 'Tegallalang Rice Terrace', 'tebasuci' ) => __( '17 min', 'tebasuci' ),
		__( 'Bali International Airport', 'tebasuci' ) => __( '60 min', 'tebasuci' ),
	);
}

/**
 * Special-offer packages.
 *
 * @return array
 */
function tebasuci_offers_data() {
	$booking = (string) tebasuci_get( 'booking_url' );

	return array(
		array(
			'title'    => __( 'Nyepi Package 2027', 'tebasuci' ),
			'text'     => __( 'Experience the tranquillity of Nyepi with a serene stay in our One-Bedroom Suite — Rice Field View, designed for relaxation and a connection with nature.', 'tebasuci' ),
			'photo'    => 'gallery-08',
			'price'    => __( 'IDR 3,575,000', 'tebasuci' ),
			'meta'     => __( '2 nights · 3 days — check-in 7 March, check-out 9 March 2027', 'tebasuci' ),
			'includes' => array(
				__( '2 nights in our Private Kitchen Room, Rice Field View', 'tebasuci' ),
				__( 'Welcome drink on arrival', 'tebasuci' ),
				__( 'Daily breakfast for two', 'tebasuci' ),
				__( 'Lunch on 8 March 2027', 'tebasuci' ),
				__( 'Dinner on 8 March 2027', 'tebasuci' ),
				__( 'Daily afternoon tea', 'tebasuci' ),
			),
			'label'    => __( 'Reserve this package', 'tebasuci' ),
			'url'      => 'https://wa.me/6282129705341',
		),
		array(
			'title'  => __( 'Pool with Floating Breakfast', 'tebasuci' ),
			'text'   => __( 'Indulge in a signature Teba Suci moment — a floating breakfast served in your private pool, booked through reception.', 'tebasuci' ),
			'photo'  => 'gallery-05',
			'label'  => __( 'Reserve', 'tebasuci' ),
			'url'    => $booking,
		),
		array(
			'title'  => __( 'Dining at D’Gadon Cafe', 'tebasuci' ),
			'text'   => __( 'Experience culinary delight at D’Gadon Cafe, our dining destination with open rice-field views. Reserve your table and settle in.', 'tebasuci' ),
			'photo'  => 'cafe',
			'label'  => __( 'Discover the cafe', 'tebasuci' ),
			'url'    => '/dgadoncafe/',
		),
		array(
			'title'  => __( 'Standard Balinese Wedding Package', 'tebasuci' ),
			'text'   => __( 'Celebrate your day in the peaceful beauty of Bali: an intimate ceremony with authentic Balinese touches, a romantic dinner, professional photography and a relaxing two-night stay — the essential details taken care of for you.', 'tebasuci' ),
			'photo'  => 'gallery-06',
			'label'  => __( 'Enquire about weddings', 'tebasuci' ),
			'url'    => '/contact/',
		),
	);
}

/**
 * Google Maps embed URL for the property.
 *
 * @return string
 */
function tebasuci_map_embed_src() {
	$query = rawurlencode( wp_strip_all_tags( (string) tebasuci_get( 'address' ) ) . ' Teba Suci Suite' );
	return 'https://maps.google.com/maps?q=' . $query . '&z=15&output=embed';
}

/**
 * Render a styled page header (eyebrow, title, intro).
 *
 * @param array $args eyebrow, title, intro.
 */
function tebasuci_render_page_hero( $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'eyebrow' => '',
			'title'   => '',
			'intro'   => '',
		)
	);
	?>
	<header class="page-hero">
		<div class="page-hero-inner" data-reveal>
			<?php if ( '' !== $args['eyebrow'] ) : ?>
				<span class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></span>
			<?php endif; ?>
			<h1 class="page-title"><?php echo nl2br( esc_html( $args['title'] ), false ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped. ?></h1>
			<?php if ( '' !== $args['intro'] ) : ?>
				<p class="page-intro"><?php echo esc_html( $args['intro'] ); ?></p>
			<?php endif; ?>
		</div>
	</header>
	<?php
}

/**
 * A list of templates this theme provides, for the one-time setup checklist
 * shown after activation.
 *
 * @return array Template file => existing page slug on the live site.
 */
function tebasuci_page_template_map() {
	return array(
		'page-templates/accommodation.php' => 'accomodation',
		'page-templates/room.php'          => 'one-bedroom-jungle-view',
		'page-templates/gallery.php'       => 'gallery',
		'page-templates/cafe.php'          => 'dgadoncafe',
		'page-templates/location.php'      => 'location',
		'page-templates/contact.php'       => 'contact',
		'page-templates/special-offer.php' => 'specialoffer',
	);
}

<?php
/**
 * Editable content.
 *
 * Every homepage text, link and photo is a Customizer setting
 * (Appearance → Customize → Teba Suci Suite). The defaults below are the
 * copy from the approved design, so the site looks finished before
 * anything is edited.
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Photos shipped with the theme. They are shown until a photo is chosen
 * from the Media Library in the Customizer.
 *
 * Each entry has the full-size file plus smaller copies (file-640.jpg, …)
 * used for the responsive srcset.
 *
 * @return array
 */
function tebasuci_bundled_images() {
	return array(
		'hero'       => array(
			'file'     => 'tebasuci-hero',
			'width'    => 1080,
			'height'   => 720,
			'variants' => array( 640, 1024 ),
		),
		'suite'      => array(
			'file'     => 'tebasuci-suite',
			'width'    => 1080,
			'height'   => 720,
			'variants' => array( 640, 1024 ),
		),
		'pool'       => array(
			'file'     => 'tebasuci-private-pool',
			'width'    => 1080,
			'height'   => 720,
			'variants' => array( 640, 1024 ),
		),
		'cafe'       => array(
			'file'     => 'tebasuci-cafe',
			'width'    => 1080,
			'height'   => 720,
			'variants' => array( 640, 1024 ),
		),
		'experience' => array(
			'file'     => 'tebasuci-experience',
			'width'    => 1600,
			'height'   => 1067,
			'variants' => array( 640, 1024, 1440 ),
		),
		'gallery5'   => array(
			'file'     => 'tebasuci-gallery5',
			'width'    => 1600,
			'height'   => 1067,
			'variants' => array( 640, 1024, 1440 ),
		),
	);
}

/**
 * Number of room rows that can be filled in.
 *
 * @return int
 */
function tebasuci_room_slots() {
	return 8;
}

/**
 * Number of gallery photos on the homepage.
 *
 * @return int
 */
function tebasuci_gallery_slots() {
	return 5;
}

/**
 * Customizer sections and their fields, in display order.
 *
 * Field types:
 * - text      single line
 * - textarea  multi-line; line breaks are kept (used for two-line headings)
 * - link      a full URL, a page path such as /contact/, or a section anchor such as #gallery
 * - email     an email address
 * - image     a photo from the Media Library (stored as attachment ID)
 * - checkbox  on/off
 *
 * @return array
 */
function tebasuci_fields() {
	static $sections = null;
	if ( null !== $sections ) {
		return $sections;
	}

	$show = array(
		'type'    => 'checkbox',
		'label'   => __( 'Show this section', 'tebasuci' ),
		'default' => true,
	);

	$image_note = __( 'Leave empty to use the photo that ships with the theme.', 'tebasuci' );
	$hide_note  = __( 'Leave empty to hide it.', 'tebasuci' );

	// Rooms: name, one-line detail and a link per row (from the live site).
	$room_defaults = array(
		1 => array( 'One Bedroom Jungle View', 'One bedroom · A quiet outlook into the green', '/one-bedroom-jungle-view/' ),
		2 => array( 'One Bedroom Rice Field View', 'One bedroom · Open views across the paddies', '/onebedroomricefieldview/' ),
		3 => array( 'One Bedroom Private Kitchen · Rice Field View', 'One bedroom · Rice field view · Private kitchenette', '/onebedroomprivatekitchenwithricefieldview/' ),
		4 => array( 'One Bedroom Villa Private Pool', 'One bedroom · Your own pool and terrace', '/one-bedroom-villa-private-pool/' ),
		5 => array( '2 Bedroom Villa Garden View', 'Two bedrooms · Garden view · Room for the family', '/2-bedroom-villa-garden-view/' ),
	);

	$room_fields = array(
		'rooms_show'       => $show,
		'rooms_eyebrow'    => array(
			'type'    => 'text',
			'label'   => __( 'Small heading', 'tebasuci' ),
			'default' => 'Stay a little longer',
		),
		'rooms_title'      => array(
			'type'    => 'textarea',
			'label'   => __( 'Heading', 'tebasuci' ),
			'default' => 'Room for your kind of escape.',
		),
		'rooms_text'       => array(
			'type'    => 'textarea',
			'label'   => __( 'Intro text', 'tebasuci' ),
			'default' => 'Choose a place to slow down, with the landscapes of Ubud just beyond your door.',
		),
		'rooms_image'      => array(
			'type'        => 'image',
			'label'       => __( 'Photo', 'tebasuci' ),
			'default'     => '',
			'bundled'     => 'pool',
			'alt'         => 'A private plunge pool villa beside the rice fields at Teba Suci Suite',
			'description' => $image_note,
		),
		'rooms_image_note' => array(
			'type'        => 'text',
			'label'       => __( 'Photo label', 'tebasuci' ),
			'default'     => 'A private pool villa',
			'description' => $hide_note,
		),
	);

	for ( $i = 1; $i <= tebasuci_room_slots(); $i++ ) {
		$defaults = isset( $room_defaults[ $i ] ) ? $room_defaults[ $i ] : array( '', '', '' );

		$room_fields[ "room_{$i}_name" ]   = array(
			'type'        => 'text',
			/* translators: %d: room number. */
			'label'       => sprintf( __( 'Room %d – name', 'tebasuci' ), $i ),
			'default'     => $defaults[0],
			'description' => 1 === $i ? __( 'Leave a room name empty to hide that row. Up to 8 rooms.', 'tebasuci' ) : '',
		);
		$room_fields[ "room_{$i}_detail" ] = array(
			'type'    => 'text',
			/* translators: %d: room number. */
			'label'   => sprintf( __( 'Room %d – details', 'tebasuci' ), $i ),
			'default' => $defaults[1],
		);
		$room_fields[ "room_{$i}_url" ]    = array(
			'type'        => 'link',
			/* translators: %d: room number. */
			'label'       => sprintf( __( 'Room %d – link', 'tebasuci' ), $i ),
			'default'     => isset( $defaults[2] ) ? $defaults[2] : '',
			'description' => 1 === $i ? __( 'Leave empty to link to the booking engine.', 'tebasuci' ) : '',
		);
	}

	$room_fields['rooms_button_label'] = array(
		'type'        => 'text',
		'label'       => __( 'Button text', 'tebasuci' ),
		'default'     => 'Explore all stays',
		'description' => $hide_note,
	);
	$room_fields['rooms_button_url']   = array(
		'type'        => 'link',
		'label'       => __( 'Button link', 'tebasuci' ),
		'default'     => '',
		'description' => __( 'Leave empty to link to the booking engine.', 'tebasuci' ),
	);

	// Gallery photos.
	$gallery_bundled = array(
		1 => array( 'hero', 'The main pool and rice-field view at Teba Suci Suite' ),
		2 => array( 'suite', 'A suite opening onto the pool and tropical greenery' ),
		3 => array( 'pool', 'A private plunge pool beside the rice fields' ),
		4 => array( 'cafe', 'D’Gadon Cafe terrace overlooking the rice fields' ),
		5 => array( 'gallery5', 'Morning yoga by the rice fields at Teba Suci Suite' ),
	);

	$gallery_fields = array(
		'gallery_show'    => $show,
		'gallery_eyebrow' => array(
			'type'    => 'text',
			'label'   => __( 'Small heading', 'tebasuci' ),
			'default' => 'A sense of place',
		),
		'gallery_title'   => array(
			'type'    => 'textarea',
			'label'   => __( 'Heading', 'tebasuci' ),
			'default' => 'Take a closer look.',
		),
		'gallery_note'    => array(
			'type'        => 'text',
			'label'       => __( 'Side note', 'tebasuci' ),
			'default'     => 'The stillness, the green, the light.',
			'description' => $hide_note,
		),
	);

	for ( $i = 1; $i <= tebasuci_gallery_slots(); $i++ ) {
		$bundled = isset( $gallery_bundled[ $i ] ) ? $gallery_bundled[ $i ] : array( '', '' );

		$gallery_fields[ "gallery_image_{$i}" ] = array(
			'type'        => 'image',
			/* translators: %d: photo number. */
			'label'       => sprintf( __( 'Photo %d', 'tebasuci' ), $i ),
			'default'     => '',
			'bundled'     => $bundled[0],
			'alt'         => $bundled[1],
			'description' => 1 === $i
				? __( 'Photo 1 is the large one. Photos 1–4 use the theme photos until you choose your own; photo 5 is optional and completes the grid.', 'tebasuci' )
				: '',
		);
	}

	$gallery_fields['gallery_link_label'] = array(
		'type'        => 'text',
		'label'       => __( 'Link text (optional)', 'tebasuci' ),
		'default'     => '',
		'description' => __( 'For example “See the full gallery”. Shown under the photos when both text and link are filled in.', 'tebasuci' ),
	);
	$gallery_fields['gallery_link_url']   = array(
		'type'    => 'link',
		'label'   => __( 'Link (optional)', 'tebasuci' ),
		'default' => '',
	);

	$sections = array(
		'tebasuci_contact'    => array(
			'title'       => __( 'Booking & contact', 'tebasuci' ),
			'description' => __( 'Used in the header, buttons, footer and the location section.', 'tebasuci' ),
			'fields'      => array(
				'booking_url'     => array(
					'type'        => 'link',
					'label'       => __( 'Booking engine link', 'tebasuci' ),
					'default'     => 'https://ibe.channex.io/tebasucisuite',
					'description' => __( 'Every “Book” and “View availability” button points here unless it has its own link.', 'tebasuci' ),
				),
				'booking_label'   => array(
					'type'    => 'text',
					'label'   => __( 'Header button text', 'tebasuci' ),
					'default' => 'Book your stay',
				),
				'maps_url'        => array(
					'type'    => 'link',
					'label'   => __( 'Google Maps link', 'tebasuci' ),
					'default' => 'https://maps.app.goo.gl/6oXzHA2DkZiZYc959',
				),
				'address'         => array(
					'type'    => 'textarea',
					'label'   => __( 'Address', 'tebasuci' ),
					'default' => 'Jl. Raya Semana, Singakerta, Kecamatan Ubud, Kabupaten Gianyar, Bali 80571',
				),
				'phone'           => array(
					'type'        => 'text',
					'label'       => __( 'Phone', 'tebasuci' ),
					'default'     => '+62 821 2970 5341',
					'description' => __( 'Shown in the footer when filled in. Use the international format, e.g. +62 361 123 456.', 'tebasuci' ),
				),
				'whatsapp'        => array(
					'type'        => 'text',
					'label'       => __( 'WhatsApp number', 'tebasuci' ),
					'default'     => '+62 821 2970 5341',
					'description' => __( 'Shown in the footer when filled in, e.g. +62 812 3456 7890.', 'tebasuci' ),
				),
				'email'           => array(
					'type'        => 'email',
					'label'       => __( 'Email', 'tebasuci' ),
					'default'     => 'info@tebasucisuite.com',
					'description' => __( 'Shown in the footer when filled in.', 'tebasuci' ),
				),
				'instagram_url'   => array(
					'type'    => 'link',
					'label'   => __( 'Instagram link', 'tebasuci' ),
					'default' => 'https://www.instagram.com/tebasucisuite/',
				),
				'facebook_url'    => array(
					'type'    => 'link',
					'label'   => __( 'Facebook link', 'tebasuci' ),
					'default' => '',
				),
				'tripadvisor_url' => array(
					'type'    => 'link',
					'label'   => __( 'Tripadvisor link', 'tebasuci' ),
					'default' => 'https://www.tripadvisor.com/Hotel_Review-g15880600-d27685441-Reviews-Teba_Suci_Suite-Singakerta_Ubud_Gianyar_Regency_Bali.html',
				),
			),
		),
		'tebasuci_brand'      => array(
			'title'       => __( 'Header & footer', 'tebasuci' ),
			'description' => __( 'The text logo is used unless a logo image is set under Site Identity. Menus are managed under Appearance → Menus; until a menu is assigned, the links from the design are used.', 'tebasuci' ),
			'fields'      => array(
				'wordmark_name'          => array(
					'type'    => 'text',
					'label'   => __( 'Text logo – name', 'tebasuci' ),
					'default' => 'Teba Suci Suite',
				),
				'wordmark_subtitle'      => array(
					'type'    => 'text',
					'label'   => __( 'Text logo – small line', 'tebasuci' ),
					'default' => 'Ubud, Bali',
				),
				'footer_tagline'         => array(
					'type'    => 'textarea',
					'label'   => __( 'Footer tagline', 'tebasuci' ),
					'default' => 'A quiet corner of Ubud, made for a slower stay.',
				),
				'footer_explore_heading' => array(
					'type'    => 'text',
					'label'   => __( 'Footer links heading', 'tebasuci' ),
					'default' => 'Explore',
				),
				'footer_contact_heading' => array(
					'type'    => 'text',
					'label'   => __( 'Footer contact heading', 'tebasuci' ),
					'default' => 'Make it yours',
				),
				'inner_cta_show'         => array(
					'type'        => 'checkbox',
					'label'       => __( 'Show the booking banner at the bottom of inner pages and posts', 'tebasuci' ),
					'default'     => true,
					'description' => __( 'Uses the text from the “Booking banner” section.', 'tebasuci' ),
				),
			),
		),
		'tebasuci_hero'       => array(
			'title'  => __( 'Hero', 'tebasuci' ),
			'fields' => array(
				'hero_image'        => array(
					'type'        => 'image',
					'label'       => __( 'Background photo', 'tebasuci' ),
					'default'     => '',
					'bundled'     => 'hero',
					'alt'         => 'The main pool at Teba Suci Suite with a floating breakfast and rice-field view',
					'description' => $image_note . ' ' . __( 'Use a wide landscape photo, at least 1920 px wide.', 'tebasuci' ),
				),
				'hero_eyebrow'      => array(
					'type'    => 'text',
					'label'   => __( 'Small heading', 'tebasuci' ),
					'default' => 'A quiet corner of Ubud',
				),
				'hero_title'        => array(
					'type'        => 'textarea',
					'label'       => __( 'Main heading', 'tebasuci' ),
					'default'     => "Find your own\nkind of Bali.",
					'description' => __( 'Press Enter to start a new line.', 'tebasuci' ),
				),
				'hero_text'         => array(
					'type'    => 'textarea',
					'label'   => __( 'Text', 'tebasuci' ),
					'default' => 'Where rice fields meet the rhythm of a slower stay.',
				),
				'hero_button_label' => array(
					'type'        => 'text',
					'label'       => __( 'Button text', 'tebasuci' ),
					'default'     => 'Discover the suites',
					'description' => $hide_note,
				),
				'hero_button_url'   => array(
					'type'    => 'link',
					'label'   => __( 'Button link', 'tebasuci' ),
					'default' => '#accommodation',
				),
				'hero_scroll_label' => array(
					'type'    => 'text',
					'label'   => __( 'Scroll hint', 'tebasuci' ),
					'default' => 'Scroll to discover',
				),
				'hero_location'     => array(
					'type'    => 'text',
					'label'   => __( 'Location label (bottom right)', 'tebasuci' ),
					'default' => 'Ubud · Bali',
				),
			),
		),
		'tebasuci_welcome'    => array(
			'title'  => __( 'Welcome', 'tebasuci' ),
			'fields' => array(
				'welcome_show'       => $show,
				'welcome_eyebrow'    => array(
					'type'    => 'text',
					'label'   => __( 'Small heading', 'tebasuci' ),
					'default' => 'Welcome to Teba Suci Suite',
				),
				'welcome_title'      => array(
					'type'    => 'textarea',
					'label'   => __( 'Heading', 'tebasuci' ),
					'default' => "A little closer\nto the nature of Bali.",
				),
				'welcome_text'       => array(
					'type'    => 'textarea',
					'label'   => __( 'Text', 'tebasuci' ),
					'default' => 'Tucked among Ubud’s green landscapes, Teba Suci Suite is a place to ease into the day, take in the view, and make room for the moments that matter.',
				),
				'welcome_link_label' => array(
					'type'        => 'text',
					'label'       => __( 'Link text', 'tebasuci' ),
					'default'     => 'Find your place here',
					'description' => $hide_note,
				),
				'welcome_link_url'   => array(
					'type'    => 'link',
					'label'   => __( 'Link', 'tebasuci' ),
					'default' => '#accommodation',
				),
				'welcome_image'      => array(
					'type'        => 'image',
					'label'       => __( 'Photo', 'tebasuci' ),
					'default'     => '',
					'bundled'     => 'suite',
					'alt'         => 'A suite opening onto the pool and tropical greenery at Teba Suci Suite',
					'description' => $image_note,
				),
				'welcome_caption'    => array(
					'type'        => 'text',
					'label'       => __( 'Photo label', 'tebasuci' ),
					'default'     => 'A slower way to stay',
					'description' => $hide_note,
				),
			),
		),
		'tebasuci_facts'      => array(
			'title'       => __( 'Highlights band', 'tebasuci' ),
			'description' => __( 'The olive band with four highlights. Leave a value and label empty to hide that highlight.', 'tebasuci' ),
			'fields'      => array(
				'facts_show'    => $show,
				'fact_1_value'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 1 – value', 'tebasuci' ),
					'default' => '11',
				),
				'fact_1_suffix' => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 1 – small unit', 'tebasuci' ),
					'default' => '',
				),
				'fact_1_label'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 1 – label', 'tebasuci' ),
					'default' => 'Private spaces',
				),
				'fact_2_value'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 2 – value', 'tebasuci' ),
					'default' => '12',
				),
				'fact_2_suffix' => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 2 – small unit', 'tebasuci' ),
					'default' => '',
				),
				'fact_2_label'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 2 – label', 'tebasuci' ),
					'default' => 'Rooms to unwind',
				),
				'fact_3_value'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 3 – value', 'tebasuci' ),
					'default' => '15',
				),
				'fact_3_suffix' => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 3 – small unit', 'tebasuci' ),
					'default' => 'min',
				),
				'fact_3_label'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 3 – label', 'tebasuci' ),
					'default' => 'From central Ubud',
				),
				'fact_4_value'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 4 – value', 'tebasuci' ),
					'default' => 'Rice',
				),
				'fact_4_suffix' => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 4 – small unit', 'tebasuci' ),
					'default' => '',
				),
				'fact_4_label'  => array(
					'type'    => 'text',
					'label'   => __( 'Highlight 4 – label', 'tebasuci' ),
					'default' => 'Field-side moments',
				),
			),
		),
		'tebasuci_rooms'      => array(
			'title'  => __( 'Accommodation', 'tebasuci' ),
			'fields' => $room_fields,
		),
		'tebasuci_experience' => array(
			'title'  => __( 'Experience', 'tebasuci' ),
			'fields' => array(
				'experience_show'       => $show,
				'experience_image'      => array(
					'type'        => 'image',
					'label'       => __( 'Photo', 'tebasuci' ),
					'default'     => '',
					'bundled'     => 'experience',
					'alt'         => 'Floating breakfast in the pool with rice-field views at Teba Suci Suite',
					'description' => $image_note,
				),
				'experience_eyebrow'    => array(
					'type'    => 'text',
					'label'   => __( 'Small heading', 'tebasuci' ),
					'default' => 'Little things, lasting memories',
				),
				'experience_title'      => array(
					'type'    => 'textarea',
					'label'   => __( 'Heading', 'tebasuci' ),
					'default' => "Let the day\nunfold naturally.",
				),
				'experience_text'       => array(
					'type'    => 'textarea',
					'label'   => __( 'Text', 'tebasuci' ),
					'default' => 'Take a quiet dip, linger over breakfast, or simply let the green views set the pace. At Teba Suci, the best moments are often the unhurried ones.',
				),
				'experience_link_label' => array(
					'type'        => 'text',
					'label'       => __( 'Link text', 'tebasuci' ),
					'default'     => 'A glimpse of the stay',
					'description' => $hide_note,
				),
				'experience_link_url'   => array(
					'type'    => 'link',
					'label'   => __( 'Link', 'tebasuci' ),
					'default' => '#gallery',
				),
			),
		),
		'tebasuci_cafe'       => array(
			'title'  => __( 'D’Gadon Cafe', 'tebasuci' ),
			'fields' => array(
				'cafe_show'       => $show,
				'cafe_eyebrow'    => array(
					'type'    => 'text',
					'label'   => __( 'Small heading', 'tebasuci' ),
					'default' => 'A table with a view',
				),
				'cafe_title'      => array(
					'type'    => 'textarea',
					'label'   => __( 'Heading', 'tebasuci' ),
					'default' => 'D’Gadon Cafe',
				),
				'cafe_text'       => array(
					'type'    => 'textarea',
					'label'   => __( 'Text', 'tebasuci' ),
					'default' => 'Settle into the easy rhythm of Bali at D’Gadon Cafe, with open rice-field views and a little more time to enjoy the moment.',
				),
				'cafe_link_label' => array(
					'type'        => 'text',
					'label'       => __( 'Link text', 'tebasuci' ),
					'default'     => 'Discover D’Gadon Cafe',
					'description' => $hide_note,
				),
				'cafe_link_url'   => array(
					'type'        => 'link',
					'label'       => __( 'Link', 'tebasuci' ),
					'default'     => '/dgadoncafe/',
					'description' => __( 'For example the cafe page, a menu PDF or #contact.', 'tebasuci' ),
				),
				'cafe_image'      => array(
					'type'        => 'image',
					'label'       => __( 'Photo', 'tebasuci' ),
					'default'     => '',
					'bundled'     => 'cafe',
					'alt'         => 'D’Gadon Cafe terrace overlooking the rice fields at Teba Suci Suite',
					'description' => $image_note,
				),
			),
		),
		'tebasuci_offer'      => array(
			'title'       => __( 'Booking banner', 'tebasuci' ),
			'description' => __( 'The sand-coloured banner with a “View availability” button. Also shown at the bottom of inner pages unless switched off under Header & footer.', 'tebasuci' ),
			'fields'      => array(
				'offer_show'         => $show,
				'offer_eyebrow'      => array(
					'type'    => 'text',
					'label'   => __( 'Small heading', 'tebasuci' ),
					'default' => 'Special staycation deal',
				),
				'offer_title'        => array(
					'type'    => 'textarea',
					'label'   => __( 'Heading', 'tebasuci' ),
					'default' => "Your next Ubud story\nstarts here.",
				),
				'offer_text'         => array(
					'type'    => 'textarea',
					'label'   => __( 'Text', 'tebasuci' ),
					'default' => 'Tailored packages designed to make your stay truly unforgettable — book now and indulge in the ultimate Ubud getaway.',
				),
				'offer_button_label' => array(
					'type'        => 'text',
					'label'       => __( 'Button text', 'tebasuci' ),
					'default'     => 'View our special deal',
					'description' => $hide_note,
				),
				'offer_button_url'   => array(
					'type'        => 'link',
					'label'       => __( 'Button link', 'tebasuci' ),
					'default'     => '/specialoffer/',
					'description' => __( 'Leave empty to link to the booking engine.', 'tebasuci' ),
				),
			),
		),
		'tebasuci_gallery'    => array(
			'title'  => __( 'Gallery', 'tebasuci' ),
			'fields' => $gallery_fields,
		),
		'tebasuci_location'   => array(
			'title'  => __( 'Location', 'tebasuci' ),
			'fields' => array(
				'location_show'          => $show,
				'location_mark'          => array(
					'type'    => 'text',
					'label'   => __( 'Monogram in the circle', 'tebasuci' ),
					'default' => 'TS',
				),
				'location_eyebrow'       => array(
					'type'    => 'text',
					'label'   => __( 'Small heading', 'tebasuci' ),
					'default' => 'Your Ubud hideaway',
				),
				'location_title'         => array(
					'type'    => 'textarea',
					'label'   => __( 'Heading', 'tebasuci' ),
					'default' => "Just beyond\nthe everyday.",
				),
				'location_text'          => array(
					'type'    => 'textarea',
					'label'   => __( 'Text', 'tebasuci' ),
					'default' => 'Find us on Jl. Raya Semana, Singakerta — around 15 minutes from the heart of Ubud.',
				),
				'location_link_label'    => array(
					'type'        => 'text',
					'label'       => __( 'Link text', 'tebasuci' ),
					'default'     => 'Find us on the map',
					'description' => $hide_note,
				),
				'location_link_url'      => array(
					'type'        => 'link',
					'label'       => __( 'Link', 'tebasuci' ),
					'default'     => '',
					'description' => __( 'Leave empty to use the Google Maps link from “Booking & contact”.', 'tebasuci' ),
				),
				'location_aside_eyebrow' => array(
					'type'    => 'text',
					'label'   => __( 'Side note – small heading', 'tebasuci' ),
					'default' => 'A change of pace',
				),
				'location_aside_text'    => array(
					'type'        => 'textarea',
					'label'       => __( 'Side note – text', 'tebasuci' ),
					'default'     => "Come for the view.\nStay for the feeling.",
					'description' => $hide_note,
				),
			),
		),
		'tebasuci_seo'        => array(
			'title'       => __( 'Search & sharing', 'tebasuci' ),
			'description' => __( 'Used only when no SEO plugin (Yoast SEO, Rank Math, All in One SEO, SEOPress, The SEO Framework) is active. The browser-tab title comes from Settings → General: “Site Title | Tagline”.', 'tebasuci' ),
			'fields'      => array(
				'seo_description' => array(
					'type'        => 'textarea',
					'label'       => __( 'Homepage description', 'tebasuci' ),
					'default'     => 'Teba Suci Suite is a quiet Ubud retreat with rice-field views, private pool villas and D’Gadon Cafe — around 15 minutes from the centre of Ubud, Bali.',
					'description' => __( 'Shown under the page title in Google results and when the site is shared. About 150 characters.', 'tebasuci' ),
				),
			),
		),
	);

	return $sections;
}

/**
 * Definition of a single field.
 *
 * @param string $key Field key.
 * @return array|null
 */
function tebasuci_field( $key ) {
	static $index = null;

	if ( null === $index ) {
		$index = array();
		foreach ( tebasuci_fields() as $section ) {
			foreach ( $section['fields'] as $field_key => $field ) {
				$index[ $field_key ] = $field;
			}
		}
	}

	return isset( $index[ $key ] ) ? $index[ $key ] : null;
}

/**
 * Current value of a field (the saved value, or the design default).
 *
 * @param string $key Field key.
 * @return mixed
 */
function tebasuci_get( $key ) {
	$field   = tebasuci_field( $key );
	$default = $field ? $field['default'] : '';
	$value   = get_theme_mod( $key, $default );

	if ( $field && 'checkbox' === $field['type'] ) {
		return (bool) $value;
	}

	return is_string( $value ) ? trim( $value ) : $value;
}

/**
 * Whether a homepage section is switched on.
 *
 * @param string $section Section prefix, e.g. "rooms".
 * @return bool
 */
function tebasuci_show( $section ) {
	return (bool) tebasuci_get( $section . '_show' );
}

<?php
/**
 * Basic search and sharing tags.
 *
 * Only used when no SEO plugin is active, so it never duplicates the
 * tags that Yoast SEO, Rank Math and similar plugins print.
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether a dedicated SEO plugin is handling meta tags.
 *
 * @return bool
 */
function tebasuci_has_seo_plugin() {
	$active = defined( 'WPSEO_VERSION' )            // Yoast SEO.
		|| defined( 'RANK_MATH_VERSION' )           // Rank Math.
		|| defined( 'AIOSEO_VERSION' )              // All in One SEO.
		|| defined( 'SEOPRESS_VERSION' )            // SEOPress.
		|| defined( 'THE_SEO_FRAMEWORK_VERSION' );  // The SEO Framework.

	return (bool) apply_filters( 'tebasuci_has_seo_plugin', $active );
}

/**
 * Plain text without tags, shortcodes or extra whitespace.
 *
 * @param string $text Raw text.
 * @return string
 */
function tebasuci_plain_text( $text ) {
	$text = excerpt_remove_blocks( strip_shortcodes( (string) $text ) );
	$text = wp_strip_all_tags( $text );
	return trim( preg_replace( '/\s+/', ' ', html_entity_decode( $text, ENT_QUOTES, get_bloginfo( 'charset' ) ) ) );
}

/**
 * Description for the current page.
 *
 * @return string
 */
function tebasuci_meta_description() {
	if ( is_front_page() ) {
		return tebasuci_plain_text( tebasuci_get( 'seo_description' ) );
	}

	if ( is_singular() ) {
		$post = get_queried_object();
		$text = has_excerpt( $post ) ? $post->post_excerpt : $post->post_content;
		return wp_trim_words( tebasuci_plain_text( $text ), 30, '…' );
	}

	if ( is_category() || is_tag() || is_tax() ) {
		return tebasuci_plain_text( term_description() );
	}

	return '';
}

/**
 * Print description, Open Graph and Twitter tags.
 */
function tebasuci_social_meta() {
	if ( tebasuci_has_seo_plugin() || is_404() || is_search() ) {
		return;
	}

	$description = tebasuci_meta_description();
	$title       = wp_get_document_title();
	$site_name   = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$url         = '';
	$image       = '';

	if ( is_front_page() ) {
		$url = home_url( '/' );
	} elseif ( is_singular() ) {
		$url = get_permalink();
	}

	if ( is_singular() && ! is_front_page() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'large' );
	} else {
		$hero  = tebasuci_image_sources( 'hero_image' );
		$image = $hero ? $hero['src'] : '';
	}

	$tags = array(
		array( 'name', 'description', $description ),
		array( 'property', 'og:type', is_singular( 'post' ) ? 'article' : 'website' ),
		array( 'property', 'og:site_name', $site_name ),
		array( 'property', 'og:title', wp_specialchars_decode( $title, ENT_QUOTES ) ),
		array( 'property', 'og:description', $description ),
		array( 'property', 'og:url', $url ),
		array( 'property', 'og:image', $image ),
		array( 'name', 'twitter:card', $image ? 'summary_large_image' : 'summary' ),
	);

	foreach ( $tags as $tag ) {
		if ( '' === (string) $tag[2] ) {
			continue;
		}
		$value = in_array( $tag[1], array( 'og:url', 'og:image' ), true ) ? esc_url( $tag[2] ) : esc_attr( $tag[2] );
		printf( '<meta %1$s="%2$s" content="%3$s">' . "\n", esc_attr( $tag[0] ), esc_attr( $tag[1] ), $value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
	}
}
add_action( 'wp_head', 'tebasuci_social_meta', 5 );

/**
 * A schema.org PostalAddress built from the plain address string.
 *
 * @return array|null
 */
function tebasuci_postal_address() {
	$raw = trim( (string) tebasuci_get( 'address' ) );
	if ( '' === $raw ) {
		return null;
	}

	$flat  = preg_replace( '/\s*\n\s*/', ', ', $raw );
	$parts = array_values( array_filter( array_map( 'trim', explode( ',', $flat ) ) ) );

	$address = array( '@type' => 'PostalAddress' );
	if ( ! empty( $parts[0] ) ) {
		$address['streetAddress'] = $parts[0];
	}
	if ( preg_match( '/\b(\d{5})\b/', $flat, $m ) ) {
		$address['postalCode'] = $m[1];
	}
	$address['addressLocality'] = apply_filters( 'tebasuci_address_locality', 'Ubud' );
	$address['addressRegion']   = apply_filters( 'tebasuci_address_region', 'Bali' );
	$address['addressCountry']  = apply_filters( 'tebasuci_address_country', 'ID' );

	return $address;
}

/**
 * Lodging/hotel details for search engines and AI answers (schema.org).
 *
 * Output on the homepage even when a SEO plugin is active: Yoast, Rank Math
 * and the like describe the page and the organisation, but not the property
 * as a hotel with rooms, amenities and a location, so this complements them.
 */
function tebasuci_structured_data() {
	if ( ! is_front_page() || ! apply_filters( 'tebasuci_output_lodging_schema', true ) ) {
		return;
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@type'    => array( 'Hotel', 'LodgingBusiness' ),
		'@id'      => home_url( '/#lodging' ),
		'name'     => wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
		'url'      => home_url( '/' ),
	);

	$description = tebasuci_plain_text( tebasuci_get( 'seo_description' ) );
	if ( '' !== $description ) {
		$data['description'] = $description;
	}

	$images = array();
	foreach ( array( 'hero_image', 'welcome_image', 'cafe_image' ) as $key ) {
		$img = tebasuci_image_sources( $key );
		if ( $img ) {
			$images[] = $img['src'];
		}
	}
	if ( $images ) {
		$data['image'] = $images;
	}

	if ( has_custom_logo() ) {
		$logo = wp_get_attachment_image_src( (int) get_theme_mod( 'custom_logo' ), 'full' );
		if ( $logo ) {
			$data['logo'] = $logo[0];
		}
	} elseif ( file_exists( TEBASUCI_DIR . '/assets/images/logo.png' ) ) {
		$data['logo'] = TEBASUCI_URI . '/assets/images/logo.png';
	}

	$address = tebasuci_postal_address();
	if ( $address ) {
		$data['address'] = $address;
	}

	$lat = (string) tebasuci_get( 'geo_latitude' );
	$lng = (string) tebasuci_get( 'geo_longitude' );
	if ( '' !== $lat && '' !== $lng ) {
		$data['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $lat,
			'longitude' => $lng,
		);
	}

	$maps = (string) tebasuci_get( 'maps_url' );
	if ( '' !== $maps ) {
		$data['hasMap'] = $maps;
	}

	$phone = (string) tebasuci_get( 'phone' );
	if ( '' !== $phone ) {
		$data['telephone'] = $phone;
	}

	$email = (string) tebasuci_get( 'email' );
	if ( '' !== $email && is_email( $email ) ) {
		$data['email'] = $email;
	}

	$data['priceRange']         = '$$';
	$data['currenciesAccepted'] = 'IDR';
	$data['checkinTime']        = '14:00';
	$data['checkoutTime']       = '11:00';
	$data['numberOfRooms']      = 12;

	$data['amenityFeature'] = array();
	foreach ( array( 'Outdoor swimming pool', 'Free Wi-Fi', 'Restaurant', 'Air conditioning', 'Rice-field view', 'Airport shuttle', 'Daily housekeeping' ) as $feature ) {
		$data['amenityFeature'][] = array(
			'@type' => 'LocationFeatureSpecification',
			'name'  => $feature,
			'value' => true,
		);
	}

	$same_as = array_values(
		array_filter(
			array(
				(string) tebasuci_get( 'instagram_url' ),
				(string) tebasuci_get( 'facebook_url' ),
				(string) tebasuci_get( 'tripadvisor_url' ),
			)
		)
	);
	if ( $same_as ) {
		$data['sameAs'] = $same_as;
	}

	echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON with tags hex-escaped.
}
add_action( 'wp_head', 'tebasuci_structured_data', 6 );

/**
 * Geo meta tags for local search (not output by the common SEO plugins).
 */
function tebasuci_geo_meta() {
	if ( ! is_front_page() ) {
		return;
	}

	$lat   = (string) tebasuci_get( 'geo_latitude' );
	$lng   = (string) tebasuci_get( 'geo_longitude' );
	$place = trim( preg_replace( '/\s*\n\s*/', ', ', (string) tebasuci_get( 'address' ) ) );

	if ( '' !== $place ) {
		printf( '<meta name="geo.placename" content="%s">' . "\n", esc_attr( $place ) );
	}
	printf( '<meta name="geo.region" content="%s">' . "\n", esc_attr( apply_filters( 'tebasuci_geo_region', 'ID-BA' ) ) );
	if ( '' !== $lat && '' !== $lng ) {
		printf( '<meta name="geo.position" content="%s;%s">' . "\n", esc_attr( $lat ), esc_attr( $lng ) );
		printf( '<meta name="ICBM" content="%s, %s">' . "\n", esc_attr( $lat ), esc_attr( $lng ) );
	}
}
add_action( 'wp_head', 'tebasuci_geo_meta', 4 );

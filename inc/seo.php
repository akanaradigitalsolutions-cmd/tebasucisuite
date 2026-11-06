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
 * Hotel details for search engines (schema.org), on the homepage.
 */
function tebasuci_structured_data() {
	if ( ! is_front_page() || tebasuci_has_seo_plugin() ) {
		return;
	}

	$data = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Hotel',
		'name'     => wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
		'url'      => home_url( '/' ),
	);

	$description = tebasuci_plain_text( tebasuci_get( 'seo_description' ) );
	if ( '' !== $description ) {
		$data['description'] = $description;
	}

	$hero = tebasuci_image_sources( 'hero_image' );
	if ( $hero ) {
		$data['image'] = $hero['src'];
	}

	$address = trim( preg_replace( '/\s*\n\s*/', ', ', (string) tebasuci_get( 'address' ) ) );
	if ( '' !== $address ) {
		$data['address'] = $address;
	}

	$phone = (string) tebasuci_get( 'phone' );
	if ( '' !== $phone ) {
		$data['telephone'] = $phone;
	}

	$email = (string) tebasuci_get( 'email' );
	if ( '' !== $email ) {
		$data['email'] = $email;
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

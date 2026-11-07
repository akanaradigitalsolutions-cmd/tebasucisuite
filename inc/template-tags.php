<?php
/**
 * Template helpers: text, links, photos, menus and small bits of markup.
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inline SVG icon (shapes from the Lucide icon set, ISC licence).
 *
 * @param string $name Icon name.
 * @return string
 */
function tebasuci_icon( $name ) {
	$paths = array(
		'arrow-right' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'arrow-down'  => '<path d="M12 5v14"/><path d="m19 12-7 7-7-7"/>',
		'arrow-up'    => '<path d="m5 12 7-7 7 7"/><path d="M12 19V5"/>',
		'menu'        => '<path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/>',
		'close'       => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return '<svg class="icon icon-' . esc_attr( $name ) . '" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}

/**
 * Escaped single-line text of a field.
 *
 * @param string $key Field key.
 * @return string
 */
function tebasuci_text( $key ) {
	return esc_html( (string) tebasuci_get( $key ) );
}

/**
 * Escaped text of a field with its line breaks kept as <br>.
 *
 * @param string $key Field key.
 * @return string
 */
function tebasuci_lines( $key ) {
	return nl2br( esc_html( (string) tebasuci_get( $key ) ), false );
}

/**
 * URL of a homepage section. On the homepage this is just the anchor
 * (smooth scroll); elsewhere it points back to the homepage.
 *
 * @param string $hash Anchor such as "#gallery".
 * @return string
 */
function tebasuci_section_url( $hash ) {
	if ( '#home' === $hash ) {
		return is_front_page() ? '#home' : home_url( '/' );
	}
	return is_front_page() ? $hash : home_url( '/' ) . $hash;
}

/**
 * Turn a saved link (full URL, /path/ or #anchor) into a usable URL.
 *
 * @param string $url Saved link.
 * @return string
 */
function tebasuci_resolve_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '';
	}
	if ( 0 === strpos( $url, '#' ) ) {
		return tebasuci_section_url( $url );
	}
	return $url;
}

/**
 * Whether a URL points to another website.
 *
 * @param string $url URL.
 * @return bool
 */
function tebasuci_is_external( $url ) {
	$host = wp_parse_url( $url, PHP_URL_HOST );
	if ( empty( $host ) ) {
		return false;
	}
	$home = (string) wp_parse_url( home_url(), PHP_URL_HOST );
	$bare = static function ( $value ) {
		return strtolower( preg_replace( '/^www\./i', '', $value ) );
	};
	return $bare( $host ) !== $bare( $home );
}

/**
 * Value of a link field, or of a fallback link field when empty.
 *
 * @param string $key          Link field.
 * @param string $fallback_key Field used when $key is empty.
 * @return string
 */
function tebasuci_url_or( $key, $fallback_key ) {
	$url = (string) tebasuci_get( $key );
	return '' !== $url ? $url : (string) tebasuci_get( $fallback_key );
}

/**
 * Print a link. Links to other websites open in a new tab, with a hint
 * for screen readers. Nothing is printed when the URL or label is empty.
 *
 * @param string $url   Full URL, /path/ or #anchor.
 * @param string $label Plain-text label.
 * @param string $class CSS classes.
 * @param string $icon  Icon after the label ('' for none).
 */
function tebasuci_link( $url, $label, $class = '', $icon = 'arrow-right' ) {
	$url   = tebasuci_resolve_url( $url );
	$label = trim( (string) $label );
	if ( '' === $url || '' === $label ) {
		return;
	}

	$external = tebasuci_is_external( $url );

	// Label and screen-reader hint share one element so buttons keep a single gap before the icon.
	printf(
		'<a%1$s href="%2$s"%3$s><span>%4$s%5$s</span>%6$s</a>',
		$class ? ' class="' . esc_attr( $class ) . '"' : '',
		esc_url( $url ),
		$external ? ' target="_blank" rel="noopener"' : '',
		esc_html( $label ),
		$external ? '<span class="screen-reader-text"> ' . esc_html__( '(opens in a new tab)', 'tebasuci' ) . '</span>' : '',
		$icon ? tebasuci_icon( $icon ) : '' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG.
	);
}

/**
 * Bundled photo: URL, srcset and dimensions.
 *
 * @param string $name Key in tebasuci_bundled_images().
 * @return array|null
 */
function tebasuci_bundled_image( $name ) {
	$images = tebasuci_bundled_images();
	if ( empty( $images[ $name ] ) ) {
		return null;
	}

	$image  = $images[ $name ];
	$base   = TEBASUCI_URI . '/assets/images/' . $image['file'];
	$srcset = array();
	foreach ( $image['variants'] as $width ) {
		$srcset[] = $base . '-' . $width . '.jpg ' . $width . 'w';
	}
	$srcset[] = $base . '.jpg ' . $image['width'] . 'w';

	return array(
		'src'    => $base . '.jpg',
		'srcset' => implode( ', ', $srcset ),
		'width'  => $image['width'],
		'height' => $image['height'],
	);
}

/**
 * Media Library attachment chosen for an image field, if any.
 *
 * @param string $key Image field.
 * @return int Attachment ID or 0.
 */
function tebasuci_image_id( $key ) {
	$id = absint( tebasuci_get( $key ) );
	return ( $id && wp_attachment_is_image( $id ) ) ? $id : 0;
}

/**
 * Sources of an image field: the chosen photo, or the bundled one.
 *
 * @param string $key Image field.
 * @return array|null Keys: src, srcset, width, height.
 */
function tebasuci_image_sources( $key ) {
	$id = tebasuci_image_id( $key );
	if ( $id ) {
		$src = wp_get_attachment_image_src( $id, 'full' );
		if ( ! $src ) {
			return null;
		}
		return array(
			'src'    => $src[0],
			'srcset' => (string) wp_get_attachment_image_srcset( $id, 'full' ),
			'width'  => (int) $src[1],
			'height' => (int) $src[2],
		);
	}

	$field = tebasuci_field( $key );
	return ( $field && ! empty( $field['bundled'] ) ) ? tebasuci_bundled_image( $field['bundled'] ) : null;
}

/**
 * <img> tag for an image field.
 *
 * @param string $key  Image field.
 * @param array  $args class, sizes, priority (true for the first photo on screen).
 * @return string
 */
function tebasuci_image( $key, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class'    => '',
			'sizes'    => '100vw',
			'priority' => false,
		)
	);

	$field       = tebasuci_field( $key );
	$default_alt = ( $field && isset( $field['alt'] ) ) ? $field['alt'] : '';
	$id          = tebasuci_image_id( $key );

	if ( $id ) {
		$alt  = trim( wp_strip_all_tags( (string) get_post_meta( $id, '_wp_attachment_image_alt', true ) ) );
		$attr = array(
			'class'    => $args['class'],
			'sizes'    => $args['sizes'],
			'alt'      => '' !== $alt ? $alt : $default_alt,
			'decoding' => 'async',
		);
		if ( $args['priority'] ) {
			$attr['loading']       = false;
			$attr['fetchpriority'] = 'high';
		} else {
			$attr['loading'] = 'lazy';
		}
		return wp_get_attachment_image( $id, 'full', false, $attr );
	}

	$image = tebasuci_image_sources( $key );
	if ( ! $image ) {
		return '';
	}

	return sprintf(
		'<img class="%1$s" src="%2$s" srcset="%3$s" sizes="%4$s" width="%5$d" height="%6$d" alt="%7$s" decoding="async"%8$s>',
		esc_attr( $args['class'] ),
		esc_url( $image['src'] ),
		esc_attr( $image['srcset'] ),
		esc_attr( $args['sizes'] ),
		(int) $image['width'],
		(int) $image['height'],
		esc_attr( $default_alt ),
		$args['priority'] ? ' fetchpriority="high"' : ' loading="lazy"'
	);
}

/**
 * Logo: the image from Site Identity if set, otherwise the text wordmark.
 *
 * @param string $context "header" or "footer".
 */
function tebasuci_wordmark( $context = 'header' ) {
	// A logo set under Appearance → Customize → Site Identity always wins.
	if ( has_custom_logo() ) {
		echo '<div class="site-logo site-logo--' . esc_attr( $context ) . '">' . get_custom_logo() . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core markup.
		return;
	}

	$name = (string) tebasuci_get( 'wordmark_name' );
	if ( '' === $name ) {
		$name = get_bloginfo( 'name' );
	}

	// Otherwise use the logo image bundled with the theme, if present.
	if ( file_exists( TEBASUCI_DIR . '/assets/images/logo.png' ) ) {
		printf(
			'<a class="site-logo site-logo--%1$s site-logo--bundled" href="%2$s" rel="home"><img src="%3$s" width="400" height="100" alt="%4$s" decoding="async"%5$s></a>',
			esc_attr( $context ),
			esc_url( tebasuci_section_url( '#home' ) ),
			esc_url( TEBASUCI_URI . '/assets/images/logo.png' ),
			esc_attr( $name ),
			'header' === $context ? ' fetchpriority="high"' : ' loading="lazy"'
		);
		return;
	}

	// Final fallback: the text wordmark from the design.
	$subtitle = (string) tebasuci_get( 'wordmark_subtitle' );

	printf(
		'<a class="wordmark%1$s" href="%2$s" rel="home"><span class="wordmark-name">%3$s</span>%4$s</a>',
		'footer' === $context ? ' footer-wordmark' : '',
		esc_url( tebasuci_section_url( '#home' ) ),
		esc_html( $name ),
		'' !== $subtitle ? '<span class="wordmark-subtitle">' . esc_html( $subtitle ) . '</span>' : ''
	);
}

/**
 * Links used until a menu is assigned under Appearance → Menus.
 * Links to switched-off homepage sections are left out.
 *
 * @param string $location "primary" or "footer".
 * @return array Anchor => label.
 */
function tebasuci_default_menu_items( $location ) {
	if ( 'footer' === $location ) {
		$items = array(
			'#accommodation' => __( 'Accommodation', 'tebasuci' ),
			'#cafe'          => __( 'D’Gadon Cafe', 'tebasuci' ),
			'#gallery'       => __( 'Gallery', 'tebasuci' ),
			'#location'      => __( 'Location', 'tebasuci' ),
		);
	} else {
		$items = array(
			'#home'          => __( 'Home', 'tebasuci' ),
			'#accommodation' => __( 'Accommodation', 'tebasuci' ),
			'#cafe'          => __( 'D’Gadon Cafe', 'tebasuci' ),
			'#location'      => __( 'Location', 'tebasuci' ),
			'#gallery'       => __( 'Gallery', 'tebasuci' ),
			'#contact'       => __( 'Contact', 'tebasuci' ),
		);
	}

	$sections = array(
		'#accommodation' => 'rooms',
		'#cafe'          => 'cafe',
		'#location'      => 'location',
		'#gallery'       => 'gallery',
	);
	foreach ( $sections as $hash => $section ) {
		if ( isset( $items[ $hash ] ) && ! tebasuci_show( $section ) ) {
			unset( $items[ $hash ] );
		}
	}

	return $items;
}

/**
 * Fallback for wp_nav_menu() when no menu is assigned to a location.
 *
 * @param array $args wp_nav_menu() arguments.
 * @return string|void
 */
function tebasuci_menu_fallback( $args ) {
	$location = ! empty( $args['theme_location'] ) ? $args['theme_location'] : 'primary';
	$class    = ! empty( $args['menu_class'] ) ? $args['menu_class'] : 'nav-menu';

	$html = '';
	foreach ( tebasuci_default_menu_items( $location ) as $hash => $label ) {
		$html .= '<li class="menu-item"><a href="' . esc_url( tebasuci_section_url( $hash ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	$html = '<ul class="' . esc_attr( $class ) . '">' . $html . '</ul>';

	if ( ! empty( $args['echo'] ) ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
		return;
	}
	return $html;
}

/**
 * Print the menu for a location (single level).
 *
 * @param string $location   Menu location.
 * @param string $menu_class Class of the <ul>.
 */
function tebasuci_nav_menu( $location, $menu_class ) {
	wp_nav_menu(
		array(
			'theme_location' => $location,
			'container'      => false,
			'menu_class'     => $menu_class,
			'depth'          => 1,
			'fallback_cb'    => 'tebasuci_menu_fallback',
		)
	);
}

/**
 * WordPress ignores the #anchor when deciding which menu item is the current
 * page, so on the homepage every section link would be announced as
 * "current page". Keep aria-current for real page links only.
 *
 * @param array $atts Link attributes.
 * @return array
 */
function tebasuci_menu_link_attributes( $atts ) {
	if ( isset( $atts['aria-current'], $atts['href'] ) && false !== strpos( (string) $atts['href'], '#' ) ) {
		unset( $atts['aria-current'] );
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'tebasuci_menu_link_attributes' );

/**
 * Anchor of the first visible section under the hero (for "Scroll to discover").
 *
 * @return string
 */
function tebasuci_first_section_after_hero() {
	$order = array(
		'welcome'    => '#welcome',
		'facts'      => '#highlights',
		'rooms'      => '#accommodation',
		'experience' => '#experience',
		'cafe'       => '#cafe',
		'offer'      => '#offers',
		'gallery'    => '#gallery',
		'location'   => '#location',
	);
	foreach ( $order as $section => $hash ) {
		if ( tebasuci_show( $section ) ) {
			return $hash;
		}
	}
	return '#contact';
}

/**
 * Footer contact lines that have been filled in.
 *
 * @return array List of [ url, label ].
 */
function tebasuci_contact_items() {
	$items = array();

	$phone = (string) tebasuci_get( 'phone' );
	if ( '' !== $phone ) {
		$items[] = array( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ), $phone );
	}

	$whatsapp = (string) tebasuci_get( 'whatsapp' );
	$digits   = preg_replace( '/\D+/', '', $whatsapp );
	if ( '' !== $digits ) {
		// wa.me needs the country code; a local Indonesian number (0812…) becomes 62812….
		if ( 0 === strpos( $digits, '0' ) ) {
			$digits = '62' . substr( $digits, 1 );
		}
		/* translators: %s: WhatsApp phone number. */
		$items[] = array( 'https://wa.me/' . $digits, sprintf( __( 'WhatsApp %s', 'tebasuci' ), $whatsapp ) );
	}

	$email = (string) tebasuci_get( 'email' );
	if ( '' !== $email && is_email( $email ) ) {
		$items[] = array( 'mailto:' . $email, $email );
	}

	$social = array(
		'instagram_url'   => 'Instagram',
		'facebook_url'    => 'Facebook',
		'tripadvisor_url' => 'Tripadvisor',
	);
	foreach ( $social as $key => $label ) {
		$url = (string) tebasuci_get( $key );
		if ( '' !== $url ) {
			$items[] = array( $url, $label );
		}
	}

	return $items;
}

/**
 * Booking banner at the bottom of inner pages and posts.
 */
function tebasuci_inner_cta() {
	if ( tebasuci_get( 'inner_cta_show' ) ) {
		get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
	}
}

/**
 * Small line above a post title: date · first category.
 *
 * @return string
 */
function tebasuci_post_meta() {
	$parts      = array( get_the_date() );
	$categories = get_the_category();
	if ( ! empty( $categories ) ) {
		$parts[] = $categories[0]->name;
	}
	return esc_html( implode( ' · ', $parts ) );
}

/**
 * Archive titles without the "Category:" prefix (shown as the small heading instead).
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

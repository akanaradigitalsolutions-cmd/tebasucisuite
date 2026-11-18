<?php
/**
 * Theme setup: supported features, menus, assets.
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Width of the reading column on pages and posts, used by embeds.
 */
function tebasuci_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tebasuci_content_width', 760 );
}
add_action( 'after_setup_theme', 'tebasuci_content_width', 0 );

/**
 * Register theme features and menu locations.
 */
function tebasuci_setup() {
	load_theme_textdomain( 'tebasuci', TEBASUCI_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Header menu', 'tebasuci' ),
			'footer'  => __( 'Footer “Explore” links', 'tebasuci' ),
		)
	);

	// Lets pages have a short intro line under the title.
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'tebasuci_setup' );

/**
 * Version string for an asset: theme version plus file modification time,
 * so every deploy busts browser and CDN caches.
 *
 * @param string $relative Path relative to the theme folder.
 * @return string
 */
function tebasuci_asset_version( $relative ) {
	$path = TEBASUCI_DIR . '/' . ltrim( $relative, '/' );
	return file_exists( $path ) ? TEBASUCI_VERSION . '.' . filemtime( $path ) : TEBASUCI_VERSION;
}

/**
 * Front-end styles and scripts.
 */
function tebasuci_enqueue_assets() {
	wp_enqueue_style(
		'tebasuci',
		TEBASUCI_URI . '/assets/css/theme.css',
		array(),
		tebasuci_asset_version( 'assets/css/theme.css' )
	);

	wp_enqueue_script(
		'tebasuci',
		TEBASUCI_URI . '/assets/js/theme.js',
		array(),
		tebasuci_asset_version( 'assets/js/theme.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/*
	 * The homepage is drawn entirely by the theme, so the block editor's
	 * stylesheets are not needed there. Filter to false to keep them.
	 */
	if ( is_front_page() && apply_filters( 'tebasuci_trim_front_page_styles', true ) ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'tebasuci_enqueue_assets', 20 );

/**
 * Preload the two main font files and, on the homepage, the hero photo,
 * so the first screen renders quickly.
 */
function tebasuci_preload_assets() {
	foreach ( array( 'bellefair-latin', 'work-sans-latin' ) as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( TEBASUCI_URI . '/assets/fonts/' . $font . '.woff2' )
		);
	}

	if ( is_front_page() ) {
		$hero = tebasuci_image_sources( 'hero_image' );
		if ( $hero ) {
			printf(
				'<link rel="preload" as="image" href="%1$s"%2$s imagesizes="100vw" fetchpriority="high">' . "\n",
				esc_url( $hero['src'] ),
				$hero['srcset'] ? ' imagesrcset="' . esc_attr( $hero['srcset'] ) . '"' : ''
			);
		}
	}
}
add_action( 'wp_head', 'tebasuci_preload_assets', 1 );

/**
 * Faster connections to the booking engine and map provider.
 *
 * @param array  $hints    URLs to hint.
 * @param string $relation Hint type.
 * @return array
 */
function tebasuci_resource_hints( $hints, $relation ) {
	if ( 'dns-prefetch' === $relation ) {
		$booking_host = wp_parse_url( (string) tebasuci_get( 'booking_url' ), PHP_URL_HOST );
		if ( $booking_host ) {
			$hints[] = '//' . $booking_host;
		}
		if ( is_page_template( array( 'page-templates/location.php', 'page-templates/contact.php' ) ) ) {
			$hints[] = '//maps.google.com';
			$hints[] = '//maps.gstatic.com';
		}
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'tebasuci_resource_hints', 10, 2 );

/**
 * Browser-tab titles read "Page | Teba Suci Suite".
 *
 * @return string
 */
function tebasuci_title_separator() {
	return '|';
}
add_filter( 'document_title_separator', 'tebasuci_title_separator' );

/**
 * Shorter excerpts for the post cards.
 *
 * @param int $length Default length in words.
 * @return int
 */
function tebasuci_excerpt_length( $length ) {
	return is_admin() ? $length : 26;
}
add_filter( 'excerpt_length', 'tebasuci_excerpt_length' );

/**
 * Plain ellipsis instead of " [&hellip;]".
 *
 * @param string $more Default "more" string.
 * @return string
 */
function tebasuci_excerpt_more( $more ) {
	return is_admin() ? $more : '…';
}
add_filter( 'excerpt_more', 'tebasuci_excerpt_more' );

/**
 * After the theme is activated, point the admin to the homepage settings.
 */
function tebasuci_activation_flag() {
	set_transient( 'tebasuci_activated', 1, DAY_IN_SECONDS );
}
add_action( 'after_switch_theme', 'tebasuci_activation_flag' );

/**
 * One-time notice with links to the Customizer and menus.
 */
function tebasuci_activation_notice() {
	if ( ! get_transient( 'tebasuci_activated' ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	delete_transient( 'tebasuci_activated' );

	printf(
		'<div class="notice notice-success is-dismissible"><p>%1$s <a href="%2$s">%3$s</a> · <a href="%4$s">%5$s</a></p></div>',
		esc_html__( 'Teba Suci Suite theme is active. Edit the homepage text, photos and links under', 'tebasuci' ),
		esc_url( admin_url( 'customize.php?autofocus[panel]=tebasuci_panel' ) ),
		esc_html__( 'Appearance → Customize → Teba Suci Suite', 'tebasuci' ),
		esc_url( admin_url( 'nav-menus.php' ) ),
		esc_html__( 'Menus', 'tebasuci' )
	);
}
add_action( 'admin_notices', 'tebasuci_activation_notice' );

<?php
/**
 * Site header: logo, menu and booking button.
 *
 * @package TebaSuci
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#fbefc3">
	<?php
	// Flag JS early (so the preloader only shows with JS) and skip it after the
	// first page of a browsing session.
	echo "<script>(function(d){d.className+=' js';try{if(sessionStorage.getItem('ts_seen'))d.className+=' preloaded';else sessionStorage.setItem('ts_seen','1');}catch(e){}})(document.documentElement);</script>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline script.
	wp_head();
	?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'tebasuci' ); ?></a>

<?php if ( is_front_page() ) : ?>
	<div class="site-preloader" id="site-preloader" role="presentation">
		<div class="site-preloader-inner">
			<span class="preloader-mark"><?php echo esc_html( tebasuci_get( 'wordmark_name' ) ? tebasuci_get( 'wordmark_name' ) : get_bloginfo( 'name' ) ); ?></span>
			<span class="preloader-bar"></span>
		</div>
	</div>
<?php endif; ?>

<div class="resort-site" id="home">
	<header class="site-header">
		<div class="header-inner">
			<?php tebasuci_wordmark( 'header' ); ?>

			<nav class="desktop-nav" id="site-navigation" aria-label="<?php esc_attr_e( 'Main navigation', 'tebasuci' ); ?>">
				<?php
				tebasuci_nav_menu( 'primary', 'nav-menu' );
				tebasuci_link( tebasuci_get( 'booking_url' ), tebasuci_get( 'booking_label' ), 'button header-booking' );
				?>
			</nav>

			<button
				class="menu-toggle"
				type="button"
				aria-controls="site-navigation"
				aria-expanded="false"
				aria-label="<?php esc_attr_e( 'Open navigation', 'tebasuci' ); ?>"
				data-label-open="<?php esc_attr_e( 'Open navigation', 'tebasuci' ); ?>"
				data-label-close="<?php esc_attr_e( 'Close navigation', 'tebasuci' ); ?>"
			>
				<?php
				echo tebasuci_icon( 'menu' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG.
				echo tebasuci_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG.
				?>
			</button>
		</div>
	</header>

	<main id="main" class="site-main" tabindex="-1">

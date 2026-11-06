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
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'tebasuci' ); ?></a>

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

<?php
/**
 * Homepage: hero.
 *
 * @package TebaSuci
 */

$tebasuci_title  = (string) tebasuci_get( 'hero_title' );
$tebasuci_scroll = (string) tebasuci_get( 'hero_scroll_label' );
?>
<section class="hero" aria-labelledby="hero-title">
	<?php
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
	echo tebasuci_image(
		'hero_image',
		array(
			'class'    => 'hero-image',
			'sizes'    => '100vw',
			'priority' => true,
		)
	);
	?>
	<div class="hero-shade" aria-hidden="true"></div>

	<div class="hero-copy" data-reveal>
		<?php if ( tebasuci_get( 'hero_eyebrow' ) ) : ?>
			<span class="eyebrow hero-eyebrow"><?php echo tebasuci_text( 'hero_eyebrow' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif; ?>

		<h1 id="hero-title">
			<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
			echo '' !== $tebasuci_title ? tebasuci_lines( 'hero_title' ) : esc_html( wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) );
			?>
		</h1>

		<?php if ( tebasuci_get( 'hero_text' ) ) : ?>
			<p><?php echo tebasuci_lines( 'hero_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
		<?php endif; ?>

		<?php tebasuci_link( tebasuci_get( 'hero_button_url' ), tebasuci_get( 'hero_button_label' ), 'button hero-button' ); ?>
	</div>

	<?php if ( '' !== $tebasuci_scroll ) : ?>
		<a class="hero-scroll" href="<?php echo esc_url( tebasuci_first_section_after_hero() ); ?>" aria-label="<?php echo esc_attr( $tebasuci_scroll ); ?>">
			<span><?php echo esc_html( $tebasuci_scroll ); ?></span>
			<?php echo tebasuci_icon( 'arrow-down' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
		</a>
	<?php endif; ?>

	<?php if ( tebasuci_get( 'hero_location' ) ) : ?>
		<span class="hero-location"><?php echo tebasuci_text( 'hero_location' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	<?php endif; ?>
</section>

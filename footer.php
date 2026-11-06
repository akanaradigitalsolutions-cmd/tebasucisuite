<?php
/**
 * Site footer: brand, links, contact details.
 *
 * @package TebaSuci
 */

$tebasuci_address = (string) tebasuci_get( 'address' );
?>
	</main>

	<footer class="site-footer" id="contact">
		<div class="footer-main">
			<div class="footer-brand">
				<?php tebasuci_wordmark( 'footer' ); ?>
				<?php if ( tebasuci_get( 'footer_tagline' ) ) : ?>
					<p><?php echo tebasuci_lines( 'footer_tagline' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></p>
				<?php endif; ?>
			</div>

			<div class="footer-links">
				<?php if ( tebasuci_get( 'footer_explore_heading' ) ) : ?>
					<span class="eyebrow"><?php echo tebasuci_text( 'footer_explore_heading' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php endif; ?>
				<?php tebasuci_nav_menu( 'footer', 'footer-menu' ); ?>
			</div>

			<div class="footer-links footer-contact">
				<?php if ( tebasuci_get( 'footer_contact_heading' ) ) : ?>
					<span class="eyebrow"><?php echo tebasuci_text( 'footer_contact_heading' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				<?php endif; ?>
				<ul class="footer-menu">
					<?php if ( tebasuci_get( 'booking_url' ) && tebasuci_get( 'booking_label' ) ) : ?>
						<li><?php tebasuci_link( tebasuci_get( 'booking_url' ), tebasuci_get( 'booking_label' ), 'footer-booking' ); ?></li>
					<?php endif; ?>
					<?php foreach ( tebasuci_contact_items() as $tebasuci_item ) : ?>
						<li><?php tebasuci_link( $tebasuci_item[0], $tebasuci_item[1], '', '' ); ?></li>
					<?php endforeach; ?>
					<?php if ( '' !== $tebasuci_address ) : ?>
						<li class="footer-address"><?php echo tebasuci_lines( 'address' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="footer-bottom">
			<span>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) ); ?></span>
			<a href="#home"><?php esc_html_e( 'Back to top', 'tebasuci' ); ?> <span aria-hidden="true">↑</span></a>
		</div>
	</footer>
</div><!-- .resort-site -->

<?php wp_footer(); ?>
</body>
</html>

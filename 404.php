<?php
/**
 * Page not found.
 *
 * @package TebaSuci
 */

get_header();
?>
<section class="page-hero page-hero--404">
	<div class="page-hero-inner">
		<span class="eyebrow"><?php esc_html_e( 'Page not found', 'tebasuci' ); ?></span>
		<h1 class="page-title"><?php esc_html_e( 'This path has wandered off.', 'tebasuci' ); ?></h1>
		<p class="page-intro"><?php esc_html_e( 'The page you’re looking for doesn’t exist or has moved. Let’s take you somewhere calmer.', 'tebasuci' ); ?></p>
		<div class="page-actions">
			<?php
			tebasuci_link( home_url( '/' ), __( 'Back to the homepage', 'tebasuci' ), 'button room-cta' );
			tebasuci_link( tebasuci_get( 'booking_url' ), tebasuci_get( 'booking_label' ), 'button offer-button' );
			?>
		</div>
	</div>
</section>
<?php
get_footer();

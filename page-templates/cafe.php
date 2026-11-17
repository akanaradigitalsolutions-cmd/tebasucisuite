<?php
/**
 * Template Name: D’Gadon Cafe
 * Template Post Type: page
 *
 * @package TebaSuci
 */

get_header();

$tebasuci_cafe    = tebasuci_cafe_data();
$tebasuci_booking = (string) tebasuci_get( 'booking_url' );

tebasuci_render_page_hero(
	array(
		'eyebrow' => __( 'A table with a view', 'tebasuci' ),
		'title'   => get_the_title(),
		'intro'   => $tebasuci_cafe['tagline'],
	)
);
?>

<section class="cafe-page">
	<div class="cafe-page-intro">
		<div class="cafe-page-copy" data-reveal>
			<?php foreach ( $tebasuci_cafe['description'] as $tebasuci_para ) : ?>
				<p><?php echo esc_html( $tebasuci_para ); ?></p>
			<?php endforeach; ?>
			<div class="cafe-page-actions">
				<?php tebasuci_link( $tebasuci_booking, __( 'Reserve a table', 'tebasuci' ), 'button room-cta' ); ?>
			</div>
		</div>

		<?php
		$tebasuci_lead = tebasuci_bundled_image( $tebasuci_cafe['gallery'][0] );
		if ( $tebasuci_lead ) :
			?>
			<figure class="cafe-page-lead" data-reveal>
				<img src="<?php echo esc_url( $tebasuci_lead['src'] ); ?>" srcset="<?php echo esc_attr( $tebasuci_lead['srcset'] ); ?>" sizes="(max-width: 900px) calc(100vw - 2.5rem), 540px" width="<?php echo (int) $tebasuci_lead['width']; ?>" height="<?php echo (int) $tebasuci_lead['height']; ?>" alt="<?php esc_attr_e( 'D’Gadon Cafe at Teba Suci Suite', 'tebasuci' ); ?>" loading="lazy" decoding="async">
			</figure>
		<?php endif; ?>
	</div>

	<div class="cafe-page-gallery">
		<?php
		foreach ( array_slice( $tebasuci_cafe['gallery'], 1 ) as $tebasuci_key ) :
			$tebasuci_img = tebasuci_bundled_image( $tebasuci_key );
			if ( ! $tebasuci_img ) {
				continue;
			}
			?>
			<figure data-reveal>
				<img src="<?php echo esc_url( $tebasuci_img['src'] ); ?>" srcset="<?php echo esc_attr( $tebasuci_img['srcset'] ); ?>" sizes="(max-width: 760px) calc(100vw - 2.5rem), 580px" width="<?php echo (int) $tebasuci_img['width']; ?>" height="<?php echo (int) $tebasuci_img['height']; ?>" alt="" loading="lazy" decoding="async">
			</figure>
		<?php endforeach; ?>
	</div>

	<?php
	while ( have_posts() ) :
		the_post();
		if ( '' !== trim( get_the_content() ) ) :
			?>
			<div class="entry-content"><?php the_content(); ?></div>
			<?php
		endif;
	endwhile;
	?>
</section>

<?php
get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
get_footer();

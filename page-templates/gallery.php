<?php
/**
 * Template Name: Gallery
 * Template Post Type: page
 *
 * A full-page photo gallery. Uses the theme’s gallery photos; if the page has
 * a WordPress gallery block in its content, that is shown underneath.
 *
 * @package TebaSuci
 */

get_header();

tebasuci_render_page_hero(
	array(
		'eyebrow' => __( 'A sense of place', 'tebasuci' ),
		'title'   => get_the_title(),
		'intro'   => __( 'The pool and the rice fields, the suites, the cafe and the quiet corners — a closer look at a stay at Teba Suci Suite.', 'tebasuci' ),
	)
);
?>

<section class="gallery-page">
	<div class="gallery-page-grid">
		<?php
		for ( $tebasuci_i = 1; $tebasuci_i <= 12; $tebasuci_i++ ) :
			$tebasuci_img = tebasuci_bundled_image( sprintf( 'gallery-%02d', $tebasuci_i ) );
			if ( ! $tebasuci_img ) {
				continue;
			}
			// Occasionally span two columns for rhythm.
			$tebasuci_wide = in_array( $tebasuci_i, array( 1, 6, 10 ), true );
			?>
			<figure class="gallery-page-item<?php echo $tebasuci_wide ? ' gallery-page-item--wide' : ''; ?>" data-reveal>
				<?php
				printf(
					'<img src="%1$s" srcset="%2$s" sizes="%3$s" width="%4$d" height="%5$d" alt="" loading="lazy" decoding="async">',
					esc_url( $tebasuci_img['src'] ),
					esc_attr( $tebasuci_img['srcset'] ),
					esc_attr( $tebasuci_wide ? '(max-width: 760px) calc(100vw - 2.5rem), 740px' : '(max-width: 760px) calc(100vw - 2.5rem), 380px' ),
					(int) $tebasuci_img['width'],
					(int) $tebasuci_img['height']
				);
				?>
			</figure>
		<?php endfor; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
get_footer();

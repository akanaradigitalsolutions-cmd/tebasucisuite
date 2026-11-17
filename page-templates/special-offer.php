<?php
/**
 * Template Name: Special Offer
 * Template Post Type: page
 *
 * @package TebaSuci
 */

get_header();

$tebasuci_offers = tebasuci_offers_data();

tebasuci_render_page_hero(
	array(
		'eyebrow' => __( 'A little more Bali', 'tebasuci' ),
		'title'   => get_the_title(),
		'intro'   => __( 'Indulge in luxury like never before with our special offers at Teba Suci Suite — tailored packages and experiences to make your stay unforgettable.', 'tebasuci' ),
	)
);
?>

<section class="offers-page">
	<?php
	foreach ( $tebasuci_offers as $tebasuci_offer ) :
		$tebasuci_img = tebasuci_bundled_image( $tebasuci_offer['photo'] );
		?>
		<article class="offer-card" data-reveal>
			<?php if ( $tebasuci_img ) : ?>
				<figure class="offer-card-media">
					<img src="<?php echo esc_url( $tebasuci_img['src'] ); ?>" srcset="<?php echo esc_attr( $tebasuci_img['srcset'] ); ?>" sizes="(max-width: 900px) calc(100vw - 2.5rem), 520px" width="<?php echo (int) $tebasuci_img['width']; ?>" height="<?php echo (int) $tebasuci_img['height']; ?>" alt="" loading="lazy" decoding="async">
				</figure>
			<?php endif; ?>
			<div class="offer-card-body">
				<h2 class="offer-card-title"><?php echo esc_html( $tebasuci_offer['title'] ); ?></h2>
				<p><?php echo esc_html( $tebasuci_offer['text'] ); ?></p>
				<?php tebasuci_link( $tebasuci_offer['url'], $tebasuci_offer['label'], 'text-link' ); ?>
			</div>
		</article>
	<?php endforeach; ?>

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

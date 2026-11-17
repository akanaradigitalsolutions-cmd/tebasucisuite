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
				<?php if ( tebasuci_has_cafe_menu() ) : ?>
					<a class="button offer-button" href="#menu">
						<span><?php esc_html_e( 'View the menu', 'tebasuci' ); ?></span>
						<?php echo tebasuci_icon( 'arrow-down' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
					</a>
				<?php endif; ?>
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
// Prefer the D’Gadon Cafe flipbook (3D FlipBook / dFlip) when the plugin is
// active; otherwise fall back to the rendered menu pages bundled with the theme.
$tebasuci_menu_sc  = (string) tebasuci_get( 'cafe_menu_shortcode' );
$tebasuci_menu_tag = ( '' !== $tebasuci_menu_sc && preg_match( '/\[([a-z0-9_-]+)/i', $tebasuci_menu_sc, $tebasuci_m ) ) ? $tebasuci_m[1] : '';
$tebasuci_flipbook = ( '' !== $tebasuci_menu_tag && shortcode_exists( $tebasuci_menu_tag ) );
$tebasuci_has_imgs = tebasuci_has_cafe_menu();
?>
<?php if ( $tebasuci_flipbook || $tebasuci_has_imgs ) : ?>
	<section class="cafe-menu" id="menu">
		<div class="cafe-menu-head" data-reveal>
			<div>
				<span class="eyebrow"><?php esc_html_e( 'The menu', 'tebasuci' ); ?></span>
				<h2><?php esc_html_e( 'What’s cooking', 'tebasuci' ); ?></h2>
			</div>
			<?php if ( $tebasuci_has_imgs ) : ?>
				<?php tebasuci_link( $tebasuci_cafe['menu']['pdf'], __( 'Download the full menu (PDF)', 'tebasuci' ), 'text-link', 'arrow-down' ); ?>
			<?php endif; ?>
		</div>

		<?php if ( $tebasuci_flipbook ) : ?>
			<div class="cafe-flipbook" data-reveal>
				<?php echo do_shortcode( $tebasuci_menu_sc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- plugin shortcode output. ?>
			</div>
		<?php else : ?>
			<div class="cafe-menu-grid">
				<?php
				$tebasuci_labels = $tebasuci_cafe['menu']['labels'];
				for ( $tebasuci_p = 1; $tebasuci_p <= count( $tebasuci_labels ); $tebasuci_p++ ) :
					$tebasuci_full  = TEBASUCI_URI . '/assets/images/cafe-menu-' . $tebasuci_p . '.jpg';
					$tebasuci_thumb = TEBASUCI_URI . '/assets/images/cafe-menu-' . $tebasuci_p . '-620.jpg';
					$tebasuci_label = $tebasuci_labels[ $tebasuci_p - 1 ];
					?>
					<figure class="cafe-menu-page" data-reveal>
						<a href="<?php echo esc_url( $tebasuci_full ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: menu section name. */ __( 'Open the %s menu full size', 'tebasuci' ), $tebasuci_label ) ); ?>">
							<img src="<?php echo esc_url( $tebasuci_thumb ); ?>" srcset="<?php echo esc_url( $tebasuci_thumb ); ?> 620w, <?php echo esc_url( $tebasuci_full ); ?> 1240w" sizes="(max-width: 760px) calc(100vw - 2.5rem), 360px" width="1240" height="1754" alt="<?php echo esc_attr( sprintf( /* translators: %s: menu section name. */ __( 'D’Gadon Cafe menu — %s', 'tebasuci' ), $tebasuci_label ) ); ?>" loading="lazy" decoding="async">
						</a>
						<figcaption><?php echo esc_html( $tebasuci_label ); ?></figcaption>
					</figure>
				<?php endfor; ?>
			</div>
		<?php endif; ?>

		<p class="cafe-menu-note"><?php esc_html_e( 'Prices do not include 15% tax and 10% service.', 'tebasuci' ); ?></p>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/offer', null, array( 'context' => 'inner' ) );
get_footer();

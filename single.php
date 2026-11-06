<?php
/**
 * Single blog post (and other single entries).
 *
 * @package TebaSuci
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
		<header class="page-hero">
			<div class="page-hero-inner" data-reveal>
				<span class="eyebrow"><?php echo tebasuci_post_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></span>
				<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				<?php if ( has_excerpt() ) : ?>
					<p class="page-intro"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="page-featured">
				<?php
				the_post_thumbnail(
					'full',
					array(
						'sizes'         => '(max-width: 1280px) calc(100vw - 3.5rem), 1220px',
						'loading'       => false,
						'fetchpriority' => 'high',
					)
				);
				?>
			</figure>
		<?php endif; ?>

		<div class="entry-content">
			<?php
			the_content();
			wp_link_pages(
				array(
					'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'tebasuci' ) . '">',
					'after'  => '</nav>',
				)
			);
			?>
		</div>

		<?php
		$tebasuci_tags = get_the_tag_list( '', ', ' );
		if ( $tebasuci_tags && ! is_wp_error( $tebasuci_tags ) ) :
			?>
			<p class="entry-tags"><span class="eyebrow"><?php esc_html_e( 'Tagged', 'tebasuci' ); ?></span> <?php echo wp_kses_post( $tebasuci_tags ); ?></p>
		<?php endif; ?>

		<?php
		the_post_navigation(
			array(
				'prev_text' => '<span class="eyebrow">' . esc_html__( 'Previous', 'tebasuci' ) . '</span><span class="post-nav-title">%title</span>',
				'next_text' => '<span class="eyebrow">' . esc_html__( 'Next', 'tebasuci' ) . '</span><span class="post-nav-title">%title</span>',
			)
		);

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	</article>
	<?php
endwhile;

tebasuci_inner_cta();

get_footer();

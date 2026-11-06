<?php
/**
 * Single page (any page other than the homepage).
 *
 * @package TebaSuci
 */

get_header();

while ( have_posts() ) :
	the_post();
	$tebasuci_parent = wp_get_post_parent_id( get_the_ID() );
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
		<header class="page-hero">
			<div class="page-hero-inner" data-reveal>
				<span class="eyebrow">
					<?php
					echo esc_html(
						$tebasuci_parent
							? wp_specialchars_decode( get_the_title( $tebasuci_parent ), ENT_QUOTES )
							: wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES )
					);
					?>
				</span>
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

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	</article>
	<?php
endwhile;

tebasuci_inner_cta();

get_footer();

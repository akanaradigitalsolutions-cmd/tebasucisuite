<?php
/**
 * Blog, archives and search results.
 *
 * @package TebaSuci
 */

get_header();

$tebasuci_eyebrow = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
$tebasuci_title   = __( 'Journal', 'tebasuci' );

if ( is_home() && ! is_front_page() ) {
	$tebasuci_title = single_post_title( '', false );
} elseif ( is_search() ) {
	$tebasuci_eyebrow = __( 'Search results', 'tebasuci' );
	/* translators: %s: search query. */
	$tebasuci_title = sprintf( __( '“%s”', 'tebasuci' ), get_search_query( false ) );
} elseif ( is_category() ) {
	$tebasuci_eyebrow = __( 'Category', 'tebasuci' );
	$tebasuci_title   = single_cat_title( '', false );
} elseif ( is_tag() ) {
	$tebasuci_eyebrow = __( 'Tag', 'tebasuci' );
	$tebasuci_title   = single_tag_title( '', false );
} elseif ( is_archive() ) {
	$tebasuci_eyebrow = __( 'Archive', 'tebasuci' );
	$tebasuci_title   = wp_strip_all_tags( get_the_archive_title() );
}
?>
<header class="page-hero">
	<div class="page-hero-inner" data-reveal>
		<span class="eyebrow"><?php echo esc_html( $tebasuci_eyebrow ); ?></span>
		<h1 class="page-title"><?php echo esc_html( $tebasuci_title ); ?></h1>
		<?php the_archive_description( '<div class="page-intro">', '</div>' ); ?>
	</div>
</header>

<div class="post-list">
	<?php if ( have_posts() ) : ?>
		<div class="post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?> data-reveal>
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="post-card-image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
							<?php the_post_thumbnail( 'large', array( 'sizes' => '(max-width: 760px) calc(100vw - 2.5rem), 400px' ) ); ?>
						</a>
					<?php endif; ?>
					<div class="post-card-body">
						<?php if ( 'post' === get_post_type() ) : ?>
							<span class="eyebrow"><?php echo tebasuci_post_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?></span>
						<?php endif; ?>
						<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
						<a class="text-link" href="<?php the_permalink(); ?>">
							<?php esc_html_e( 'Read more', 'tebasuci' ); ?>
							<span class="screen-reader-text"><?php the_title(); ?></span>
							<?php echo tebasuci_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						</a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<?php
		the_posts_pagination(
			array(
				'mid_size'  => 1,
				'prev_text' => '<span aria-hidden="true">←</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'tebasuci' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'tebasuci' ) . '</span><span aria-hidden="true">→</span>',
			)
		);
		?>
	<?php else : ?>
		<div class="empty-state">
			<p>
				<?php
				echo is_search()
					? esc_html__( 'Nothing matched your search. Try different words.', 'tebasuci' )
					: esc_html__( 'Nothing has been published here yet.', 'tebasuci' );
				?>
			</p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div>

<?php
tebasuci_inner_cta();

get_footer();

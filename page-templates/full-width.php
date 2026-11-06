<?php
/**
 * Template Name: Full width (no title)
 * Template Post Type: page
 *
 * For pages laid out entirely with blocks: no title band, no booking
 * banner, and content may run edge to edge (use “Full width” alignment).
 *
 * @package TebaSuci
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry entry--full' ); ?>>
		<?php the_title( '<h1 class="screen-reader-text">', '</h1>' ); ?>
		<div class="entry-content entry-content--full">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();

<?php
/**
 * Homepage.
 *
 * Every section's text, links and photos are edited under
 * Appearance → Customize → Teba Suci Suite. Sections can be switched off there.
 *
 * @package TebaSuci
 */

get_header();

get_template_part( 'template-parts/front/hero' );
get_template_part( 'template-parts/front/welcome' );
get_template_part( 'template-parts/front/facts' );
get_template_part( 'template-parts/front/accommodation' );
get_template_part( 'template-parts/front/experience' );
get_template_part( 'template-parts/front/cafe' );
get_template_part( 'template-parts/offer', null, array( 'context' => 'front' ) );
get_template_part( 'template-parts/front/gallery' );
get_template_part( 'template-parts/front/location' );

get_footer();

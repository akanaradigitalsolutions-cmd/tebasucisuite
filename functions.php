<?php
/**
 * Teba Suci Suite theme bootstrap.
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TEBASUCI_VERSION', '1.0.0' );
define( 'TEBASUCI_DIR', get_template_directory() );
define( 'TEBASUCI_URI', get_template_directory_uri() );

require TEBASUCI_DIR . '/inc/content.php';
require TEBASUCI_DIR . '/inc/setup.php';
require TEBASUCI_DIR . '/inc/template-tags.php';
require TEBASUCI_DIR . '/inc/pages.php';
require TEBASUCI_DIR . '/inc/contact-form.php';
require TEBASUCI_DIR . '/inc/customizer.php';
require TEBASUCI_DIR . '/inc/seo.php';

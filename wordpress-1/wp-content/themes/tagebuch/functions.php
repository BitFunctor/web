<?php
/**
 * Load HTMLkombinat Ressources
 *
 * @package HTML_Kombinat
 * @subpackage Tagebuch
 * @since Tagebuch 1.0
 * @author Alexander Geilhaupt <alex@htmlkombinat.com> http://www.htmlkombinat.com
 */

if ( !defined( 'ABSPATH' ) ) {
	header("HTTP/1.0 404 Not Found");
	exit();
}
	
require_once(get_template_directory()."/core/constants/constants.php");
require_once(get_template_directory()."/core/classes/htmlkombinat-class.php");
require_once(get_template_directory()."/core/classes/highres-class.php");
require_once(get_template_directory()."/core/classes/administration-class.php");
require_once(get_template_directory()."/core/classes/adminpage-class.php");
require_once(get_template_directory()."/core/classes/widget-class.php");

// Content width
if ( ! isset( $content_width ) ) 
    $content_width = 600;

// Initialize the core
$HTMLkombinat = new htmlkombinat();

// Initialize High resolution image support
$HK_High_Resolution_Images = new HK_High_Resolution_Images();

// For the Backend
if( is_admin() ){
	$hkAdmin = new hkAdmin();
}
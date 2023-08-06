<?php
/**
 * Theme Searchform
 *
 * Searchform
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

?>
<form method="get" class="searchform" role="search" action="<?php echo home_url( '/' ); ?>">
	<label class="search-form-label"><?php _e('Search','htmlkombinat') ?></label>
	<input autocomplete=off type="search" name="s" value="<?php _e('Search + Enter','htmlkombinat') ?>" onFocus="this.value='';" onBlur="if(this.value==''){this.value='<?php _e('Search + Enter','htmlkombinat') ?>';}">
	<input type="submit" class="search-button" value="<?php _e('Search','htmlkombinat') ?>">
</form>
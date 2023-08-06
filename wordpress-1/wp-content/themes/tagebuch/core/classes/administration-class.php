<?php
/**
 * Class hkAdmin
 *
 * Extends HTML Kombinat's Core
 *
 * @package HTML_Kombinat
 * @subpackage HTML_Kombinat_Core
 * @since HTML Kombinat Core 2.0
 * @author Alexander Geilhaupt <alex@htmlkombinat.com> http://www.htmlkombinat.com
 */
class hkAdmin extends htmlkombinat {
	
	public $hkAdminPage;
	/**
	 * Constructor
	 *
	 * Load all the main things, we use for the admin panel
	 *
	 * @return void
	 **/
	function __construct() {
		$this->hkAdminPage = new hkAdminPage();
		add_action( 'admin_head' , array( &$this, 'HTML_Kombinat_head' ) );
		add_action( 'admin_init', array( &$this, 'HTML_Kombinat_setup' ) );
	}
	
	/**
	 * Add some CSS to admin header
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_head() {
		echo '<style type="text/css">#headimg{background-repeat:no-repeat; background-position:center center;} .current-logo{background-color:#FFFFFF; width:255px;} .author-img{float:left; margin:0 5px 0 0;} .hk-configuration-select{width:25em;} .no-wrap{white-space:nowrap}</style>';	
	}
	
	/**
	 * Load theme's admin page
	 *
	 * @return void
	 **/
	function HTML_Kombinat_setup() {
		register_setting( 'htmlkombinat_configuration', 'htmlkombinat_mainconfig', array( &$this, 'HTML_Kombinat_save_options' ) );
		}
		
	function HTML_Kombinat_save_options() {
		parent::HTML_Kombinat_get_options();

		if(	isset( $_POST['reset-general-layout'] ) 
			|| isset( $_POST['reset-homepage'] ) 
			|| isset( $_POST['reset-social-icons'] ) 
			|| isset( $_POST['reset-webmaster-tools'] ) 
			|| isset( $_POST['reset-custom-css'] ) 
			|| isset( $_POST['reset-custom-scripts'] ) 
			|| isset( $_POST['submit-restore-defaults'] ) ) {
				
			parent::HTML_Kombinat_get_default_options();
			
			if( isset( $_POST['submit-restore-defaults'] ) ) {
				return $this->default_options;
			}
			
			foreach($this->default_options as $key => $value ) {
				if( isset( $_POST[ $key ] ) ) {
					if( is_array( $value ) ) {
						foreach( $value as $subkey => $subvalue) {
							if( isset( $_POST[ $key ][ $subkey ] )) {
								$this->options[ $key ][ $subkey ] = $subvalue;
							}
						}
					} else {
						$this->options[ $key ] = $value;
					}
				}
			}

		} else {
		
			if( isset( $_POST['submit-homepage'] )) {
				if( !isset( $_POST['show_homepage_headline'] )) {
					$_POST['show_homepage_headline'] = 0;
				}
			}

			foreach($this->options as $key => $value ) {
				if( is_array( $value ) ) {
					foreach( $value as $subkey => $subvalue) {
						if( isset( $_POST[ $key ][ $subkey ] )) {
							if( $key == "social_icons" ) {
								$this->options[ $key ][ $subkey ] = esc_url_raw( $_POST[ $key ][ $subkey ] );
							} else {
								$this->options[ $key ][ $subkey ] = wp_filter_post_kses( $_POST[ $key ][ $subkey ] );
							}
						}
					}
				} else {
					if( isset( $_POST[ $key ] )) {
						if( $key == 'tracking_code' || $key == 'custom_css' || $key == 'custom_scripts_header' || $key == 'custom_scripts_footer' ) {
							$this->options[ $key ] = wp_kses_stripslashes( $_POST[ $key ] );
						} elseif( $key == "home_page_link" ) {
							$this->options[ $key ] = esc_url_raw( $_POST[ $key ] );
						} else {
							$this->options[ $key ] = wp_filter_post_kses( $_POST[ $key ] );
						}
					}
				}
			}
		}
	return $this->options;
	}
	
	/**
	 * Puts a message to some pages
	 *
	 * @return void
	 **/
	function HTML_Kombinat_show_retina_message() {
		$current_screen = get_current_screen();
		if ( $current_screen->base == 'appearance_page_custom-header' ) : ?>
		<div class="updated">
			<p><strong><?php printf( __( 'The %s Theme supports high resolution displays!', 'htmlkombinat' ), HTMLKOMBINAT_THEMENAME ); ?></strong></p>
		 	<p><?php _e( 'The displayed resolution of the header image on your website is half of the resolution of the image you need to upload.', 'htmlkombinat' ) ?></p>
		</div>
		<?php
		endif;
	}
}
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
class hkAdminpage extends htmlkombinat {

	public $page;
	public $metaboxes_view;

	/**
	 * Constructor
	 *
	 * Load the admin page and everything we need
	 *
	 * @return void
	 **/
	function __construct() {
		// Get current User
		parent::HTML_kombinat_get_current_user();
		add_action( 'admin_menu', array( &$this, 'admin_page' ) );
		$this->metaboxes_view = "open";
		parent::HTML_Kombinat_get_options();
	}

	/**
	 * Overrides the open postboxes on theme option page
	 *
	 * @return void
	 **/
	function view_metaboxes() {
		$metaboxes = array(
			'edit-general-layout',
			'edit-custom-logo',
			'edit-webmaster-tools',
			'edit-social-network-urls',
			'edit-custom-css',
			'edit-custom-scripts'
		);
		delete_user_option($this->user['ID'], 'closedpostboxes_'.$this->page);
		if($this->metaboxes_view == "close") {
			update_user_option($this->user['ID'], 'closedpostboxes_'.$this->page, $metaboxes);
		}
	}
	
	/**
	 * Loads the admin page
	 *
	 * @return void
	 **/
	function admin_page() {
		// Add a sub menu page with the same vars
		$this->page = add_theme_page( HTMLKOMBINAT_THEMENAME . ' ' . __('Configuration','htmlkombinat'), __('Theme Options','htmlkombinat'), 'manage_options', 'htmlkombinat_configuration', array( &$this, 'load_admin_page' ) );
		add_action('load-'.$this->page,  array($this,'load_page_actions'),9);
		add_action('admin_footer-'.$this->page,array($this,'load_footer_scripts'));
		add_action('add_meta_boxes', array( &$this, 'load_metaboxes') );
	}
	
	
	/**
	 * Includes the admin page
	 *
	 * @return void
	 **/
	function load_admin_page() {
		if (!isset($_REQUEST['settings-updated'])) {
			$_REQUEST['settings-updated'] = false;
			$this->metaboxes_view = "close";
		}
		self::view_metaboxes();
		get_template_part( 'core/administration/administration','' );
	}
	
	
	/**
	 * Includes the page actions
	 *
	 * @return void
	 **/
	function load_page_actions() {
		do_action('add_meta_boxes_'.$this->page, null);
		do_action('add_meta_boxes', $this->page, null);
 
		/* Add screen options with two default colums */
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );
 
		/* Enqueue WordPress' script for handling the metaboxes */
		wp_enqueue_script('postbox'); 
	}
	
	
	/**
	 * Includes the metabox script to the footer
	 *
	 * @return void
	 **/
	function load_footer_scripts() {
		?>
		<script> postboxes.add_postbox_toggles(pagenow);</script>
		<?php
	}	
	
	/**
	 * Includes the metaboxes to the page
	 *
	 * @return void
	 **/
	function load_metaboxes(){
		// Main Boxes
		add_meta_box('edit-general-layout', __( 'General Layout Settings', 'htmlkombinat' ), array( &$this, 'load_metabox_general_layout'),$this->page,'normal','low');
		add_meta_box('edit-social-network-urls', __( 'Social Icons', 'htmlkombinat' ), array( &$this, 'load_metabox_social_networks_urls'),$this->page,'normal','low');
		add_meta_box('edit-webmaster-tools', __( 'Webmaster Tools', 'htmlkombinat' ), array( &$this, 'load_metabox_webmaster_tools'),$this->page,'normal','low');
		add_meta_box('edit-custom-css', __( 'Custom CSS', 'htmlkombinat' ), array( &$this, 'load_metabox_custom_css'),$this->page,'normal','low');
		add_meta_box('edit-custom-scripts', __( 'Custom Scripts', 'htmlkombinat' ), array( &$this, 'load_metabox_custom_scripts'),$this->page,'normal','low');
		// Additional Boxes
		add_meta_box('logo-info',__( 'Your Logo', 'htmlkombinat' ), array( &$this, 'load_metabox_logo'),$this->page,'side','high');
		add_meta_box('restore-all-defaults',__( 'Restore all Defaults', 'htmlkombinat' ), array( &$this, 'load_metabox_restore_all_defaults'),$this->page,'side','low');
		add_meta_box('theme-support',__( 'About the Author', 'htmlkombinat' ), array( &$this, 'load_metabox_theme_support'),$this->page,'side','low');
	}
	
	
	/**
	 * Content of metabox edit-general-layout
	 *
	 * @return void
	 **/
	function load_metabox_general_layout() {
		/** 
		 * Set items for select boxes
		**/
		// Sidebar and content appearance
		$sidebars = array(
			array(
				'value' => 'left',
				'text' => __( 'Show Content left / Sidebar right', 'htmlkombinat' )
			),
			array(
				'value' => 'right',
				'text' => __( 'Show Content right / Sidebar left', 'htmlkombinat' )
			),
			array(
				'value' => 'full-width',
				'text' => __( 'Show full width', 'htmlkombinat' )
			)
		);
		// View excerpt or full post on main blog page
		$post_views = array(
			array(
				'value' => 'excerpt',
				'text' => __( 'Show Excerpt', 'htmlkombinat' )
			),
			array(
				'value' => 'fullpost',
				'text' => __( 'Show Full Posts', 'htmlkombinat' )
			)
		);
		?>
		<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields( 'htmlkombinat_configuration' ); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="sidebar_page" class="description"><?php _e( 'Page Appearance', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<select name="sidebar_page" id="sidebar_page" class="hk-configuration-select">
							<?php foreach ( $sidebars as $sidebar) :  ?>
							<option value="<?php echo $sidebar['value'] ?>"<?php  echo ( $this->options['sidebar_page'] == $sidebar['value'] ) ? ' selected="selected" ' : ''; ?>><?php echo $sidebar['text'] ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="sidebar_blog" class="description"><?php _e( 'Blog Appearance', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<select name="sidebar_blog" id="sidebar_blog" class="hk-configuration-select">
							<?php foreach ( $sidebars as $sidebar) :  ?>
							<option value="<?php echo $sidebar['value'] ?>"<?php  echo ( $this->options['sidebar_blog'] == $sidebar['value'] ) ? ' selected="selected" ' : ''; ?>><?php echo $sidebar['text'] ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="sidebar_article" class="description"><?php _e( 'Article Appearance', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<select name="sidebar_article" id="sidebar_article" class="hk-configuration-select">
							<?php foreach ( $sidebars as $sidebar) :  ?>
							<option value="<?php echo $sidebar['value'] ?>"<?php  echo ( $this->options['sidebar_article'] == $sidebar['value'] ) ? ' selected="selected" ' : ''; ?>><?php echo $sidebar['text'] ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="post_format_blogpage" class="description"><?php _e( 'Post Format on Blog Pages', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<select name="post_format_blogpage" id="post_format_blogpage" class="hk-configuration-select">
							<?php foreach ( $post_views as $post_view) :  ?>
							<option value="<?php echo $post_view['value'] ?>"<?php  echo ( $this->options['post_format_blogpage'] == $post_view['value'] ) ? ' selected="selected" ' : ''; ?>><?php echo $post_view['text'] ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">&nbsp;</th>
					<td>
						<?php submit_button( __( 'Save Changes', 'htmlkombinat' ), 'primary', 'submit-general-layout', false); ?>
						&nbsp;&nbsp;
						<?php submit_button( __( 'Restore Defaults', 'htmlkombinat' ), 'secondary', 'reset-general-layout', false ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		</form><?php
	}
	
	
	/**
	 * Content of metabox edit-social-network-urls
	 *
	 * @return void
	 **/
	function load_metabox_social_networks_urls(){
		?>
		<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields( 'htmlkombinat_configuration' ); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="facebook_url" class="description"><?php _e( 'You on Facebook', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="facebook_url" name="social_icons[facebook_url]" class="regular-text code url" value="<?php echo esc_url( $this->options['social_icons']['facebook_url'] ); ?>" /><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="twitter_url" class="description"><?php _e( 'You on Twitter', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="twitter_url" name="social_icons[twitter_url]" class="regular-text code url" value="<?php echo esc_url( $this->options['social_icons']['twitter_url'] ); ?>" /><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="gplus_url" class="description"><?php _e( 'You on Google+', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="gplus_url" name="social_icons[gplus_url]" class="regular-text code url" value="<?php echo esc_url( $this->options['social_icons']['gplus_url'] ); ?>" /><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="flickr_url" class="description"><?php _e( 'You on flickr', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="flickr_url" name="social_icons[flickr_url]" class="regular-text code url" value="<?php echo esc_url( $this->options['social_icons']['flickr_url'] ); ?>" /><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="xing_url" class="description"><?php _e( 'You on XING', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="xing_url" name="social_icons[xing_url]" class="regular-text code url" value="<?php echo esc_url( $this->options['social_icons']['xing_url'] ); ?>" /><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="linkedin_url" class="description"><?php _e( 'You on LinkedIn', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="linkedin_url" name="social_icons[linkedin_url]" class="regular-text code url" value="<?php echo esc_url( $this->options['social_icons']['linkedin_url'] ); ?>" /><br />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">&nbsp;</th>
					<td>
						<?php submit_button( __( 'Save Changes', 'htmlkombinat' ), 'primary', 'submit-social-icons', false); ?>
						&nbsp;&nbsp;
						<?php submit_button( __( 'Restore Defaults', 'htmlkombinat' ), 'secondary', 'reset-social-icons', false ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		</form><?php
	}
	
	/**
	 * Content of metabox edit-webmaster-tools
	 *
	 * @return void
	 **/
	function load_metabox_webmaster_tools(){
		?>
		<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields( 'htmlkombinat_configuration' ); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="google_site_verification" class="description"><?php _e( 'Google Site Verification', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="google_site_verification" name="google_site_verification" class="regular-text code url" value="<?php echo esc_attr( $this->options['google_site_verification'] ); ?>" /><br />
						<span class="description"><?php _e( 'Enter your Google ID number only.', 'htmlkombinat' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="bing_site_verification" class="description"><?php _e( 'Bing Site Verification', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="bing_site_verification" name="bing_site_verification" class="regular-text code url" value="<?php echo esc_attr( $this->options['bing_site_verification'] ); ?>" /><br />
						<span class="description"><?php _e( 'Enter your Bing ID number only.', 'htmlkombinat' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="yahoo_site_verification" class="description"><?php _e( 'Yahoo Site Verification', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<input type="text" id="yahoo_site_verification" name="yahoo_site_verification" class="regular-text code url" value="<?php echo esc_attr( $this->options['yahoo_site_verification'] ); ?>" /><br />
						<span class="description"><?php _e( 'Enter your Yahoo ID number only.', 'htmlkombinat' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="tracking_code" class="description"><?php _e( 'Site tracking code', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<textarea id="tracking_code" rows="10" name="tracking_code" class="widefat"><?php echo stripslashes( esc_textarea( $this->options['tracking_code'] ) ); ?></textarea><br />
						<span class="description"><?php _e( 'For example Google Analytics code including <code>&lt;script&gt;</code> tag.', 'htmlkombinat' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">&nbsp;</th>
					<td>
						<?php submit_button( __( 'Save Changes', 'htmlkombinat' ), 'primary', 'submit-webmaster-tools', false); ?>
						&nbsp;&nbsp;
						<?php submit_button( __( 'Restore Defaults', 'htmlkombinat' ), 'secondary', 'reset-webmaster-tools', false ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		</form><?php
	}
	
	/**
	 * Content of metabox edit-custom-css
	 *
	 * @return void
	 **/
	function load_metabox_custom_css(){
		?>
		<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields( 'htmlkombinat_configuration' ); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="custom_css" class="description"><?php _e( 'Custom CSS', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<textarea id="custom_css" rows="25" name="custom_css" class="widefat code"><?php echo stripslashes( esc_textarea( $this->options['custom_css'] ) ); ?></textarea>
						<br /><span class="description"><?php _e( 'Your Custom CSS appear in the <code>&lt;head&gt;</code> tag.<br />Do not include the <code>&lt;style&gt;</code> tag.', 'htmlkombinat' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">&nbsp;</th>
					<td>
						<?php submit_button( __( 'Save Changes', 'htmlkombinat' ), 'primary', 'submit-custom-css', false); ?>
						&nbsp;&nbsp;
						<?php submit_button( __( 'Restore Defaults', 'htmlkombinat' ), 'secondary', 'reset-custom-css', false ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		</form><?php
	}
	
	/**
	 * Content of metabox edit-custom-scripts
	 *
	 * @return void
	 **/

	function load_metabox_custom_scripts(){
		?>
		<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields( 'htmlkombinat_configuration' ); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="custom_scripts_header" class="description"><?php _e( 'Custom Scripts header', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<textarea id="custom_scripts_header" rows="25" name="custom_scripts_header" class="widefat code"><?php echo stripslashes( esc_textarea( $this->options['custom_scripts_header'] ) ); ?></textarea>
						<br /><span class="description"><?php _e( 'This appears in the <code>&lt;head&gt;</code> tag.<br />Do not include the <code>&lt;script&gt;</code> tag.', 'htmlkombinat' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="custom_scripts_footer" class="description"><?php _e( 'Custom Scripts footer', 'htmlkombinat' ); ?>:</label>
					</th>
					<td>
						<textarea id="custom_scripts_footer" rows="25" name="custom_scripts_footer" class="widefat code"><?php echo stripslashes( esc_textarea( $this->options['custom_scripts_footer'] ) ); ?></textarea>
						<br /><span class="description"><?php _e( 'This appears before closing the <code>&lt;body&gt;</code> tag.<br />Do not include the <code>&lt;script&gt;</code> tag.', 'htmlkombinat' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">&nbsp;</th>
					<td>
						<?php submit_button( __( 'Save Changes', 'htmlkombinat' ), 'primary', 'submit-custom-scripts', false); ?>
						&nbsp;&nbsp;
						<?php submit_button( __( 'Restore Defaults', 'htmlkombinat' ), 'secondary', 'reset-custom-scripts', false ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		</form><?php
	}
	
	/**
	 * Content of metabox logo-info
	 *
	 * @return void
	 **/
	function load_metabox_logo(){
		if( get_header_image() != '' ) : ?>
			<p><img class="current-logo" src="<?php header_image(); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a></p>
			<p><?php _e( 'You can change your logo at', 'htmlkombinat' ); ?> <a href="<?php echo admin_url('themes.php?page=custom-header') ?>"><?php _e( 'Appearance', 'default' ); ?> &raquo; <?php _e( 'Header', 'default' ); ?></a></p>
		<?php else : ?>
			<p><?php _e( 'You don\'t have a logo yet. If you want to upload one, go to', 'htmlkombinat' ); ?> <a href="<?php echo admin_url('themes.php?page=custom-header') ?>"><?php _e( 'Appearance', 'default' ); ?> &raquo; <?php _e( 'Header','default' ); ?></a></p>
		<?php endif;
	}
	
	/**
	 * Content of metabox restore-all-defaults
	 *
	 * @return void
	 **/
	function load_metabox_restore_all_defaults(){
		?>
		<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields( 'htmlkombinat_configuration' ); ?>
		<p><strong><?php _e( 'This button could destroy your website!', 'htmlkombinat' ); ?></strong></p>
		<p><?php _e( 'If you click the &quot;Restore all Defaults&quot; button, all theme options will be set to default and you will loose all your data except your custom header. So please be carefull!', 'htmlkombinat' ); ?></p>
		<p><?php _e( 'If you want to reset the custom header, please got to', 'htmlkombinat' ); ?> <a href="<?php echo admin_url('themes.php?page=custom-header') ?>"><?php _e( 'Appearance', 'default' ); ?> &raquo; <?php _e( 'Header', 'default' ); ?></a></p>
		<p><?php submit_button( __( 'Restore all Defaults', 'htmlkombinat' ), 'primary', 'submit-restore-defaults', false); ?></p>
		</form><?php
	}
	
	/**
	 * Content of metabox theme-support
	 *
	 * @return void
	 **/
	function load_metabox_theme_support(){
		?>
		<div class="author-img"><img src="<?php echo HTMLKOMBINAT_AUTHOR_IMG ?>" width="90" height="90"></div>
		<p><?php _e( "My name is Alexander Geilhaupt (wich means something like &quot;horny head&quot;) and I'm a german web developer. I live in Berlin but I'm not a nerd. I love fast cars, the Autobahn, women and WordPress.", 'htmlkombinat' ); ?></p>
		<p><a href="<?php echo HTMLKOMBINAT_AUTHOR_URL ?>" target="_blank"><?php _e( 'Visit my Website', 'htmlkombinat' ); ?></a></p>
		<?php
	}
}
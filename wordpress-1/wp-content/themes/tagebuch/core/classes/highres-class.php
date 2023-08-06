<?php
/**
 * Class HK_High_Resolution_Images
 *
 * Support for high resolution displays
 *
 * @package HTML_Kombinat
 * @since HTML Kombinat Core 2.2
 * @author Alexander Geilhaupt <alex@htmlkombinat.com> http://www.htmlkombinat.com
 */

class HK_High_Resolution_Images extends htmlkombinat {

	public $wp_upload_dir;
	/**
	 * Constructor
	 *
	 * Prepares the core to handle high resolution images
	 *
	 * @return void
	 **/
	function __construct() {
		$this->wp_upload_dir = wp_upload_dir();
		self::HTML_Kombinat_load_highres_hooks();
	}

	

	/**
	 * Load Hooks
	 *
	 * @return void
	 **/
	function HTML_Kombinat_load_highres_hooks() {
		add_filter( 'the_content', array( &$this,'HTML_Kombinat_replace_image_tags') );
		add_filter( 'widget_text', array( &$this,'HTML_Kombinat_replace_image_tags') );
		add_action( 'post_thumbnail_html', array( &$this,'HTML_Kombinat_replace_image_tags') );
		add_action( 'get_avatar', array( &$this,'HTML_Kombinat_replace_image_tags') );
		add_action( 'comment_text', array( &$this,'HTML_Kombinat_replace_image_tags') );
		if( is_admin() ) {
			add_action( 'shutdown', array( &$this, 'HTML_Kombinat_highres_custom_header' ));
			add_filter( 'manage_media_columns', array( &$this, 'HTML_Kombinat_manage_media_columns' ) );
			add_filter( 'manage_media_custom_column', array( &$this, 'HTML_Kombinat_manage_media_custom_columns' ), 10, 2 );
			add_action( 'delete_attachment', array( &$this, 'HTML_kombinat_delete_all_highres_images' ), 1, 1);
			add_action( 'shutdown', array( &$this, 'HTML_Kombinat_show_highres_message' ));
		}
	}

	
	/**
	 * Show messages to a couple of pages
	 *
	 * @return void
	 **/
	function HTML_Kombinat_show_highres_message() {
		$current_screen = get_current_screen();
		if ( $current_screen->base == 'appearance_page_custom-header' ) : ?>
		<div class="updated">
			<p><strong><?php printf( __( 'The %s Theme supports high resolution displays!', 'htmlkombinat' ), HTMLKOMBINAT_THEMENAME ); ?></strong></p>
		 	<p><?php _e( 'The custom header images are stored in double resolution and downsized for normal resolution displays.', 'htmlkombinat' ) ?></p>
		</div>
		<?php
		endif;
	}
	
	/**
	 * Sets a column to media
	 *
	 * @return array $cols
	 **/
	function HTML_Kombinat_manage_media_columns( $cols ) {
		$cols['highres'] = __( 'High Resolution Support', 'htmlkombinat' );
		return $cols;
	}
	
	/**
	 * Manages the high resolution support custom column
	 *
	 * @return bool
	 **/
	function HTML_Kombinat_manage_media_custom_columns( $column, $attachment_id ) {
		if ( $column != 'highres' ) {
			return false;
		}
		$attachment_url = wp_get_attachment_url( $attachment_id );
		$image = self::HTML_Kombinat_image_meta( $attachment_id, $attachment_url, true );
		if( isset( $_REQUEST['hk-action'] ) ) {
			if( $_REQUEST['id'] == $attachment_id ) {
				self::HTML_Kombinat_handle_highres_images( $_REQUEST['hk-action'], $image );
			}
		}
		if( substr_count( $image['mime-type'], 'image' ) == 1 ) :
			
			if( $image['attachment_context'] == 'custom-header' ) : ?>
				<p><?php _e( 'You can change your custom header images at', 'htmlkombinat' ); ?> <a href="<?php echo admin_url('themes.php?page=custom-header') ?>"><?php _e( 'Appearance', 'default' ); ?> &raquo; <?php _e( 'Header', 'default' ); ?></a></p>
			<?php return false;
			endif;
			if( isset( $image['sizes'] )) :
				if( is_file( $image['basedir'].$image['sizes']['thumbnail']['highres_file'] ) ) : ?>
				<p><?php _e( 'High Resolution Images saved.', 'htmlkombinat' ); ?></p>
				<form method="post" action="">
					<input type="hidden" name="hk-action" value="delete-highres-images">
					<input type="hidden" name="id" value="<?php echo $attachment_id; ?>">
					<p><?php submit_button( __( 'Delete High Resolution Images', 'htmlkombinat' ), 'secondary', 'delete-highres-images-'.$attachment_id, false); ?></p>
				</form>
				<?php  else : ?>
				<form method="post" action="">
					<input type="hidden" name="hk-action" value="generate-highres-images">
					<input type="hidden" name="id" value="<?php echo $attachment_id; ?>">
					<p><?php submit_button( __( 'Generate High Resolution Images', 'htmlkombinat' ), 'primary', 'generate-highres-images-'.$attachment_id, false); ?></p>
				</form>
			<?php endif;
		else: ?>
			<p><?php _e( 'This is no image', 'htmlkombinat' ); ?></p>
	<?php endif;
	endif;
	}
	
	/**
	 * Sets the highres image name
	 *
	 * @return string $highres_image
	 **/
	function HTML_Kombinat_set_highres_image( $image_url = '' ) {
		if( $image_url == '' ) {
			return false;
		}
		$image_pathinfo = pathinfo( $image_url );
		$image_dir = str_replace($this->wp_upload_dir['baseurl'],$this->wp_upload_dir['basedir'],$image_pathinfo['dirname']);
		$highres_image = $image_pathinfo['filename'].'@2x.'.$image_pathinfo['extension'];
		return $highres_image;
	}
	
	/**
	 * Fetches image meta data
	 *
	 * @return array $image
	 **/
	function HTML_Kombinat_image_meta( $attachment_id = '', $image_url = '', $set_highres_values = false ) {
		if( $attachment_id == '' || $image_url == '' ) {
			return false;
		}
		$attachment_context = get_post_meta( $attachment_id, '_wp_attachment_context' );
		if( count( $attachment_context ) == 0 ) {
			$attachment_context[0] = 'default-usage';
		}
		$image_pathinfo = pathinfo( $image_url );
		$image_dir = str_replace( $this->wp_upload_dir['baseurl'], $this->wp_upload_dir['basedir'], $image_pathinfo['dirname'] );
		$image_path = trailingslashit( $image_dir ).$image_pathinfo['basename'];
		$image = wp_get_attachment_metadata( $attachment_id, $image_path );
		$image['basedir'] = trailingslashit( $image_dir );
		$image['file_name'] = $image_pathinfo['basename'];
		if( $set_highres_values ) {
			if( isset( $image['file'] )) {
				$image['highres_file'] = self::HTML_Kombinat_set_highres_image( $image['file'] );
				if( is_array( $image['sizes'] ) ) {
					foreach( $image['sizes'] as $key => $value ) {
						$image['sizes'][ $key ]['highres_file'] = self::HTML_Kombinat_set_highres_image( $image['sizes'][ $key ]['file'] );
					}
				}
			}
		}
		$image['mime-type'] = get_post_mime_type( $attachment_id );
		$image['attachment_context'] = $attachment_context[0];
		return $image;
	}
	
	/**
	 * Sets highres images to custon header images
	 *
	 * @return void
	 **/
	function HTML_Kombinat_highres_custom_header() {
		$current_screen = get_current_screen();
		if ( $current_screen->base != 'appearance_page_custom-header' ) {
			return false;
		}
		$header_images = get_uploaded_header_images();
		if( !is_array( $header_images )) {
			return false;
		}
		foreach( $header_images as $header_image ) {
			$image = self::HTML_Kombinat_image_meta( $header_image['attachment_id'], $header_image['thumbnail_url'], true );
			$image['new_width'] = floor($image['width'] / 2);
			$image['new_height'] = floor($image['height'] / 2);
			if( !is_file( $image['basedir'].$image['highres_file'] ) ) {
				if( !copy( $image['basedir'].$image['file_name'], $image['basedir'].$image['highres_file'] ) ) {

				}
				$resize = self::HTML_Kombinat_resize_image( $image['basedir'].$image['highres_file'], $image['basedir'].$image['file_name'], $image['new_width'], $image['new_height'], true, $image['mime-type'] );
			}
		}
	}

	/**
	 * Resize images
	 *
	 * @return bool
	 **/
	function HTML_Kombinat_resize_image( $file = '', $destination = '', $width = 0, $height = 0, $crop = true, $mime_type = null ) {
		if( !is_file( $file ) || $destination == '' || $width == 0 || $height == 0) {
			return false;
		}
		$image = wp_get_image_editor( $file );
		if( !is_wp_error( $image ) ) {
			$image->resize( $width, $height, $crop );
			$image->save( $destination, $mime_type );
			return true;
		}
		return false;
	}
	

	/**
	 * Deletes all highres images after delete post
	 *
	 * @return bool
	 **/
	function HTML_kombinat_delete_all_highres_images( $attachment_id ) {
		if( $attachment_id == '' ) {
			return false;
		}
		$attachment_url = wp_get_attachment_url( $attachment_id );
		$image = self::HTML_Kombinat_image_meta( $attachment_id, $attachment_url, true );
		$delete = self::HTML_Kombinat_handle_highres_images( 'delete-highres-images', $image );
	}

	/**
	 * Generates or deletes highres images
	 *
	 * @return bool
	 **/
	function HTML_Kombinat_handle_highres_images( $action = '', $image = '' ) {
		if( $action == '' ) {
			return false;
		}
		switch( $action ) {
			
			case 'generate-highres-images':
			
			if( is_array( $image['sizes'] ) ) {
				foreach( $image['sizes'] as $key => $value ) {
					if( floor($image['sizes'][ $key ]['width'] * 2) <= $image['width'] ) {
						$crop = false;
						$cropit = get_option($key.'_crop');
						if($key == 'post-thumbnail' || $cropit == 1 ) {
							$crop = true;
						}
					$width = floor( $image['sizes'][ $key ]['width'] * 2);
					$height  = floor( $image['sizes'][ $key ]['height'] * 2);
					$source_image = $image['basedir'].$image['file_name'];
					$dest_image = $image['basedir'].$image['sizes'][ $key ]['highres_file'];
					$resize = self::HTML_Kombinat_resize_image( $source_image, $dest_image, $width, $height, $crop, $image['mime-type'] );
					}
				}
			}
			return true;
			break;
			
			case 'delete-highres-images':
			
			if( is_array( $image['sizes'] ) ) {
				foreach( $image['sizes'] as $key => $value ) {
					if( is_file( $image['basedir'].$image['sizes'][ $key ]['highres_file'] ) ) {
						if( !unlink( $image['basedir'].$image['sizes'][ $key ]['highres_file'] ) ) {
							return false;
						}
					}
				}	
			}
			if( is_file( $image['basedir'].$image['highres_file'] ) ) {
				if( !unlink( $image['basedir'].$image['highres_file'] ) ) {
					return false;
				}
			}
			return true;
			break;
			
			default: 
			return false;	
		}
	}

	/**
	 * Set high resolution images
	 * Used in Frontend
	 *
	 * @return string
	 **/
	
	function HTML_Kombinat_replace_image_tags( $html ) {
		if( $html == '' ) {
			return $html;
		}
		$html = str_replace( ' & ', ' &amp; ', $html );
		$doc = new DOMDocument();
		@$doc->loadHTML( $html );
		$images = $doc->getElementsByTagName('img');
		foreach( $images as $image ) {
			$img_src = parse_url( $image->getAttribute('src') );
			$img_host = '';
			$avatar = '';
			$avatar_highres = '';
			if( isset( $img_src['scheme'] ) && isset( $img_src['host'] ) ) {
				$img_host = $img_src['scheme'].'://'.$img_src['host'];
			}
			$img_path_info = pathinfo( $img_src['path'] );
			$extension = "";
			if( isset( $img_path_info['extension'] ) ) {
				$extension = $img_path_info['extension'];
			}
			$img_highres_path = trailingslashit($img_path_info['dirname']).$img_path_info['filename']."@2x.".$extension;
			if( isset( $img_src['query'] ) && isset( $img_src['scheme'] ) && isset( $img_src['host'] ) ) {
				if( substr_count( $img_src['host'], 'gravatar' ) == 1 ) {
					$img_host = '';
					$img_src['path'] = str_replace( "&", "&amp;", $image->getAttribute('src') );
					$tmp = explode("=",$img_src['query']);
					$avatarsize = floatval( $tmp[1] );
					$query = "?".$tmp[0]."=";
					unset($tmp);
					$avatar = $query.$avatarsize;
					$avatar_highres = $query.floor( $avatarsize * 2 );
					$img_highres_path =  str_replace( $avatar, $avatar_highres, str_replace("&","&amp;",$image->getAttribute('src')));
				}
			}
			$img_new_attribute = 'data-high-resolution-src="'.$img_host.$img_highres_path.'"';
			$img_src_attribute = 'src="'.$img_host.$img_src['path'].'"';
			if( is_file( untrailingslashit(ABSPATH).$img_highres_path ) || $avatar != '' ) { 
				if(substr_count( $html, $img_src_attribute ) == 0 ) { 
					$img_src_attribute = str_replace( '"', "'", $img_src_attribute );
					$img_new_attribute = str_replace( '"', "'", $img_new_attribute );
				}
				$html = str_replace( $img_src_attribute, $img_src_attribute.' '.$img_new_attribute, $html );
			}
		}
		return $html;
	}

}

?>
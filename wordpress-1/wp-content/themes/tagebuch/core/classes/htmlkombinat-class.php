<?php
/**
 * Class HTMLkombinat
 *
 * HTML Kombinat's Core
 *
 * @package HTML_Kombinat
 * @since HTML Kombinat Core 1.0
 * @author Alexander Geilhaupt <alex@htmlkombinat.com> http://www.htmlkombinat.com
 */
class htmlkombinat {
	// Define variables
	public $options = array();
	public $default_options = array();
	public $avatarSize = 144; //Retina support
	public $avatarSizeDepth = 144; //Retina support
	public $html_kombinat_links = array();
	public $user = array();

	/**
	 * Constructor
	 *
	 * Load all the main things, we use in this Theme
	 *
	 * @return void
	 **/
	function __construct() {
		// Get current User
		self::HTML_kombinat_get_current_user();
		// Add General CSS
		add_action('wp_enqueue_scripts', array( &$this,'HTML_Kombinat_theme_styles') );
		// Add Editor Style
		add_editor_style();
		// Add Jscripts
		add_action( 'wp_enqueue_scripts', array( &$this,'HTML_Kombinat_enque_scripts') );
		// Add Custom Scripts
		add_action( 'wp_head', array( &$this,'HTML_Kombinat_custom_head_tags') );
		add_action( 'wp_footer', array( &$this,'HTML_Kombinat_custom_footer_scripts') );
		// Add textdomain
		load_theme_textdomain( 'htmlkombinat', get_template_directory().'/languages' );
		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );
		// Add excerpt to pages
		add_post_type_support( 'page', 'excerpt' );
		// Add custom header
		self::HTML_Kombinat_custom_header();
		// Add custom background
		self::HTML_Kombinat_custom_background();
		// Set Imagesizes on Theme Setup
		add_action( 'after_setup_theme', array( &$this,'HTML_Kombinat_set_image_sizes') );
		// Register Page Menues
		self::HTML_Kombinat_register_page_menus();
		// Get Options
		self::HTML_Kombinat_get_options();
		// Get default Options
		self::HTML_Kombinat_get_default_options();
		// Register Sidebars
		self::HTML_Kombinat_register_sidebars();
		// Register Hooks
		self::HTML_Kombinat_register_hooks();	
		// Add Shortcode version (experimental)
		add_shortcode( 'version', array( &$this,'HTML_Kombinat_show_version') );
	}
	

	/**
	 * Make the current user global
	 *
	 * @return void
	 **/
	function HTML_kombinat_get_current_user(){
		global $current_user;
		get_currentuserinfo();
		if( is_object( $current_user->data )) {
			foreach( $current_user->data as $key => $value ) {
				$this->user[ $key ] = $value;
			}
		}
	}
		
	/**
	 * Fills the htmlkombinat options array with the main configuration options.
	 *
	 * @return void
	 **/
	function HTML_Kombinat_get_options() {
		$this->options = wp_parse_args( get_option( 'htmlkombinat_mainconfig' , array() ), self::HTML_Kombinat_get_default_options() );
	}
		
	/**
	 * Fills the htmlkombinat options array with defaults.
	 *
	 * @return void
	 **/
	function HTML_Kombinat_get_default_options(){
		$this->default_options = array(
			'retina' => '',
			'sidebar_blog' => 'left',
			'sidebar_page' => 'left',
			'sidebar_article' => 'right',
			'post_format_blogpage' => 'excerpt',
			'google_site_verification' => '',
			'bing_site_verification' => '',
			'yahoo_site_verification' => '',
			'tracking_code' => '',
			'custom_css' => '',
			'custom_scripts_header' => '',
			'custom_scripts_footer' => '',
			'social_icons' => array(
				'facebook_url' => '',
				'twitter_url' => '',
				'gplus_url' => '',
				'flickr_url' => '',
				'xing_url' => '',
				'linkedin_url' => ''
			)
		);
		return $this->default_options;
	}
	
	
	/**
	 * Insert Custom head tags
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_custom_head_tags() {
		if( $this->options['google_site_verification'] != '' ) : ?>
		<meta name="google-site-verification" content="<?php echo stripslashes($this->options['google_site_verification']) ?>">
		<?php endif;
		if( $this->options['bing_site_verification'] != '' ) : ?>
		<meta name="msvalidate.01" content="<?php echo stripslashes($this->options['bing_site_verification']) ?>">
		<?php endif;
		if( $this->options['yahoo_site_verification'] != '' ) : ?>
		<meta name="y_key" content="<?php echo stripslashes($this->options['yahoo_site_verification']) ?>">
		<?php endif;
		if( $this->options['custom_scripts_header'] != '' ) : ?>
		<script type="text/javascript">
		<!--
			<?php echo stripslashes($this->options['custom_scripts_header']) ?>
		//-->
		</script>
		<?php endif;
		if( $this->options['custom_css'] != '' ) : ?>
		<style type="text/css">
			<?php echo stripslashes($this->options['custom_css']) ?>
		</style>
		<?php endif;
	}
	
	
	/**
	 * Insert Custom footer scripts & Custom Background Color
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_custom_footer_scripts() {
		if( $this->options['tracking_code'] != '' ) {
		 echo stripslashes( html_entity_decode( $this->options['tracking_code'] ));
		}//background-attachment
		$background_color = get_theme_mod( 'background_color' );
		$background_image = get_theme_mod( 'background_image' );
		?>
		<script type="text/javascript">
		<!--
			var custom_background_color = '<?php echo $background_color ?>';
			var custom_background_image = '<?php echo $background_image ?>';
			
			<?php echo stripslashes($this->options['custom_scripts_footer']) ?>
		//-->
		</script>
		<?php
	}
	
	
	/**
	 * Show a sidebar toggle?
	 *
	 * @return bool
	 **/
	function HTML_Kombinat_has_sidebar() {
		global $HTMLkombinat;
			if( is_page() ) {
				$template = get_page_template();
				$template = str_replace(get_template_directory()."/","",$template);
				if( $template == "template-fullwidth.php" ) {
					return false;
				}
			}
			if(( is_page() || is_404() ) && $HTMLkombinat->options['sidebar_page'] == 'full-width') {
				return false;	
			} else {
				if( is_single()  && $HTMLkombinat->options['sidebar_article'] == 'full-width' ) {
					return false;	
				}
				if($HTMLkombinat->options['sidebar_blog'] == 'full-width') {
					return false;	
				}
			}
			return true;
	}
	
	
	/**
	 * Load Theme Styles
	 *
	 * @return void
	 **/
	function HTML_Kombinat_theme_styles(){
		// General CSS
		wp_register_style(
			'html-kombinat-general-style',
			 get_template_directory_uri() . '/style.css',
			 array(),
			 HTMLKOMBINAT_THEME_VERSION
		);
		// Enqueing
		wp_enqueue_style( 'html-kombinat-general-style' );
		
		// Responsive General CSS
		wp_register_style(
			'html-kombinat-responsive-style',
			 get_template_directory_uri() . '/css/responsive.css',
			 array('html-kombinat-general-style'),
			 HTMLKOMBINAT_THEME_VERSION,
			 'screen and (max-width: 1024px)'
		);
		// Enqueing
		wp_enqueue_style( 'html-kombinat-responsive-style' );
		
		// Smartphone CSS
		wp_register_style(
			'html-kombinat-smartphone-style',
			get_template_directory_uri() . '/css/smartphone.css',
			array(
			 	'html-kombinat-general-style',
			 	'html-kombinat-responsive-style',
			),
			HTMLKOMBINAT_THEME_VERSION,
			'screen and (max-width: 640px)'
		);
		// Enqueing
		wp_enqueue_style( 'html-kombinat-smartphone-style' );
	}
	
	/**
	 * Load java scripts
	 *
	 * @return void
	 **/
	function HTML_Kombinat_enque_scripts() {
		// Load modernizr
		wp_enqueue_script(
			'modernizr', 
			get_template_directory_uri() . '/js/modernizr.js'
		);
		
		// Load jQuery Effects Core
		wp_enqueue_script( 'jquery-effects-core' );
		
		// Load jQuery validate
		wp_enqueue_script(
			'validate', 
			get_template_directory_uri() . '/js/jquery.validate.min.js',
			array( 'jquery' )
		);
		
		// Load messages for jQuery validate
		wp_enqueue_script(
			'messages', 
			get_template_directory_uri() . '/js/localization/'.__( 'messages_en.js', 'htmlkombinat' ),
			array( 'jquery' )
		);
		
		// Load HTML Kombinat scripts
		wp_enqueue_script(
			'init', 
			get_template_directory_uri() . '/js/init.compressed.js',
			array( 'jquery' )
		);
		
		wp_enqueue_script(
			'highres', 
			get_template_directory_uri() . '/js/highres.js',
			array( 'jquery' ),
			'',
			true
		);
		// Load script for sites with threaded comments (when in use)
		if ( is_singular() && comments_open() && get_option('thread_comments') ) { 
            wp_enqueue_script('comment-reply'); 
        }

	}
		
	/**
	 * Register page menus
	 *
	 * @return void
	 **/
	function HTML_Kombinat_register_page_menus() {
		// Primary  
		register_nav_menu(
			'primary', 
			__( 'Primary Menu', 'htmlkombinat' )
		);
		
		// Top
		register_nav_menu(
			'secondary', 
			__( 'Secondary Menu', 'htmlkombinat' )
		);
		
	}
	
	function HTML_Kombinat_set_image_sizes() {
		$article_thumbnail_w = 594;
		$article_thumbnail_h = 250;
		$medium_size_w = 240;
		$large_size_w = 592;
		$thumbnail_size_w = 150;
		$thumbnail_size_h = 150;
		// Add post thumbnails
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( $article_thumbnail_w, $article_thumbnail_h, true );
		}
		
	}
		
	/**
	 * Register Sidebars
	 *
	 * @return void
	 **/
	function HTML_Kombinat_register_sidebars() {
		// Main Sidebar
		register_sidebar( array(
			'name' => __( 'Main Sidebar', 'htmlkombinat'),
			'id' => 'sidebar-main',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
			));
			
		// Alternate Sidebar for Pages
		register_sidebar( array(
			'name' => __( 'Page Sidebar', 'htmlkombinat'),
			'id' => 'sidebar-page',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
			));
			
		// Alternate Sidebar for Articles
		register_sidebar( array(
			'name' => __( 'Post Sidebar', 'htmlkombinat'),
			'id' => 'sidebar-post',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
			));
			
		// Widget area for Footer Left
		register_sidebar( array(
			'name' => __( 'Footer Left', 'htmlkombinat'),
			'id' => 'footer-left',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
			));
			
		// Widget area for Footer Middle
		register_sidebar( array(
			'name' => __( 'Footer Middle', 'htmlkombinat'),
			'id' => 'footer-middle',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
			));
						
		// Widget area for Footer Right
		register_sidebar( array(
			'name' => __( 'Footer Right', 'htmlkombinat'),
			'id' => 'footer-right',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
			));
	}
		
		
	/**
	 * Register Hooks
	 *
	 * @return void
	 **/
	function HTML_Kombinat_register_hooks()
		{
		global $template, $wp_query;
		
		// Remove HTML5-invalid anchor attributes (rel="category") in wp_list_actegories
		add_filter(
			'wp_list_categories', 
			array( &$this, 'HTML_Kombinat_clean_HTML5' )
		);
		
		// Remove HTML5-invalid anchor attributes (rel="category") in the_category
		add_filter(
			'the_category', 
			array( &$this, 'HTML_Kombinat_clean_HTML5' ) 
		);
	}
	

	/**
	 * Return clean HTML5
	 *
	 * @return string
	 **/
	function HTML_Kombinat_clean_HTML5( $output ) {
		$output = str_replace(' rel="category tag"', '', $output );
		return $output;
	}
	
	
	/**
	 * Outputs the content of the <title> tag.
	 *
	 * @return void Echoes it's output
	 **/
	 function HTML_Kombinat_the_title()
	 	{
		global $post, $page, $paged;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf(__( 'Page %s', 'htmlkombinat' ), max( $paged, $page ));
		}
		
	/**
	 * Support custom-header
	 * @since HTML Kombinat Core 2.0
	 *
	 * @return void
	 **/
	function HTML_Kombinat_custom_header() {
		$args = array(
			'width' => 600,
			'height' => 260,
			'default-image' => get_template_directory_uri() . '/images/misc/tagebuch-logo.png',
			'header-text' => false,
			'uploads' => true
		);
		add_theme_support( 'custom-header', $args );
	}
		
	/**
	 * Support custom-background
	 * @since HTML Kombinat Core 2.0
	 *
	 * @return void
	 **/
	function HTML_Kombinat_custom_background() {
		$args = array(
			'default-color' => 'efefef',
			'default-image' => '',
		);
		add_theme_support( 'custom-background', $args );
	}
		
	/**
	 * Outputs a logo or the blog info in header.
	 * @since HTML Kombinat Core 2.0
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_the_header() {
		if( get_header_image() != '' ) :
			$logo_attribute = '';
			$header_img = pathinfo(get_header_image());
			$retina_image = $header_img['dirname'].'/'.$header_img['filename'].'@2x.'.$header_img['extension'];
			$logo_attribute = ' data-high-resolution-src="'.$retina_image.'"';
			?>
			<a class="header-logo" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php header_image(); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"<?php echo $logo_attribute; ?>></a>
		<?php endif; ?>
		<?php if ( !get_header_image() ) : ?>
			<hgroup>
				<h1 class="blog-name"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="blog-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
		<?php endif;
	}
		
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 */
	function HTML_Kombinat_page_menu_args($args) {
		$args['show_home'] = true;
		return $args;
	}
		
	/**
	 * Outputs the menu.
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_create_menu($menuType = "primary", $depth = 0) {
		global $wp_query;
		add_filter( 
			'wp_page_menu_args', 
			array( &$this, 'HTML_Kombinat_page_menu_args' ) 
		);
		
		$args = array(
			    'container' => '',
				'fallback_cb' =>  false,
				'depth' =>  $depth,
				'menu_id' => $menuType.'-menu', 
				'theme_location' => $menuType
			);
	
		if( $menuType == "primary" && !has_nav_menu( $menuType )) {
			self::HTML_Kombinat_page_menu();
			return;
		}
		
		wp_nav_menu($args);
		
	}
		
	/**
	 * Outputs the header menu with a single link.
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_page_menu() {
		global $wp_query;
		$arguments = array(
			'sort_column ' => 'menu_order',
			'title_li' => ''
		);
		?>
			<ul id="primary-menu" class="menu">
				<?php wp_list_pages( $arguments ); ?>
			</ul>
		<?php
	}

	/**
	 * Outputs the Comments.
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_comment_template( $comment, $args, $depth ) {
		global $wp_query;
		$GLOBALS['comment'] = $comment;
		switch($comment->comment_type) :
			case 'pingback':
			case 'trackback':
?>
		<li class="post pingback">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<p><?php _e( 'Pingback:', 'htmlkombinat' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit','htmlkombinat'), '<span class="edit-link">', '</span>' ); ?></p>
<?php
				break;
			default:
				$avatar = get_avatar($comment,$this->avatarSize);
				if($comment->comment_parent != '0') {
					$avatar = get_avatar(get_comment_author_email(),$this->avatarSizeDepth);
				}
?>
		<li <?php comment_class(); ?>>
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<div class="comment-author comment-metabar">
					<footer>
						<div class="left"><?php echo $avatar ?></div>
						<cite class="fn"><?php comment_author_link() ?></cite>
						<?php edit_comment_link( __('Edit','htmlkombinat'), '<span class="edit-post right">', '</span>'); ?>
						<p><span class="left"><time class="timestamp" datetime="<?php comment_time('c') ?>"><?php printf(__('Said on %1$s at %2$s','htmlkombinat'),get_comment_date(),get_comment_time()); ?></time></span>
						<?php if ( $comment->comment_approved == '0' ) : ?>
						<br><em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'htmlkombinat' ); ?></em>
						<?php endif; ?></p>
					</footer>
				</div>
<?php
				break;
		endswitch;
?>
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
				<p class="reply-link"><span class="meta-comment"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'htmlkombinat' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span></p>
			</article>
<?php
		}
		
	/**
	 * Outputs the Comment Form.
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_comment_form() {
		global $wp_query;
		$commenter = wp_get_current_commenter();
		$required_text = "";
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? ' aria-required="true"' : '' );
		
		$fields = array(
				'author' => '<p class="comment-form-author"><label for="author" class="comment-author-label">'.__( 'Name', 'htmlkombinat' ).( $req ? '<span class="required">*</span>' : '' ) .':</label><input id="author" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30"'.$aria_req.( $req ? ' class="required"' : '' ) .'  /></p>',
				'email' => '<p class="comment-form-email"><label for="email" class="comment-email-label">'.__( 'Email', 'htmlkombinat' ).( $req ? '<span class="required">*</span>' : '' ) .':</label><input id="email" name="email" type="email" value="'.esc_attr($commenter['comment_author_email']).'" size="30" '.$aria_req.' class="email'.( $req ? ' required' : '' ) .'"  /></p>',
				'url' => '<p class="comment-form-url"><label for="url" class="comment-url-label">'.__( 'Website', 'htmlkombinat' ).':</label><input id="url" name="url" type="text" value="'.esc_attr($commenter['comment_author_url']).'" class="url" size="30" /></p>'
			);
			
		$args = array(
				'fields' => $fields,
				'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.','htmlkombinat' ) . ( $req ? $required_text : '' ) . '</p>',
				'comment_field' => '<p class="comment-form-comment"><label for="comment" class="comment-comment-label">'.__( 'Comment','htmlkombinat' ).'*:</label><textarea id="comment" name="comment" aria-required="true" class="required"></textarea></p>'
			);
		
		// Validate the comment form
		if(comments_open()) : ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#commentform").validate();
			});
		</script>
		<?php endif;
		
		comment_form($args);
	}
	
	/**
	 * Outputs a couple of icons in the footer.
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_social_networks_links()
		{
		global $HTMLkombinat;
		$social_networks_links  = '<div class="social-menu"><ul class="social"><li><a href="'.get_bloginfo('rss2_url').'" class="rss" title="'.__('RSS-Feeds','htmlkombinat').'"></a></li>'."\n";
		if( is_array( $HTMLkombinat->options['social_icons'] ) ) {
			foreach( $HTMLkombinat->options['social_icons'] as $key => $value ) {
				if(!empty($value)) {
					$social_networks_links .= '<li><a href="'.$HTMLkombinat->options['social_icons'][ $key ].'" class="'.$key.'" title="'.get_bloginfo('name').__(' on ','htmlkombinat').$HTMLkombinat->options['social_icons'][ $key ].'"></a></li>'."\n";
				}
			}
		}
		$social_networks_links .= '</ul></div>';
		echo $social_networks_links;
	}
		
		
	/**
	 * Shortcodes for theme and core version.
	 *
	 * @return void Echoes it's output
	 **/
	function HTML_Kombinat_show_version( $atts ) {
		extract( shortcode_atts( array( 'type' => 'theme' ), $atts ) );
		if($type == 'theme') {
			return HTMLKOMBINAT_THEME_VERSION;
		}
		if($type == 'core') {
			return HTMLKOMBINAT_CORE_VERSION;
		}
	}
	
	
	/**
	 * Outputs a pagination instead of next_posts_link or previous_posts_link if wp_pagenavi plugin is not active.
	 *
	 * @return void Echoes it's output
	 **/
	function pagination( $prev_text = "&laquo;", $next_text = "&raquo;", $type = "list" )
		{
		if(function_exists( 'wp_pagenavi' )) {// if wp_pagenavi plugin is active, break here.
			wp_pagenavi();
			return;
		}
		
		global $wp_query;
		$big = 999999999; // need an unlikely integer
		
		if($prev_text == "") {
			$prev_text  = "&laquo;";	
		}
		
		if($next_text == "") {
			$next_text  = "&raquo;";
		}
		
		if($type == "") {
			$type  = "list";
		}
		
		$args = array(
			'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'prev_next' => true,
			'prev_text' => $prev_text,
			'next_text' => $next_text,
			'type' => $type,
			'total' => $wp_query->max_num_pages
		);
		
		$pagination = paginate_links($args);
		
		if(!empty($pagination)) : ?>
			<div class="clear-all"></div>
			<nav class="pages">
			<?php echo $pagination;	?>
			<div class="clear"></div>
			</nav>
		<?php endif;
	}
		
	 /**
	 * Outputs a pagination for the post
	 * We think that if we use HTML5, we should use a workaround
	 * for the pagination of a single post to display a <nav> tag.
	 *
	 * @return void Echoes it's output
	 **/
	function post_pagination( $prev_text = "&laquo;", $next_text = "&raquo;" )
		{
		global $wp_query;

		if($prev_text == "") {
			$prev_text  = "&laquo;";	
		}
		
		if($next_text == "") {
			$next_text  = "&raquo;";
		}
		
		$args = array(
			'before' => '',
			'after' => '',
			'echo' => 0,
			'link_before' => '<span>',
			'link_after' => '</span>'
			);

		$post_pagination = trim( wp_link_pages( $args ) );
		$pagination_array = explode( " ", str_replace( "<a href", "<a_href", $post_pagination ) );
		$p = 0;
		for($i = 0; $i < count($pagination_array); $i++) {
			$liClass = "";
			if(isset($wp_query->query_vars['page'])) {
				if($wp_query->query_vars['page'] == ($i+1) || ($wp_query->query_vars['page'] == '0' && $i == 0)) {
					$liClass = ' class="current"';
				}
			}
			$pagination[$i] = "<li".$liClass.">".trim($pagination_array[$i])."</li>";
		}
		if( count( $pagination ) > 1 ) : ?>
			<div class="clear-all"></div>
			<nav class="pages">
				<ul class="page-numbers">
				<?php echo str_replace( "<a_href", "<a href", implode( "\n", $pagination ) ); ?>
				</ul>
			</nav>
			<div class="clear"></div>
			<?php endif;
		}

}

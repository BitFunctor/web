<?php
/**
 * Theme Footer
 *
 * Footer of the Tagebuch Theme display all content for the <footer> and closing the site
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

global $HTMLKombinat;
?>

			<div class="clear-all"></div>
			<footer id="footer" role="contentinfo">
				<div class="footer-wrapper">
					<div class="sidebar wrapper pw-footer">
						<div class="content-left left">
						<?php if ( ! dynamic_sidebar( 'footer-left' ) ) : ?>
							<aside>
								<p><?php _e( 'Footer Widget left', 'htmlkombinat' ); ?></p>
							</aside>
						<?php endif; ?>
						</div>
						<div class="content-middle left">
						<?php if ( ! dynamic_sidebar( 'footer-middle' ) ) : ?>
							<aside>
								<p><?php _e( 'Footer Widget Middle', 'htmlkombinat' ); ?></p>
							</aside>
						<?php endif; ?>
						</div>
						<div class="content-right right">
						<?php if ( ! dynamic_sidebar( 'footer-right' ) ) : ?>
							<aside>
								<p><?php _e( 'Footer Widget right', 'htmlkombinat' ); ?></p>
							</aside>
						<?php endif; ?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
				<div id="copyright" class="copyright">
					<div class="wrapper">
						<p class="left">
							&copy; <?php echo date("Y") ?> <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> |
							<?php _e( 'Proudly powered by', 'htmlkombinat' ); ?> <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'htmlkombinat' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'htmlkombinat' ); ?>" rel="friend">WordPress</a> |
							<?php _e( 'Theme by', 'htmlkombinat' ); ?> <a href="<?php echo HTMLKOMBINAT_AUTHOR_URL; ?>" title="<?php echo HTMLKOMBINAT_THEMENAME.' Version '.HTMLKOMBINAT_THEME_VERSION; ?>" rel="friend"><?php echo HTMLKOMBINAT_AUTHOR; ?></a>
						</p>
						<?php
						/*
						 * Display Social Network Icons
						 */
						 htmlkombinat::HTML_Kombinat_social_networks_links();
						?>
						<div class="clear"></div>
					</div>
				</div>
			</footer><!-- #footer -->
			<div class="clear"></div>
		</div>
		<div id="htmlkombinat-responsive-menu-container" class="htmlkombinat-menu-container"></div>
		<div id="htmlkombinat-responsive-sidebar-container" class="htmlkombinat-sidebar-container"></div>
		<?php wp_footer(); ?>
	</body>
</html>
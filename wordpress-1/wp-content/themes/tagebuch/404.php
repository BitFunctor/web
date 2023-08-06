<?php
/**
 * 404 Template
 *
 * 404 Template of the Tagebuch Theme 
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

global $HTMLkombinat;
get_header(); 
?>
			<div id="page-content" class="pw-page two-columns box">
				<div id="content" role="main" class="content <?php  echo $HTMLkombinat->options['sidebar_page']; ?>">
					<div class="article-container">
						<article id="error-404" <?php post_class(); ?>>
							<header class="entry-header">
								<p class="sticky-message"><?php _e( 'Error 404', 'htmlkombinat' ); ?></p>
								<h2 class="entry-title"><?php _e( 'Sorry, but you\'re looking for something, that isn\'t here.', 'htmlkombinat' ); ?></h2>
							</header>
							<div class="entry">
							  <p><strong><?php _e('Maybe you like to read one of the last posts.','htmlkombinat'); ?></strong></p>
								   <?php query_posts('showposts=15'); ?>
								   <?php while (have_posts()) : the_post(); ?>
									  <ul class="arc">
										 <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
									  </ul>
								   <?php endwhile;?>
								<div class="clear"></div>
							</div>
						</article><!-- #error-404 -->
					</div><!-- .article-container -->
				</div><!-- #content -->
				<?php if ( $HTMLkombinat->options['sidebar_page'] != 'full-width' ) : ?>
				<div id="sidebar" class="sidebar <?php  echo ( $HTMLkombinat->options['sidebar_page'] == 'left' ) ? 'right' : 'left'; ?>" role="complementary">
					<?php get_sidebar('sidebar-page'); ?>
				</div>
				<?php endif; ?>
				<div id="content-clear" class="clear"></div>
			</div>
			<?php get_footer(); ?>
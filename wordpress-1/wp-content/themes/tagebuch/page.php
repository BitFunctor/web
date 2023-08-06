<?php
/**
 * Main Template
 *
 * Main Template of the Tagebuch Theme 
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
				<div id="content" role="main" class="content <?php echo $HTMLkombinat->options['sidebar_page']; ?>">
					<div class="article-container">
						<?php if ( have_posts() ) : ?>
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<div class="clear-all"></div>
								<h2 class="entry-title"><?php the_title(); ?></h2>
							</header>
							<div class="entry">
								<?php if(has_post_thumbnail()) : ?>
									<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>
									<div class="article-image"><a href="<?php echo $large_image_url[0]; ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a></div>
									<div class="clear"></div>
								<?php endif; ?>
								<?php the_content(); ?>
							</div>
							<?php $HTMLkombinat->post_pagination(); ?>
						</article><!-- #post-<?php the_ID(); ?> -->
								<?php if ( comments_open() ) : ?>
								<?php comments_template( '', true ); ?>
								<?php endif; ?>
							<?php endwhile; ?>
						<?php endif; ?>
					</div><!-- .article-container -->
				</div><!-- #content -->
				<?php if ( $HTMLkombinat->options['sidebar_page'] != 'full-width' ) : ?>
				<div id="sidebar" class="sidebar <?php  echo ( $HTMLkombinat->options['sidebar_page'] == 'left' ) ? 'right' : 'left'; ?>" role="complementary">
					<?php get_sidebar('page'); ?>
				</div>
				<?php endif; ?>
				<div id="content-clear" class="clear"></div>
			</div>
			<?php get_footer(); ?>
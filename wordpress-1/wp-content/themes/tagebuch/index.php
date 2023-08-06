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
				<div id="content" role="main" class="content <?php echo $HTMLkombinat->options['sidebar_blog']; ?>">
					<div class="article-container">
						<?php if ( have_posts() ) : ?>
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
							<?php if ( is_sticky() ) : ?>
								<p class="sticky-message"><?php _e( 'Featured', 'htmlkombinat' ); ?></p>
							<?php else : ?>
								<div class="clear-all"></div>
							<?php endif; ?>
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'htmlkombinat' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								<div class="metabar">
									<p>
										<span class="post-date"><?php the_time(get_option('date_format')); ?></span>
										<span class="author vcard"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php printf(__( 'View all posts by %s', 'htmlkombinat' ), get_the_author()); ?>"><?php the_author(); ?></a></span>
										<span class="meta-comment"><?php comments_popup_link(__('Leave a Reply', 'htmlkombinat'), __('1 Reply', 'htmlkombinat'), __('% Replies', 'htmlkombinat'), 'comments-link', __('Comments are closed', 'htmlkombinat')); ?></span>
										<?php edit_post_link(__('Edit','htmlkombinat'), '<span class="edit-post right">', '</span>'); ?>
									</p>
								</div>
							</header>
							<div class="entry">
								<?php if(is_search() || is_category() || is_archive() || $HTMLkombinat->options['post_format_blogpage'] == "excerpt") : ?>
									<?php if(has_post_thumbnail()) : ?>
										<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'htmlkombinat' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
									<?php endif; ?>
									<?php the_excerpt(); ?>
									<p class="break"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'htmlkombinat' ), the_title_attribute( 'echo=0' ) ); ?>"><?php printf(__('<span class="read-more">Continue reading</span>', 'htmlkombinat')); ?></a></p>
								<?php else : ?>
									<?php if(has_post_thumbnail()) : ?>
										<div class="article-image"><?php the_post_thumbnail(); ?></div>
									<?php endif; ?>
									<?php the_content(__('<span class="read-more">Continue reading</span>', 'htmlkombinat')); ?>
									<?php if(get_the_title() == "" || $numpages > 1 ) : ?>
										<p class="break"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'htmlkombinat' ), the_title_attribute( 'echo=0' ) ); ?>"><?php printf(__('<span class="read-more">Continue reading</span>', 'htmlkombinat')); ?></a></p>
									<?php endif; ?>
								<?php endif; ?>
							</div>
							<div class="clear"></div>
						</article><!-- #post-<?php the_ID(); ?> -->
							<?php endwhile; ?>
							<?php htmlkombinat::pagination(); ?>
							<?php else : ?>
							<article id="no-post" class="post no-results not-found">
								<header class="entry-header">
									<h2 class="entry-title"><?php _e( 'Nothing Found', 'htmlkombinat' ); ?></h2>
								</header>
								<div class="entry-content">
									<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'htmlkombinat' ); ?></p>
									<?php get_search_form(); ?>
								</div>
							</article><!-- #no-post -->
						<?php endif; ?>
					</div><!-- .article-container -->
				</div><!-- #content -->
				<?php if ( $HTMLkombinat->options['sidebar_blog'] != 'full-width' ) : ?>
				<div id="sidebar" class="sidebar <?php  echo ( $HTMLkombinat->options['sidebar_blog'] == 'left' ) ? 'right' : 'left'; ?>" role="complementary">
					<?php get_sidebar('sidebar-main'); ?>
				</div>
				<?php endif; ?>
				<div id="content-clear" class="clear"></div>
			</div>
			<?php get_footer(); ?>
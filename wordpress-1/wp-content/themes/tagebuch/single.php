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
				<div id="content" role="main" class="content <?php  echo $HTMLkombinat->options['sidebar_article']; ?>">
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
								<h2 class="entry-title"><?php the_title(); ?></h2>
								<div class="metabar"><p><span class="meta-comment"><?php comments_popup_link(__('Leave a Reply', 'htmlkombinat'), __('One Reply', 'htmlkombinat'), __('% Replies', 'htmlkombinat'), 'comments-link', __('Comments are closed', 'htmlkombinat')); ?></span></p></div>
							</header>
							<div class="entry">
								<?php if(has_post_thumbnail()) : ?>
									<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>
									<div class="article-image"><a href="<?php echo $large_image_url[0]; ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a></div>
									<div class="clear"></div>
								<?php endif; ?>
								<?php the_content(); ?>
							</div>
							<div class="clear"></div>
							<footer>
								<div class="metabar">
									<p>
										<span class="post-date"><?php the_date(); ?></span>
										<span class="author vcard"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php printf(__( 'View all posts by %s', 'htmlkombinat' ), get_the_author()); ?>"><?php the_author(); ?></a></span>
										<?php edit_post_link(__('Edit','htmlkombinat'), '<span class="edit-post right">', '</span>'); ?><br>
										<span class="category-list"><?php the_category(', ');?></span>
										<?php the_tags('<br><span class="tag-list">', ', ', '</span>'); ?>
									</p>
								</div>
							</footer>
			
					<?php if (get_the_author_meta('description') != '') : ?>
						<?php $avatar = get_avatar(get_the_author_meta('user_email'),$HTMLkombinat->avatarSize); ?>
						<div class="author-info">
							<div class="left"><?php echo $avatar ?></div>
							<h2><?php _e('About','htmlkombinat'); ?> <?php the_author_posts_link(); ?></h2>
							<p><?php the_author_meta('description') ?></p>
							<div class="clear"></div>
						</div>
						<?php endif; ?>
						<?php $HTMLkombinat->post_pagination(); ?>
						</article><!-- #post-<?php the_ID(); ?> -->
								<?php comments_template( '', true ); ?>
							<?php endwhile; ?>
						<?php endif; ?>
						<div class="clear-all"></div>
						<div class="left"><?php previous_post_link(); ?></div>
						<div class="right"><?php next_post_link(); ?></div>
					</div><!-- .article-container -->
				</div><!-- #content -->
				<?php if ( $HTMLkombinat->options['sidebar_article'] != 'full-width' ) : ?>
				<div id="sidebar" class="sidebar <?php  echo ( $HTMLkombinat->options['sidebar_article'] == 'left' ) ? 'right' : 'left'; ?>" role="complementary">
					<?php get_sidebar('sidebar-post'); ?>
				</div>
				<?php endif; ?>
				<div id="content-clear" class="clear"></div>
			</div>
			<?php get_footer(); ?>
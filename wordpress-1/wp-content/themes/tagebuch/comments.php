<?php
/**
 * Comments Template
 *
 * Comments Template of the Tagebuch Theme 
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
?>
	<div id="comments">
	<?php if(post_password_required()) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'htmlkombinat' ); ?></p>
	</div><!-- #comments -->
	<?php
			return;
		endif;
?>
	<?php if ( have_comments() ) : ?>
		<h3 id="comments-title">
			<?php comments_number(__('No comments so far','htmlkombinat'), __('One Comment','htmlkombinat'), __('% Comments','htmlkombinat'));?>
		</h3>
		<ol class="commentlist">
			<?php wp_list_comments(array('callback' => array(&$HTMLkombinat,'HTML_Kombinat_comment_template'))); ?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
		<div class="clear-all"></div>
		<nav id="comment-nav-below" class="pages">
			<div class="nav-previous left"><?php previous_comments_link( __( '&larr; Older Comments', 'htmlkombinat' ) ); ?></div>
			<div class="nav-next right"><?php next_comments_link( __( 'Newer Comments &rarr;', 'htmlkombinat' ) ); ?></div>
			<div class="clear"></div>
		</nav>
		<div class="clear-all"></div>
		<?php endif; ?>

	<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'htmlkombinat' ); ?></p>
	<?php endif; ?>
	<?php  htmlkombinat::HTML_Kombinat_comment_form() ?>
</div><!-- #comments -->

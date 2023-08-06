<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p>This post is password protected. Enter the password to view comments.<p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'comment';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>

<div class="comments_caption" id="comments">
<h2><?php comments_number('No Comments', 'One Comment', '% Comments' );?> to &#8220;<?php the_title(); ?>&#8221;</h2>
</div>

<?php foreach ($comments as $comment) : ?>

<div class="comment_wrap" id="comment-<?php comment_ID() ?>">
<div class="comment_wrap_head">
<img src="<?php gravatar('X', '40'); ?>" alt="<?php //_e('Gravatar'); ?>" class="gravatar" />
<p><span><?php comment_time('d.m.y') ?> at <?php comment_time('H:i') ?></span><br />Posted by <b><?php comment_author_link() ?></b> </p>
</div>
<div class="comment_wrap_post">
<?php comment_text() ?>
<?php if ($comment->comment_approved == '0') : ?>
<p><em>Your comment is awaiting moderation.</em></p>
<?php endif; ?>
</div>

</div>




	<?php /* Changes every other comment to a different class */
		if ('comment' == $oddcomment) $oddcomment = 'alt';
		else $oddcomment = 'comment';
	?>

	<?php endforeach; /* end for each comment */ ?>


 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<!--<p class="nocomments">Comments are closed.</p>-->

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<div id ="leave_a_comment_wrap">
<div class="leave_a_comment">
<h2>Leave a Comment</h2>
</div>
<div class="trackback_rss">
<p><?php comments_rss_link('RSS feed for comments on this post.'); ?></p></div>
</div>


<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<h2>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</h2>
<?php else : ?>

<div id="comment_form">

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>
<p>Logged in as <b><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a></b>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"><b>Logout</b></a></p>
<?php else : ?>

<p>
<label for="author">Username <?php if ($req) echo "(required)"; ?> :</label><br />
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="27" tabindex="1" class="data" /><br />
</p>

<p>
<label for="email">Email <?php if ($req) echo "(required)"; ?> :</label><br />
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="27" tabindex="2" class="data" /><br />
</p>

<p>
<label for="url">Web Site :</label><br />
<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="27" tabindex="3" class="data" /><br />
</p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p>
<label for="comment">Comment :</label><br />
<textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea>
</p>

<p>
<input name="submit" type="submit" id="submit" tabindex="5" value="Submit" class="sbutton"/>
</p>

<p>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>

<?php do_action('comment_form', $post->ID); ?>
</form>
</div>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>


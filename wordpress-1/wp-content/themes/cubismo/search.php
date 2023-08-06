<?php get_header(); ?>


<div id="content_wrap">
<div id="content">
<?php if (have_posts()) : ?>
<div id="caption">
<h2>Search results</h2>
<div id="m_post">
<div class="o_entries"><?php next_posts_link('<span>Older Entries</span>') ?> </div>
<div class="r_entries"><?php previous_posts_link ('<span>Recent Entries</span>') ?></div>
</div>
</div>

<?php while (have_posts()) : the_post(); ?>
<div class="post">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="tags"><?php the_tags('<b>Tags:</b>', ', ', '.'); ?></p>
<?php the_content(); ?>
</div>
<div class="post_details">
<p>Posted on <?php the_time("j F 'y"); ?> by <?php the_author_posts_link(); ?>, under <?php the_category(', ') ?>. <a href="<?php comments_link(); ?>"><?php comments_number('No Comments','1 Comment','% Comments'); ?></a>.</p>
</div>

<?php endwhile; ?>

<div id="more_posts">
<?php next_posts_link('&laquo; Older Entries') ?>&nbsp;&nbsp;&nbsp;<?php previous_posts_link ('Recent Entries &raquo;') ?>
</div>
<?php else : ?>
<div class="post" id="page_post">
<h2 class="arh">Search results</h2>
<p class="arh">No matches. Please try again, or use the navigation menus to find what you search for.</p>
</div>
<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
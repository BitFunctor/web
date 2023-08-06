<?php get_header(); ?>


<div id="content_wrap">
<div id="content">
<div id="caption">
<?php if (have_posts()) : ?>
<?php $post = $posts[0]; ?>

<?php if (is_category()) { ?><h2>Archive for '<?php echo single_cat_title(); ?>'</h2>
<?php } elseif (is_day()) { ?><h2>Archive for <?php the_time('F jS, Y'); ?></h2>
<?php } elseif (is_month()) { ?><h2>Archive for <?php the_time('F, Y'); ?></h2>
<?php } elseif (is_year()) { ?><h2>Archive for the year <?php the_time('Y'); ?></h2>
<?php } elseif (is_search()) { ?><h2>Search results</h2>
<?php } elseif (is_author()) { ?><h2>Archive by Author</h2>
<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?><h2>Archives</h2>
<?php } elseif (is_tag()) { ?><h2>Tag Archives: <?php echo single_tag_title('', true); ?></h2>
<?php } ?>


<div id="m_post">
<div class="o_entries"><?php next_posts_link('<span>Older Entries</span>') ?> </div>
<div class="r_entries"><?php previous_posts_link (' <span>Recent Entries</span> ') ?></div>
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
<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
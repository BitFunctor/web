<?php get_header(); ?>


<div id="content_wrap">
<div id="content">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="post" id="page_post">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p class="tags"><?php the_tags('<b>Tags:</b>', ', ', '.'); ?></p>
<?php the_content(); ?>
</div>
<div class="post_details">
<p>Posted on <?php the_time("j F 'y"); ?> by <?php the_author_posts_link(); ?>, under <?php the_category(', ') ?>.</p>
</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>


</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
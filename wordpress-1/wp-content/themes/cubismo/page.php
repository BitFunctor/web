<?php get_header(); ?>


<div id="content_wrap">
<div id="content">
<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>
<div class="post" id="page_post">
<h2><?php the_title(); ?></h2>
<?php the_content(); ?>
<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
</div>

<?php endwhile; ?>

<?php endif; ?>


<?php comments_template(); ?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
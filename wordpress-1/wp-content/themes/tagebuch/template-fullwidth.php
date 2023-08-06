<?php
/**
 * Template Name: Full Width
 */
global $HTMLkombinat;
get_header(); 
?>
			<div id="page-content" class="pw-page box">
				<div id="content" role="main" class="content full-width">
					<div class="article-container">
						<?php if ( have_posts() ) : ?>
							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<h2 class="entry-title"><?php the_title(); ?></h2>
							</header>
							<div class="entry">
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
				<div class="clear"></div>
			</div>
			<?php get_footer(); ?>
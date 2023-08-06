<div id="sidebar">
<ul>
<?php 	/* Widgetized sidebar, if you have the plugin installed. */
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
<li>
<h2>About this place</h2>
<p>You've probably also heard that the US dollar is at historic lows versus many other major currencies most notably the <a href="#">british pound</a>.</p>
</li>
<li>
<h2>Recent Entries</h2>
<ul>
<?php
 $myposts = get_posts('numberposts=5&offset=0&category=0');
 foreach($myposts as $post) :
 ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
 <?php endforeach; ?>
</ul>
</li>
<li>
<h2>Categories</h2>
<ul>
<?php wp_list_categories('orderby=name&show_count=1&hide_empty=0&exclude=,2&title_li='); ?>
</ul>
</li>
<li>
<h2>Archive</h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</li>
<li>
<h2>Meta</h2>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
<?php wp_meta(); ?>
</ul>
</li>
<?php endif; ?>
</ul>
</div>
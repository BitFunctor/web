<div id="footer">
<ul>
<?php if (is_page()) { $highlight = "page_item"; } else {$highlight = "page_item current_page_item"; } ?>
<li class="<?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>">Home</a></li>
<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
</ul>
<p><a href="#header">Back on top</a></p>
</div>
</div>
</div>
<div id="copyright">
<p>Copyright 2007 by <b>Your Name</b>.</p>
<p>Design by <a href="http://colorlightstudio.com">Igor Penjivrag</a>.</p>
</div>
<?php wp_footer(); ?>
</body>
</html>
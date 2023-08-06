<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
<meta name="description" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" />
<meta name="keywords" content="" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<title><?php bloginfo('name'); wp_title(); ?></title>
<?php wp_head(); ?>
</head>

<body>

<div id="wrap">
<div id="header">
<h2><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h2>
<p><?php bloginfo('description'); ?></p>
</div>
<div id="menu">
<ul>
<?php if (is_page()) { $highlight = "page_item"; } else {$highlight = "page_item current_page_item"; } ?>
<li class="<?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>">Home</a></li>
<?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
</ul>
<div id="login">

<?php if (is_user_logged_in()): ?>

<?php global $user_identity, $current_user; get_currentuserinfo(); ?>

<p>Hello <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. Do you want to <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout.</a></p>

<?php else : ?>
<p>Would you like to <a href="<?php echo get_option('siteurl'); ?>/wp-login.php">Login</a> or <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=register">Register</a> ?</p>
<?php endif; ?>

</div>
</div>
<div id="page_desc">
<div id="text">
<?php if (is_home() || is_author() || is_search() || is_archive() || is_single() || is_404()): ?>
<p>Hello and welcome to beautiful <?php bloginfo('name'); ?>.</p>
<?php else : ?>
<p><?php echo get_post_meta($post->ID, "desc", true); ?></p>
<?php endif; ?>
</div>
<div id="search_top">
<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="sfield" />
<input type="image" src="<?php bloginfo('template_directory'); ?>/img/search_button.gif" class="sbutton" id="searchsubmit" />
</div>
</form>
</div>
</div>
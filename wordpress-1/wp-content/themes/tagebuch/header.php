<?php
/**
 * Theme Header
 *
 * Head of the Tagebuch Theme
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

$html_kombinat_has_sidebar = htmlkombinat::HTML_Kombinat_has_sidebar();
?><!DOCTYPE HTML>
<!--[if !IE]>      <html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<title><?php 
		/*
		 * Print the <title> tag using HTMLkombinat::HTML_Kombinat_the_title()
		 * @see core/htmlkombinat-class.php
		 */
		htmlkombinat::HTML_Kombinat_the_title();
	?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php
	/*
	 * Add wp_head()
	 */
	 	wp_head();
	?>
	</head>
	<body <?php body_class(); ?>>
		<div id="responsive-menu-switch" class="responsive-menu-switch">
			<span id="menu-toggle-button" class="menu-toggle-button"></span>
			<?php if( $html_kombinat_has_sidebar ) : ?>
			<span id="sidebar-toggle-button" class="sidebar-toggle-button"></span>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
		<div id="top" class="htmlkombinat-body">
			<header id="header" role="banner">
				<div class="header">
					<div class="wrapper">
						<div class="logo left">
							<?php htmlkombinat::HTML_Kombinat_the_header();	?>
						</div>
						<div class="right">
							<div id="secondary-navigation-wrapper">
								<nav id="secondary-navigation">
									<?php htmlkombinat::HTML_Kombinat_create_menu( 'secondary', 1 ); ?>
								</nav>
							</div>
							<div id="header-search-wrapper">
								<div id="header-search" class="header-search"><?php get_search_form(); ?></div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="wrapper">
					<div id="main-navigation-wrapper" class="main-navigation-wrapper">
						<nav id="main-navigation" role="navigation">
							<?php htmlkombinat::HTML_Kombinat_create_menu( 'primary' ); ?>
							<div class="clear"></div>
						</nav><!-- #main-navigation -->
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</header><!-- #header -->

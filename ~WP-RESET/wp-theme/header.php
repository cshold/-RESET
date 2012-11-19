<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen">

	<?php wp_enqueue_script('jquery'); ?>
	<?php wp_head(); ?>

	<script src="<?php bloginfo('template_directory'); ?>/js/h5.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/css_browser_selector.js"></script>

</head>
	<body <?php body_class(); ?>>

		<header>
			<div class="center">
				<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
			</div>
		</header>
		<nav>
			<div class="center">
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
			</div>
		</nav>
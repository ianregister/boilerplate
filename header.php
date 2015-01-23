<?php 
/* Force standards mode */
/* http://www.validatethis.co.uk/news/fix-bad-value-x-ua-compatible-once-and-for-all/ */
if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
	header('X-UA-Compatible: IE=edge,chrome=1'); 
?><!doctype html>

<!-- Copyright <?php echo date('Y'); ?> -->
<!-- Made by Ian Register > ianregister.com -->

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<!-- Head -->
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="dns-prefetch" href="//code.jquery.com">
	<link rel="dns-prefetch" href="//ajax.googleapis.com">
	<link rel="dns-prefetch" href="//google-analytics.com">
	
	<meta name="author" content="Copyright &copy; <?php echo date('Y'); ?> Ian Register" />
	
	<meta name="description" content="" />
			
	<!-- Mobile viewport optimized: j.mp/bplateviewport -->
	<meta name="viewport" content="width=device-width,initial-scale=1">
	
	<!-- CSS: implied media=all -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/styles.css" />

	<link rel="icon" type="image/x-png" href="<?php echo get_template_directory_uri(); ?>/images/graphics/logo.png" />

	<!-- www.phpied.com/conditional-comments-block-downloads/ -->
	
	<!-- Stylesheet for IE browsers greater than or equal to IE9 -->
	<!--[if lte IE 9]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" media="screen" />
	<![endif]-->
	
	
	<?php wp_head(); ?>

	<script>$LAB
		.script('<?php echo get_template_directory_uri(); ?>/js/libraries.min.js').wait()
		.script('<?php echo get_template_directory_uri(); ?>/js/plugins.min.js').wait()
		.script('<?php echo get_template_directory_uri(); ?>/js/main.min.js')
	</script>
	
	<!-- These guys will save our souls -->
	<script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr.min.js"></script>
	
	<!-- Nope, this fellah for the html5shiv needs be here else IE will get horribly confused (no CDN coz who cares about IE performance) -->
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/libs/html5.js"></script>
	<![endif]-->
	
	<title><?php wp_title(); ?></title>
</head>

<body class="hidden">

<div id="site">
	<header>
	<?php get_template_part('templates/modules/nav'); ?>
	</header>
	
	<section id="content">


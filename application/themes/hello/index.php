<?php global $Options;?>
<?php $theme_uri    =    base_url() . 'public/themes/hello/';?>
<?php
// Blog
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo $theme_uri;?>index-single/css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="<?php echo $theme_uri;?>index-single/css/style.css"> <!-- Resource style -->
    <script src="<?php echo $theme_uri;?>js/modernizr.js"></script> <!-- Modernizr -->
    <title><?php echo xss_clean($Options[ 'site_name' ]);?></title>
</head>

<body>
	<section id="cd-intro">
		<div id="cd-intro-background"></div>
		<div id="cd-intro-tagline">
			<h1><?php echo __('Hello !!!', 'hello');?></h1>
		</div> <!-- cd-intro-tagline -->
	</section> <!-- #cd-intro -->

	<main class="cd-content">
		<div class="cd-container">
			<p><?php echo sprintf(__('This is the first Tendoo Theme. We still working on this feature to let people create better blog With tendoo. <a href="%s">Get to blog here</a>. <br>This theme use "Post_Type" and "Blog" modules.', 'hello'), site_url(array( 'blog' )));?></p>
		</div>
	</main> <!-- cd-content -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?php echo $theme_uri . '/index-single/index-js/main.js';?>"></script> <!-- Resource jQuery -->
</body>
</html>

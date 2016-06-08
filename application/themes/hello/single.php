<?php global $Options;?>
<?php $theme_uri    =    base_url() . 'public/themes/hello/';?>
<?php
$Posts        =    get_instance()->blog->get(array(
    array( 'where'    =>    array( 'POST_SLUG' => @$arguments[2] ) )
));

if (count($Posts) == 0) {
    redirect(array( '404' ));
}
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
			<h1><?php echo sprintf(__('%s &mdash; %s', 'hello'), xss_clean($Posts[0][ 'TITLE' ]), $Options[ 'site_name' ]);?></h1>
		</div> <!-- cd-intro-tagline -->
	</section> <!-- #cd-intro -->

	<main class="cd-content">
		<div class="cd-container">
			<p><?php echo xss_clean($Posts[0][ 'CONTENT' ]);?></p>
            <small><?php echo sprintf(__('By %s', 'hello'), User::get($Posts[0][ 'AUTHOR' ])->name);?> &mdash; <a href="<?php echo site_url(array( 'blog' ));?>"><?php _e('Go Back', 'hello');?></a></small>
		</div>
	</main> <!-- cd-content -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="<?php echo $theme_uri . '/index-single/index-js/main.js';?>"></script> <!-- Resource jQuery -->
</body>
</html>

<?php global $Options;?>
<?php $theme_uri    =    base_url() . 'public/themes/hello/';?>
<?php
header('HTTP/1.0 404 NOT FOUND');
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo sprintf(__('This is not de page you\'re looking for &mdash; %s', 'hello'), $Options[ 'site_name' ]);?></title>
</head>

<body>
	<h1><?php echo sprintf(__('This is not de page you\'re looking for &mdash; %s', 'hello'), $Options[ 'site_name' ]);?></h1>
</body>
</html>

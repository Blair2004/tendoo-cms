<?php
/**
 * 	File Name 	: header.php
 *	Description :	header file for Auth purposes page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- Add Scale for mobile devices, @since 3.0.7 -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- End Add Scale for mobile devices -->

<?php $this->enqueue->load_css();?>
<?php $this->enqueue->load_js();?>

<!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->

<?php Html::title();?>
</head>

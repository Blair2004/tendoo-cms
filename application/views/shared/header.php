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

<?php Html::title();?>
<?php $this->events->do_action('common_header');?>
</head>

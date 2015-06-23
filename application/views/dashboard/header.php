<?php
/**
 * 	File Name : header.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since	:	1.4
**/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php Enqueue::loadcss();?>
<?php Enqueue::loadjs();?>
<title><?php echo Html::get_title();?></title>
</head>
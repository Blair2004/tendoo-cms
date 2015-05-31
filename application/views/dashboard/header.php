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
<?php $this->enqueue->loadcss();?>
<?php $this->enqueue->loadjs();?>
<title><?php echo $this->html->get_title();?></title>
</head>
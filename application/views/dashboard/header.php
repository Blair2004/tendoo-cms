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
<script type="text/javascript">
var tendoo	=	new Object;
</script>

<?php $this->enqueue->load_css();?>
<?php $this->enqueue->load_js();?>
<?php $this->events->do_action( 'dashboard_header' );?>

<title><?php echo Html::get_title();?></title>
</head>
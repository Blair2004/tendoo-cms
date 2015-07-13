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

<script>
var tendoo				=	new Object;
tendoo.base_url		=	'<?php echo base_url();?>';
tendoo.dashboard_url	=	'<?php echo site_url( array( 'dashboard' ) );?>';
tendoo.current_url	=	'<?php echo current_url();?>';
tendoo.index_url		=	'<?php echo index_page();?>';
tendoo.form_expire	=	'<?php echo gmt_to_local( time() , 'UTC' ) + GUI_EXPIRE;?>';
tendoo.user				=	{
	id			:		<?php echo $this->events->apply_filters( 'tendoo_object_user_id' , 'false' );?>
}
</script>

<?php Enqueue::loadcss();?>
<?php Enqueue::loadjs();?>

<title><?php echo Html::get_title();?></title>
</head>
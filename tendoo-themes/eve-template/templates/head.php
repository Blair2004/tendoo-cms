<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="description" content="<?php echo word_limiter(get_page('description'),500);?>">
		<meta name="keywords" content="<?php echo get_page('keywords');?>">
		<script>
		var site_url	=	"<?php echo $this->url->site_url();?>";
		var base_url	=	"<?php echo $this->url->main_url();?>";
		var site_longitude	=	<?php echo ($long	=	riake( 'gmap_longitude' , get_items( 'contact_gmap_data' ) ) ) == true ? $long : 77.20341 ;?>;
		var site_latitude	=	<?php echo ($lat	=	riake( 'gmap_latitude' , get_items( 'contact_gmap_data' ) ) ) == true ? $lat : 28.65850 ;?>;
	</script>
		<title><?php echo get_page('title');?></title>
        <?php output('headers');?>
	</head>
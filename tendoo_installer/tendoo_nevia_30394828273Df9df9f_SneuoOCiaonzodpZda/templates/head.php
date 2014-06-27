<html>
	<head>
		<meta charset="utf-8">
        <meta name="description" content="<?php echo word_limiter(get_page('description'),500);?>">
		<meta name="keywords" content="<?php echo get_page('keywords');?>">
		<script>
		var site_url	=	"<?php echo $this->url->site_url();?>";
		var base_url	=	"<?php echo $this->url->main_url();?>";
	</script>
		<title><?php echo get_page('title');?></title>
		<?php echo $this->file->css_load();?>
		<?php echo $this->file->js_load();?>        
	</head>

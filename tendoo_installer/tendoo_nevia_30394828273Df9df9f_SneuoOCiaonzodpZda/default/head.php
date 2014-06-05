<html>
	<head>
		<meta charset="utf-8">
        <meta name="description" content="<?php echo $this->tendoo->getDescription();?>">
		<meta name="keywords" content="<?php echo $this->tendoo->getKeywords();?>">
		<script>
		var site_url	=	"<?php echo $this->url->site_url();?>";
		var base_url	=	"<?php echo $this->url->main_url();?>";
	</script>
		<title><?php echo $this->tendoo->getTitle();?></title>
		<?php echo $this->file->css_load();?>
		<?php echo $this->file->js_load();?>        
	</head>

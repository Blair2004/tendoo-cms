<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="<?php echo $this->core->tendoo->getDescription();?>">
<title><?php echo $this->core->tendoo->getTitle();?></title>
<script>
var tendoo				=	new Object();
	tendoo.url			=	new function(){
		this.main		=	function(){
			return '<?php echo $this->core->url->main_url();?>';
		};
		this.base_url	=	function(){
			return '<?php echo $this->core->url->base_url();?>';
		};
		this.site_url	=	function(e){
			return '<?php echo $this->core->url->site_url();?>'+e;
		};
	};
</script>
<?php echo $this->core->file->css_load();?>
<?php echo $this->core->file->js_load();?>
</head>
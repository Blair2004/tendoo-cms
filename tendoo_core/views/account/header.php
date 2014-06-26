<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="<?php echo get_page('description');?>">
<title><?php echo get_page('title');?></title>
<script>
var tendoo				=	new Object();
	tendoo.url			=	new function(){
		this.main		=	function(){
			return '<?php echo $this->instance->url->main_url();?>';
		};
		this.base_url	=	function(){
			return '<?php echo $this->instance->url->base_url();?>';
		};
		this.site_url	=	function(e){
			return '<?php echo $this->instance->url->site_url();?>'+e;
		};
	};
</script>
<?php echo output('css');?>
<?php echo output('js');?>
</head>
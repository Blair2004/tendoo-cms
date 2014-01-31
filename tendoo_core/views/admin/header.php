<!DOCTYPE html>
<html lang="fr" class=" js no-touch no-android chrome no-firefox no-iemobile no-ie no-ie10 no-ios">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="description" content="<?php echo $this->core->tendoo->getDescription();?>">
<link rel="stylesheet" media="all" href="<?php echo $this->core->url->font_url('fontawesome-webfont.woff');?>">
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
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
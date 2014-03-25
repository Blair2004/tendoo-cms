<!DOCTYPE html>
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
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
			if(typeof e == 'object')
			{
				var completed	=	'';
				for($i = 0;$i< e.length;$i ++)
				{
					if($i == 0)
					{
						completed	+= e[$i];
					}
					else
					{
						completed	+= '/'+e[$i];
					}
				}
				return '<?php echo $this->core->url->main_url();?>index.php/'+completed;
			}
			return '<?php echo $this->core->url->main_url();?>index.php/'+e;
		};
	};
</script>
<?php echo $this->core->file->css_load();?>
<?php echo $this->core->file->js_load();?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
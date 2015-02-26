<!DOCTYPE html>
<html lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="description" content="<?php echo get_page('description');?>">
<title><?php echo get_page('title');?></title>
<script>
var tendoo				=	new Object();
	tendoo.url			=	new function(){
		this.main		=	function(){
			return '<?php echo get_instance()->url->main_url();?>';
		};
		this.base_url	=	function(){
			return '<?php echo get_instance()->url->base_url();?>';
		};
		this.site_url	=	function(e){
			if(typeof e == 'object')
			{
				var completed	=	'';
				for($i = 0;$i< e.length;$i ++)
				{
					completed	+=	e+'/';
				}
				return '<?php echo get_instance()->url->base_url();?>'+completed;
			}
			return '<?php echo get_instance()->url->base_url();?>'+e;
		};
	};
</script>
<?php echo output('css');?>
<?php echo output('js');?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
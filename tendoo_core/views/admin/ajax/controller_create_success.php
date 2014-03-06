	$('#controller_creation_error_contener').html('');
	$('#controller_creation_error_contener').append('<?php echo tendoo_success('Le contrôleur à été correctement crée.');?>');
	tendoo.notice.alert('Le contrôleur à été correctement crée.');
	var timeout	=	setTimeout(function(){
		document.location = '<?php echo $this->core->url->site_url(array('admin','pages'));?>';
	},2000);
<?php
	$field		=	array();
	$field[]	=	(form_error('page_name')) ;
	$field[]	=	(form_error('page_cname')) ;
	$field[]	=	(form_error('page_title')) ;
	$field[]	=	(form_error('page_module')) ;
	$field[]	=	(form_error('page_priority')) ;
	$field[]	=	(form_error('page_description')) ;
	$field[]	=	(form_error('page_visible')) ;
	$field[]	=	(form_error('page_parent')) ;
	$field[]	=	(form_error('page_keywords')) ;
	?>
	$('#controller_creation_error_contener').html('');
	<?php
	foreach($field as $f)
	{
		if(strlen($f) > 5)
		{
			?>
			$('#controller_creation_error_contener').append('<?php echo addslashes($f);?>');
			<?php
		}
	}
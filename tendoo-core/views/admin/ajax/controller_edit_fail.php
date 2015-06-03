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
    tendoo.notice.alert(
		'<ul>'+
	<?php
	$i = 0;
	foreach($field as $f)
	{
		?>
		'<li><?php echo addslashes($f);?></li>'+;
		<?php
	}
	?>
	'</ul>','error');
<?php
if(true == false)
{
	?>
    <script type="application/javascript">
    <?php
}
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
		"<ul style='margin:0 0 0 5px;padding:0'>"+
	<?php
	$i = 0;
	foreach($field as $f)
	{
		if(strlen($f) > 5)
		{
		?>
		"<li><?php echo addslashes(strip_tags($f));?></li>"+
		<?php
		}
	}
	?>
	'</ul>','warning');
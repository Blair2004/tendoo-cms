tendoo.notice.alert('<?php echo $message;?>','<?php echo $notice_type;?>');
<?php
if($notice_type == 'success')
{
?>
$('.creatingCategory').trigger('click');
$('[name="category"]').html('');
$('[name="category"]').append('<option value="">Choisir la cat&eacute;gorie</option>');
<?php
	$Category	=	$news->getCat();
	foreach($Category as $c)
	{
		?>
$('[name="category"]').append('<option value="<?php echo $c['ID'];?>"><?php echo $c['CATEGORY_NAME'];?></option>');	
		<?php
	}
}
?>
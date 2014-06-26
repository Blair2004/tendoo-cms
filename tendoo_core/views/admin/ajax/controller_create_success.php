<?php
	ob_start();
	if($get_pages)
	{
		?><div class="dd"><ol class="dd-list"><?php
		foreach($get_pages as $g)
		{						
			?><li class="dd-item" controllers c_id="<?php echo $g['ID'];?>" c_name="<?php echo $g['PAGE_NAMES'];?>" c_cname="<?php echo $g['PAGE_CNAME'];?>" c_title="<?php echo $g['PAGE_TITLE'];?>"><input type="hidden" controller_title name="controller[title][]" value="<?php echo $g['PAGE_TITLE'];?>"><input type="hidden" controller_description name="controller[description][]" value="<?php echo $g['PAGE_DESCRIPTION'];?>"><input type="hidden" controller_main name="controller[main][]" value="<?php echo $g['PAGE_MAIN'];?>"><input type="hidden" controller_module name="controller[module][]" value="<?php echo is_array($g['PAGE_MODULES']) ? $g['PAGE_MODULES'][0]['NAMESPACE'] : $g['PAGE_MODULES'];?>"><input type="hidden" controller_parent name="controller[parent][]" value="<?php echo $g['PAGE_PARENT'];?>"><input type="hidden" controller_name name="controller[name][]" value="<?php echo $g['PAGE_NAMES'];?>"><input type="hidden" controller_cname name="controller[cname][]" value="<?php echo $g['PAGE_CNAME'];?>"><input type="hidden" controller_keywords name="controller[keywords][]" value="<?php echo $g['PAGE_KEYWORDS'];?>"><input type="hidden" controller_link name="controller[link][]" value="<?php echo $g['PAGE_LINK'];?>"><input type="hidden" controller_visible name="controller[visible][]" value="<?php echo $g['PAGE_VISIBLE'];?>"><input type="hidden" controller_id name="controller[id][]" value="<?php echo $g['ID'];?>"><div class="dd-handle"><span controller_name_visible><?php echo $g['PAGE_NAMES'];?></span><span id="controller_priority_status"><?php
			if($g['PAGE_MAIN'] == 'TRUE')
			{
				?>- <small>Index</small><?php
			}
			?></span><div style="float:right"><button class="edit_controller dd-nodrag btn btn-primary btn-sm" type="button"><i class="fa fa-plus"></i></button> <button class="remove_controller dd-nodrag btn btn-warning btn-sm" type="button"><i class="fa fa-times"></i></button></div></div><ol class="dd-list"><?php 
			$this->instance->tendoo_admin->getChildren($g['PAGE_CHILDS'],TRUE); ?></ol></li><?php
		}
		?></ol></div><?php
	}
	else
	{
	?><div class="panel"><div class="panel-heading"> Aucun contrôleur disponible </div></div><?php
	}
$result	=	addslashes(ob_get_contents());
ob_end_clean();
?>
<?php
if(true == false)
{
	?>
    <script type="text/javascript">
    <?php
}
?>
	tendoo.notice.alert('<?php echo strip_tags(tendoo_success('Le contrôleur à été correctement crée.'));?>');
	$('#controller_form').append("<input type='reset'>");
	$('#controller_form').find('[type="reset"]').trigger('click').remove();

	$('.TENDOO_MENU form').hide(500).html("<?php echo $result;?>").show(500,function(){
		tendoo.controllers	=	new tendoo_controllers();
		bootCScript();
	});
	
<?php
if($files)
{
	?>
    <div class="row">
    <?php
	foreach($files  as $f)
	{
		?>
		<div class="col-xs-6 col-md-3 content_file" style="margin-bottom:10px;" file_url="<?php echo $this->core->url->main_url().MODULES_DIR.$module[0]['ENCRYPTED_DIR'].'/content_repository/'.$f['FILE_NAME'];?>">
			<a href="javascript:void(0)" class="thumbnail">
			  <img style="height:100px;" src="<?php echo $this->core->url->main_url().MODULES_DIR.$module[0]['ENCRYPTED_DIR'].'/content_repository/small_'.$f['FILE_NAME'];?>" alt="...">
			</a>
		</div>
		<?php
	}
	?>
    </div>
    <?php
	if(is_array($paginate[4]))
	{
		?>
        <ul class="pagination">
        <?php
		foreach($paginate[4] as $p)
		{
			if($p['state'] == 'on')
			{
			?>
              <li class="active"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
            <?php
			}
			else
			{
			?>
              <li><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
            <?php
			}
		}
		?>
        </ul>
        <?php
	}
}

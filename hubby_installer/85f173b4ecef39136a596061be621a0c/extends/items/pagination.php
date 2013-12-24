<ul class="pager" style="height:20px;">
    <?php
			if(is_array($this->pagination_datas['innerLink']))
			{
				foreach($this->pagination_datas['innerLink'] as $p)
				{
					if($p['state'] == 'active')
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
			}
			else
			{
				?>
    <li><a href="#">0</a></li>
    <?php
			}
				?>
</ul>
	
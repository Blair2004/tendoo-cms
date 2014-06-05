<nav class="pagination">
			<ul>
<?php
			if(is_array($this->pagination_datas['innerLink']))
			{
				foreach($this->pagination_datas['innerLink'] as $p)
				{
					if($p['state'] == 'active')
					{
					?>
				<li><a href="<?php echo $p['link'];?>" class="current"><?php echo $p['text'];?></a></li>
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
			?>
			</ul>
			<div class="clearfix"></div>
		</nav>
<?php
		if(count($this->ttRightWidgets) > 0)
		{
			foreach($this->ttRightWidgets as $w)
			{
		?>
		<aside id="categories-2" class="widget widget_categories">
			<h1 class="widget-title"><?php echo $w['TITLE'];?></h1>		
			<?php echo $w['CONTENT'];?>
		</aside>
            <?php
			}
		}
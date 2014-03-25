<?php
		if(count($this->ttBottomWidgets) > 0)
		{
			foreach($this->ttBottomWidgets as $w)
			{
		?>
		<div class="botwid col-6 col-lg-3 widget_meta">
			<h3 class="bothead"><?php echo $w['TITLE'];?></h3>			
			<div class="textwidget">
				<p><?php echo $w['CONTENT'];?></p>
			</div>
		</div>
            <?php
			}
		}
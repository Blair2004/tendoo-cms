<?php
		if(count($this->ttWidgets) > 0)
		{
		?>
        <aside id="sidebar">
        <?php
			foreach($this->ttWidgets as $w)
			{
		?>
            <div class="block">
                <h4><?php echo $w['TITLE'];?></h4>
                <?php echo $w['CONTENT'];?>
            </div>
            <?php
			}
			?>
        </aside>
        <?php
		}
		?>
        <div class="clearfix"></div>
        <?php

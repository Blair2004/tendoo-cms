<?php
		if(count($this->currentForm) > 0)
		{
		?>
        <form method="<?php echo $type;?>" enctype="<?php echo $enctype;?>" action="<?php echo $action;?>" id="commentform">
        	<?php
			foreach($this->currentForm as $c)
			{
				echo $c;
			}
			?>
        </form>
        <?php
		}

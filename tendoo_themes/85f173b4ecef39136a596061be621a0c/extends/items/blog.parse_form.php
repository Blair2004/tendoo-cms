<?php
		if(count($this->currentForm) > 0)
		{
		?>
        <form method="<?php echo $this->formType;?>" enctype="<?php echo $this->formEnctype;?>" action="<?php echo $this->formAction;?>" id="commentform">
        	<?php
			foreach($this->currentForm as $c)
			{
				echo $c;
			}
			?>
        </form>
        <?php
		}

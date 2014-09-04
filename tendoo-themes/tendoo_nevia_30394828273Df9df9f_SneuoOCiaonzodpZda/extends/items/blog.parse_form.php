<?php
		if(count($this->currentForm) > 0)
		{
		?>
        <form class="contactform" method="<?php echo $this->formType;?>" enctype="<?php echo $this->formEnctype;?>" action="<?php echo $this->formAction;?>" id="commentform">
        	<fieldset>
        	<?php
			foreach($this->currentForm as $c)
			{
				echo $c;
			}
			?>
            </fieldset>
        </form>
        <?php
		}
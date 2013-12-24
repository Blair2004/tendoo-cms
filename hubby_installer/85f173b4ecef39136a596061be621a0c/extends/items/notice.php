<?php
		if(strlen($this->core->notice->parse_notice()) > 0)
		{
		?>
        <div class="headline" style="font-size:15px;">
            <?php $this->core->notice->parse_notice();?>
        </div>
        <?php
		}

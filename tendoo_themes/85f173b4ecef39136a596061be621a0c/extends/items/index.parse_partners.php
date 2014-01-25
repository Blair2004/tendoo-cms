<?php

		if(isset($this->partners_content))
		{
		?>
        <div class="page-content">
        <h2 class="page-title"><?php echo $this->partners_title;?></h2>
        <div class="shadow-wrapper margin1">
            <div class="left-shadow"></div>
            <div class="mid-shadow"></div>
            <div class="right-shadow"></div>
        </div>
        <p style="margin-bottom:20px;"><?php echo strip_tags($this->partners_content);?></p>
        </div>
<?php
		}

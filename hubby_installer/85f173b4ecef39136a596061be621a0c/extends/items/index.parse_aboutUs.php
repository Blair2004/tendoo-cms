<?php
if(isset($this->indexAboutUs))
		{
		?>
        <h1 class="home-block-heading"><?php echo $this->indexAboutUsTitle;?></h1>
        <div class="text-posts" style="margin-left:24px;">
            <p><?php echo strip_tags($this->indexAboutUs);?></p>
        </div>
        <div class="clearfix"></div>
		<?php
		}
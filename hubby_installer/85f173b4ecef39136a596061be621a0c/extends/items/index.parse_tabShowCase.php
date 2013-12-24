<?php
		if(count($this->tabShowCase) > 0)
		{
		?>
        <h1 class="home-block-heading"><?php echo $this->tabShowCaseTitle;?></h1>
        <div style="padding:0 24px;">
            <ul class="tabs">
            <?php
                foreach($this->tabShowCase as $s)
                {
                    ?>
                    <li><a href="#" class="current"><span><?php echo $s['TITLE'];?></span></a></li>
                    <?php
                }
            ?>
            </ul>
            <div class="panes">
            <?php
            foreach($this->tabShowCase as $s)
            {
            ?>
                <div style="display: block;">
                    <p><?php echo $s['CONTENT'];?></p>
                </div>
            <?php
            }
            ?>
            </div>
		</div>
        <div class="clearfix"></div>	
        <br />
        <?php
		}

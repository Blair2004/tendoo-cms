<?php
		if(count($this->featuredProduct) > 0)
		{
		?>
        <h1 class="home-block-heading"><?php echo $this->featuredProductTitle;?></h1>
        <div class="featured">
        <?php 
		foreach($this->featuredProduct as $p)
		{
		?>
            <figure>
                <a href="<?php echo $p['THUMB'];?>" data-rel="prettyPhoto" class="thumb"><img src="<?php echo $p['THUMB'];?>" alt="<?php echo $p['TITLE'];?>"></a>
                <div>
                    <a href="<?php echo $p['LINK'];?>" class="heading"><?php echo $p['TITLE'];?></a>
                    <?php echo word_limiter(strip_tags($p['CONTENT']),100);?>
                    <div style="line-height:20px;background:#002191;color:#EEE;padding:0 5px;">Prix : <?php echo $p['PRICE'];?> <?php echo $this->featuredProductDevise;?></div>
                </div>
                <a class="link" href="<?php echo $p['LINK'];?>"></a>
            </figure>
		<?php
		}
		?>
            <div class="clearfix"></div>
        </div>
        <?php
		}

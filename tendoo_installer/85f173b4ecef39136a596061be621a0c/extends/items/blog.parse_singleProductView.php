<?php
		if(count($this->singleProductView) > 0)
		{
			$this->singleProductView	=&	$this->singleProductView[0];
	?>
	<div id="post-content">
	<div class="feature-image">
		<a href="<?php echo $this->singleProductView['FULL'];?>" data-rel="prettyPhoto"><img src="<?php echo $this->singleProductView['THUMB'];?>" alt="<?php echo $this->singleProductView['TITLE'];?> text" /></a>
	</div>
	<h1 class="post-heading"><?php echo $this->singleProductView['TITLE'];?> - <?php echo $this->productListingDevise;?> <?php echo $this->singleProductView['PRICE'];?></h1>
    <div class="content-area"><?php echo $this->singleProductView['CONTENT'];?></div>
    <div style="float:left;padding:10px 20px;background:#0C6;font-weight:600;margin-right:5px;"><a href="<?php echo $this->singleProductView['ADD_LINK'];?>"><?php echo $this->singleProductView['ADD_TEXT'];?></a></div>
    <div style="float:left;padding:10px 20px;background:#000;font-weight:600;margin-right:5px;"><a style="color:#FFF" href="<?php echo $this->singleProductView['REMOVE_LINK'];?>"><?php echo $this->singleProductView['REMOVE_TEXT'];?></a></div>
    <div style="float:left;padding:10px 20px;background:#09C;font-weight:600;margin-right:5px;"><a href="<?php echo $this->singleProductView['CHECK_LINK'];?>"><?php echo $this->singleProductView['CHECK_TEXT'];?></a></div>
		
	<div class="clearfix"></div>
    </div>
        <?php
		}

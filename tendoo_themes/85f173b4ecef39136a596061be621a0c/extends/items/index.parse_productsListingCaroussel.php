<?php
		if(count($this->productListingCaroussel) > 0)
		{
				?>
<div class="flexslider home-slider">
  <ul class="slides">
 <?php
	foreach($this->productListingCaroussel as $c)
	{
?>
    <li>
    
      <a href="<?php echo $c['LINK'];?>"><img src="<?php echo $c['THUMB'];?>"  alt="<?php echo $c['TITLE'];?>"  /></a>
      <div style="padding:20px 20px;background:rgba(0, 0, 0, 0.8);position:absolute;top:0;color:white;"><?php echo $c['TITLE'];?></div>
      <p class="flex-caption">
	  	<?php echo word_limiter(strip_tags($c['CONTENT']),20);?>
        <div style="padding:10 20px;background:#FFF;opacity:0.8;float:right"><?php echo $this->productListingDevise;?> <?php echo $c['PRICE'];?></div></p>
      
    </li>
<?php
	}
			?>
  </ul>
</div>
<div class="shadow-slider"></div>
<?php
		}

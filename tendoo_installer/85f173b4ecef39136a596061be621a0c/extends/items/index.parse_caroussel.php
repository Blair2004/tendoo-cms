<?php
		if(count($this->carousselElement) > 0)
		{
				?>
<div class="flexslider home-slider">
  <ul class="slides">
 <?php
	foreach($this->carousselElement as $c)
	{
?>
    <li>
      <a href="<?php echo $c['LINK'];?>"><img src="<?php echo $c['IMAGE'];?>"  alt="<?php echo $c['TITLE'];?>" style="width:100%;"  /></a>
      <p class="flex-caption"><?php echo word_limiter(strip_tags($c['CONTENT']),20);?></p>
    </li>
<?php
	}
			?>
  </ul>
</div>
<div class="shadow-slider"></div>
<?php
		}

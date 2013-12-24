<?php
		if(count($this->onTopContent) > 0)
		{
		?>
<h1 class="home-block-heading"><?php echo $this->onTopContentTitle;?></h1>
<div class="featured masonry" style="position: relative; height: 759px;">
<?php
foreach($this->onTopContent as $c)
	{
	?>
    <figure class="masonry-brick">
        <a href="<?php echo $c['THUMB'];?>" data-rel="prettyPhoto" class="thumb" rel="prettyPhoto"><img src="<?php echo $c['THUMB'];?>" alt="<?php echo $c['TITLE'];?>"></a>
        <div>
            <a href="<?php echo $c['LINK'];?>" class="heading"><?php echo $c['TITLE'];?></a>
             <?php echo word_limiter(strip_tags($c['CONTENT']),50);?>
        </div>
        <a class="link" href="<?php echo $c['LINK'];?>"></a>
    </figure>
	<?php
	}
			?>
    <div class="clearfix"></div>
</div>
<!-- ENDS Featured -->
<?php
		}

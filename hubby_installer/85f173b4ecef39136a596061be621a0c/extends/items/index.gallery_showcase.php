<?php
if(count($this->galleryGroup) > 0)
{
?>
<h1 class="home-block-heading"><?php echo $this->galleryShowCaseTitle;?></h1>
<ul class="home-gallery">
<?php
    foreach($this->galleryGroup as $g)
    {
?>
    <li><a href="<?php echo $g['FULL'];?>" data-rel="prettyPhoto" class="thumb"><img src="<?php echo $g['THUMB'];?>" alt="<?php echo $g['TITLE'];?>" /></a></li>
    <?php
    }
    ?>
</ul>
<div class="clearfix"></div>
<?php
}
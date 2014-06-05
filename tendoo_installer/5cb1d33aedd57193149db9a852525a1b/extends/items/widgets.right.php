<?php
if(count($this->ttRightWidgets) > 0)
{
	foreach($this->ttRightWidgets as $w)
	{
?>
<nav class="widget">
    <h4><?php echo $w['TITLE'];?></h4>
    <?php echo $w['CONTENT'];?>
</nav>
<div class="clearfix"></div>
<?php
	}
}
?>
<?php
if(count($this->ttBottomWidgets) > 0)
{
	foreach($this->ttBottomWidgets as $w)
	{
?>
<div class="four columns">
    <h4><?php echo $w['TITLE'];?></h4>
    <?php echo $w['CONTENT'];?>
</div>
<?php
	}
}
?>
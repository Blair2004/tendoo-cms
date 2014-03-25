<?php
if(count($this->galleryGroup) > 0)
{
?>
	<div class="row">
		<div id="primary">
			<h3><?php echo $this->galleryShowCaseTitle;?></h3>
		<?php
    foreach($this->galleryGroup as $g)
    {
?>
			<article class="col-sm-3 col-6 portbox post">
				<div class="hthumb">
					<a href="<?php echo $g['FULL'];?>"><img alt="<?php echo $g['TITLE'];?>" src="<?php echo $g['THUMB'];?>" style="height:20%;" class="img-responsive"></a>
				</div>
			</article>
	<?php
    }
    ?>
		</div>
	</div>
<?php
}
?>
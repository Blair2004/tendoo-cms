<?php
		if(count($this->onTopContent) > 0)
		{
		?>
<div class="section-wide">
	<div class="row">
		<div class="section-title col-12">
			<h2><?php echo $this->onTopContentTitle;?></h2>
			<p></p>
		</div>
		<div class="boxitems">
	<?php
	foreach($this->onTopContent as $c)
		{
	?>
			<div class="col-sm-3 col-6 portbox">
				<div class="hthumb">
					<a href="<?php echo $c['LINK'];?>"><img style="height:150px;" class="img-responsive" src="<?php echo $c['THUMB'];?>"></a>
				</div>
				<h3><a href="<?php echo $c['LINK'];?>"><?php echo $c['TITLE'];?></a></h3>
			</div>
<?php
}
		?>
		</div>
	</div>
</div>
<!-- ENDS Featured -->
<?php
		}

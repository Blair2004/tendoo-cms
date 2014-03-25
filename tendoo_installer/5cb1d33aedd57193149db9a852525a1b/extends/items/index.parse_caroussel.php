<?php
		if(count($this->carousselElement) > 0)
		{
				?>
<div class="flexslider" id="slidebox">
	<ul class="slides">
	<?php
	foreach($this->carousselElement as $c)
	{
	?>
		<li style="width: 100%; float: left; margin-right: -100%; position: relative; display: none;" class="">
			<a href="<?php echo $c['LINK'];?>">
				<img src="<?php echo $c['IMAGE'];?>" class="grayscale" alt="<?php echo $c['TITLE'];?>">
			</a>
			<div class="flex-caption">
				<h2><?php echo $c['TITLE'];?></h2>
				<p><?php echo word_limiter(strip_tags($c['CONTENT']),20);?></p>
				<a href="<?php echo $c['LINK'];?>" class="frmore"> Lire la suite </a>
			</div>
		</li>
	<?php
	}
	?>
	</ul>
	<div class="doverlay"></div>
	<ul class="flex-direction-nav">
		<li><a href="#" class="flex-prev">Pr&eacute;c&eacute;dent</a></li>
		<li><a href="#" class="flex-next">Suivant</a></li>
	</ul>
</div>
<?php
		}

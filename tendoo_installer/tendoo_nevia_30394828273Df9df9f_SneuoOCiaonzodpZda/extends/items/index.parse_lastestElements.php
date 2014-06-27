<?php
if(count($this->lastestElements) > 0)
{
?>
    <div class="columns">

		<h3 class="margin-1"><?php echo $this->lastestElementsTitle;?></h3>
		<?php
		foreach($this->lastestElements as $lt)
		{
			$globals	=	$this->instance->date->time($lt['DATETIME'],TRUE);
			
		?>
		<div class="four columns alpha">
			<article class="recent-blog">
				<section class="date">
					<span class="day"><?php echo $globals['d'];?></span>
					<span class="month"><?php echo $globals['month'];?></span>
				</section>
				<h4><a href="<?php echo $lt['LINK'];?>"><?php echo word_limiter($lt['TITLE'],8);?></a></h4>
				<p><?php echo word_limiter($lt['CONTENT'],10);?></p>
			</article>
		</div>
		<?php
		}
		?>
	</div>
<?php
}
?>
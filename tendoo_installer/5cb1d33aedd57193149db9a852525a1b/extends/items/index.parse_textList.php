<?php
if(count($this->listText) > 0)
{
?>
<div class="container floated">
	<div class="blank floated">

		<!-- Recent Work Entire -->
		<div class="four columns carousel-intro">

			<section class="entire">
				<h3><?php echo $this->textListTitle;?></h3>
				<p></p>
			</section>

			<div class="carousel-navi">
				<div id="work-prev" class="arl jcarousel-prev"><i class="icon-chevron-left"></i></div>
				<div id="work-next" class="arr jcarousel-next"><i class="icon-chevron-right"></i></div>
			</div>
			<div class="clearfix"></div>

		</div>

		<!-- jCarousel -->
		<section class="jcarousel recent-work-jc">
			<ul>
				<!-- Recent Work Item -->
				<?php
				foreach($this->listText as $t)
				{
				?>
				<li class="four columns">
					<a href="<?php echo $t['LINK'];?>" class="portfolio-item">
						<figure>
							<img src="<?php echo $t['THUMB'];?>" alt="<?php echo $t['TITLE'];?>" style="height:120px;">
							<figcaption class="item-description">
								<h5><?php echo word_limiter($t['TITLE'],5);?></h5>
								<span><?php echo word_limiter($t['CONTENT'],10);?></span>
							</figcaption>
						</figure>
					</a>
				</li>
				<?php
				}
				?>
			</ul>
		</section>
		<!-- jCarousel / End -->

	</div>
</div><?php
}
?>
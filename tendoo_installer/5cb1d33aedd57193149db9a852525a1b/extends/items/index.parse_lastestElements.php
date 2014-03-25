<?php
if(count($this->lastestElements) > 0)
{
		?>
	<div class="section-wide">
		<div class="row">
			<div class="section-title col-12">
				<h2><?php echo $this->lastestElementsTitle;?></h2>
				<p></p>
			</div>
			<div class="boxitems">
			<?php
			foreach($this->lastestElements as $c)
			{
				$date	=	$this->core->tendoo->time($c['DATETIME'],TRUE);
				?>
				<div class="boxitems">
					 <div class="col-sm-3 col-6 postbox" style="height:380px;">
						<div class="hthumb">
							<a href="<?php echo $c['LINK'];?>"><img style="height:150px;" class="img-responsive" src="<?php echo $c['THUMB'];?>"></a>
						</div>
						<h3><a href="<?php echo $c['LINK'];?>"><?php echo $c['TITLE'];?></a></h3>
						<div class="hometa"> 
							<span class="posted-on"> 
								<time class="entry-date published" datetime="<?php echo $c['DATETIME'];?>"><?php echo $date['d'].' '.$date['month'].' '.$date['y'];?></time>
							</span>
							<span class="byline"> par 
								<span class="author vcard"><a class="url fn n" href="author/admin/index.html" title="View all posts by admin">admin</a>
								</span>
							</span> 
						</div>
						<p><?php echo word_limiter(strip_tags($c['CONTENT']),30);?></p>
					</div>
				</div>
			<?php
			}
			?>
			</div>
		</div>
	</div>
	<!-- -->
	<?php
	if(true == false)
	{
	?>
	<div class="section-wide sec">
		<div class="row">
			<div class="section-title col-12">
				<h2> Latest Articles</h2>
				<p>Latest posts from the blog </p>
			</div>
			<div class="boxitems">
				 <div class="col-sm-3 col-6 postbox">
					<div class="hthumb">
						<a href="<?php echo $c['LINK'];?>"><img class="img-responsive" src="../../cdn.demo.fabthemes.com/revera/files/2013/08/wallpaper-939317-750x500.jpg"></a>
					</div>
				 <h3><a href="<?php echo $c['LINK'];?>"> Etiam mauris tortor, pharetra quis lobortis in, pharetra in diam</a></h3>
				 <div class="hometa"> <span class="posted-on">Posted on <a href="2013/08/19/etiam-mauris-tortor-pharetra-quis-lobortis-in-pharetra-in-diam/index.html" title="5:33 am" rel="bookmark"><time class="entry-date published" datetime="2013-08-19T05:33:33+00:00">August 19, 2013</time><time class="updated" datetime="2013-08-19T05:34:15+00:00">August 19, 2013</time></a></span><span class="byline"> by <span class="author vcard"><a class="url fn n" href="author/admin/index.html" title="View all posts by admin">admin</a></span></span> </div>
				  <p>Duis tempus leo vitae ipsum viverra, blandit condimentum sapien porttitor. Duis porttitor sed metus eget mollis. Curabitur bibendum imperdiet tortor, ut pulvinar purus elementum nec. Suspendisse at erat luctus; hendrerit sapien sed, consectetur erat. Maecenas dignissim suscipit orci at molestie. Aenean fringilla dolor vitae lacus lacinia eleifend. Suspendisse et libero nunc. Etiam mauris tortor, pharetra […]</p>
				 </div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<?php // echo word_limiter(strip_tags($c['CONTENT']),50);?>	
	<?php
}
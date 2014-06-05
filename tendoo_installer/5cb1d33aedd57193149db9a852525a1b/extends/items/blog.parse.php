<div class="container floated">

	<div class="sixteen floated page-title">

		<h2><?php echo $this->pageTitle;?><span> <?php if(strlen($this->pageDescription) > 0) : echo '/ '.word_limiter($this->pageDescription,10);endif;?></span></h2>

		<!--
		<nav id="breadcrumbs">
			<ul>
				<li>You are here:</li>
				<li><a href="#">Home</a></li>
				<li>Blog</li>
			</ul>
		</nav>
        -->
	</div>

</div>
<div class="container floated">

	<!-- Page Content -->
	<div class="eleven floated">

		<!-- Post -->
		<?php $this->parseBlogPost();?> 
        <?php $this->parseSingleBlogPost();?> 
	</div>
	<!-- Content / End -->


	<!-- Sidebar -->
	<div class="four floated sidebar right">
		<aside class="sidebar">

			<!-- Search -->
            <?php $this->parseRightWidgets();?>

		</aside>
	</div>
	<!-- Page Content / End -->

</div>
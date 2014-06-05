<div id="content">

<!-- 960 Container -->
<div class="container floated">

	<div class="sixteen floated page-title">

		<h2><?php echo $this->pageTitle;?><span> / <?php if(strlen($this->pageDescription) > 0) : echo word_limiter($this->pageDescription,10);endif;?></span></h2>

		<!-- Portfolio Navi -->
		<div class="clearfix"></div>

	</div>

</div>
<!-- 960 Container / End -->

<!-- Page Content -->
<div class="page-content">

<div class="container">
	<div class="sixteen columns">

		<!-- Slider  -->
		<?php echo $this->uniqueContent;?>
		<!-- Slider / End -->

	</div>
</div>

<!-- Page Content / End -->

</div>